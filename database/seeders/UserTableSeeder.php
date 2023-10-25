<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $super = User::create([
            'role' => 'admin',
            'avatar' => '/uploads/avatar.png',
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        //create permission
        $permissions = [
          
            [
                'group_name' => 'Appearance',
                'permissions' => [
                    'about',
                    'blogs',
                    'blogs-category',
                    'blog-tags',
                    'faq',
                    'features',
                    'team',
                    'language',
                    'menu',
                    'custom-page',
                    'partners',
                    'seo',
                    'testimonials'


                ]
            ],
            [
                'group_name' => 'Site Settings',
                'permissions' => [
                    'page-settings',
                    'admin',
                    'developer-settings',
                    'roles',


                ]
            ],
            [
                'group_name' => 'User Logs',
                'permissions' => [
                    'payouts',
                    'customer',
                    'notification',
                ]
            ],
           
            [
                'group_name' => 'Marketplace',
                'permissions' => [
                    'prompt-models',
                    'prompt-categories',
                    'cron-job',
                    'gateways',
                    'order',
                    'support',
                ]
            ],


        ];

        //assign permission

        foreach ($permissions as $key => $row) {


            foreach ($row['permissions'] as $per) {
                $permission = Permission::create(['name' => $per, 'group_name' => $row['group_name']]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
                $super->assignRole($roleSuperAdmin);
            }
        }


        $users = array(
            array('id' => '2','name' => 'Ashik','username' => 'quasdoloressuntt','avatar' => '/uploads/demo/1692809000sz79V6Rx7uiLx00KdDPe.webp','cover_image' => NULL,'authkey' => 'cjJ8IuPhgd1AoZ51vutnaB6Io3b3HZpNEB1yJfsaCcnqq1Wubl','wallet' => '0','credits' => '0','role' => 'user','email' => 'user9@email.com','phone' => '34534567567','country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$1uvFwWGL2DWzwkv3sRAp7egtg.8YPVXILJ.HS.vh3ra5sIJ05K51C','status' => '1','meta' => '{"socials":{"facebook":"https:\\/\\/codecanyon.net\\/","twitter":"https:\\/\\/codecanyon.net\\/","linkedin":"https:\\/\\/codecanyon.net\\/","dribbble":"https:\\/\\/codecanyon.net\\/"},"bio":"Alex Sterling is a visionary in the realm of AI-driven communication and creative technology. With a passion for crafting meaningful interactions between humans and machines, Alex has carved out a unique role as a Prompt Engineer.","address":"Enim ea saepe ut fac"}','user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-04 14:32:56','updated_at' => '2023-08-23 16:54:34'),
            array('id' => '3','name' => 'Rifat','username' => 'dolorecupiditateex','avatar' => '/uploads/demo/1692809000sz79V6Rx7uiLx00KdDPe.webp','cover_image' => NULL,'authkey' => 'VzoSs0IkuCNVN4qnOtBANStHaTpkWwKXgefDIP1FyCYEGR5iaQ','wallet' => '0','credits' => '0','role' => 'user','email' => 'user8@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$kzN6ktY1ZZPzPHFMn7a0aOnjHXLLJnpsfBoWAiWiS0f0kXO15nYDS','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-05 16:44:05','updated_at' => '2023-08-05 16:44:05'),
            array('id' => '4','name' => 'Riyad','username' => 'omnisdoloremestve','avatar' => '/uploads/demo/1692816090n0Hc21koS8W84LP6Y8xY.jpg','cover_image' => NULL,'authkey' => 'vbdeyKKqoA7XGzZcvCVIhC1sDvDawD77LCxRUiB798H3Xowgu8','wallet' => '22.8','credits' => '0','role' => 'user','email' => 'user7@email.com','phone' => '1234567890','country' => 'Anguilla','email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$TxfxBlTQKHEKvkXJiIKGoero5zuQapizUWR8noKJiIYRog5htSt8G','status' => '1','meta' => '{"socials":{"facebook":"https:\\/\\/www.facebook.com","twitter":"https:\\/\\/twitter.com\\/","linkedin":"https:\\/\\/www.linkedin.com\\/","dribbble":"https:\\/\\/dribbble.com\\/"},"bio":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since","address":"Illo minus sequi vol"}','user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-06 08:06:10','updated_at' => '2023-08-23 18:41:30'),
            array('id' => '5','name' => 'obcaecati','username' => 'obcaecati','avatar' => '/uploads/demo/1692804363wc26GmO3R3YpPwJEXniQ.webp','cover_image' => NULL,'authkey' => 'WXJaUUyiIzsK75szxs4E4rIklQy1zHL3W1QcFU0trl3ZQdxA0s','wallet' => '26.6','credits' => '200','role' => 'user','email' => 'user@email.com','phone' => '3536456456456','country' => 'Bangladesh','email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$LuwuU9uEj1PIr3H5h0aiM.B3/sVPhPJeUo7ZOALa3QoLvtY.15eTi','status' => '1','meta' => '{"socials":{"facebook":"https:\\/\\/www.civa.org.uk","twitter":"https:\\/\\/www.myh.cc","linkedin":"https:\\/\\/www.saw.mobi","dribbble":"https:\\/\\/www.cetoniganoky.info"},"bio":"Iure illo est dolor","address":"Rerum reiciendis ame"}','user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-06 08:16:17','updated_at' => '2023-08-23 17:14:01'),
            array('id' => '6','name' => 'obcaecatiffr','username' => 'obcaecatiffr','avatar' => NULL,'cover_image' => NULL,'authkey' => 'fAr5t6F8lh4S6FKYZUfxpPFM4dHKQSvoLQGM4FEPAtsC0htX8c','wallet' => '0','credits' => '0','role' => 'user','email' => 'user6@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$1uvFwWGL2DWzwkv3sRAp7egtg.8YPVXILJ.HS.vh3ra5sIJ05K51C','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-13 16:54:42','updated_at' => '2023-08-13 16:54:42'),
            array('id' => '7','name' => 'Mollitia','username' => 'mollitia','avatar' => '/uploads/demo/1692814379KqYhAHQKywS2JyipJyB1.webp','cover_image' => NULL,'authkey' => 'ojjyMkQqlrUNtWy0CydVym1JJPHvqILcAN7ZmDJPXMtK83oL5w','wallet' => '10.45','credits' => '0','role' => 'user','email' => 'user1@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$znKxRRsxoFy3O2oxH7rWmOcwSWBJ1VYrgxiRwPBTiZUvnuXwbU7W6','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-21 15:20:51','updated_at' => '2023-08-23 18:12:59'),
            array('id' => '8','name' => 'Eaque','username' => 'eaque','avatar' => '/uploads/demo/1692815448fszNGgjYYvMSDdH5S2YV.webp','cover_image' => NULL,'authkey' => 'hanfOg6OMOCLzxraSOtlDtNkYzVvMSGvTO8HCIQnnVulqIBkWw','wallet' => '10.45','credits' => '0','role' => 'user','email' => 'user2@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$fG/P6.g5mLKDCewPqFwQteSETHwpUGQAKKEKTzeRscPtuN0dR5fyK','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-21 15:21:09','updated_at' => '2023-08-23 18:30:48'),
            array('id' => '9','name' => 'Modi','username' => 'modi','avatar' => NULL,'cover_image' => NULL,'authkey' => 'KBmyMtRvfKAHs2PX6JqcgBLB7ZBAQA7PI0DjouYrLPldVrR2GR','wallet' => '0','credits' => '0','role' => 'user','email' => 'user3@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$BcFOonZLG8/jwGzHuyQlnOJ5dR.TNankfjvHNsBKCkn1V5mhognYi','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-21 15:21:29','updated_at' => '2023-08-21 15:21:29'),
            array('id' => '10','name' => 'Culpa et commodo vol','username' => 'culpaetcommodovol','avatar' => NULL,'cover_image' => NULL,'authkey' => 'mrd7SVkZ5nOvBoU9o3FV9OFdlUIiShLU45pBke0R12lq1Z9Geh','wallet' => '0','credits' => '0','role' => 'user','email' => 'user4@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$ZcvL8xY4H7wjfcLkN6ku7utQ1UWGNkU1LR5f4p9UHCTDjUrfJ63UW','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-21 15:21:45','updated_at' => '2023-08-21 15:21:45'),
            array('id' => '11','name' => 'Consequatur dolorem','username' => 'consequaturdolorem','avatar' => '/uploads/demo/1692816170XJe5FF63NMUTrBc2Uoy7.webp','cover_image' => NULL,'authkey' => 'Swgnup2wuZXNhn78Zz7DHtdsP49PHhYvJ2JoOA5rYPRG70BFpP','wallet' => '0','credits' => '0','role' => 'user','email' => 'user5@email.com','phone' => NULL,'country' => NULL,'email_verified_at' => NULL,'kyc_verified_at' => NULL,'password' => '$2y$10$rf2LFQDLbTCN9G3qIARTReDQtVOxv9h2wN77Cy2KPsI.7a2jALOvK','status' => '1','meta' => NULL,'user_id' => NULL,'remember_token' => NULL,'created_at' => '2023-08-21 15:21:59','updated_at' => '2023-08-23 18:42:50')
          );
         
          User::insert($users);  
    }
}
