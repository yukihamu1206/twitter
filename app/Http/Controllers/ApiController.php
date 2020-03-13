<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            ['lists' => $lists],
            200,[],
            JSON_UNESCAPED_UNICODE);

    }

    public function tweet_post(Request $request)
    {

        $tweet = new Tweet;
        $tweet->text = $request->text;
        $tweet->user_id = Auth()->user()->id;

        $tweet->save();

        return response()->json(
            ['tweet' => $tweet->text,
            200, [],
            JSON_UNESCAPED_UNICODE);
    }

    public function tweet_get(Request $request, $id)
    {

        $tweet = Tweet::find($id);

        return response()->json(
            ['tweet' => $tweet->text],
            200, [],
            JSON_UNESCAPED_UNICODE);

    }

    public function tweet_update(Request $request, Tweet $tweet)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'text' => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $tweet->tweetUpdate($tweet->id, $data);

        Log::debug($tweet);

        return responce()->json(
            ['update_tweet' => $tweet->text],
            200, [],
            JSON_UNESCAPED_UNICODE);

    }

}
