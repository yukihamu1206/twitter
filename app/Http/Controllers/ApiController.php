<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use \GuzzleHttp\Client;

class ApiController extends Controller
{

    public function tweets(){


        $tweets = Tweet::all();

        $lists = [];

        foreach ($tweets as $tweet){
            $elm = [
                'id' => $tweet->id,
                'text' => $tweet->text,
                'comment' => $tweet->comments,
                'favorite_count' => $tweet->favorites->count()
            ];

            $lists[] = $elm;
        }


        return response()->json(
            ['data' => $lists],
            200,[],
            JSON_UNESCAPED_UNICODE);

    }

    public function tweet_post(){

        $tweet = new Tweet;
        $tweet->text = 'おほほほ';
        $tweet->user_id = Auth()->user()->id;

        $tweet->save();

        return response()->json(
            ['data' => $tweet],
            200,[],
            JSON_UNESCAPED_UNICODE);
    }

    public function tweet_get(Request $request, $id){

         $tweet = Tweet::find($id);

        return response()->json(
            ['data' => $tweet],
            200,[],
            JSON_UNESCAPED_UNICODE);

    }
}
