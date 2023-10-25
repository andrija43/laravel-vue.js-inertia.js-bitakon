<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = array(
            array('id' => '1','title' => 'Why does your business need a chatbot?','slug' => 'why-does-your-business-need-a-chatbot','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 10:17:03','updated_at' => '2023-03-06 10:17:03'),
            array('id' => '2','title' => 'Do I need a credit card to sign up?','slug' => 'do-i-need-a-credit-card-to-sign-up','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 10:17:50','updated_at' => '2023-03-06 10:17:50'),
            array('id' => '3','title' => 'Do you offer a 30 day money-back guarantee?','slug' => 'do-you-offer-a-30-day-money-back-guarantee','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 10:18:16','updated_at' => '2023-03-06 10:18:16'),
            array('id' => '5','title' => 'Bessie Cooper','slug' => 'Vp People','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 17:54:06','updated_at' => '2023-03-06 17:54:06'),
            array('id' => '7','title' => 'Rhonda Ortiz','slug' => 'Founder & CO','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 17:55:23','updated_at' => '2023-03-06 17:55:23'),
            array('id' => '8','title' => 'Updates to Payout Cycles & Minimum Payouts','slug' => 'updates-to-payout-cycles-minimum-payouts','type' => 'blog','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:50:45','updated_at' => '2023-08-23 06:28:09'),
            array('id' => '9','title' => 'Exploring the layers of who\'s the Controller now?','slug' => 'exploring-the-layers-of-whos-the-controller-now','type' => 'blog','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 18:57:44','updated_at' => '2023-08-23 06:22:54'),
            array('id' => '10','title' => 'On abuse of power and power Of the Collective','slug' => 'on-abuse-of-power-and-power-of-the-collective','type' => 'blog','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 19:00:52','updated_at' => '2023-08-23 06:22:34'),
            array('id' => '12','title' => 'Keith Powers','slug' => 'Developer','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 19:23:24','updated_at' => '2023-03-06 19:23:24'),
            array('id' => '13','title' => 'Mary','slug' => 'Digital Marketer','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 19:24:12','updated_at' => '2023-03-06 19:25:36'),
            array('id' => '14','title' => 'Clinton Ramosup','slug' => 'Freelancer','type' => 'testimonial','status' => '1','featured' => '1','lang' => '5','created_at' => '2023-03-06 19:24:59','updated_at' => '2023-03-06 19:25:22'),
            array('id' => '15','title' => 'Financial Services','slug' => 'financial-services','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 19:30:09','updated_at' => '2023-03-06 19:30:09'),
            array('id' => '16','title' => 'How it will take impact for Food & Restaurants business.','slug' => 'how-it-will-take-impact-for-food-restaurants-business','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 19:31:09','updated_at' => '2023-03-06 19:31:09'),
            array('id' => '19','title' => 'Buy & Sell your Prompts','slug' => '/uploads/23/08/1693376244pN5qNYvf6VE2bZmMr0E9.png','type' => 'feature','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-06 23:32:24','updated_at' => '2023-08-03 17:08:32'),
            array('id' => '20','title' => 'Add your Prompts','slug' => '/uploads/23/08/1693376031Yl3WRklP0u1hYIbrVz4W.png','type' => 'feature','status' => '1','featured' => '0','lang' => 'en','created_at' => '2023-03-07 08:02:46','updated_at' => '2023-08-03 17:05:41'),
            array('id' => '21','title' => 'Create your Collection','slug' => '/uploads/23/08/1693375911XVH0JUGUggysSx4jzI0o.png','type' => 'feature','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-07 08:13:22','updated_at' => '2023-08-03 17:04:31'),
            array('id' => '22','title' => 'Set up your Account','slug' => '/uploads/23/08/169337577782hDLeCpqoQAP9LZzW1i.png','type' => 'feature','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-03-07 08:22:38','updated_at' => '2023-08-03 17:03:45'),
            array('id' => '23','title' => 'Automatically sync in real time','slug' => 'top','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 19:39:14','updated_at' => '2023-04-09 19:39:14'),
            array('id' => '24','title' => 'Do I need a credit card to sign up?','slug' => 'top','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 19:39:50','updated_at' => '2023-04-09 19:39:50'),
            array('id' => '25','title' => 'Free 10 Days Trial','slug' => 'top','type' => 'faq','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 19:40:59','updated_at' => '2023-04-09 19:40:59'),
            array('id' => '26','title' => 'Terms and conditions','slug' => 'terms-and-conditions','type' => 'page','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 19:40:59','updated_at' => '2023-04-09 19:40:59'),
          
            array('id' => '28','title' => 'Bessie Cooper','slug' => 'Co-founder','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-09-16 14:30:06','updated_at' => '2023-09-16 14:32:10'),
            array('id' => '29','title' => 'Mark Cuban','slug' => 'Co-founder','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-09-16 14:56:45','updated_at' => '2023-09-16 14:56:45'),
            array('id' => '30','title' => 'Esther Howard','slug' => 'UI Designer','type' => 'team','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-09-16 14:58:43','updated_at' => '2023-09-16 14:58:43'),
            array('id' => '27','title' => 'Privacy policy','slug' => 'privacy-policy','type' => 'page','status' => '1','featured' => '1','lang' => 'en','created_at' => '2023-04-09 19:40:59','updated_at' => '2023-04-09 19:40:59')
          );
     Post::insert($posts);
     
    }
}
