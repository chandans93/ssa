<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Config;
use Helpers;
use App\User;
use Input;
use Redirect;
use Response;
use Illuminate\Http\Request;
use App\Transactions;
use App\UserFronts;
use App\Templates;
use App\Country;
use App\Services\User\Contracts\UserRepository;
use SocialNorm\Exceptions\ApplicationRejectedException;
use SocialNorm\Exceptions\InvalidAuthorizationCodeException;
use Socialite;
use DB;

class SocialLoginController extends Controller {

    public function __construct(UserRepository $UserRepository) {
        $this->objUser = new UserFronts();
        $this->UserRepository = $UserRepository;
        $this->avatarOriginalImageUploadPath = Config::get('constant.AVATAR_ORIGINAL_IMAGE_UPLOAD_PATH');

    }

    public function googleLogin() {
        try {
            $redirectToUpdateProfile = $redirectToDashboard = 0;            
            $user = Socialite::driver('google')->user();
            $name = $user->name;
            $email = $user->email;
            $password = $user->id;
            $fu_social_provider = '3';
            $fu_google_identifier = $user->id;
            $fu_google_accesstoken = $user->token;
            $userDetail = [];
            $userDetail['fu_user_name'] = (isset($name) && $name != '') ? $name : '';
            $userDetail['fu_email'] = (isset($email) && $email != '') ? $email : '';
            $userDetail['password'] = (isset($password) && $password != '') ? bcrypt($password) : '';
            $userDetail['fu_google_identifier'] = $fu_google_identifier;
            $userDetail['fu_social_provider'] = $fu_social_provider;
            $userDetail['fu_google_accesstoken'] = $fu_google_accesstoken;
            $userDetail['deleted'] = '1';
            $userDetail['fu_isverified'] = '1';
            $existPassword = '';

            $userWithSocialId = $this->UserRepository->getUserBySocialId($userDetail['fu_google_identifier'], $userDetail['fu_social_provider']);

            if (isset($userWithSocialId) && !empty($userWithSocialId)) {
                if ($userDetail['fu_email'] != '') {
                    $userEmailExistWithAnotherId = $this->UserRepository->checkActiveEmailExist($userDetail['fu_email'], $userWithSocialId->id);

                    if (isset($userEmailExistWithAnotherId) && !empty($userEmailExistWithAnotherId)) {
                        $userDetail['fu_email'] = '';
                        $userDetail['id'] = $userWithSocialId->id;
                        $existPassword = $userWithSocialId->password;
                        $redirectToUpdateProfile = 1;
                    } else {
                        $redirectToDashboard = 1;
                        $userDetail['id'] = $userWithSocialId->id;
                        $userDetail['fu_email'] = $userWithSocialId->fu_email;
                        $existPassword = $userWithSocialId->password;
                    }
                } else {
                    $userDetail['id'] = $userWithSocialId->id;
                    $existPassword = $userWithSocialId->password;
                    $userDetail['fu_email'] = $userWithSocialId->fu_email;
                    $redirectToUpdateProfile = 1;
                }
            } else {
                if ($userDetail['fu_email'] != '') {
                    $userEmailExist = $this->UserRepository->checkActiveEmailExist($userDetail['fu_email']);
                    if (isset($userEmailExist) && !empty($userEmailExist)) {
                        $getExistEmailUserData = $this->UserRepository->getUserDetailByEmailId($userDetail['fu_email']);
                        $userDetail['id'] = $getExistEmailUserData->id;
                        $existPassword = $getExistEmailUserData->password;
                        $redirectToDashboard = 1;
                    } else {
                        $redirectToDashboard = 1;
                    }
                } else {
                    $redirectToUpdateProfile = 1;
                }
            }
            $randomPassword = rand(1234567, 123456789);
            $userDetail['password'] = bcrypt($randomPassword);

            $userDetailSavedAndGetId = $this->UserRepository->saveUserDetail($userDetail);
            // This id use for update password column
            $userDetailSavedAndGetId = array('id' => $userDetailSavedAndGetId['id']);
            $userDetail['id'] = $userDetailSavedAndGetId['id'];

            $response['status'] = 1;
            $response['message'] = trans('appmessages.default_success_msg');
            $response['data'] = $userDetailSavedAndGetId;
            if (Auth::front()->attempt(['fu_email' => $userDetail['fu_email'], 'password' => $randomPassword, 'fu_google_identifier' => $userDetail['fu_google_identifier'], 'deleted' => 1])) {
                if (Auth::front()->check()) {
                    if ($existPassword != '') {
                        $userDetail['password'] = $existPassword;
                    } else {
                        $userDetail['password'] = '';
                    }
                    $userDetailSaved = $this->UserRepository->saveUserDetail($userDetail);
                    $userDetailSavedAndGetId = array('id' => $userDetailSaved['id']);
                    $userId = $userDetailSavedAndGetId['id'];
                    $notDeleted = DB::table(config::get('databaseconstants.TBL_FRONT_USER'))->where('id', $userId)->where('deleted', '1')->first();
                    if ($notDeleted->fu_first_name == '' || $notDeleted->fu_last_name == '' || $notDeleted->fu_user_name == '' || $notDeleted->fu_email == '') {
                        $redirectToUpdateProfile = 1;
                    } else {
                        $signupSucess = 1;
                    }
                } else {
                    Auth::front()->logout();
                    $signupSucess = 0;
                }
            } else {
                $signupSucess = 0;
            }
                $status = Helpers::checkCompleteProfile(); 
                if($status==0)
                        {
                            return Redirect::to('/editprofile')->with('uploadAvatarPath', $this->avatarOriginalImageUploadPath);
                        }
                        else{
                             return Redirect::to('/');                   
                        }
        }
        catch (\Exception $e) {
            return Redirect::to('login/');
        }  

    }

