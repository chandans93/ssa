<?php

namespace App\Http\Controllers\Front;

use App\UserFronts;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use Request;
use App\Country;
use App\Http\Requests\UserSignupRequest;
use App\Services\User\Contracts\UserRepository;
use App\Services\Template\Contracts\TemplatesRepository;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;
use App\Http\Requests\UserManagementRequest;
use App\Http\Requests\UserCompleteProfileRequest;
use App\Services\CMS\Contracts\CMSRepository;
use Mail;

class UserManagementController extends Controller {

    public function __construct(UserRepository $UserRepository, TemplatesRepository $TemplatesRepository, PurchaseVoucherRepository $PurchaseVoucherRepository,CMSRepository $CMSRepository) {
        $this->CMSRepository = $CMSRepository;
        $this->objUser = new UserFronts();
        $this->UserRepository = $UserRepository;
        $this->TemplateRepository = $TemplatesRepository;
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;
        $this->controller = 'UserManagementController';
        $this->avatarOriginalImageUploadPath = Config::get('constant.AVATAR_ORIGINAL_IMAGE_UPLOAD_PATH');
    }

    public function signup() {
        $privacyPolicy = $this->CMSRepository->getCMSBySlug('privacy--policy');
        $termsOfService = $this->CMSRepository->getCMSBySlug('terms-of-service');

        return view('front.Signup')->with('privacyPolicy',$privacyPolicy)->with('termsOfService',$termsOfService);
    }

