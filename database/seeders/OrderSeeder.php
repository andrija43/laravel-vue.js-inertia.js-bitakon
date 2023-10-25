<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = array(
            array('id' => '1','invoice_no' => '0000001','user_id' => '1','amount' => '19','tax' => '0','payment_id' => 'tr_cyNeD23bfg','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => Carbon::now()->subDays(7),'updated_at' =>  Carbon::now()->subDays(7)),
            array('id' => '2','invoice_no' => '0000002','user_id' => '1','amount' => '100','tax' => '0','payment_id' => 'tr_cyNeD23bfg','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => Carbon::now()->subDays(6),'updated_at' =>  Carbon::now()->subDays(6)),
            array('id' => '3','invoice_no' => '0000003','user_id' => '1','amount' => '22','tax' => '0','payment_id' => 'tr_Ppd3PNQkzP','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => Carbon::now()->subDays(5),'updated_at' =>  Carbon::now()->subDays(5)),
            array('id' => '4','invoice_no' => '0000004','user_id' => '6','amount' => '24','tax' => '0','payment_id' => 'tr_eLCED5xk4P','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => Carbon::now()->subDays(4),'updated_at' =>  Carbon::now()->subDays(4)),
            array('id' => '5','invoice_no' => '0000005','user_id' => '6','amount' => '9','tax' => '0','payment_id' => 'tr_S2SQPnYtxo','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => Carbon::now()->subDays(4),'updated_at' =>  Carbon::now()->subDays(4)),
            array('id' => '6','invoice_no' => '0000006','user_id' => '7','amount' => '14.5','tax' => '0','payment_id' => '46456hfgh345','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => Carbon::now()->subDays(4),'updated_at' =>  Carbon::now()->subDays(4)),
            array('id' => '7','invoice_no' => '0000007','user_id' => '4','amount' => '14.5','tax' => '0','payment_id' => '568797823123','gateway_id' => '4','meta' => NULL,'status' => '1','created_at' => now(),'updated_at' => now()),
            array('id' => '8','invoice_no' => '0000008','user_id' => '10','amount' => '18.5','tax' => '0','payment_id' => 'tr_cxCTJkwS7u','gateway_id' => '3','meta' => NULL,'status' => '1','created_at' => now(),'updated_at' => now())
        );
          
        Order::insert($orders);
    }
}
