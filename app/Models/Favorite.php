<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    #いいねしているかどうかの判定処理
    public function isFavorite(Int $user_id, Int $tweet_id)
    {
        return (boolean) $this->where('user_id',$user_id)->where('tweet_id',$tweet_id)->first();
    }

    public function storeFavorite(Int $user_id, Int $tweet_id)
    {
        $this->user_id = $user_id;
        $this->tweet_id = $tweet_id;
        $this->save();

        return;
    }

}
