<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getSettings(){
        $settings = Setting::first();
        $related_sites = $this->relatedSites();
        if(!$settings){
            return apiResponse(404 , 'settings not found');
        }
        $data = [
            'settings' => new SettingResource($settings),
            'related_sites' => $related_sites,
        ];
        return apiResponse(200 , 'Settings & Related Sites  retrieved successfully', $data);
    }

    public function relatedSites(){
        $related_sites = RelatedNewsSite::select('name' , 'url')->get();
        if(!$related_sites){
            return apiResponse(404 , 'Related sites not found');
        }
        return $related_sites;
    }
}

