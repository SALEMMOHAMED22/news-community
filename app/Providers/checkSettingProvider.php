<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class checkSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $getSetting =  Setting::firstOr(function(){

           return Setting::create([
               "site_name"=>"news",
               "email"=> "news@gmail.com",
               "favicon"=> "test/favicon.webp",
               "logo"=>"test/logo.webp",
               "facebook"=>"https://www.facebook.com/",
               "twitter"=>"https://www.twitter.com/",
               "instagram"=>"https://www.instagram.com/",
               "youtube"=>"https://www.youtube.com/",
               "phone"=>"01019907979",
               "country"=>"Egypt",
               "city"=>"Cairo",
               "street"=>"El Mahatta",
               'small_desc'=>'23 of PARAGE is equality of condition, blood, or dignity; specifically : equality between persons (as brothers) one of whom holds a part of a fee ',
              
            ]);
        });

     
        // $getSetting->whatsapp = 'https://wa.me/'. $getSetting->phone;
       

       

      
     
        view()->share([
            'getSetting' =>$getSetting,
           
        ]);

    }
}
