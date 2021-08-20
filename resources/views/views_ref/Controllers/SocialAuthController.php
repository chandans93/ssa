<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

class SocialAuthController extends Controller
{
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
    }
     public function google()
    {
         
        return Socialite::driver('google')->redirect();
    }

     public function handleProviderCallback()
    {
        try {
            //$user = Socialite::driver('google')->user();
            $user = Socialite::driver('google')->stateless()->user();   //watch out with changes due to stateless user
        } catch (Exception $e) {
            return Redirect::to('login');
        }
        // $user->token;
    }
}
