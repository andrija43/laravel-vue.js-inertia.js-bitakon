<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Prompt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $carts = $request->session()->get('cart', []);

        return Inertia::render('Frontend/Cart/Index', [
            'carts' => $carts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $alreadyPurchased = DB::table('orderitems')
            ->join('users', 'orderitems.user_id', '=', 'users.id')
            ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
            ->join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
            ->selectRaw('prompts.*, users.name, users.avatar, users.username, promptmodels.title as model_title')
            ->where('orders.user_id', auth()->user()->id)
            ->where('prompts.id', $request->input('id'))
            ->groupBy('prompts.id')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        if (!$alreadyPurchased->isEmpty()) {
            return throw ValidationException::withMessages(['prompt' => 'You have already purchased this prompt']);
        }

        $id = $request->input('id');
        $prompt = Prompt::where('status', 1)
            ->with(['promptmodel:id,title'])
            ->findOrFail($id);
        $preview = $request->input('preview');
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $cart[$id] = [
            'id' => $id,
            'price' => $prompt->price,
            'title' => $prompt->title,
            'slug' => $prompt->slug,
            'user' => $prompt->user_id,
            'model' => $prompt->promptmodel->title,
            'preview' => $preview ?? json_decode($request->input('meta'))->preview ?? null,
        ];


        $request->session()->put('cart', $cart);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }

        return back();
    }
}
