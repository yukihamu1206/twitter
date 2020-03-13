@extends('layouts.app')

@section('content')

    <script>
        $(function(){
            var url = 'http://localhost/api/tweets/1';
            var type = 'GET';
            $.ajax({
                url:url,
                type:type,
            }).done(function(data){
                if(data['tweet']){
                   $('.form-control').text(data['tweet']);
                }else{
                    console.log('false');
                }
            });

            $('.submit_button').click(function(){
                var token = "{{ Auth()->user()->api_token }}";
                var url = 'http://localhost/api/tweets/1?api_token='+ token;
                var type = 'PUT';
                var data =  $('.form-control').serialize();
                console.log(data);
                $.ajax({
                    url:url,
                    type:type,
                    data:data,
                }).done(function(data){
                    if(data['update_tweet']){
                        console.log(data);
                        $('.form-control').text(data['update_tweet']);
                    }else{
                        console.log('false');
                    }
                });
            });
        });
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update</div>

                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            @method('PUT')

                                <div class="form-group row mb-0">
{{--                                    <div class="col-md-12 p-3 w-100 d-flex">--}}
{{--                                            <img src="{{ asset('storage/profile_image/'.$profile_image) }}" class="rounded-circle" width="50" height="50">--}}
{{--                                        <div class="ml-2 d-flex flex-column">--}}
{{--                                            <p class="mb-0">{{ $user->name }}</p>--}}
{{--                                            <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-md-12">
                                        <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4"></textarea>

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
                                    <button type="button" class="btn btn-primary submit_button">
                                        ツイートする
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection






