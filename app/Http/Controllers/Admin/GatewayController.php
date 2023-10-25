<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gateway;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Traits\Uploader;
class GatewayController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:gateways'); 
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
                'name' => '<i class="fa fa-plus"></i>&nbsp;'.__('Create A Manual Gateway'),
                'url' => route('admin.gateways.create'),
            ]
        ];

        $gateways = Gateway::get();
        $active_gateway = Gateway::where('status',1)->count();
        $totalGateways = count($gateways);
        $inactive_gateway = $totalGateways-$active_gateway;
        return Inertia::render('Admin/Gateway/Index', compact('gateways','active_gateway','totalGateways','inactive_gateway','segments','buttons'));
        
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
                'url' => route('admin.gateways.index'),
            ]
        ];

        return Inertia::render('Admin/Gateway/Create', compact('segments','buttons'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|unique:gateways,name',
            'comment'    => 'max:1000',
            'logo'       => 'nullable|image|max:1024',
            'charge'     => 'required',
            'currency'   => 'required',
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'min:0', 'gte:min_amount'],
        ]);

        $gateway = new Gateway();

        if ($request->hasFile('logo')) {
            $gateway->logo = $this->saveFile($request, 'logo');
        }

        $gateway->currency = $request->currency;
        $gateway->name = $request->name;
        $gateway->charge = $request->charge;
        $gateway->multiply = $request->multiply ?? 0;
        $gateway->namespace = 'App\Gateway\CustomGateway';
        $gateway->is_auto = 0;
        $gateway->image_accept = $request->image_accept;
        $gateway->status = $request->status;
        $gateway->comment = $request->comment;
        $gateway->save();

        return Inertia::location(route('admin.gateways.index'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.gateways.index'),
            ]
        ];

        $gateway = Gateway::findOrFail($id);
        if($gateway->is_auto == 1){
            $credentials = json_decode($gateway->data ?? '');
        }
        else{
            $credentials = [];
        }
       

        return Inertia::render('Admin/Gateway/Edit', compact('segments','buttons','gateway','credentials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
        $request->validate([
            'name' => 'required|unique:gateways,name,' . $id,
            'logo' => 'nullable|image|max:1000',
            'charge' => 'required',
            'namespace' => 'nullable',
            'currency' => 'required',
            'min_amount' => ['required', 'numeric', 'min:0'],
            'max_amount' => ['required', 'numeric', 'min:0', 'gte:min_amount'],
        ]);

        $gateway = Gateway::findOrFail($id);

        if ($gateway->is_auto == 0) {
            $request->validate([
                'comment' => 'required',
            ]);
        } else {
            $gateway->data = $request->credentials ? json_encode($request->credentials) : '';
        }
        if ($request->hasFile('logo')) {
            $this->removeFile($gateway->logo);
            $gateway->logo = $this->saveFile($request, 'logo');
        }

        $gateway->comment    = $request->comment;
        $gateway->name       = $request->name;
        $gateway->charge     = $request->charge;
        $gateway->multiply = $request->multiply ?? 0;
        $gateway->currency   = $request->currency;
        $gateway->test_mode  = $request->test_mode ?? 0;
        $gateway->status     = $request->status;
        $gateway->min_amount = $request->min_amount;
        $gateway->max_amount = $request->max_amount;        
        $gateway->save();

        return back();
    }
}
