@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="d-inline-flex">
                        <div class="p-3 d-flex flex-column">
                                <img src="{{ asset('storage/profile_image/'.$profile_image) }}" class="rounded-circle" width="100" height="100">
                            <div class="mt-3 d-flex flex-column">
                                <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>
                                <span class="text-secondary">{{ $user->screen_name }}</span>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column justify-content-between">
                            <div class="d-flex">
                                <div>
                                    @if ($user->id === Auth::user()->id)
                                        <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-primary">プロフィールを編集する</a>
                                     @else
                                         @if($is_following)
                                             <form action="{{ route('unfollow',['id' => $user->id]) }}" method="POST">
                                                 {{ csrf_field() }}
                                                 {{ method_field('delete') }}

                                                 <button type="submit" class="'btn btn-danger">フォロー解除</button>
                                             </form>
                                    @else
                                        <form action="{{ route('follow', ['id' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger">フォローする</button>
                                        </form>
                                    @endif

                                    @if($is_followed)
                                         <span class="mt-2 px-1 bg-secondary text-light">フォローされています</span>
                                     @endif
                                 @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">ツイート数</p>
                                <span>{{ $tweet_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロー数</p>
                                <span>{{ $follow_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロワー数</p>
                                <span>{{  $follower_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            @foreach($lists as $list)
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-haeder p-3 w-100 d-flex">
                                    <img src="{{  asset('storage/profile_image/'.$list['profile_image']) }}" class="rounded-circle" width="50" height="50">
                                    <div class="ml-2 d-flex flex-column flex-grow-1">
                                    <p class="mb-0">{{ $list['user_name'] }}</p>
                                    <a href="{{ url('users/' .$list['user_id']) }}" class="text-secondary">{{ $list['screen_name'] }}</a>
                                </div>
                                <div class="d-flex justify-content-end flex-grow-1">
                                    <p class="mb-0 text-secondary">{{ $list['created_at'] }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $list['tweet_text'] }}
                            </div>
                            <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                @if ($list['user_id'] === $login_user->id)
                                    <div class="dropdown mr-3 d-flex align-items-center">
                                        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-fw"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <form method="POST" action="{{ url('tweets/' .$list['tweet_id']) }}" class="mb-0">
                                                @csrf
                                                @method('DELETE')

                                                <a href="{{ url('tweets/' .$list['tweet_id'] .'/edit') }}" class="dropdown-item">編集</a>
                                                <button type="submit" class="dropdown-item del-btn">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                <div class="mr-3 d-flex align-items-center">
                                    <a href="{{ url('tweets/'.$list['tweet_id']) }}"><i class="far fa-comment fa-fw"></i></a>
                                        <p class="mb-0 text-secondary">{{ $list['comment_count'] }}</p>
                                </div>

                                <div class="d-flex align-items-center">
                                        <button type="submit" class="btn p-0 border-0 text-danger favorite" id="favorite" data-tweet_id="{{$list['tweet_id']}}" data-favorite="{{ optional($list['user_favorite'])->id }}"><i class="fa-heart fa-fw {{ $list['user_favorite'] ? 'fas' : 'far' }}"></i></button>

                                        <p class="mb-0 text-secondary">{{ $list['favorite_count'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach


            <script>
                $( function () {
                    $( ".favorite" ).click( function ( e ) {
                        let button = $(this);
                        let favorite_count = button.parent().find('p');
                        if ( $( this ).children( 'i' ).hasClass( 'far' ) ) {
                            let tweet_id = $(this).data('tweet_id');
                            $.ajax( {
                                url: "{{ url('/favorites') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    // TODO: 正しい tweet_id が取れていない ⇨ いいねボタンのDOMにツイートのIDも持たせておく
                                    tweet_id: tweet_id,
                                },
                                type: "POST",
                                success: function ( data ) {
                                    if ( data['result'] === true ) {
                                        button.children('i').removeClass( 'far' );
                                        button.children('i').addClass( 'fas' );
                                        // attrにする場合は取得も設定もattr
                                        button.attr( 'data-favorite', data['user_favorite_id'] );
                                        // これはdata-favoriteに設定してる
                                        // button.data( 'favorite', data['user_favorite_id'] );
                                        favorite_count.text( data['favorites_count'] );

                                    } else {
                                        console.log( 'errorrrrrr' );
                                    }
                                }
                            })
                        } else {
                            // 取り出す時もattr
                            let favorite = button.attr('data-favorite');
                            // attrで設定してこれでとると取れない
                            // let favorite = button.data('favorite');
                            let tweet_id =  button.data('tweet_id');
                            $.ajax( {
                                url: '/favorites/' + favorite,
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    tweet_id: tweet_id,
                                },
                                type: "DELETE",
                                success: function ( data ) {
                                    if ( data['result'] === true ) {
                                        button.children('i').removeClass( 'fas' );
                                        button.children('i').addClass( 'far' );
                                        button.attr( 'data-favorite', "" );
                                        favorite_count.text( data['favorites_count'] );
                                    } else {
                                        console.log( 'errorrrrrr' );
                                    }
                                }
                            } );
                        }
                    } );
                } );
            </script>
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
        </div>
    </div>
@endsection


