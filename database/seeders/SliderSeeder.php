<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;
class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = array(
            array('id' => '14','prompt_id' => '26','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:53:37','updated_at' => '2023-08-22 17:53:37'),
            array('id' => '15','prompt_id' => '25','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:53:47','updated_at' => '2023-08-22 17:53:47'),
            array('id' => '16','prompt_id' => '24','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:53:53','updated_at' => '2023-08-22 17:53:53'),
            array('id' => '17','prompt_id' => '21','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:54:04','updated_at' => '2023-08-22 17:54:04'),
            array('id' => '18','prompt_id' => '18','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:54:30','updated_at' => '2023-08-22 17:54:30'),
            array('id' => '19','prompt_id' => '17','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:54:39','updated_at' => '2023-08-22 17:54:39'),
            array('id' => '20','prompt_id' => '16','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:54:46','updated_at' => '2023-08-22 17:54:46'),
            array('id' => '21','prompt_id' => '20','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:58:02','updated_at' => '2023-08-22 17:58:02'),
            array('id' => '22','prompt_id' => '14','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:58:15','updated_at' => '2023-08-22 17:58:15'),
            array('id' => '23','prompt_id' => '12','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:58:28','updated_at' => '2023-08-22 17:58:28'),
            array('id' => '24','prompt_id' => '11','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:58:37','updated_at' => '2023-08-22 17:58:37'),
            array('id' => '25','prompt_id' => '10','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:58:49','updated_at' => '2023-08-22 17:58:49'),
            array('id' => '26','prompt_id' => '9','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:59:01','updated_at' => '2023-08-22 17:59:01'),
            array('id' => '27','prompt_id' => '4','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:59:10','updated_at' => '2023-08-22 17:59:10'),
            array('id' => '28','prompt_id' => '5','meta' => NULL,'status' => '1','created_at' => '2023-08-22 17:59:18','updated_at' => '2023-08-22 17:59:18')
          );
          
        Slider::insert($sliders);
    }
}
