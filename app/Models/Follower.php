<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'following_id','followed_id'
    ];

    protected $primaryKey = [
        'following_id','followed_id'
    ];


}
