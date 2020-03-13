<?php

namespace App\Http\Resources;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;


class TweetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'comment' => CommentResource::collection($this->comments),
            'favorite_count' => FavoriteResource::collection($this->favorites)
            ];
    }

    public function tweet_post()
    {

    }
}
