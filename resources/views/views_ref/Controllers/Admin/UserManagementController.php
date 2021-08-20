<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use App\Country;
use App\State;
use App\City;
use Redirect;
use App\UserFronts;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\User\Contracts\UserRepository;
use App\Services\Template\Contracts\TemplatesRepository;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;
use App\Services\PurchaseVoucher\Contracts\PurchaseCoinsRepository;
use Mail;

class UserManagementController extends Controller {

    public function __construct(UserRepository $UserRepository, TemplatesRepository $TemplatesRepository, PurchaseVoucherRepository $PurchaseVoucherRepository) {
        $this->middleware('auth.admin');
        $this->objUser = new UserFronts();
        $this->UserRepository = $UserRepository;
        $this->controller = 'UserManagementController';
        $this->TemplateRepository = $TemplatesRepository;
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;
        $this->loggedInUser = Auth::admin()->get();
        $this->avatarOriginalImageUploadPath = Config::get('constant.AVATAR_ORIGINAL_IMAGE_UPLOAD_PATH');
    }

    public function index() {

        return view('admin.ListUsers')->with('controller', $this->controller);
    }

    public function getdata() {
        $data = UserFronts::select(['id', 'fu_user_name', 'fu_email', 'fu_phone', 'deleted'])->whereRaw('deleted IN (1,2)');


        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveuser", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveuser", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.edituser", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deleteuser", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {

        $userDetail = [];
        $countries = Helpers::getCountries();
        $states = Helpers::getStates();
        $cities = Helpers::getCities();
        $uploadAvatarPath = $this->avatarOriginalImageUploadPath;
        return view('admin.EditUsers', compact('userDetail', 'countries', 'states', 'cities', 'uploadAvatarPath'))->with('controller', $this->controller);
    }

    public function edit($id) {

        $userDetail = $this->objUser->find($id);
        $uploadAvatarPath = $this->avatarOriginalImageUploadPath;
        return view('admin.EditUsers', compact('userDetail', 'uploadAvatarPath'))->with('controller', $this->controller);
    }

    public function save(UserRequest $UserRequest) {
        $userDetail = [];
        $userDetail['id'] = e(Input::get('id'));
        $userDetail['fu_avatar'] = e(Input::get('fu_avatar'));
        $userDetail['fu_first_name'] = e(Input::get('fu_first_name'));
        $userDetail['fu_last_name'] = e(Input::get('fu_last_name'));
        if($userDetail['id'] == 0)
        {
            $firstname = strtolower(substr($userDetail['fu_first_name'], 0,30));
            $lastname = strtolower(substr($userDetail['fu_last_name'], 0, 30));
            $nrRand = rand(0, 100000);
            $userDetail['fu_user_name'] = $firstname . $lastname . $nrRand;
        }    
        else
        {
            $userDetail['fu_user_name'] = e(Input::get('fu_user_name'));
        }
        
        $userDetail['fu_email'] = e(Input::get('fu_email'));
        $hiddenPassword = e(Input::get('hidden_password'));
        $password = e(Input::get('password'));
        $confirm_password = e(Input::get('confirm_password'));
        $userDetail['fu_address1'] = e(Input::get('fu_address1'));
        $userDetail['fu_address2'] = e(Input::get('fu_address2'));
        $userDetail['fu_city'] = e(Input::get('fu_city'));
        $userDetail['fu_state'] = e(Input::get('fu_state'));
        $userDetail['fu_country'] = e(Input::get('fu_country'));
        $userDetail['fu_zipcode'] = e(Input::get('fu_zipcode'));
        $userDetail['fu_phone'] = e(Input::get('fu_phone'));
        $userDetail['fu_gender'] = e(Input::get('fu_gender'));
        $userDetail['fu_birthdate'] = date('Y-m-d', strtotime(e(input::get('fu_birthdate'))));
        $userDetail['fu_social_provider'] = 1;
        $userDetail['fu_facebook_identifier'] = e(Input::get('fu_facebook_identifier'));
        $userDetail['fu_facebook_accesstoken'] = e(Input::get('fu_facebook_accesstoken'));
        $userDetail['fu_google_identifier'] = e(Input::get('fu_google_identifier'));
        $userDetail['fu_google_accesstoken'] = e(Input::get('fu_google_accesstoken'));
        $userDetail['fu_isfirstlogin'] = e(Input::get('fu_isfirstlogin'));
        $userDetail['fu_isverified'] = 1;
        $userDetail['deleted'] = e(Input::get('deleted'));

        if ($hiddenPassword != '' && $password == '') {
            $userDetail['password'] = $hiddenPassword;
        } else {
            $userDetail['password'] = bcrypt($password);
        }

        if ($userDetail['id'] != 0) {
            $response = $this->UserRepository->saveUserDetail($userDetail);
        } else {
            $userDetailSaved = $this->UserRepository->saveUserDetail($userDetail);
            $UserDetailbyId = $this->UserRepository->getUserById($userDetailSaved['id']);

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


            $purchaseDetail['pv_user_id'] = $UserDetailbyId->id;
            $purchaseDetail['pv_total_voucher'] = 3;
            $response = $this->PurchaseVoucherRepository->savePurchaseVoucharDetail($purchaseDetail);
        }

        if ($response['flag'] == 2) {
            return Redirect::to("admin/user")->with('success', trans('adminlabels.userupdatesuccess'))->with('controller', $this->controller);
        }
        if ($response['flag'] == 1) {

            return Redirect::to("admin/user")->with('success', trans('adminlabels.useraddsuccess'))->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/user")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function delete($id) {
        $return = $this->UserRepository->deleteUser($id);
        if ($return) {

            return Redirect::to("admin/user")->with('success', trans('adminlabels.userdeletesuccess'))->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/user")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editactive($id) {
        $return = $this->UserRepository->editactiveStatus($id);
        if ($return) {

            return Redirect::to("admin/user")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/user")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editinactive($id) {
        $return = $this->UserRepository->editinactiveStatus($id);
        if ($return) {

            return Redirect::to("admin/user")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/user")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

}
