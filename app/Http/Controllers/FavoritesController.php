<?php

namespace App\Http\Controllers;
use App\Models\Favorite;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $tweet_id = $request->tweet_id;
        $is_favorite = $favorite->isFavorite($user->id,$tweet_id);

        if(!$is_favorite){
            $favorite->storeFavorite($user->id,$tweet_id);
            return back();
        }

        return back();

    }

    /**
     * [API] Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAsync(Request $request, Favorite $favorite)
    {
        $user        = auth()->user();
        $tweet_id    = $request->post('tweet_id');
        $is_favorite = $favorite->isFavorite($user->id, $tweet_id);

        if ( ! $is_favorite) {
            // いいねをつける
            $favorite->storeFavorite($user->id, $tweet_id);

            return response()->json([
                'result' => true
            ]);
        } else {
            // すでにいいね済みの場合
            return response()->json([
                'result' => false
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        $user_id = $favorite->user_id;
        $tweet_id = $favorite->tweet_id;
        $favorite_id = $favorite->id;
        $is_favorite = $favorite->isFavorite($user_id,$tweet_id);

        if($is_favorite){
            $favorite->destroyFavorite($favorite_id);
            return back();
        }

        return back();

    }
}
