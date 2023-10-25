<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptcategoryimage;
use App\Models\Promptfile;
use App\Models\Promptmodel;
use App\Models\Promptmodelrelation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Auth;
class OrderController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query()
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(10);
        return Inertia::render('Frontend/Dashboard/Order/Index', [
            'orders' => $orders,
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('user_id',Auth::id())->with('user', 'gateway')->findOrFail($id);
        $invoice_data = get_option('invoice_data', true);
        $meta = json_decode($order->meta ?? '');
        $prompts = DB::table('orderitems')
            ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
            ->join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
            ->selectRaw('prompts.*, promptmodels.title as model_title')
            ->where('orders.id', $id)
            ->where('orders.user_id', auth()->user()->id)
            ->groupBy('prompts.id')
            ->get();
        return Inertia::render('Frontend/Dashboard/Order/Show', [
            'order' => $order,
            'invoice_data' => $invoice_data,
            'meta' => $meta,
            'prompts' => $prompts,
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $islug
     * @return \Illuminate\Http\Response
     */
    public function prompt_show($id, $slug)
    {       
       
        $prompt = Prompt::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'user:id,name,username,created_at,avatar',
                'collection:id,name,slug,created_at,preview',
                'promptmodel:id,title,slug,created_at,has_submodel',
            ])
            ->firstOrFail();
        $order = Order::whereHas('items', function($query) use ($prompt){
                return $query->where('prompt_id', $prompt->id);
        })->where('status', 1)->where('user_id', Auth::user()->id)->findOrFail($id);    

        $promptCategory = Promptcategory::where('id', $prompt->promptcategory_id)->first();
        $promptcategoryimages = Promptcategoryimage::where('promptcategory_id', $prompt->promptcategory_id)->pluck('url');

        if ($prompt->promptmodel->has_submodel) {
            $promptModelRelation = Promptmodelrelation::where('prompt_id', $prompt->id)->pluck('promptmodel_id');

            $promptSubmodels = Promptmodel::whereIn('id', $promptModelRelation)
                ->with('model:id,title,slug,created_at,promptmodel_id')
                ->where('type', 'sub_models')
                ->get();
        }
        $promptFiles = Promptfile::where('prompt_id', $prompt->id)->first();
        return Inertia::render('Frontend/Dashboard/Order/PromptShow', [
            'prompt' => $prompt,
            'promptSubmodels' => $promptSubmodels ?? [],
            'promptCategory' => $promptCategory ?? [],
            'promptcategoryimages' => $promptcategoryimages,
            'promptModelRelation' => $promptModelRelation ?? '',
            'promptFiles' => $promptFiles,
        ]);
    }
}
