<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discount;
class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discounts = array(
            array('id' => '3','prompt_id' => '6','will_expire' => '2024-12-24','percentage' => '10','created_at' => '2023-08-07 05:31:18','updated_at' => '2023-08-23 15:15:11'),
            array('id' => '4','prompt_id' => '5','will_expire' => '2025-12-23','percentage' => '9','created_at' => '2023-08-23 15:18:49','updated_at' => '2023-08-23 15:18:49'),
            array('id' => '5','prompt_id' => '33','will_expire' => '2025-10-30','percentage' => '5','created_at' => '2023-08-23 16:01:59','updated_at' => '2023-08-23 16:01:59'),
            array('id' => '6','prompt_id' => '32','will_expire' => '2025-11-23','percentage' => '6','created_at' => '2023-08-23 16:02:29','updated_at' => '2023-08-23 16:02:29'),
            array('id' => '7','prompt_id' => '31','will_expire' => '2025-12-19','percentage' => '3','created_at' => '2023-08-23 16:03:00','updated_at' => '2023-08-23 16:03:00'),
            array('id' => '8','prompt_id' => '26','will_expire' => '2025-12-23','percentage' => '3','created_at' => '2023-08-23 16:03:36','updated_at' => '2023-08-23 16:03:36'),
            array('id' => '9','prompt_id' => '27','will_expire' => '2025-12-23','percentage' => '5','created_at' => '2023-08-23 17:15:24','updated_at' => '2023-08-23 17:15:24'),
            array('id' => '10','prompt_id' => '25','will_expire' => '2025-12-24','percentage' => '5','created_at' => '2023-08-23 17:25:55','updated_at' => '2023-08-23 17:25:55'),
            array('id' => '11','prompt_id' => '24','will_expire' => '2025-12-25','percentage' => '5','created_at' => '2023-08-23 17:28:27','updated_at' => '2023-08-23 17:28:27')
          );
          
        Discount::insert($discounts);
    }
}
