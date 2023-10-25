<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promptcategory;
class PromptcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promptcategories = array(
            array('id' => '6','name' => '3D','slug' => '3d','preview' => '/uploads/23/08/1691309286yYVoy40p31WOxTsWC4Pv.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-06 08:08:06','updated_at' => '2023-08-06 08:08:06'),
            array('id' => '7','name' => 'Art','slug' => 'art','preview' => '/uploads/23/08/1691309366JxluShTcD5Hdy7V8nlSB.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-06 08:09:26','updated_at' => '2023-08-06 08:09:26'),
            array('id' => '8','name' => 'Illustrations','slug' => 'illustrations','preview' => '/uploads/23/08/1691309412JA3lwziqNqgQqCkZatbe.jpg','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '33','status' => '1','created_at' => '2023-08-06 08:10:12','updated_at' => '2023-08-06 08:10:12'),
            array('id' => '10','name' => 'Animals','slug' => 'animals','preview' => '/uploads/demo/1692632193iNp7ks6nP6kkO0eHZMI5.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-21 15:36:33','updated_at' => '2023-08-21 15:36:33'),
            array('id' => '11','name' => 'Anime','slug' => 'anime','preview' => '/uploads/demo/1692632234cVeFgYlXMxDRiBghePyI.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-21 15:37:14','updated_at' => '2023-08-21 15:37:14'),
            array('id' => '12','name' => 'Logo','slug' => 'logo','preview' => '/uploads/demo/1692726093SWTlZIdMYfVv1TWkBA9s.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-21 15:44:42','updated_at' => '2023-08-22 17:41:33'),
            array('id' => '13','name' => 'Buildings','slug' => 'buildings','preview' => '/uploads/demo/169263350955eB8sjEXDbOBsqQEuJR.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-21 15:58:29','updated_at' => '2023-08-21 15:58:29'),
            array('id' => '14','name' => 'Cartoons','slug' => 'cartoons','preview' => '/uploads/demo/1692633539yOiqFVL0XgJC2UqaLIqy.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-21 15:58:59','updated_at' => '2023-08-21 15:58:59'),
            array('id' => '15','name' => 'NFT','slug' => 'nft','preview' => '/uploads/demo/1692633577JUhvq0TYfMtqShExdrMT.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '5','status' => '1','created_at' => '2023-08-21 15:59:37','updated_at' => '2023-08-21 15:59:37'),
            array('id' => '16','name' => '3D','slug' => '3d','preview' => '/uploads/23/08/1691309286yYVoy40p31WOxTsWC4Pv.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-06 08:08:06','updated_at' => '2023-08-06 08:08:06'),
            array('id' => '17','name' => 'Art','slug' => 'art','preview' => '/uploads/23/08/1691309366JxluShTcD5Hdy7V8nlSB.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-06 08:09:26','updated_at' => '2023-08-06 08:09:26'),
            array('id' => '18','name' => 'Illustrations','slug' => 'illustrations','preview' => '/uploads/23/08/1691309412JA3lwziqNqgQqCkZatbe.jpg','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-06 08:10:12','updated_at' => '2023-08-06 08:10:12'),
            array('id' => '19','name' => 'Animals','slug' => 'animals','preview' => '/uploads/demo/1692632193iNp7ks6nP6kkO0eHZMI5.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-21 15:36:33','updated_at' => '2023-08-21 15:36:33'),
            array('id' => '20','name' => 'Anime','slug' => 'anime','preview' => '/uploads/demo/1692632234cVeFgYlXMxDRiBghePyI.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-21 15:37:14','updated_at' => '2023-08-21 15:37:14'),
            array('id' => '21','name' => 'Logo','slug' => 'logo','preview' => '/uploads/demo/1692726117YhzTcoaVegL5RboTxPNC.png','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-21 15:44:42','updated_at' => '2023-08-22 17:41:57'),
            array('id' => '22','name' => 'Buildings','slug' => 'buildings','preview' => '/uploads/demo/169263350955eB8sjEXDbOBsqQEuJR.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-21 15:58:29','updated_at' => '2023-08-21 15:58:29'),
            array('id' => '23','name' => 'Cartoons','slug' => 'cartoons','preview' => '/uploads/demo/1692633539yOiqFVL0XgJC2UqaLIqy.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-21 15:58:59','updated_at' => '2023-08-21 15:58:59'),
            array('id' => '24','name' => 'NFT','slug' => 'nft','preview' => '/uploads/demo/1692633577JUhvq0TYfMtqShExdrMT.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '3','status' => '1','created_at' => '2023-08-21 15:59:37','updated_at' => '2023-08-21 15:59:37'),
            array('id' => '25','name' => 'Art','slug' => 'art','preview' => '/uploads/23/08/1691309366JxluShTcD5Hdy7V8nlSB.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-06 08:09:26','updated_at' => '2023-08-06 08:09:26'),
            array('id' => '26','name' => 'Illustrations','slug' => 'illustrations','preview' => '/uploads/23/08/1691309412JA3lwziqNqgQqCkZatbe.jpg','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-06 08:10:12','updated_at' => '2023-08-06 08:10:12'),
            array('id' => '27','name' => 'Animals','slug' => 'animals','preview' => '/uploads/demo/1692632193iNp7ks6nP6kkO0eHZMI5.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-21 15:36:33','updated_at' => '2023-08-21 15:36:33'),
            array('id' => '28','name' => 'Anime','slug' => 'anime','preview' => '/uploads/demo/1692632234cVeFgYlXMxDRiBghePyI.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-21 15:37:14','updated_at' => '2023-08-21 15:37:14'),
            array('id' => '30','name' => 'Buildings','slug' => 'buildings','preview' => '/uploads/demo/169263350955eB8sjEXDbOBsqQEuJR.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-21 15:58:29','updated_at' => '2023-08-21 15:58:29'),
            array('id' => '31','name' => 'Cartoons','slug' => 'cartoons','preview' => '/uploads/demo/1692633539yOiqFVL0XgJC2UqaLIqy.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-21 15:58:59','updated_at' => '2023-08-21 15:58:59'),
            array('id' => '32','name' => 'NFT','slug' => 'nft','preview' => '/uploads/demo/1692633577JUhvq0TYfMtqShExdrMT.webp','is_filterable' => '1','meta' => NULL,'promptmodel_id' => '4','status' => '1','created_at' => '2023-08-21 15:59:37','updated_at' => '2023-08-21 15:59:37'),
            array('id' => '33','name' => 'Ads','slug' => 'ads','preview' => '/uploads/23/08/1691164173uMlw0v1waLTeu8FrAuaC.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '34','status' => '1','created_at' => '2023-08-04 15:49:33','updated_at' => '2023-08-04 15:49:33'),
            array('id' => '34','name' => 'Business','slug' => 'business','preview' => '/uploads/23/08/16911642178h58SbLJqplXf7KqtHPv.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '34','status' => '1','created_at' => '2023-08-04 15:50:17','updated_at' => '2023-08-04 15:50:17'),
            array('id' => '35','name' => 'Chatbot','slug' => 'chatbot','preview' => '/uploads/23/08/1691164276js1M4CXWj0iDYrLbx5yc.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '34','status' => '1','created_at' => '2023-08-04 15:51:16','updated_at' => '2023-08-04 15:51:16'),
            array('id' => '37','name' => 'Ads','slug' => 'ads','preview' => '/uploads/23/08/1691164173uMlw0v1waLTeu8FrAuaC.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '35','status' => '1','created_at' => '2023-08-04 15:49:33','updated_at' => '2023-08-04 15:49:33'),
            array('id' => '38','name' => 'Business','slug' => 'business','preview' => '/uploads/23/08/16911642178h58SbLJqplXf7KqtHPv.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '35','status' => '1','created_at' => '2023-08-04 15:50:17','updated_at' => '2023-08-04 15:50:17'),
            array('id' => '39','name' => 'Chatbot','slug' => 'chatbot','preview' => '/uploads/23/08/1691164276js1M4CXWj0iDYrLbx5yc.webp','is_filterable' => '0','meta' => NULL,'promptmodel_id' => '35','status' => '1','created_at' => '2023-08-04 15:51:16','updated_at' => '2023-08-04 15:51:16')
        );

        Promptcategory::insert($promptcategories);
    }
}
