@extends('layouts.app')

@section('content')
    <script>
        $(function(){
            $('.submit_button').click(function(){
            var data = $('.form-control').serialize();
            var token = "{{ Auth()->user()->api_token }}";
            var url = 'http://localhost/api/tweet?api_token='+ token ;
            var type='POST';
            $.ajax({
                url:url,
                type:type,
                data:data,
            }).done(function(data){
                if(data){
                    $('img').attr('src',"{{ asset('storage/profile_image/aaa.jpg') }}");
                    $('#tweet_text').text(data['tweet']);
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
                    <div class="card-header">Create</div>

                    <div class="card-body">
                        <form method="POST" id="form">
                            @csrf
                            <div class="form-group row mb-0">
{{--                                <div class="col-md-12 p-3 w-100 d-flex">--}}
{{--                                    <img src="{{ asset('storage/profile_image/'.$profile_image) }}" class="rounded-circle" width="50" height="50">--}}

{{--                                    <div class="ml-2 d-flex flex-column">--}}
{{--                                        <p class="mb-0">{{ $user->name }}</p>--}}
{{--                                        <a href="{{ url('users/'.$user->id ) }}" class="text-secondary">{{ $user->screen_name }}</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-12">

                                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" row="4">{{ old('text') }}</textarea>

                                    @error('text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-right">
                                    <p class="md-4 text-danger">140字以内</p>
                                    <button type="button" class="btn btn-primary submit_button">
                                        ツイートする</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <img src="">
                <p id="tweet_text"></p>
            </div>
        </div>
    </div>
@endsection






