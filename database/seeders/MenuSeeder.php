<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = array(
            array('id' => '1','name' => 'Header','position' => 'main-menu','data' => '[{"id":"e95lu1cs","text":"Home","icon":null,"href":"\\/","target":"_self","title":null,"children":[]},{"id":"6d7q03p1","text":"Prompts","icon":null,"href":"\\/prompt","target":"_self","title":null,"children":[]},{"id":"6aq2z5n9","text":"Authors","icon":null,"href":"\\/top-sellers","target":"_self","title":null,"children":[]},{"id":"6teppfjx","text":"Collections","icon":null,"href":"\\/collection","target":"_self","title":null,"children":[]},{"id":"fzoydss6","text":"On Sell","icon":null,"href":"\\/discounts","target":"_self","title":null,"children":[]},{"id":"b2hbs7ik","text":"Blog","icon":null,"href":"\\/blogs","target":"_self","title":null,"children":[]},{"id":"h7hrsutc","text":"Contact Us","icon":null,"href":"\\/contact","target":"_self","title":null,"children":[]}]','lang' => 'en','status' => '1','created_at' => '2023-08-03 16:57:06','updated_at' => '2023-08-21 15:19:44'),
            array('id' => '2','name' => 'Market','position' => 'footer-left','data' => '[{"id":"ctw391xu","text":"Create A Shop","icon":null,"href":"\\/register","target":"_self","title":null,"children":[]},{"id":"7u90osuc","text":"List a Item","icon":null,"href":"\\/account\\/prompt\\/create","target":"_self","title":null,"children":[]},{"id":"4r8wupe3","text":"Start Selling","icon":null,"href":"\\/account\\/prompt","target":"_self","title":null,"children":[]},{"id":"k15ht8xt","text":"My Account","icon":null,"href":"\\/account","target":"_self","title":null,"children":[]},{"id":"2lgxqgjs","text":"Shop","icon":null,"href":"\\/prompt","target":"_self","title":null,"children":[]}]','lang' => 'en','status' => '1','created_at' => '2023-08-16 17:33:43','updated_at' => '2023-08-16 17:40:17'),
            array('id' => '3','name' => 'Community','position' => 'footer-center','data' => '[{"id":"gaj7mxr8","text":"Collections","icon":null,"href":"\\/collection","target":"_self","title":null,"children":[]},{"id":"8c6fkq6c","text":"About Us","icon":null,"href":"\\/about","target":"_self","title":null,"children":[]},{"id":"law145ip","text":"Latest News","icon":null,"href":"\\/blogs","target":"_self","title":null,"children":[]},{"id":"ekteoag9","text":"Discussion","icon":null,"href":"\\/contact","target":"_self","title":null,"children":[]},{"id":"cbrdfgnc","text":"Orders","icon":null,"href":"\\/dashboard\\/orders","target":"_self","title":null,"children":[]}]','lang' => 'en','status' => '1','created_at' => '2023-08-16 17:33:58','updated_at' => '2023-08-20 16:27:17'),
            array('id' => '4','name' => 'Resources','position' => 'footer-right','data' => '[{"id":"d49e2gaz","text":"Generate","icon":null,"href":"\\/generate","target":"_self","title":null,"children":[]},{"id":"ahjc6sxa","text":"Explore Prompts","icon":null,"href":"\\/prompt","target":"_self","title":null,"children":[]},{"id":"h59zzusx","text":"Help center","icon":null,"href":"\\/contact","target":"_self","title":null,"children":[]},{"id":"iimp8pdz","text":"Faqs","icon":null,"href":"\\/faq","target":"_self","title":null,"children":[]}]','lang' => 'en','status' => '1','created_at' => '2023-08-16 17:34:10','updated_at' => '2023-08-20 16:55:40'),
           
          );

          
        Menu::insert($menus);
    }
}
