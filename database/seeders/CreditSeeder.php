<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Creditlog;
class CreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creditlogs = array(
            array('id' => '1','user_id' => '1','price' => '100','credits' => '100','payment_id' => '4zDgGrV48Ro38cG118','gateway_id' => '9','status' => '1','meta' => '','created_at' => Carbon::now()->subDays(7),'updated_at' => Carbon::now()->subDays(7)),
            array('id' => '2','user_id' => '2','price' => '200','credits' => '200','payment_id' => '6z6644DgGrV48Ro38cG118','gateway_id' => '8','status' => '1','meta' => '','created_at' => Carbon::now()->subDays(5),'updated_at' => Carbon::now()->subDays(5)),
            array('id' => '3','user_id' => '3','price' => '150','credits' => '150','payment_id' => '534646786786nvf123','gateway_id' => '7','status' => '1','meta' => '','created_at' => Carbon::now()->subDays(2),'updated_at' => Carbon::now()->subDays(2)),
            array('id' => '4','user_id' => '4','price' => '300','credits' => '300','payment_id' => '57567562342367','gateway_id' => '3','status' => '1','meta' => '','created_at' => now(),'updated_at' => now()),
           
        );

        Creditlog::insert($creditlogs);
          
    }
}