    public function completeProfile() {
        if (Auth::front()->check()) {
            $status = Helpers::checkCompleteProfile();
            if ($status == 0) {
                return view('front.CompleteProfile')->with('uploadAvatarPath', $this->avatarOriginalImageUploadPath);
            } else {
                return Redirect::to('/');
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function doSignup(UserSignupRequest $UserSignupRequest) {

        $userDetail = [];
        $userDetail['id'] = e(Input::get('id'));
        $userDetail['fu_first_name'] = e(Input::get('fu_first_name'));
        $userDetail['fu_last_name'] = e(Input::get('fu_last_name'));
        if ($userDetail['id'] == 0) {
            $firstname = strtolower(substr($userDetail['fu_first_name'], 0, 30));
            $lastname = strtolower(substr($userDetail['fu_last_name'], 0, 30));
            $nrRand = rand(0, 100000);
            $userDetail['fu_user_name'] = $firstname . $lastname . $nrRand;
        } else {
            $userDetail['fu_user_name'] = e(Input::get('fu_user_name'));
        }
        $userDetail['fu_email'] = e(Input::get('fu_email'));
        $hiddenPassword = e(Input::get('hidden_password'));
        $password = e(Input::get('password'));
        $confirm_password = e(Input::get('confirm_password'));
        $userDetail['fu_social_provider'] = 1;
        $userDetail['fu_facebook_identifier'] = e(Input::get('fu_facebook_identifier'));
        $userDetail['fu_facebook_accesstoken'] = e(Input::get('fu_facebook_accesstoken'));
        $userDetail['fu_google_identifier'] = e(Input::get('fu_google_identifier'));
        $userDetail['fu_google_accesstoken'] = e(Input::get('fu_google_accesstoken'));
        $userDetail['fu_isfirstlogin'] = e(Input::get('fu_isfirstlogin'));
        $userDetail['fu_isverified'] = e(Input::get('fu_isverified'));
        $userDetail['deleted'] = e(Input::get('deleted'));


        if ($hiddenPassword != '' && $password == '') {
            $userDetail['password'] = $hiddenPassword;
        } else {
            $userDetail['password'] = bcrypt($password);
        }

        $userDetailSaved = $this->UserRepository->saveUserDetail($userDetail);
        $UserDetailbyId = $this->UserRepository->getUserById($userDetailSaved['id']);

        // --------------------start sending mail ----------------------------//

        $replaceArray = array();
        $replaceArray['USER_NAME'] = $UserDetailbyId->fu_user_name;
        $replaceArray['USER_UNIQUEID'] = Helpers::getUserUniqueId();
        $replaceArray['USER_URL'] = url("verifyUserRegistration?token=" . $replaceArray['USER_UNIQUEID']);

        $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.USER_VAIRIFIED_EMAIL_TEMPLATE_NAME'));
        $content = $this->TemplateRepository->getEmailContent($emailTemplateContent->et_body, $replaceArray);
        $data = array();
        $data['subject'] = $emailTemplateContent->et_subject;
        $data['toEmail'] = $UserDetailbyId->fu_email;
        $data['toName'] = $UserDetailbyId->fu_first_name;
        $data['content'] = $content;
        $data['user_token'] = $replaceArray['USER_UNIQUEID'];
        $data['user_url'] = $replaceArray['USER_URL'];
        $data['user_id'] = $UserDetailbyId->id;
        Mail::send(['html' => 'emails.Template'], $data, function($message) use ($data) {
            $message->subject($data['subject']);
            $message->to($data['toEmail'], $data['toName']);
            $userTokenDetail = [];
            $userTokenDetail['uev_token'] = $data['user_token'];
            $userTokenDetail['uev_user'] = $data['user_id'];
            $this->UserRepository->addUserEmailVarifyToken($userTokenDetail);
        });
        // ------------------------end sending mail ----------------------------//


        $purchaseDetail['pv_user_id'] = $UserDetailbyId->id;
        $purchaseDetail['pv_total_voucher'] = 3;
        $purchaseDetailSaved = $this->PurchaseVoucherRepository->savePurchaseVoucharDetail($purchaseDetail);

        return view('front.SignupVerification', compact('response'));

        if ($response) {
            return Redirect::to("/")->with('success', trans('adminlabels.userupdatesuccess'));
        } else {
            return Redirect::to("admin/user")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }

    public function editProfile() {


        if (Auth::front()->check()) {
            $user_id = Auth::front()->get()->id;
            $userdetail = $this->UserRepository->profiledetail($user_id);
            return view('front.Editprofile')->with('userdetail', $userdetail)->with('uploadAvatarPath', $this->avatarOriginalImageUploadPath);
        } else
            return Redirect::to("/");
    }

    public function updateProfile(UserCompleteProfileRequest $UserCompleteProfileRequest) {
        $updateProfile = [];
        $id = $updateProfile['id'] = Auth::front()->get()->id;
        $updateProfile['fu_first_name'] = e(input::get('fu_first_name'));
        $updateProfile['fu_last_name'] = e(input::get('fu_last_name'));
        $updateProfile['fu_email'] = e(input::get('fu_email'));
        $updateProfile['fu_user_name'] = e(input::get('fu_user_name'));
        $updateProfile['fu_address1'] = e(input::get('fu_address1'));
        $updateProfile['fu_phone'] = e(input::get('fu_phone'));
        $updateProfile['fu_address2'] = e(input::get('fu_address2'));
        $updateProfile['fu_zipcode'] = e(input::get('fu_zipcode'));
        $updateProfile['fu_country'] = e(input::get('fu_country'));
        $updateProfile['fu_city'] = e(input::get('fu_city'));
        $updateProfile['fu_state'] = e(input::get('fu_state'));
        $updateProfile['fu_gender'] = e(input::get('fu_gender'));
        $updateProfile['fu_avatar'] = e(Input::get('fu_avatar'));
        $updateProfile['fu_birthdate'] = date('Y-m-d', strtotime(e(input::get('fu_birthdate'))));
        $response = $this->UserRepository->saveUserDetail($updateProfile);
        if ($response['flag'] == 2) {
            return Redirect::to("/editprofile")->with('success', trans('adminlabels.profileupdatesuccess'));
        } else {
            return Redirect::to("/editprofile")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }

    public function saveCompleteProfile(UserManagementRequest $UserManagementRequest) {

        $userDetail = [];
        $userDetail['id'] = Auth::front()->get()->id;
        $userDetail['fu_address1'] = e(Input::get('fu_address1'));
        $userDetail['fu_address2'] = e(Input::get('fu_address2'));
        $userDetail['fu_city'] = e(Input::get('fu_city'));
        $userDetail['fu_state'] = e(Input::get('fu_state'));
        $userDetail['fu_country'] = e(Input::get('fu_country'));
        $userDetail['fu_zipcode'] = e(Input::get('fu_zipcode'));
        $userDetail['fu_phone'] = e(Input::get('fu_phone'));
        $userDetail['fu_gender'] = e(Input::get('fu_gender'));
        $userDetail['fu_birthdate'] = date('Y-m-d', strtotime(e(input::get('fu_birthdate'))));
        $userDetail['fu_avatar'] = e(Input::get('fu_avatar'));
        $response = $this->UserRepository->saveUserDetail($userDetail);
        if ($response['flag'] == 2) {
            return Redirect::to("/")->with('success', trans('adminlabels.userupdatesuccess'));
        } else {
            return Redirect::to("admin/user")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }

}
