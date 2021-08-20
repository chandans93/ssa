<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use App\UserFront;
use App\Http\Requests\UserLoginRequest;
use App\Services\User\Contracts\UserRepository;
use Response;
use Cookie;
use Illuminate\Http\Request;
 use Illuminate\Cookie\CookieJar;


class LoginController extends Controller
{
    public function __construct(UserRepository $UserRepository) {
                
        $this->UserRepository = $UserRepository; 
        $this->avatarOriginalImageUploadPath = Config::get('constant.AVATAR_ORIGINAL_IMAGE_UPLOAD_PATH');              
        
    }

    public function login()
    {$remember='';
        if (Auth::front()->check()) {
            return Redirect::to("/");
        }
        else{
            
            $remember=$request->cookie('remember');
          return view('front.Login')->with('remember',$remember); 
        } 
    }
    public function rememberToken($email,$password)
    {
        setcookie("vw_email", $email, time()+3600);
        setcookie("vw_password", $password, time()+3600);
    }
    public function loginCheck(UserLoginRequest $request) {
        $email = e(Input::get('email'));
        $password = e(Input::get('password'));        
        $remember = (Input::get('remember')) ? true : false; 
        $response = [];
        $response['status'] = 0;
        $response['message'] = trans('appmessages.default_error_msg');
        if( $remember){
         $this->rememberToken($email,$password);
        }

        if (isset($email) && $email != '' && isset($password) && $password != '') 
        {   

            $uesrEmailExist = $this->UserRepository->checkActiveEmailExist($email);
            
            if($uesrEmailExist == 1)
            {    
                

                if ($user = Auth::front()->attempt(['fu_email' => $email, 'password' => $password,'deleted' => 1],true)) 
            {
                $user = $this->UserRepository->getUserDetailByEmailId($email);
                $id = $user['id'];
                $userName = $user['fu_user_name'];
                if (!empty($user) && $user['fu_isverified'] == '1' ) {
                    if($user['fu_first_name'] != '' && $user['fu_last_name'] !='' && $user['fu_email'] !='' && $user['fu_user_name'] !='' && $user['fu_avatar'] !='' && $user['fu_address1'] !='' && $user['fu_address2'] !='' && $user['fu_city'] !='' && $user['fu_state'] !='' && $user['fu_country'] !='' && $user['fu_zipcode'] !='' && $user['fu_phone'] !='' && $user['fu_birthdate'] !='' && $user['fu_gender'] !='')
                    {
                    return Redirect::to('/');
                    exit;
                    }
                    else{
                       
                        return Redirect::to('/completeProfile');
                    }
                } else {
                    Auth::front()->logout();
                    return Redirect::to('/login')->with('error', trans('appmessages.notvarified_user_msg'));
                }
            } 
            else 
            {                
                $response['message'] = trans('appmessages.invalid_user_pwd_msg');
                return Redirect::to('/login')->with('error', trans('appmessages.invalid_pwd_msg'));
            }
        } 
        else 
        {
             return Redirect::to('/login')->with('error',('Email not exist'));
        }
        
        }
        else
        {
            $response['message'] = trans('appmessages.missing_data_msg');
        }
        return Redirect::back()
                        ->withInput()
                        ->withErrors(trans('validation.invalidcombo'));
    }
    public function getLogout()
    {   

        Auth::front()->logout();

        return Redirect::to('/');
    }
    
     public function verifyUserRegistration()
    {        

        $token=input::get('token');
        if($token)
        {
            $UserTokenVarify = $this->UserRepository->updateUserTokenStatusByToken($token);
            if($UserTokenVarify)
            {
                $user = $this->UserRepository->updateUserVerifyStatusById($UserTokenVarify[0]->uev_user);
               
                if($user){ $varifymessage = trans('appmessages.email_verify_msg'); } else { $varifymessage = trans('appmessages.default_error_msg'); }
            }
            else
            {
                $varifymessage = trans('appmessages.already_email_verify_msg');
            }
        }
        return Redirect::to('/login')->with('success', trans('appmessages.account_varify'));
    }
}