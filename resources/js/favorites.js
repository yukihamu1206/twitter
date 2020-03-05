$(function(){
    $('.favorites_button').click(function(){
        $.ajax({
            url:"{{ action('FavoritesController@store'}}",
            type:'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                'tweet_id': tweet_id ,
                'user_id' : user_id
            },
            success: function(data) {
                if (data.status == 'success') {
                    console.log("success!!!");
                } else {
                    console.log("errrrrorrrrr!!!!!!");
                }
            }
        })
    });

    });
