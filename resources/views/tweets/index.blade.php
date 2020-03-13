@extends('layouts.app')

@section('content')
    <script>
        $(function(){
            var url = 'http://localhost/api/tweets';
            var type = 'GET';

            $.ajax({
                url: url,
                type: type,
                dataType: "json"
            }).done(function (data){
                if (data['lists']) {
                    console.log(data);
                } else {
                    console.log('false');
                }
            });
        });

    </script>

@endsection