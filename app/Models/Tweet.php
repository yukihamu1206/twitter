<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Tweet extends Model
{
    use softDeletes;

    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->belongsTo(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getUserTimeLines(Int $user_id)
    {
        return $this->where('user_id',$user_id)->orderBy('created_at','DESC')->paginate(50);
    }

    public function getTweetCount(Int $user_id)
    {
        return $this->where('user_id',$user_id)->count();
    }

    public function getTimeLines(Int $user_id,Array $follow_ids)
    {
        #自分とフォローしているユーザーIDを結合
        $follow_ids[] = $user_id;
        return $this->whereIn('user_id',$follow_ids)->orderBy('created_at','DESC')->paginate(50);
    }
    #書斎ページのツイートを取得
    public function getTweet(Int $tweet_id)
    {
        return $this->with('user')->where('id', $tweet_id)->first();
    }
    #tweet投稿
    public function tweetStore(Int $user_id, Array $data)
    {
        #格納してる
        $this->user_id = $user_id;
        $this->text = $data['text'];
        $this->save();

        return;
    }
    #編集するツイートを取得する
    public function getEditTweet(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id',$user_id)->where('id',$tweet_id)->first();
    }

    public function tweetUpdate(Int $tweet_id, Array  $data)
    {
        $this->id = $tweet_id;
        $this->text = $data['text'];
        $this->update();

    return;

    }
    #ツイートを削除
    public function tweetDestroy(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id',$user_id)->where('id',$tweet_id)->delete();
    }


}
