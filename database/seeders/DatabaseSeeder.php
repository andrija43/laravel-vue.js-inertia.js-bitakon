<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            GatewayTableSeeder::class,
            OptiontableSeeder::class,
            CategorySeeder::class,
            MenuSeeder::class,
            PostSeeder::class,
            PostmetaSeeder::class,
            PostCategorySeeder::class,
            PromptModelSeeder::class,
            PromptcategorySeeder::class,
            PayoutmethodSeeder::class,
            CollectionSeeder::class,
            PromptSeeder::class,
            PromptcategoryimagesSeeder::class,
            PromptfileSeeder::class,
            PromptmodelrelationsSeeder::class,
            OrderSeeder::class,
            OrderitemSeeder::class,
            DiscountSeeder::class,
            SliderSeeder::class,
            CreditSeeder::class

        ]);
    }
}
