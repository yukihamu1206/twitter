@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3 text-right">
                <a href="{{ url('users') }}">ユーザ一覧 <i class="fas fa-users" class="fa-fw"></i> </a>
            </div>
                @foreach ($timelines as $timeline)
                @foreach($lists as $list)
                        <div class="col-md-8 mb-3">
                            <div class="card">
                                <div class="card-haeder p-3 w-100 d-flex">
                                      <img src="{{ asset('storage/profile_image/'.$list['profile_image']) }}" class="rounded-circle" width="50" height="50">
                                    <div class="ml-2 d-flex flex-column">
                                        <p class="mb-0">{{ $list['user_name'] }}</p>
                                        <a href="{{ url('users/' .$list['user_id']) }}" class="text-secondary">{{ $list['screen_name'] }}</a>
                                    </div>
                                    <div class="d-flex justify-content-end flex-grow-1">
                                        <p class="mb-0 text-secondary">{{ $list['created_at'] }}</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! nl2br(e($list['tweet_text'])) !!}
                                </div>

                                <div class="card-footer py-1 d-flex justify-content-end bg-white">
                                    @if ($list['user_id'] === Auth::user()->id)
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
                                            <a href="{{ url('tweets/' .$list['tweet_id']) }}"><i class="far fa-comment fa-fw"></i></a>
                                            <p class="mb-0 text-secondary">{{ $list['comment_count'] }}</p>
                                    </div>


                                    <div class="d-flex align-items-center">
                                            @if($list['user_favorite'])
                                                <button type="button" class="btn p-0 border-0 text-danger favorite"><i class="far fa-heart fa-fw"></i></button>
                                            @else
                                                <button type="button" class="btn p-0 border-0 text-danger favorite"><i class="fas fa-heart fa-fw"></i></button>
                                            @endif

                                            <p class="mb-0 text-secondary">{{ $list['favorite_count'] }}</p>
                                    </div>

{{--                                        @if($list['user_favorite'] == null)--}}
{{--                                            <script>--}}
{{--                                                $(function() {--}}
{{--                                                    $(".favorite").click(function (e) {--}}
{{--                                                        $.ajax({--}}
{{--                                                            url: "{{ url('/favorites') }}",--}}
{{--                                                            data: {--}}
{{--                                                                _token: "{{ csrf_token() }}",--}}
{{--                                                                tweet_id: "{{ $list['tweet_id'] }}",--}}
{{--                                                            },--}}
{{--                                                            type: "POST",--}}
{{--                                                            success: function (data) {--}}
{{--                                                                if(data['result'] === true) {--}}
{{--                                                                    let heart = $(".fa-heart");--}}
{{--                                                                    heart.removeClass('far');--}}
{{--                                                                    heart.addClass('fas');--}}

{{--                                                                }else{--}}
{{--                                                                    error_log('errorrrrrr');--}}
{{--                                                                }--}}

{{--                                                            }--}}
{{--                                                        })--}}
{{--                                                    });--}}
{{--                                                });--}}
{{--                                            </script>--}}
{{--                                        @else--}}
{{--                                            <script>--}}
{{--                                                $(function() {--}}
{{--                                                    $(".favorite").click(function (e) {--}}
{{--                                                        $.ajax({--}}
{{--                                                            url: "{{ url('/favorites/'. $list['user_favorite']->id) }}",--}}
{{--                                                            data: {--}}
{{--                                                                _token: "{{ csrf_token() }}",--}}
{{--                                                                tweet_id: "{{ $list['tweet_id'] }}",--}}
{{--                                                            },--}}
{{--                                                            type: "DELETE",--}}
{{--                                                            success: function (data) {--}}
{{--                                                                if(data['result'] === true){--}}
{{--                                                                    let heart = $(".fa-heart");--}}
{{--                                                                    heart.removeClass('fas');--}}
{{--                                                                    heart.addClass('far');--}}
{{--                                                                }--}}

{{--                                                            }--}}
{{--                                                        })--}}
{{--                                                    });--}}
{{--                                                });--}}
{{--                                            </script>--}}
{{--                                        @endif--}}



                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
        </div>
    </div>
@endsection
