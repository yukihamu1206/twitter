<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('users.index',[
            'all_users' => $all_users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Tweet $tweet, Follower $follower)
    {

        #今ログインしているuser
        $login_user = auth()->user();
        #フォローしているユーザー
        $is_following = $login_user->isFollowing($user->id);
        #フォロワー
        $is_followed = $login_user->isFollowed($user->id);
        #tweet全部取得　
        $timelines = $tweet->getUserTimeLines($user->id);
        #tweet数
        $tweet_count = $tweet->getTweetCount($user->id);
        #フォロー数
        $follow_count = $follower->getFollowCount($user->id);
        #フォロワー数
        $follower_count = $follower->getFollowerCount($user->id);
        if($user->profile_image){
            $profile_image = $user->profile_image;
        }else{
            $profile_image = 'aaa.jpg';
        }


        return view('users.show',[
            'user' => $user,
            'is_following' => $is_following,
            'is_followed' => $is_followed,
            'timelines' => $timelines,
            'tweet_count' => $tweet_count,
            'follow_count' => $follow_count,
            'follower_count' => $follower_count,
            'profile_image' => $profile_image
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        if($user->profile_image){
            $profile_image = $user->profile_image;
        }else{
            $profile_image = 'aaa.jpg';
        }

        return view('users.edit',[
            'user' => $user,
            'profile_image' => $profile_image,


        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'screen_name' => ['required', 'string', 'max:50',Rule::unique('users')->ignore($user->id)],
            'name' =>['required','string','max:225'],
            'profile_image' => ['file','image','mimes:jpeg,png,jpg','max:2048'],
            'email' => ['required','string','email','max:225',Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        $user->updateProfile($data);
        return redirect('users/'.$user->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    #フォローする
    public function follow(User $user)
    {   #自分
        $follower = auth()->user();
        $is_following = $follower->isFollowing($user->id);
        #フォローする　
        if(!$is_following){
            $follower->follow($user->id);
            return back();
        }
    }

    public function unfollow(User $user)
    {
        #自分
        $follower = auth()->user();
        $is_following = $follower->isFollowing($user->id);
        #フォロー解除する
        if($is_following){
            $follower->unfollow($user->id);
            return back();
        }

    }
}
