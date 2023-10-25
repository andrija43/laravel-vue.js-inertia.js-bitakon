<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Option;

class OptiontableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {


    $options = array(
      array('id' => '1','key' => 'primary_data','value' => '{"logo":"\\/uploads\\/logo.png","favicon":"uploads\\/favicon.png","logo_dark":"\\/uploads\\/logo-black.png","contact_email":"contact@email.com","contact_phone":"8801234567890","address":"Bowery St, New York","socials":{"facebook":"https:\\/\\/www.facebook.com\\/","youtube":"https:\\/\\/youtube.com\\/","twitter":"https:\\/\\/twitter.com\\/","instagram":"https:\\/\\/www.instagram.com\\/","linkedin":"https:\\/\\/linkedin.com\\/"},"footer_logo":"\\/uploads\\/23\\/04\\/16809882645YTjTdvCTduL5D1hCfX7.png","marquee":"Discover & Callect Extraordinary Digital Art and Rare Prompts, Discover & Callect Extraordinary Digital Art and Rare Prompts","footer_description":" Ignite creativity! Buy, sell unique inspiration for writers, designers, coders. Thought-provoking prompts, coding challenges, and more. Join now!"}','lang' => 'en'),
      array('id' => '2','key' => 'tax','value' => '2','lang' => 'en'),
      array('id' => '3','key' => 'base_currency','value' => '{"name":"USD","icon":"$","position":"left"}','lang' => 'en'),
      array('id' => '4','key' => 'invoice_data','value' => '{"company_name":"Bitakon","address":"San francisco","city":"California","post_code":"12345","country":"USA"}','lang' => 'en'),
      array('id' => '5','key' => 'languages','value' => '{"en":"English"}','lang' => 'en'),
      array('id' => '6','key' => 'seo_home','value' => '{"site_name":"Home","matatag":"","matadescription":"","twitter_site_title":"home","preview":""}','lang' => 'en'),
      array('id' => '7','key' => 'seo_blog','value' => '{"site_name":"Blogs","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '8','key' => 'seo_about','value' => '{"site_name":"About Us","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '9','key' => 'seo_pricing','value' => '{"site_name":"Pricing","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '10','key' => 'seo_contact','value' => '{"site_name":"Contact Us","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '11','key' => 'seo_faq','value' => '{"site_name":"Faq","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '12','key' => 'seo_team','value' => '{"site_name":"Our Team","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '13','key' => 'seo_features','value' => '{"site_name":"Features","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '15','key' => 'header_footer','value' => '{"header":{"announcement_type":"C:\\\\fakepath\\\\verifay-light.png","announcement_title":"C:\\\\fakepath\\\\verifay-dark.png","announcement_link":"\\/contact"},"footer":{"title":"Ready To Launch \\ud83d\\ude80","description":"Find top prompts, produce better results, save on API costs, sell your own prompts.","right_image_link":"\\/pricing","left_image_link":"\\/pricing"},"certificate_image":"\\/uploads\\/23\\/08\\/1692550731p5g0d5phS9yltXK06PIl.png","certificate_image_dark":"\\/uploads\\/23\\/08\\/16925507314R3n41j685MMuwbhcSDc.png"}','lang' => 'en'),
      array('id' => '16','key' => 'home-page','value' => '{"heading":{"title":"Sell your prompt with <strong>Bitakon<\\/strong>","left_button_link":"\\/pricing","right_button_link":"\\/pricing"},"brand":{"title":"Over 32K+ software businesses growing with Bitakon","status":"active"},"cta":{"title":"More than 13,000 teams use our platform"},"features":{"title":"Explore Our Amazing Features \\ud83d\\udd25","status":"active"},"platform":{"title":"Start Sell using Bitakon","description":"We provide a bird`s eye perspective of your entire bot, which aids in the development of a highly engaging bot. You can create, test, and build chatbots graphically using a single no-code online interface.","button_title":"Get Started","button_link":"\\/pricing"},"account_area":{"heading":"Create your free account","subheading":"It takes only 3 minutes to get started","description":"Plug your messaging channels, install your widget and\\r\\nyou\\u2019re ready to go","form_link":"\\/register\\/2","status":"active","button_link1":"\\/pricing","button_link2":"\\/pricing"},"about":{"title":"Download the Bitakon app to Explore <br> Any  Prompt","description":"Bitakon can work around the clock and can handle multiple requests simultaneously, which means that it is always available to assist customers, even outside of regular business hours.","action_area_title":"Lets create a Prompt \\ud83d\\ude80","qr_code":[],"action_android_icon_name":"fa-brands fa-google-play","action_android_text":"Download","action_ios_icon_name":"fa-brands fa-apple","action_android_link":"\\/contact","action_ios_link":"\\/contact","action_ios_text":"Download"},"top_faq":{"title":"Bitakon For Creatives business \\ud83d\\ude07","description":"Bitakon is the best quaint james bond victoria sponge happy days cras arse over blatant"},"integration":{"title":"Top Integration \\ud83e\\udd1d\\ud83c\\udffb"},"testimonial":{"title":"User Feedback \\ud83c\\udf96\\ufe0f"},"calltoaction":{"title":"Discover a better way to <br> manage spendings","button_title":"Get Started Now","button_link":"\\/pricing"},"right_button_image":"\\/uploads\\/23\\/03\\/16782229849w7zEZUReAELpYZzBhfy.png","left_button_image":"\\/uploads\\/23\\/03\\/16782229844xnXg3VVbopZTUmCVkoP.png","hero_left_image":"\\/uploads\\/23\\/04\\/1680991267dcZhpgfhm46WulMpbFmU.png","hero_image":"\\/uploads\\/23\\/03\\/1678140600lS8T5SkGWjUDMw00x8aR.png","testimonial_cover":"\\/uploads\\/23\\/04\\/1680990550b4VGZjg5I0mHrS0ZEzEO.png","integration_cover":"\\/uploads\\/23\\/04\\/1680691072MdDwD8iZV7nFu32OLg7Z.png","integration_left":"\\/uploads\\/23\\/04\\/1680687785yK5jB6wU8F0njvElGAqE.png","integration_right":"\\/uploads\\/23\\/04\\/1680687785b4Qk1bP8HMnMCuedEqOo.png","hero_right_image":"\\/uploads\\/23\\/04\\/1680991267IpQIAwGSbY5ZIFRwO6Pp.png","cta_logo":"\\/uploads\\/23\\/03\\/1678039536jzV8Ut6FTWgytwnEZxo0.png","cta_thumbnail":"\\/uploads\\/23\\/03\\/1678139635o3AHoY7EGdexS7UuUajq.png","platform_thumbnail":"\\/uploads\\/23\\/03\\/1678139743EuXomMHlbRJIEUobx62D.png","account_area_thumbnail":"\\/uploads\\/23\\/03\\/1678140032Wxqq2w6cndL4uWiEHf8B.png","account_area_top_thumbnail":"\\/uploads\\/23\\/03\\/1678039536eRShFlGn3Uw9tN1X14E0.png","account_area_bottom_thumbnail":"\\/uploads\\/23\\/03\\/16780395365JXHyeVBXUVAldB1V5Se.png","account_footer_left_image":"\\/uploads\\/23\\/03\\/16780395365VbXNjp8vpREwrrQ8R44.png","account_footer_right_image":"\\/uploads\\/23\\/03\\/1678039536cX0XI21coIdJ3M1Im54A.png","faq_cover":"\\/uploads\\/23\\/04\\/1680990550DfwMWKaP9MfCYR6fPued.png","about_cover":"\\/uploads\\/23\\/04\\/1680989187xEbFX8vGfdBmWfMkb3Xo.gif","qr_code":null}','lang' => 'en'),
      array('id' => '17','key' => 'why-choose','value' => '{"title":"Why choose Bitakon \\ud83c\\udf96\\ufe0f","subtitle":"Get start","left_button_link":"\\/pricing","right_button_link":"\\/pricing","left_block_title":"Active Customers","left_block_value":"1200","center_block_title":"Total Customers","center_block_value":"1500","right_block_title":"Positive Reviews","right_block_value":"600","left_button_image":"\\/uploads\\/23\\/03\\/1678120554l1bhGUjz28tmiBtCqTK6.png","right_button_image":"\\/uploads\\/23\\/03\\/1678120554IAVDm9xBLZXYtGAamM0I.png","left_block_image":"\\/uploads\\/23\\/03\\/1678120554hneDbhf9WG6aXvdV0h6q.png","center_block_image":"\\/uploads\\/23\\/03\\/1678120554PcP79pqqlziQ71Yf1T70.png","right_block_image":"\\/uploads\\/23\\/03\\/1678120554dGH99dtfF4slpDVVHjT1.png"}','lang' => 'en'),
      array('id' => '18','key' => 'contact-page','value' => '{"address":"Bowery St, New York,","country":"NY 10013,USA","map_link":"https:\\/\\/www.google.com.bd\\/maps\\/@23.74591,90.3701368,15z","contact1":"8801234567890","contact2":"8801234567891","email1":"support@email.com","email2":"contact@email.com"}','lang' => 'en'),
      array('id' => '19','key' => 'about','value' => '{"breadcrumb_title":"About Bitakon","breadcrumb_description":"Over 12 years of experience in the IT Industry & Tech service","marquee":"Discover & callect extraordinary digital art and Bitakon  Discover & callect extraordinary digital art and Bitakon","description":"At Bitakon, we\'re excited about a brand new type of digital good called a non-fungible token, or NFT. NFTs have exciting new properties:unique, <br\\/> provably scarce, tradeable, and usable across multiple applications. Just like physical goods, you can do whatever you want with them!","launching":"2020","users":"200k","employees":"200+","collections":"20k","prompts":"1k","volume":"2m","button_title":"Check our work","button_link":"\\/features","facilities":"Fast support, Stable api response, Reasonable price, User-friendly UX, Regular features update","introducing_video":"https:\\/\\/www.youtube.com\\/watch?v=Fu3MIwF-LJw"}','lang' => 'en'),
      array('id' => '20','key' => 'counter','value' => '{"experience":"12","active_customers":"900","positive_reviews":"200","satisfied_customers":"800"}','lang' => 'en'),
      array('id' => '21','key' => 'author_fee','value' => '5','lang' => 'en'),
      array('id' => '22','key' => 'per_credit_fee','value' => '1','lang' => 'en'),
      array('id' => '23','key' => 'image_generate_charge','value' => '10','lang' => 'en'),
      array('id' => '24','key' => 'theme_path','value' => 'Home','lang' => 'en'),
      array('id' => '25','key' => 'seo_collection','value' => '{"site_name":"Collections","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '26','key' => 'seo_prompts','value' => '{"site_name":"Prompts","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '27','key' => 'seo_discount','value' => '{"site_name":"Discount","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '28','key' => 'seo_login','value' => '{"site_name":"Sing In","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '29','key' => 'seo_register','value' => '{"site_name":"Sing Up","matatag":"","matadescription":"","preview":""}','lang' => 'en'),
      array('id' => '30','key' => 'seo_seller','value' => '{"site_name":"Authors","matatag":"","matadescription":"","preview":""}','lang' => 'en')
    );
    
    

    Option::insert($options);
  }
}
