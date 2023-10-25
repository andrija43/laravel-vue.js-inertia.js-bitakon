<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Orderitem;
use Carbon\Carbon;
class OrderitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderitems = array(
            array('id' => '1','order_id' => '1','prompt_id' => '6','user_id' => '5','amount' => '8','seller_amount' => '7.6','commissions' => '0.4','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(7)),
            array('id' => '2','order_id' => '1','prompt_id' => '5','user_id' => '5','amount' => '11','seller_amount' => '10.45','commissions' => '0.55','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(7)),
            array('id' => '3','order_id' => '2','prompt_id' => '5','user_id' => '5','amount' => '20','seller_amount' => '10.45','commissions' => '0.55','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' =>Carbon::now()->subDays(6)),
            array('id' => '4','order_id' => '3','prompt_id' => '14','user_id' => '8','amount' => '11','seller_amount' => '10.45','commissions' => '0.55','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(5)),
            array('id' => '5','order_id' => '3','prompt_id' => '9','user_id' => '7','amount' => '11','seller_amount' => '10.45','commissions' => '0.55','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(5)),
            array('id' => '6','order_id' => '4','prompt_id' => '26','user_id' => '4','amount' => '5','seller_amount' => '4.75','commissions' => '0.25','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(4)),
            array('id' => '7','order_id' => '4','prompt_id' => '33','user_id' => '4','amount' => '5','seller_amount' => '4.75','commissions' => '0.25','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(4)),
            array('id' => '8','order_id' => '4','prompt_id' => '32','user_id' => '4','amount' => '5','seller_amount' => '4.75','commissions' => '0.25','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(4)),
            array('id' => '9','order_id' => '4','prompt_id' => '31','user_id' => '4','amount' => '9','seller_amount' => '8.55','commissions' => '0.45','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(4)),
            array('id' => '10','order_id' => '5','prompt_id' => '27','user_id' => '5','amount' => '9','seller_amount' => '8.55','commissions' => '0.45','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(4)),
            array('id' => '11','order_id' => '6','prompt_id' => '25','user_id' => '11','amount' => '14','seller_amount' => '8.55','commissions' => '5','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => Carbon::now()->subDays(4)),
            array('id' => '12','order_id' => '7','prompt_id' => '48','user_id' => '7','amount' => '14','seller_amount' => '8.55','commissions' => '5','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => now()),
            array('id' => '13','order_id' => '8','prompt_id' => '48','user_id' => '7','amount' => '14','seller_amount' => '8.55','commissions' => '5','is_refunded' => '0','is_calculated' => '1','created_at' => NULL,'updated_at' => now())
          );
          
        Orderitem::insert($orderitems);
    }
}
