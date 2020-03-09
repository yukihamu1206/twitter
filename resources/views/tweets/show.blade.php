
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-haeder p-3 w-100 d-flex">
                            <img src="{{  asset('storage/profile_image/'.$profile_image) }}" class="rounded-circle" width="50" height="50">
                        <div class="ml-2 d-flex flex-column">
                            <p class="mb-0">{{ $tweet_user->name }}</p>
                            <a href="{{ url('users/' .$tweet_user->id) }}" class="text-secondary">{{ $tweet_user->screen_name }}</a>
                        </div>
                        <div class="d-flex justify-content-end flex-grow-1">
                            <p class="mb-0 text-secondary">{{ $tweet->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($tweet_text)) !!}
                    </div>
                    <div class="card-footer py-1 d-flex justify-content-end bg-white">
                        @if ($tweet_user === Auth::user())
                            <div class="dropdown mr-3 d-flex align-items-center">
                                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-fw"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <form method="POST" action="{{ url('tweets/' .$tweet->id) }}" class="mb-0">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ url('tweets/' .$tweet->id .'/edit') }}" class="dropdown-item">編集</a>
                                        <button type="submit" class="dropdown-item del-btn">削除</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        <div class="mr-3 d-flex align-items-center">
                            <a href="{{ url('tweets/' .$tweet->id) }}"><i class="far fa-comment fa-fw"></i></a>
                            <p class="mb-0 text-secondary">{{ count($tweet->comments) }}</p>
                        </div>




                    <div class="d-flex align-items-center">
                            <button type="button" class="btn p-0 border-0 text-danger favorite" id="favorite" data-favorite="{{optional($user_favorite)->id }}"><i class="fa-heart fa-fw {{ $user_favorite ? 'fas' : 'far' }}" id="favorite_i"></i></button>

                        <p class="mb-0 text-secondary favorite_count">{{ $favorite_count }}</p>


                                <script>
                                    $(function() {
                                        $(".favorite").click(function(e) {
                                            if($(this).children('i').hasClass('far')) {
                                                $.ajax({
                                                        url: "{{ url('/favorites') }}",
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            tweet_id: "{{ $tweet->id }}",
                                                        },
                                                        type: "POST",
                                                        success: function (data) {
                                                            if (data['result'] === true) {
                                                                let heart = $(".fa-heart");
                                                                heart.removeClass('far');
                                                                heart.addClass('fas');
                                                                $('#favorite').attr('data-favorite',data['user_favorite_id']);
                                                                $(".favorite_count").text(data['favorites_count']);

                                                            } else {
                                                                error_log('errorrrrrr');
                                                            }
                                                         }
                                                    });
                                            }else {
                                                let element = document.getElementById('favorite');
                                                let favorite =  element.dataset.favorite;
                                                $.ajax({
                                                    url: '/favorites/' + favorite,
                                                    data: {
                                                        _token: "{{ csrf_token() }}",
                                                        tweet_id: "{{ $tweet->id }}",
                                                    },
                                                    type: "DELETE",
                                                    success: function (data) {
                                                        if (data['result'] === true) {
                                                            let heart = $(".fa-heart");
                                                            heart.removeClass('fas');
                                                            heart.addClass('far');
                                                            $(".favorite_count").text(data['favorites_count']);
                                                            $('i').data('favorite',"{{optional($user_favorite)->id}}");

                                                        } else {
                                                            error_log('errorrrrrr');
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    });
                              </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <ul class="list-group">
                    @forelse ($comments as $comment)
                        <li class="list-group-item">
                            <div class="py-3 w-100 d-flex">
                                @if($comment->user->profile_image)
                                    <img src="{{ asset('storage/profile_image/' .$comment->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/aaa.jpg') }}" class="rounded-circle" width="50" height="50">
                                @endif
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0">{{ $comment->user->name }}</p>
                                    <a href="{{ url('users/' .$comment->user->id) }}" class="text-secondary">{{ $comment->user->screen_name }}</a>
                                </div>
                                <div class="d-flex justify-content-end flex-grow-1">
                                    <p class="mb-0 text-secondary">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                            <div class="py-3">
                                {!! nl2br(e($comment->text)) !!}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">
                            <p class="mb-0 text-secondary">コメントはまだありません。</p>
                        </li>
                    @endforelse
                    <li class="list-group-item">
                    <div class="py-3">
                        <form method="POSt" action="{{ route("comments.store") }}">
                            @csrf

                    <div class="form-group row mb-0">
                        <div class="col0md-12 p-3 w-100 d-flex">
                            @if($user->profile_image == null)
                                <img src="{{ asset('storage/profile_image/aaa.jpg') }}" class="rounded-circle" width="50" height="50">
                            @else
                                <img src="{{ asset('storage/profile_image/'.$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                            @endif
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $user->name }}</p>
                                <a href="{{ url('users/'.$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                            <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>

                            @error('text')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>
                    </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-right">
                                    <p class="mb-4 text-danger">140文字以内</p>
                                    <button type="submit" class="btn btn-primary">
                                        ツイートする
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
@endsection
