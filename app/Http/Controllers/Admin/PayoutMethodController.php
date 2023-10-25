<?php

namespace App\Http\Controllers\Admin;

use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Traits\Uploader;

class PayoutMethodController extends Controller
{
    use Uploader;
    public function __construct()
    {
        $this->middleware('permission:payouts');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Payout Method'),
                'url' => route('admin.payout-methods.create'),
            ]
        ];
        $methods = PayoutMethod::latest()->paginate(20);
        $totalPayoutmethod =  PayoutMethod::count();
        $totalActivePayoutmethod =  PayoutMethod::where('status', 1)->count();
        $totalInActivePayoutmethod =  PayoutMethod::where('status', 0)->count();

        return Inertia::render('Admin/PayoutMethod/Index', [
            'methods' => $methods,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalPayoutmethod' => $totalPayoutmethod,
            'totalActivePayoutmethod' => $totalActivePayoutmethod,
            'totalInActivePayoutmethod' => $totalInActivePayoutmethod,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.payout-methods.index'),
            ]
        ];

        return Inertia::render('Admin/PayoutMethod/Create', [
            'buttons' => $buttons,
            'segments' => $segments,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'currency_name' => ['required', 'string'],
            'charge_type' => ['required', 'string'],
            'delay' => ['required', 'numeric'],
            'image'  => 'required|image|max:2000',
            'min_limit' => ['required', 'gt:0'],
            'max_limit' => ['required', 'after_or_equal:min_limit'],
            'fixed_charge' => ['nullable', 'gt:0', 'min:1'],
            'percent_charge' => ['nullable', 'between:0,100', 'min:1'],
            'instruction' => ['required', 'string'],
            'status' => ['required'],
        ]);

        
        $preview = $this->saveFile($request, 'image');
        $data = json_encode($request->inputs);
        
        $method = new PayoutMethod; 
        $method->name = $request->name;
        $method->currency_name = $request->currency_name;
        $method->charge_type = $request->charge_type;
        $method->delay = $request->delay;
        $method->min_limit = $request->min_limit;
        $method->max_limit = $request->max_limit;
        $method->fixed_charge = $request->fixed_charge;
        $method->percent_charge = $request->percent_charge;
        $method->instruction = $request->instruction;
        $method->status = $request->status;
        $method->image = $preview;
        $method->data = $data;
        $method->save();        
       
        return to_route('admin.payout-methods.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayoutMethod  $Payoutmethod
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.payout-methods.index'),
            ]
        ];
        $payoutmethod = PayoutMethod::find($id);

        return Inertia::render('Admin/PayoutMethod/Edit', [
            'segments' => $segments,
            'buttons' => $buttons,
            'payoutmethod' => $payoutmethod,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PayoutMethod  $Payoutmethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'payoutmethod.name' => ['required', 'string'],
            'payoutmethod.delay' => ['required', 'numeric'],
            'payoutmethod.currency_name' => ['required', 'string'],
            'payoutmethod.min_limit' => ['required', 'gt:0'],
            'payoutmethod.charge_type' => ['required', 'string'],
            'payoutmethod.max_limit' => ['required', 'after_or_equal:min_limit'],
            'payoutmethod.fixed_charge' => ['nullable', 'gt:0'],
            'payoutmethod.percent_charge' => ['nullable', 'between:0,100'],
            'payoutmethod.instruction' => ['required', 'string'],
            'payoutmethod.image'  => 'nullable|image|max:2000',
            'payoutmethod.status' => ['required'],
        ]);

        
        $data = json_encode($request['payoutmethod']['data']) ?? null;
        
       

        
       // dd($preview);
        $request = $request['payoutmethod'];

        $method =  PayoutMethod::findOrFail($id);
        $method->name = $request['name'];
        $method->currency_name = $request['currency_name'];
        $method->charge_type = $request['charge_type'];
        $method->delay = $request['delay'];
        $method->min_limit = $request['min_limit'];
        $method->max_limit = $request['max_limit'];
        $method->fixed_charge = $request['fixed_charge'];
        $method->percent_charge = $request['percent_charge'];
        $method->instruction = $request['instruction'];
        $method->status = $request['status'];
        $method->data = $data; 
        
        if (request()->hasFile('payoutmethod.image')) {
            $method->image = $this->saveFile(request(), 'payoutmethod.image');
        
        }
        $method->save();
               
        return to_route('admin.payout-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayoutMethod  $Payoutmethod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $method = PayoutMethod::find($id);
        $this->removeFile($method->image);
        $method->delete();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        foreach ($request->ids as $id) {
            $method = PayoutMethod::find($id);
            if (file_exists($method->image)) {
                $this->removeFile($method->image);
            }
            $method->delete();
        }
        return back();
    }
}
