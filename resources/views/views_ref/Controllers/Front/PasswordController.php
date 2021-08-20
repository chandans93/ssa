<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParentPasswordChangeRequest;
use Auth;
use Image;
use Config;
use Helpers;
use Input;
use Redirect;
use Response;
use Mail;
use App\Templates;
use DB;
use DateTime;
use App\Services\User\Contracts\UserRepository;
use App\Services\Template\Contracts\TemplatesRepository;

class PasswordController extends Controller {

    public function __construct(UserRepository $UserRepository, TemplatesRepository $TemplatesRepository
    ) {
        $this->TemplateRepository = $TemplatesRepository;
        $this->UserRepository = $UserRepository;
    }

    public function forgotPasswordOTP($email) {

        if (isset($email) && $email != '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (is_numeric($email) && $email > 0 && $email == round($email, 0)) {
                    $response['message'] = trans('appmessages.inprocess');
                    return Redirect::to('/login')->with('error', trans('appmessages.inprocess'));
                    exit;
                } else {
                    $response['message'] = trans('appmessages.invalid_email_msg');
                    return Redirect::to('/login')->with('error', trans('appmessages.invalid_email_msg'));
                    exit;
                }
            } else {

                $data = array();
                $userDetail = $this->UserRepository->getUserDetailByEmailId($email);


                if (isset($userDetail) && !empty($userDetail)) {

                    if ($userDetail['fu_social_provider'] != 1) {

                    } else {
                        // --------------------start sending mail -----------------------------//

                        $replaceArray = array();
                        $replaceArray['USER_NAME'] = $userDetail->fu_user_name;
                        $id = $userDetail->id;
                        $replaceArray['USER_UNIQUEID'] = Helpers::getUserUniqueId();
                        $replaceArray['USER_URL'] = url("resetUserPassword" . "/" . $replaceArray['USER_UNIQUEID']);

                        $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.USER_RESET_EMAIL_TEMPLATE_NAME'));
                        $content = $this->TemplateRepository->getEmailContent($emailTemplateContent->et_body, $replaceArray);
                        $data = array();
                        $data['subject'] = $emailTemplateContent->et_subject;
                        $data['toEmail'] = $userDetail->fu_email;
                        $data['toName'] = $userDetail->fu_first_name;
                        $data['content'] = $content;
                        $data['USER_UNIQUEID'] = $replaceArray['USER_UNIQUEID'];
                        $data['user_url'] = $replaceArray['USER_URL'];
                        $data['user_id'] = $userDetail->id;
                        Mail::send(['html' => 'emails.Template'], $data, function($message) use ($data) {
                            $message->subject($data['subject']);
                            $message->to($data['toEmail'], $data['toName']);
                            $useruniqueid = [];
                            $useruniqueid['urp_uniquecode'] = $data['USER_UNIQUEID'];
                            $useruniqueid['urp_user_id'] = $data['user_id'];
                            $this->UserRepository->addUserResetPassword($useruniqueid);
                        });

                        // ------------------------end sending mail ----------------------------//

                        exit;
                    }
                } else {
                    
                    $response['message'] = trans('appmessages.usernotexistwithemail');
                    return Redirect::to('/login')->with('error', trans('appmessages.usernotexistwithemail'));
                    exit;
                }
            }
        } else {
            
            $response['message'] = trans('appmessages.missing_data_msg');
            return Redirect::to('/login')->with('error', trans('appmessages.missing_data_msg'));
            exit;
        }
        return Redirect::back()
                        ->withErrors('Something went wrong. Please, try again.');
    }

    public function saveForgotPassword() {

        $userDetail = [];
        $userDetail['id'] = e(Input::get('id'));
        $userDetail['password'] = bcrypt(e(Input::get('new_password')));
        $this->UserRepository->saveUserDetail($userDetail);
        return view('front.SaveForgotPassword', compact('response'));
    }

    public function resetUserPassword($uniqueid) {

        $final = Helpers::getCalculatedTime($uniqueid);
         
        $final_date = $final['final_date'];
        $id  = $final['id'];
        
        if ($final_date > 1440) {
            return view('front.PasswordTimeOut');
        } else {
            return view('front.SetForgotPassword', compact('id'));
        }
    }

}
