<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promptcategoryimage;
class PromptcategoryimagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promptcategoryimages = array(
            array('id' => '4','promptcategory_id' => '37','name' => 'code','url' => '/uploads/demo/1692805144IQ6w5pTiCsulXnAiU6vC.webp','created_at' => '2023-08-23 15:39:04','updated_at' => '2023-08-23 15:39:04'),
            array('id' => '5','promptcategory_id' => '37','name' => 'doc','url' => '/uploads/demo/16928051549FC8aFsSwwTNGfwrPdUK.webp','created_at' => '2023-08-23 15:39:14','updated_at' => '2023-08-23 15:39:14'),
            array('id' => '6','promptcategory_id' => '37','name' => 'settings','url' => '/uploads/demo/1692805167iNzakxV5bpPBanlrXpuU.webp','created_at' => '2023-08-23 15:39:27','updated_at' => '2023-08-23 15:39:27'),
            array('id' => '7','promptcategory_id' => '37','name' => 'search','url' => '/uploads/demo/1692805179hF692mC6pnjjGM093oKs.webp','created_at' => '2023-08-23 15:39:39','updated_at' => '2023-08-23 15:39:39'),
            array('id' => '8','promptcategory_id' => '37','name' => 'edit','url' => '/uploads/demo/1692805193xCHJxkz64dUMuOb6R3XA.webp','created_at' => '2023-08-23 15:39:53','updated_at' => '2023-08-23 15:39:53'),
            array('id' => '9','promptcategory_id' => '33','name' => 'code','url' => '/uploads/demo/1692805144IQ6w5pTiCsulXnAiU6vC.webp','created_at' => '2023-08-23 15:39:04','updated_at' => '2023-08-23 15:39:04'),
            array('id' => '10','promptcategory_id' => '33','name' => 'doc','url' => '/uploads/demo/16928051549FC8aFsSwwTNGfwrPdUK.webp','created_at' => '2023-08-23 15:39:14','updated_at' => '2023-08-23 15:39:14'),
            array('id' => '11','promptcategory_id' => '33','name' => 'settings','url' => '/uploads/demo/1692805167iNzakxV5bpPBanlrXpuU.webp','created_at' => '2023-08-23 15:39:27','updated_at' => '2023-08-23 15:39:27'),
            array('id' => '12','promptcategory_id' => '33','name' => 'search','url' => '/uploads/demo/1692805179hF692mC6pnjjGM093oKs.webp','created_at' => '2023-08-23 15:39:39','updated_at' => '2023-08-23 15:39:39'),
            array('id' => '13','promptcategory_id' => '33','name' => 'edit','url' => '/uploads/demo/1692805193xCHJxkz64dUMuOb6R3XA.webp','created_at' => '2023-08-23 15:39:53','updated_at' => '2023-08-23 15:39:53'),
            array('id' => '14','promptcategory_id' => '38','name' => 'code','url' => '/uploads/demo/1692805144IQ6w5pTiCsulXnAiU6vC.webp','created_at' => '2023-08-23 15:39:04','updated_at' => '2023-08-23 15:39:04'),
            array('id' => '15','promptcategory_id' => '38','name' => 'doc','url' => '/uploads/demo/16928051549FC8aFsSwwTNGfwrPdUK.webp','created_at' => '2023-08-23 15:39:14','updated_at' => '2023-08-23 15:39:14'),
            array('id' => '16','promptcategory_id' => '38','name' => 'settings','url' => '/uploads/demo/1692805167iNzakxV5bpPBanlrXpuU.webp','created_at' => '2023-08-23 15:39:27','updated_at' => '2023-08-23 15:39:27'),
            array('id' => '17','promptcategory_id' => '38','name' => 'search','url' => '/uploads/demo/1692805179hF692mC6pnjjGM093oKs.webp','created_at' => '2023-08-23 15:39:39','updated_at' => '2023-08-23 15:39:39'),
            array('id' => '18','promptcategory_id' => '38','name' => 'edit','url' => '/uploads/demo/1692805193xCHJxkz64dUMuOb6R3XA.webp','created_at' => '2023-08-23 15:39:53','updated_at' => '2023-08-23 15:39:53'),
            array('id' => '19','promptcategory_id' => '34','name' => 'code','url' => '/uploads/demo/1692805144IQ6w5pTiCsulXnAiU6vC.webp','created_at' => '2023-08-23 15:39:04','updated_at' => '2023-08-23 15:39:04'),
            array('id' => '20','promptcategory_id' => '34','name' => 'doc','url' => '/uploads/demo/16928051549FC8aFsSwwTNGfwrPdUK.webp','created_at' => '2023-08-23 15:39:14','updated_at' => '2023-08-23 15:39:14'),
            array('id' => '21','promptcategory_id' => '34','name' => 'settings','url' => '/uploads/demo/1692805167iNzakxV5bpPBanlrXpuU.webp','created_at' => '2023-08-23 15:39:27','updated_at' => '2023-08-23 15:39:27'),
            array('id' => '22','promptcategory_id' => '34','name' => 'search','url' => '/uploads/demo/1692805179hF692mC6pnjjGM093oKs.webp','created_at' => '2023-08-23 15:39:39','updated_at' => '2023-08-23 15:39:39'),
            array('id' => '23','promptcategory_id' => '34','name' => 'edit','url' => '/uploads/demo/1692805193xCHJxkz64dUMuOb6R3XA.webp','created_at' => '2023-08-23 15:39:53','updated_at' => '2023-08-23 15:39:53'),
            array('id' => '24','promptcategory_id' => '39','name' => 'code','url' => '/uploads/demo/1692805144IQ6w5pTiCsulXnAiU6vC.webp','created_at' => '2023-08-23 15:39:04','updated_at' => '2023-08-23 15:39:04'),
            array('id' => '25','promptcategory_id' => '39','name' => 'doc','url' => '/uploads/demo/16928051549FC8aFsSwwTNGfwrPdUK.webp','created_at' => '2023-08-23 15:39:14','updated_at' => '2023-08-23 15:39:14'),
            array('id' => '26','promptcategory_id' => '39','name' => 'settings','url' => '/uploads/demo/1692805167iNzakxV5bpPBanlrXpuU.webp','created_at' => '2023-08-23 15:39:27','updated_at' => '2023-08-23 15:39:27'),
            array('id' => '27','promptcategory_id' => '39','name' => 'search','url' => '/uploads/demo/1692805179hF692mC6pnjjGM093oKs.webp','created_at' => '2023-08-23 15:39:39','updated_at' => '2023-08-23 15:39:39'),
            array('id' => '28','promptcategory_id' => '39','name' => 'edit','url' => '/uploads/demo/1692805193xCHJxkz64dUMuOb6R3XA.webp','created_at' => '2023-08-23 15:39:53','updated_at' => '2023-08-23 15:39:53'),
            array('id' => '29','promptcategory_id' => '35','name' => 'code','url' => '/uploads/demo/1692805144IQ6w5pTiCsulXnAiU6vC.webp','created_at' => '2023-08-23 15:39:04','updated_at' => '2023-08-23 15:39:04'),
            array('id' => '30','promptcategory_id' => '35','name' => 'doc','url' => '/uploads/demo/16928051549FC8aFsSwwTNGfwrPdUK.webp','created_at' => '2023-08-23 15:39:14','updated_at' => '2023-08-23 15:39:14'),
            array('id' => '31','promptcategory_id' => '35','name' => 'settings','url' => '/uploads/demo/1692805167iNzakxV5bpPBanlrXpuU.webp','created_at' => '2023-08-23 15:39:27','updated_at' => '2023-08-23 15:39:27'),
            array('id' => '32','promptcategory_id' => '35','name' => 'search','url' => '/uploads/demo/1692805179hF692mC6pnjjGM093oKs.webp','created_at' => '2023-08-23 15:39:39','updated_at' => '2023-08-23 15:39:39'),
            array('id' => '33','promptcategory_id' => '35','name' => 'edit','url' => '/uploads/demo/1692805193xCHJxkz64dUMuOb6R3XA.webp','created_at' => '2023-08-23 15:39:53','updated_at' => '2023-08-23 15:39:53'),
            array('id' => '34','promptcategory_id' => '38','name' => 'Businesses','url' => '/uploads/demo/16928091511X9Y5g4CYEJAxqBWMUVw.webp','created_at' => '2023-08-23 16:45:51','updated_at' => '2023-08-23 16:45:51'),
            array('id' => '35','promptcategory_id' => '38','name' => 'chatbot','url' => '/uploads/demo/1692809167hWP104GZJcdhrjuKOmDK.webp','created_at' => '2023-08-23 16:46:07','updated_at' => '2023-08-23 16:46:07'),
            array('id' => '36','promptcategory_id' => '38','name' => 'seo','url' => '/uploads/demo/1692809176t3Mkz3ss5UrUSboLG3Rh.webp','created_at' => '2023-08-23 16:46:16','updated_at' => '2023-08-23 16:46:16')
          );
          
        Promptcategoryimage::insert($promptcategoryimages);
    }
}
