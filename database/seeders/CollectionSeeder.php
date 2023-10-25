<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Collection;
class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = array(
            array('id' => '1','name' => 'Modern Art collection','slug' => 'modern-art-collectionpz','user_id' => '5','preview' => '/uploads/demo/16928157814cCw6fskwyPLZuMMeaKN.jpg','is_featured' => '1','status' => '1','created_at' => '2023-08-06 17:28:12','updated_at' => '2023-08-23 18:36:21'),
            array('id' => '2','name' => '3D Construction Building','slug' => '3d-construction-buildingpg','user_id' => '4','preview' => '/uploads/demo/1692806431csOPDTmk0WizmLbMPNNp.jpg','is_featured' => '1','status' => '1','created_at' => '2023-08-23 16:00:31','updated_at' => '2023-08-23 16:00:31'),
            array('id' => '3','name' => 'NFT Bundle','slug' => 'nft-bundlee6','user_id' => '11','preview' => '/uploads/demo/1692811489dv9OeEy3RSbKADCFJtJf.webp','is_featured' => '1','status' => '1','created_at' => '2023-08-23 17:24:49','updated_at' => '2023-08-23 17:26:27'),
            array('id' => '4','name' => 'Building & Rooms','slug' => 'building-roomsvv','user_id' => '10','preview' => '/uploads/demo/1692812084bQWEAmCZQNS392TkkPVF.webp','is_featured' => '1','status' => '1','created_at' => '2023-08-23 17:34:44','updated_at' => '2023-08-23 17:34:44'),
            array('id' => '5','name' => 'Landscape Bundle','slug' => 'landscape-bundlez0','user_id' => '7','preview' => '/uploads/demo/16928125209Q5NXvN6YjjfrDhaOskY.webp','is_featured' => '1','status' => '1','created_at' => '2023-08-23 17:42:00','updated_at' => '2023-08-23 17:42:00'),
            array('id' => '6','name' => 'App Design Bundle','slug' => 'app-design-bundleqv','user_id' => '7','preview' => '/uploads/demo/1692812809xkgZ7HVFhjq3ORS6LphI.webp','is_featured' => '1','status' => '1','created_at' => '2023-08-23 17:46:49','updated_at' => '2023-08-23 17:46:49'),
            array('id' => '7','name' => 'Automations','slug' => 'automations9h','user_id' => '6','preview' => '/uploads/demo/1692814631PfjrJGcO8wu9D3EX1GLF.webp','is_featured' => '1','status' => '1','created_at' => '2023-08-01 18:17:11','updated_at' => '2023-08-23 18:17:11'),
            array('id' => '8','name' => 'Bundle of Arts','slug' => 'bundle-of-artsaq','user_id' => '8','preview' => '/uploads/demo/1692815428EKvJSyoIULO1PVfsM6oC.jpg','is_featured' => '1','status' => '1','created_at' => '2023-08-23 18:30:28','updated_at' => '2023-08-23 18:30:28')
        );

        Collection::insert($collections);
          
    }
}
