<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Creditlog;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Cache;
use App\Models\Option;
class CreditController extends Controller
{
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
                'name' => '<i class="fa fa-credit-card"></i>&nbsp&nbsp' . __('Credit Recharge Fee'),
                'url' => '#',
                'target' => '#per_credit_fee',

            ],
            [
                'name' => '<i class="fi fi-rs-images"></i>&nbsp&nbsp' . __('Image Generate Fee'),
                'url' => '#',
                'target' => '#image_generate_charge',

            ],
        ];
        $creditlogs = Creditlog::query()
            ->with(['user:id,name,created_at', 'gateway'])
            ->latest()
            ->paginate(10);
        $totalCreditlog = Creditlog::query()->count();
        $activeCreditlog = Creditlog::query()->where('status', 1)->count();
        $inactiveCreditlog = Creditlog::query()->where('status', 0)->count();
        $per_credit_fee = get_option('per_credit_fee');
        $image_generate_charge = get_option('image_generate_charge');

        return Inertia::render('Admin/Credits/Index', [
            'creditlogs' => $creditlogs,
            'per_credit_fee' => $per_credit_fee,
            'image_generate_charge' => $image_generate_charge,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalCreditlog' => $totalCreditlog ?? [],
            'activeCreditlog' => $activeCreditlog ?? [],
            'inactiveCreditlog' => $inactiveCreditlog ?? [],
        ]);
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
        $creditlog = Creditlog::findOrFail($id);

        $request->validate([
            'credits' => 'required',
        ]);
        if ($request->status == 1 && $creditlog->status == 0 || $creditlog->status == 2) {
            $user = User::query()->findOrFail($creditlog->user_id);
            $user->increment('credits', $request->credits ?? $creditlog->credits);
            
        }
        $creditlog->update([
            'credits' => $request->credits,
            'status' => $request->status ?? $creditlog->status,
        ]);

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCreditCharge(Request $request)
    {
        $option = Option::where('key','per_credit_fee')->first();
        $option->value = $request->per_credit_fee;
        $option->save();

        Cache::forget('per_credit_fee');

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateImageGenerateCharge(Request $request)
    {
        $option = Option::where('key','image_generate_charge')->first();
        $option->value = $request->image_generate_charge;
        $option->save();

        Cache::forget('image_generate_charge');

        return back();
    }
}
