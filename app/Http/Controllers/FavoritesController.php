<?php

namespace App\Http\Controllers;

use App\Models\Favorite;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoritesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Favorite $favorite)
    {
        $user        = auth()->user();
        $tweet_id    = $request->tweet_id;
        $is_favorite = $favorite->isFavorite($user->id, $tweet_id);

        if ( ! $is_favorite) {
            $favorite->storeFavorite($user->id, $tweet_id);

            $favorites_count  = $favorite->where('tweet_id', $tweet_id)
                ->count();
            $user_favorite_id = $favorite->where('user_id', $user->id)
                ->where('tweet_id', $tweet_id)
                ->first()->id;



            return response()->json([
                'result'           => true,
                'favorites_count'  => $favorites_count,
                'user_favorite_id' => $user_favorite_id,
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Favorite $favorite)
    {
        $user_id     = $favorite->user_id;
        $tweet_id    = $favorite->tweet_id;
        $favorite_id = $favorite->id;
        $is_favorite = $favorite->isFavorite($user_id, $tweet_id);

        if ($is_favorite) {
            $favorite->destroyFavorite($favorite_id);

            $favorites_count = $favorite->where('tweet_id', $tweet_id)->count();

            return response()->json([
                'result'          => true,
                'favorites_count' => $favorites_count,
            ]);
        }


    }
}
