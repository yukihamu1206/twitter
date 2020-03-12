<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Follower;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Tweet $tweet, Follower $follower)
    {
        $user = auth()->user();
        //フォローしている　userのIDを持ってくる
        $follow_ids = $follower->followingIds($user->id);

        $following_ids = $follow_ids->toArray();

        $timelines = $tweet->getTimeLines($user->id, $following_ids);

        $lists = [];
        foreach($timelines as $timeline){
            $elm = [
                'tweet_text' => $timeline->text,
                'created_at' => $timeline->created_at->format('Y-m-d H:i'),
                'profile_image' => $timeline->user->profime_image != null ? $timeline->user->profile_image : 'aaa.jpg',
                'tweet_id' =>$timeline->id,
                'user_id' => $timeline->user->id,
                'user_name' => $timeline->user->name,
                'screen_name' => $timeline->user->screen_name,
                'comment_count' => $timeline->comments->count(),
                'favorite' => $timeline->favorites,
                'user_favorite' => $timeline->favorites->where('user_id',auth()->user()->id)->first(),
                'favorite_count' => $timeline->favorites->count()
            ];



            $lists[] = $elm;

        }

        return view('tweets.index', [
            'user' => $user,
            'timelines' => $timelines,
            'lists' => $lists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = Auth()->user();
        if($user->profile_image){
            $profile_image = $user->profile_image;
        }else{
            $profile_image = 'aaa.jpg';
        }

        return view('tweets.create',[
            'user' => $user,
            'profile_image' => $profile_image,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tweet $tweet)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data,[
            'text' => ['required','string', 'max:140']
        ]);

        $validator->validate();
        $tweet->tweetStore($user->id,$data);

        return redirect('tweets');
    }

    /**
     * Display the specified resource.
     *
     * @param  Tweet  $tweet
     * @param  Comment  $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Tweet $tweet, Comment $comment)
    {

        $user = auth()->user();
        $tweet = $tweet->getTweet($tweet->id);
        $tweet_user = $tweet->user;
        $tweet_text = $tweet->text;
        $comments = $comment->getComments($tweet->id);
        $favorite_count = $tweet->favorites->count();
        $user_favorite = $tweet->favorites->where('user_id',$user->id)->first();



        if ($tweet->user->profile_image){
            $profile_image = $tweet->user->profile_image;
        }else{
             $profile_image = 'aaa.jpg';
        }

        return view('tweets.show',[
            'user'=>$user,
            'tweet'=>$tweet,
            'tweet_user' => $tweet_user,
            'tweet_text' => $tweet_text,
            'comments'=>$comments,
            'profile_image' => $profile_image,
            'user_favorite' => $user_favorite,
            'favorite_count' => $favorite_count
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Tweet $tweet)
    {
        $user = auth()->user();
        $tweets = $tweet->getEditTweet($user->id,$tweet->id);
        if($user->profile_image){
            $profile_image = $user->profile_image;
        }else{
            $profile_image = 'aaa.jpg';
        }

        return view('tweets.edit',[
            'user'=> $user,
            'tweets' => $tweets,
            'profile_image' => $profile_image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Tweet $tweet)
    {
        $data = $request->all();
        $validator = Validator::make($data,[
            'text' => ['required', 'string', 'max:140']
        ]);

        $validator->validate();
        $tweet->tweetupdate($tweet->id, $data);

        return redirect('users/'.$tweet->user->id );


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tweet $tweet)
    {
        $user = auth()->user();
        $tweet->tweetDestroy($user->id,$tweet->id);

        return back();
    }
}
