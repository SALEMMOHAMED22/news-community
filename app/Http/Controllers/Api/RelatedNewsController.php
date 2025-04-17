<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RelatedNewsResource;
use App\Models\RelatedNewsSite;
use Illuminate\Http\Request;

class RelatedNewsController extends Controller
{
    public function getRelatedNews(){
        $relatedNews =  RelatedNewsSite::get();

        if(!$relatedNews){
            return apiResponse(404 , 'No Related News Found');
        }
        return apiResponse(200 , 'Related News', ['relatedNews' => RelatedNewsResource::collection($relatedNews)]);
    }
}
