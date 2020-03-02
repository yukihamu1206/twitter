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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function favorites(){
        return $this->belongsTo(Favorite::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
