<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PayoutMethod;
class PayoutmethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payout_methods = array(
            array('id' => '1','currency_name' => 'USD','name' => 'Payoneer','image' => '/uploads/23/08/1691475401sWfBOSPA4Zt1ljNTtL0z.png','min_limit' => '1','max_limit' => '20000','delay' => '10','charge_type' => 'fixed','fixed_charge' => '2','percent_charge' => NULL,'data' => '[{"type": "text", "label": "Account Name"}, {"type": "email", "label": "Email Address"}]','instruction' => '<p>For any kind of business loss we will not take liability for it..</p>','status' => '1','created_at' => '2023-08-08 06:16:41','updated_at' => '2023-08-08 06:16:41')
        );

        PayoutMethod::insert($payout_methods);
    }
}
