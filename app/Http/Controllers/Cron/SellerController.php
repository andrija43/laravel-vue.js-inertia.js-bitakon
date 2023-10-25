<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\User;
class SellerController extends Controller
{
    public function calculateOrder() {
       $items = Orderitem::whereHas('order', function($q){
             return $q->where('status',1);
       })->with('order','user')->where('is_calculated',0)->where('seller_amount',0)->latest()->get();

       $author_fee = get_option('author_fee');
       foreach ($items as $key => $item) {
            $amount = $item->amount;
            $charge = $author_fee > 0 ? ($amount / 100) * $author_fee : 0;
            $seller_amount = $amount - $charge;
            
           
            Orderitem::where('id',$item->id)->update(['seller_amount'=> $seller_amount, 'is_calculated'=> 1, 'commissions'=>$charge]);

            $user = User::where('id',$item->user_id)->first();
            $user->wallet = $user->wallet+$seller_amount;
            $user->save();
          
       }

     
       return "seller wallet calculated";
    }
}
