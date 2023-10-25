<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array('id' => '6','title' => 'Payout','slug' => 'payout','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:35:06','updated_at' => '2023-03-06 18:35:06'),
            array('id' => '7','title' => 'Prompts','slug' => 'prompts','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:35:30','updated_at' => '2023-03-06 18:35:30'),
            array('id' => '8','title' => 'Ai','slug' => 'ai','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:36:44','updated_at' => '2023-03-06 18:36:44'),
            array('id' => '9','title' => 'New Features','slug' => 'new-features','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:36:50','updated_at' => '2023-03-06 18:36:50'),
            array('id' => '10','title' => 'Nft','slug' => 'nft','type' => 'blog_category','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:37:56','updated_at' => '2023-03-06 18:37:56'),
            array('id' => '11','title' => 'support','slug' => 'support','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:38:24','updated_at' => '2023-03-06 18:38:24'),
            array('id' => '12','title' => 'marketing','slug' => 'marketing','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:38:46','updated_at' => '2023-03-06 18:38:46'),
            array('id' => '13','title' => 'generative','slug' => 'generative','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:39:05','updated_at' => '2023-03-06 18:39:05'),
            array('id' => '14','title' => 'chatbot','slug' => 'chatbot','type' => 'tags','status' => '1','is_featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:39:16','updated_at' => '2023-03-06 18:39:16'),
            array('id' => '23','title' => '#','slug' => '/uploads/demo/1692771227argW4RgZtJ5r5v71cgjd.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:13:47','updated_at' => '2023-08-23 06:13:47'),
            array('id' => '24','title' => '#','slug' => '/uploads/demo/16927712342M6YSxqMGwz4Fppck0bg.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:13:54','updated_at' => '2023-08-23 06:13:54'),
            array('id' => '25','title' => '#','slug' => '/uploads/demo/1692771242d2mCmCOWCk5Siaoor0NW.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:14:02','updated_at' => '2023-08-23 06:14:02'),
            array('id' => '26','title' => '#','slug' => '/uploads/demo/1692771246Ha0xIS1DjFJkYNO57twH.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:14:06','updated_at' => '2023-08-23 06:14:06'),
            array('id' => '27','title' => '#','slug' => '/uploads/demo/1692771250U6bN0971K7eNs3JOcqgJ.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:14:10','updated_at' => '2023-08-23 06:14:10'),
            array('id' => '28','title' => '#','slug' => '/uploads/demo/1692771328OAz3vkHeL5Bry5yOKGKk.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:15:28','updated_at' => '2023-08-23 06:15:28'),
            array('id' => '29','title' => '#','slug' => '/uploads/demo/1692771332NxVZbCx8AQFVRSO849DT.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:15:32','updated_at' => '2023-08-23 06:15:32'),
            array('id' => '30','title' => '#','slug' => '/uploads/demo/1692771337Bebgp57JZ3QA813DcU6p.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:15:37','updated_at' => '2023-08-23 06:15:37'),
            array('id' => '31','title' => '#','slug' => '/uploads/demo/16927713420APh5TkyBciWPG3FOXlR.png','type' => 'brand','status' => '1','is_featured' => '1','lang' => 'partner','created_at' => '2023-08-23 06:15:42','updated_at' => '2023-08-23 06:15:42')
          );
          

        Category::insert($categories);

    }
}