    public function facebookLogin() {

        $redirectToUpdateProfile = $redirectToDashboard = 0;
         
        try {
            $details = Socialite::driver('facebook')->user();
            $response = [];
            $response['status'] = 0;
            $response['message'] = trans('appmessages.default_error_msg');
            $name = $details->name;
            $email = ($details->email != '') ? $details->email : '';
            $password = $details->id;
            $fu_social_provider = 2;
            $fu_facebook_accesstoken = $details->token;
            $fu_facebook_identifier = $details->id;
            $userDetail = [];
            $userDetail['fu_user_name'] = (isset($name) && $name != '') ? $name: '';
            $userDetail['fu_email'] = (isset($email) && $email != '') ? $email : '';
            $userDetail['password'] = (isset($password) && $password != '') ? bcrypt($password) : '';
            $userDetail['fu_facebook_identifier'] = $fu_facebook_identifier;
            $userDetail['fu_social_provider'] = $fu_social_provider;
            $userDetail['fu_facebook_accesstoken'] = $fu_facebook_accesstoken;
            $userDetail['deleted'] = '1';
            $userDetail['fu_isverified'] = '1';
            $existPassword = '';

            $userWithSocialId = $this->UserRepository->getUserBySocialId($userDetail['fu_facebook_identifier'], $userDetail['fu_social_provider']);
            if (isset($userWithSocialId) && !empty($userWithSocialId)) {
                if ($userDetail['fu_email'] != '') {
                    $userEmailExistWithAnotherId = $this->UserRepository->checkActiveEmailExist($userDetail['fu_email'], $userWithSocialId->id);

                    if (isset($userEmailExistWithAnotherId) && !empty($userEmailExistWithAnotherId)) {
                        $userDetail['fu_email'] = '';
                        $userDetail['id'] = $userWithSocialId->id;
                        $existPassword = $userWithSocialId->password;
                        $redirectToUpdateProfile = 1;
                    } else {
                        $redirectToDashboard = 1;
                        $userDetail['id'] = $userWithSocialId->id;
                        $userDetail['fu_email'] = $userWithSocialId->fu_email;
                        $existPassword = $userWithSocialId->password;
                    }
                } else {
                    $userDetail['id'] = $userWithSocialId->id;
                    $existPassword = $userWithSocialId->password;
                    $userDetail['fu_email'] = $userWithSocialId->fu_email;
                    $redirectToUpdateProfile = 1;
                }
            } else {
                if ($userDetail['fu_email'] != '') {
                    $userEmailExist = $this->UserRepository->checkActiveEmailExist($userDetail['fu_email']);
                    if (isset($userEmailExist) && !empty($userEmailExist)) {
                        $getExistEmailUserData = $this->UserRepository->getUserDetailByEmailId($userDetail['fu_email']);
                        $userDetail['id'] = $getExistEmailUserData->id;
                        $existPassword = $getExistEmailUserData->password;
                        $redirectToDashboard = 1;
                    } else {
                        $redirectToDashboard = 1;
                    }
                } else {
                    $redirectToUpdateProfile = 1;
                }
            }
            $randomPassword = rand(1234567, 123456789);
            $userDetail['password'] = bcrypt($randomPassword);

            $userDetailSavedAndGetId = $this->UserRepository->saveUserDetail($userDetail);
            // This id use for update password column

            $userDetailSavedAndGetId = array('id' => $userDetailSavedAndGetId['id']);

            $userDetail['id'] = $userDetailSavedAndGetId['id'];

            $response['status'] = 1;
            $response['message'] = trans('appmessages.default_success_msg');
            $response['data'] = $userDetailSavedAndGetId;

            if (Auth::front()->attempt(['fu_email' => $userDetail['fu_email'], 'password' => $randomPassword, 'fu_facebook_identifier' => $userDetail['fu_facebook_identifier'], 'deleted' => 1])) {
                if (Auth::front()->check()) { 
                    if ($existPassword != '') {
                        $userDetail['password'] = $existPassword;
                    } else {
                        $userDetail['password'] = '';
                    }
                    $userDetailSaved = $this->UserRepository->saveUserDetail($userDetail);
                    $signupSucess = 0;
                } else {
                    Auth::front()->logout();
                    $signupSucess = 0;
                }
            } else {
                $signupSucess = 0;
            }
            $status = Helpers::checkCompleteProfile(); 
            if($status==0)
                    {
                        return Redirect::to('/editprofile')->with('uploadAvatarPath', $this->avatarOriginalImageUploadPath);
                    }
                    else{
                         return Redirect::to('/');                   
                    }
        } catch (\Exception $e) {
            return Redirect::to('login/');
        }

    }

}
