<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::admin()->check()) {
            return Redirect::to("/admin/dashboard");
        }
        return view('admin.Login');
    }
    public function loginCheck()
    {
        $email    = e(Input::get('email'));
        $password = e(Input::get('password'));
        if (Auth::admin()->attempt(['email' => $email, 'password' => $password])) {
            return Redirect::to("/admin/dashboard");
        }

        return Redirect::back()
                        ->withInput()
                        ->withErrors(trans('validation.invalidcombo'));
    }
    public function getLogout()
    {
        Auth::admin()->logout();

        return Redirect::to('/admin');
    }
}
?>
