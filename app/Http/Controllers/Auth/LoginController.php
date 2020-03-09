<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/tweets';

    /**
     * twitterの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectTOProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * twitterからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        //twitterから情報を取得して、もし取得できなかった場合catchの処理が走る(この場合はログイン画面にいく)
        try {
            $user = Socialite::deiver('twitter')->user;
        }
        catch(\Excption $e){
            return redirect('login')->with('oauth_error','ログインに失敗しました');
        }

        $authUser = $this->findOrCreateUser($user);

        $myinfo = User::firstOrCreate(
           　['name' => $uer->screen_name,]
            ['name' => $user->nickname,'email' => $user->getEmail()]);
        Auth::login($myinfo);
        return redirect()->to('/'); // homeへ転送



        Auth::login($authUser, true);

        return redirect()->route('home');
    }

    private function findOrCreateUser($twitterUser)
    {
        $authUser = User::where('id', $twitterUser->id)->first();

        if ($authUser){
            return $authUser;
        }

        return User::create([
            'name' => $twitterUser->name,
            'handle' => $twitterUser->nickname,
            'twitter_id' => $twitterUser->id,
            'avatar' => $twitterUser->avatar_original
        ]);
    }







    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }






}
