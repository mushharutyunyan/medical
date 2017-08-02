<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialUser;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Socialite;
use Twitter;
use Session;
use Input;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return response()->json(array('code' => 401, 'message' => Lang::get('auth.throttle')),401);
        }
        if ($this->attemptLogin($request)) {
            return response()->json(true);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return response()->json(array('code' => 401, 'message' => Lang::get('auth.failed')),401);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if ($provider == 'twitter') {
            $this->loginTwitter();
        } else {
            return Socialite::driver($provider)->redirect();
        }
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        if ($provider == 'twitter') {
            $success = $this->callbackTwitter($provider);
        } else {
            $user = Socialite::driver($provider)->user();
            $success = $this->createOrGetUser($provider,$user);
        }
        if($success){
            return redirect('/');
        }
        return redirect('/')->withErrors(['social_email_exists'=>Lang::get('auth.socialError')]);
    }

    public function loginTwitter() {
        $sign_in_twitter = true;
        $force_login = false;
        Twitter::reconfig(['token' => '', 'secret' => '']);
        $token = Twitter::getRequestToken(url('login/twitter/callback/'));
        if (isset($token['oauth_token_secret'])) {
            $url = Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);
            Session::put('oauth_state', 'start');
            Session::put('oauth_request_token', $token['oauth_token']);
            Session::put('oauth_request_token_secret', $token['oauth_token_secret']);
            echo "<script>window.location.replace('" . $url . "');</script>";
        }
    }

    public function callbackTwitter() {
        if (Session::has('oauth_request_token')) {
            $request_token = [
                'token' => Session::get('oauth_request_token'),
                'secret' => Session::get('oauth_request_token_secret'),
            ];
            Twitter::reconfig($request_token);

            $oauth_verifier = false;

            if (Input::has('oauth_verifier')) {
                $oauth_verifier = Input::get('oauth_verifier');
            }

            // getAccessToken() will reset the token for you
            $token = Twitter::getAccessToken($oauth_verifier);
            $credentials = Twitter::getCredentials(['include_email' => true]);
            $success = $this->createOrGetUser('twitter',$credentials);
            if($success){
                return true;
            }
            return false;
        }
    }
    public function createOrGetUser($provider,$user){

        if(!SocialUser::where('social_id', $user->id)->count()){
            $email = $user->id;
            if(isset($user->email)){
                $email = $user->email;
            }
            if(User::where('email',$email)->count()){
                return false;
            }else{
                $new_user = User::create(array(
                    'email' => $email,
                    'name' => $user->name,
                    'password' => bcrypt($user->id),
                ));
                SocialUser::create(array(
                    'user_id' => $new_user->id,
                    'social_id' => $user->id,
                    'provider' => $provider
                ));
                $user = $new_user;
            }
        }else{
            $social_user = SocialUser::where('social_id', $user->id)->first();
            $user = $social_user->user;
        }
        \Auth::login($user, true);
        return true;
    }
}
