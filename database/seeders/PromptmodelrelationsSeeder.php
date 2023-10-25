<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promptmodelrelation;
class PromptmodelrelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promptmodelrelations = array(
            array('prompt_id' => '5','promptmodel_id' => '19'),
            array('prompt_id' => '5','promptmodel_id' => '26'),
            array('prompt_id' => '47','promptmodel_id' => '19'),
            array('prompt_id' => '47','promptmodel_id' => '25'),
            array('prompt_id' => '13','promptmodel_id' => '23'),
            array('prompt_id' => '13','promptmodel_id' => '31'),
            array('prompt_id' => '12','promptmodel_id' => '20'),
            array('prompt_id' => '12','promptmodel_id' => '29'),
            array('prompt_id' => '11','promptmodel_id' => '19'),
            array('prompt_id' => '11','promptmodel_id' => '26')
          );
        Promptmodelrelation::insert($promptmodelrelations);
    }
}
