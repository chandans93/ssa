<?php

namespace App\Http\Controllers\WebService;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Helpers;
use Config;
use Mail;
use App\UserFronts;
use App\PurchaseVouchers;
use App\Rewards;
use App\Services\User\Contracts\UserRepository;
use App\Services\Template\Contracts\TemplatesRepository;
use App\Services\ForumCategory\Contracts\ForumCategoryRepository;
use App\Services\Forum\Contracts\ForumRepository;
use App\Services\ForumPost\Contracts\ForumPostRepository;
use App\Services\News\Contracts\NewsRepository;
use App\Services\Newscomment\Contracts\NewscommentRepository;
use App\Services\Slider\Contracts\SliderRepository;
use App\Http\Requests\NewscommentRequest;


class WebserviceController extends Controller {

    public function __construct(UserRepository $UserRepository, TemplatesRepository $TemplatesRepository,ForumCategoryRepository $Forum_categoryRepository,ForumRepository $ForumRepository,ForumPostRepository $ForumPostRepository,NewsRepository $NewsRepository , NewscommentRepository $NewscommentRepository,SliderRepository $SliderRepository) {
        $this->objUser = new UserFronts();
        $this->UserRepository = $UserRepository;
        $this->TemplateRepository = $TemplatesRepository;
        $this->ForumCategoryRepository = $Forum_categoryRepository;
        $this->ForumRepository = $ForumRepository;
        $this->ForumPostRepository = $ForumPostRepository;
        $this->avatarOriginalImageUploadPath = Config::get('constant.AVATAR_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->newsThumbImageUploadPath = Config::get('constant.NEWS_THUMB_UPLOAD_PATH');
        $this->NewsRepository = $NewsRepository;
        $this->NewscommentRepository = $NewscommentRepository;
        $this->SliderRepository = $SliderRepository;

    }

    public function index(Request $request) {

        $methodName = $request->input('methodName');
        $body = $request->all();

        $this->$methodName($body);
    }

    public function login($body) {

        $outputArray = [];
        $outputArray['status'] = '0';
        $outputArray['message'] = trans('appmessages.default_error_msg');
        $email = $body['email'];
        $password = $body['password'];
        $deviceId = $body['deviceId'];

        $frontUser = new UserFronts();
        $user = $frontUser->getAllUserFrontByEmail($email);

        if (!$user) {
            // If user not exists 
            $outputArray['status'] = '0';
            $outputArray['message'] = trans('appmessages.usernotexistwithemail');
        } else {
            if ($user->deleted != 1) {
                $outputArray['status'] = '0';
                $outputArray['message'] = 'You\'re account has been deactivated or deleted by admin. Please contact the administrator.';
                echo json_encode($outputArray);
                exit;
            }
            // Authenticate user
            if (Auth::front()->attempt(['fu_email' => $email, 'password' => $password])) {
                // User verified or not
                if ($user['fu_isverified'] == '1') {
                    
                    // Generate access token for web service
                    $accessToken = Helpers::getUserUniqueId();
                    
                    // Update device ID of user
                    $user->fu_device_token = $deviceId;
                    $user->fu_access_token = $accessToken;
                    $user->save();

                    if ($user['fu_first_name'] != '' && $user['fu_last_name'] != '' && $user['fu_email'] != '' && $user['fu_user_name'] != '' && $user['fu_avatar'] != '' && $user['fu_address1'] != '' && $user['fu_address2'] != '' && $user['fu_city'] != '' && $user['fu_state'] != '' && $user['fu_country'] != '' && $user['fu_zipcode'] != '' && $user['fu_phone'] != '' && $user['fu_birthdate'] != '' && $user['fu_gender'] != '') {
                        $profileCompletionStatus = '1';
                    } else {
                        $profileCompletionStatus = '0';
                    }
                    // Get total voucher count of user
                     if (isset($user['id']) && $user['id']>0 ){    
            $displayStatus='2';
            $usersRewardPoints = Helpers::getAvailableRewardPoints($user['id']);
            $usersTotalVoucherCount =  Helpers::getTotalVouchers($user['id']);
        }
        else{
            $displayStatus='1';
            $usersRewardPoints ='0';
            $usersTotalVoucherCount = '0';

        }      
        $detail = $this->SliderRepository->allSlider($displayStatus);
        $path=Config::get('constant.SLIDER_BIG_UPLOAD_PATH');
        $allSlider=array();
        foreach($detail as $k=>$v){
            $value = array();
            $value['hps_redirection_link'] = $v->hps_redirection_link;
            $value['hps_image'] = asset($path.$v->hps_image);
            $allSlider[] =$value;
        }
           
                     $avatarPath = asset($this->avatarOriginalImageUploadPath);
                    $outputArray['status'] = '1';
                    $outputArray['message'] = 'You are successfully logged in';
                    $outputArray['profileCompletion'] = $profileCompletionStatus;
                    $user['vouchers'] = (string) $usersTotalVoucherCount;
                    $user['rewardpoints'] = (string) $usersRewardPoints;
                    $user['avatarPath'] = (string)$avatarPath ;
                    $user['allSlider'] = $allSlider ;
                    $outputArray['data'] = $user;
                } else {
                    $outputArray['status'] = '0';
                    $outputArray['message'] = trans('appmessages.notvarified_user_msg');
                }
            } else {
                $outputArray['status'] = '0';
                $outputArray['message'] = trans('appmessages.invalid_pwd_msg');
            }
        }
        echo json_encode($outputArray);
        exit;
    }

    public function register($body) {

        $email = $body['email'];
        $name = $body['name'];
        $password = $body['password'];
        $surname = $body['surname'];
        $deviceId = $body['deviceId'];

        $outputArray = [];
        $outputArray['status'] = '0';
        $outputArray['message'] = trans('appmessages.default_error_msg');

        $frontUser = new UserFronts();
        $user = $frontUser->getAllUserFrontByEmail($email);

        if ($user) {
            // If user deactivated by admin
            if ($user->deleted != 1) {
                $outputArray['status'] = '0';
                $outputArray['message'] = 'You\'re account has been deactivated or deleted by admin. Please contact the administrator.';
                echo json_encode($outputArray);
                exit;
            }

            $outputArray['status'] = '0';
            $outputArray['message'] = trans('appmessages.userwithsameemailaddress');
        } else {
            // Save front user data in front_user table
            $userDetail['fu_email'] = $email;
            $userDetail['password'] = bcrypt($password);
            $userDetail['fu_first_name'] = $name;
            $userDetail['fu_last_name'] = $surname;
            $userDetail['fu_user_name'] = $name . " " . $surname;
            $userDetail['fu_device_token'] = $deviceId;
            $userDetail['fu_access_token'] = Helpers::getUserUniqueId();
            $userDetail['fu_isverified'] = 0;
            $userDetail['deleted'] = 1;
            $userDetailSaved = UserFronts::create($userDetail);
            
            // Save purchased voucher data of user in purchased_vouchers table
            $userPurchasedVoucherDetail['pv_user_id'] = $userDetailSaved['id'];
            $userPurchasedVoucherDetail['pv_total_voucher'] = 3;
            $userPurchasedVoucherDetail['deleted_at'] = 1;
            $userPurchasedVoucherDetailSaved = PurchaseVouchers::create($userPurchasedVoucherDetail);

            $UserDetailbyId = $this->UserRepository->getUserById($userDetailSaved['id']);

            // --------------------start sending mail ----------------------------//

            $replaceArray = [];
            $replaceArray['USER_NAME'] = $UserDetailbyId->fu_user_name;
            $replaceArray['USER_UNIQUEID'] = Helpers::getUserUniqueId();
            $replaceArray['USER_URL'] = url("verifyUserRegistration?token=" . $replaceArray['USER_UNIQUEID']);

            $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.USER_VAIRIFIED_EMAIL_TEMPLATE_NAME'));
            $content = $this->TemplateRepository->getEmailContent($emailTemplateContent->et_body, $replaceArray);
            $data = [];
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

            $outputArray['status'] = '1';
            $outputArray['message'] = trans('appmessages.signupmail_success_msg');
            $outputArray['userId'] = (string) $UserDetailbyId->id;
        }
        echo json_encode($outputArray);
        exit;
    }
    
    public function editDetails($body) {
        
        $outputArray = [];
        $outputArray['status'] = '0';
        $outputArray['message'] = trans('appmessages.default_error_msg');
        $fu_access_token=$body['fu_access_token'];
        
        // Get User data
        $user = Helpers::getUserdataFromAccessToken($fu_access_token);
        $outputArray['user']=$user;
        if (!$user) {
            // If access token not found
            $outputArray['status'] = '2';
            $outputArray['message'] = 'Access token mismatched.';
        } else {
            if ($user->deleted != 1) {
                $outputArray['status'] = '0';
                $outputArray['message'] = 'You\'re account has been deactivated or deleted by admin. Please contact the administrator.';
                echo json_encode($outputArray);
                exit;
            }
             $updateProfile = [];
        $id = $updateProfile['id'] =  $user->id;
        $updateProfile['fu_first_name'] = $body['fu_first_name'];
        $updateProfile['fu_last_name'] = $body['fu_last_name'];
        $updateProfile['fu_email'] = $body['fu_email'];
        $updateProfile['fu_user_name'] = $body['fu_user_name'];
        $updateProfile['fu_address1'] = $body['fu_address1'];
        $updateProfile['fu_phone'] = $body['fu_phone'];
        $updateProfile['fu_address2'] = $body['fu_address2'];
        $updateProfile['fu_zipcode'] = $body['fu_zipcode'];
        $updateProfile['fu_country'] = $body['fu_country'];
        $updateProfile['fu_city'] = $body['fu_city'];
        $updateProfile['fu_state'] = $body['fu_state'];
        $updateProfile['fu_gender'] = $body['fu_gender'];
        $updateProfile['fu_avatar'] = $body['fu_avatar'];
        $updateProfile['fu_birthdate'] = date('Y-m-d', strtotime($body['fu_birthdate']));
        $response = $this->UserRepository->saveUserDetail($updateProfile);
        if ($response['flag'] == 2) {
                 $outputArray['data'] = $updateProfile;
                $outputArray['status'] = '1';
                $outputArray['message'] = 'User detail updated successfully.!';
            
        } else {
            $outputArray['status'] = '0';
                $outputArray['message'] = 'Problem occured while update user details.!';
        }
        }
        echo json_encode($outputArray);
        exit;
    }
    
    public function forgotPassword($body) {
        $outputArray = [];
        $outputArray['status'] = '0';
        $outputArray['message'] = trans('appmessages.default_error_msg');
        
        $email = $body['email'];
        
        $frontUser = new UserFronts();
        $user = $frontUser->getAllUserFrontByEmail($email);
        
        if (!$user) {
            // If user not exists 
            $outputArray['status'] = '0';
            $outputArray['message'] = trans('appmessages.usernotexistwithemail');
        } else {
            if ($user->deleted != 1) {
                $outputArray['status'] = '0';
                $outputArray['message'] = 'You\'re account has been deactivated or deleted by admin. Please contact the administrator.';
            } else {
                // --------------------start sending mail -----------------------------//

                $replaceArray = array();
                $replaceArray['USER_NAME'] = $user->fu_user_name;
                $id = $user->id;
                $replaceArray['USER_UNIQUEID'] = Helpers::getUserUniqueId();
                $replaceArray['USER_URL'] = url("resetUserPassword" . "/" . $replaceArray['USER_UNIQUEID']);

                $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.USER_RESET_EMAIL_TEMPLATE_NAME'));
                $content = $this->TemplateRepository->getEmailContent($emailTemplateContent->et_body, $replaceArray);
                $data = array();
                $data['subject'] = $emailTemplateContent->et_subject;
                $data['toEmail'] = $user->fu_email;
                $data['toName'] = $user->fu_first_name;
                $data['content'] = $content;
                $data['USER_UNIQUEID'] = $replaceArray['USER_UNIQUEID'];
                $data['user_url'] = $replaceArray['USER_URL'];
                $data['user_id'] = $id;
                Mail::send(['html' => 'emails.Template'], $data, function($message) use ($data) {
                    $message->subject($data['subject']);
                    $message->to($data['toEmail'], $data['toName']);
                    $useruniqueid = [];
                    $useruniqueid['urp_uniquecode'] = $data['USER_UNIQUEID'];
                    $useruniqueid['urp_user_id'] = $data['user_id'];
                    $this->UserRepository->addUserResetPassword($useruniqueid);
                });

                // ------------------------end sending mail ----------------------------//
                $outputArray['status'] = '1';
                $outputArray['message'] = 'An e-mail with password reset link has been sent to you! Please check your inbox!';
            }
        }        
        echo json_encode($outputArray);
        exit;
    }
    
    public function getProfile($body) {
        $outputArray = [];
        $outputArray['status'] = '0';
        $outputArray['message'] = trans('appmessages.default_error_msg');
        
        $accessToken = $body['accessToken'];
        
        // Get user's data
        $user = Helpers::getUserdataFromAccessToken($accessToken);
        
        if($user) {
            if ($user->deleted != 1) {
                $outputArray['status'] = '0';
                $outputArray['message'] = 'You\'re account has been deactivated or deleted by admin. Please contact the administrator.';
                echo json_encode($outputArray);
                exit;
            }
            $outputArray['status'] = '1';
            $outputArray['message'] = 'Success';
            $outputArray['data'] = $user;
        } else {
            $outputArray['status'] = '2';
            $outputArray['message'] = 'Access token mismatched.!';
        }
        echo json_encode($outputArray);
        exit;
    }

    public function forum()
    {
        $detail=$this->ForumCategoryRepository->findForumCategoryDetail();
        $data = array();
        $postCount='0';
        $lastpostid='0';
        
        if (isset($detail) && !empty($detail)) {
            foreach ($detail as $key=>$val){
                $value = $topicId = array();
                $value['id']=$categoryId = $val['id'];
                $value['fc_name']=$val['fc_name'];
                $value['TopicCount']='0';
                $topicsId=$this->ForumRepository->getTopicsid($categoryId);
                $topicCount = isset($topicsId)?count($topicsId):0;
                $value['TopicCount']= $topicCount;
                if (isset($topicsId) && !empty($topicsId)) {
                    foreach ($topicsId as $key1=>$topicdetail) {
                        $topicId[]=$topicdetail['id'];                      
                    }
                $postCount =$this->ForumPostRepository->getpostCount($topicId);
                $lastpostid=$this->ForumPostRepository->getlastpostid($topicId);
                }
                $value['post']='';
                $value['username']='';
                $value['post_time']='';

                if($lastpostid>'0'){
                    $lastpost= $this->ForumPostRepository-> getLastPostFront($lastpostid);
                    if (isset($lastpost) && !empty($lastpost)) {
                            $value['post']=$lastpost['fp_post_reply'];
                            $value['username']=$lastpost['fu_user_name'];
                            $value['post_time']=date('D M j, Y g:i a',strtotime($lastpost['created_at']));
                    }
                }

                $value['postCount']=$postCount;
                $data[] = $value;
            }
        } 

        $outputArray['status'] = '1';
        $outputArray['message'] = 'Success';
        $outputArray['data'] = $data;

        echo json_encode($outputArray);
        exit;
    }

    public function forumCategory($body)
    {
        $id = $body['id'];
        $detail=$this->ForumRepository->findForumTopicsDetail($id);
        $data = array();
        $postCount='0';
        $lastpostid='0';
        if (isset($detail) && !empty($detail)) {
            foreach ($detail as $key=>$val){
                $value = array();
                $value['id']=$val['id'];
                $value['topic']=$val['f_forum_topic'];
                $value['topic_by']='by administrator <i class="fa fa-angle-double-right" aria-hidden="true"></i> '.date('D M j, Y g:i a',strtotime($val['created_at']));
                
                
                if (isset($val['id']) && $val['id']>'0') {
                    $topicId['0']=$val['id'];   
                    $postCount =$this->ForumPostRepository->getpostCount($topicId);
                    $lastpostid=$this->ForumPostRepository->getlastpostid($topicId);
                }
                $value['post']='';
                $value['username']='';
                $value['post_time']='';

                if($lastpostid>'0'){
                    $lastpost= $this->ForumPostRepository-> getLastPostFront($lastpostid);
                    if (isset($lastpost) && !empty($lastpost)) {
                            $value['post']=$lastpost['fp_post_reply'];
                            $value['username']=$lastpost['fu_user_name'];
                            $value['post_time']=date('D M j, Y g:i a',strtotime($lastpost['created_at']));
                    }
                }
                $value['postCount']=$postCount;
                $data[] = $value;
            }
        }
        $outputArray['status'] = '1';
        $outputArray['message'] = 'Success';
        $outputArray['data'] = $data;

        echo json_encode($outputArray);
        exit;
    }

    public function forumTopicDetail($body)
    {
        $id = $body['id'];

        $detail=$this->ForumRepository->forumDetail($id);
        $post = $data = $topic = $reply =array();
        if($detail)
        {
            $topic['id'] = $detail->id;
            $topic['f_forum_topic'] = $detail->f_forum_topic;
            $topic['f_description'] = $detail->f_description;
            $topic['created_at'] = date('F j Y',strtotime($detail->created_at));
        }
        $postCount='0';
        
        if (isset($detail) && !empty($detail)) {
            if (isset($detail['id']) && $detail['id']>'0') {
                $topicId['0']=$detail['id'];
                $postCount =$this->ForumPostRepository->getpostCount($topicId);
                $post=$this->ForumPostRepository->getAllPost($topicId);
            }
        }
        $topic['postCount']=$postCount;

        $data['topic'] = $topic;

        if (isset($post) && !empty($post)) {
            foreach ($post as $key2=>$postreply){
                $val=array();
                $val['reply']=$postreply['fp_post_reply'];
                $val['username']=$postreply['username'];
                $val['post_time']=Helpers::humanTime(strtotime($postreply['created_at']));
                $val['fu_avatar']= asset($this->avatarOriginalImageUploadPath.$postreply['fu_avatar']);
                $val['id']=$id=$postreply['id'];

                $parentdetail= $this->ForumPostRepository-> getsubdetail($id);

                foreach ($parentdetail as $key3=>$postcomment){
                    if (isset($postcomment) && !empty($postcomment)){
                        $subPost['username']=$postcomment['username'];
                        $subPost['reply']=$postcomment['fp_post_reply'];
                        $subPost['fu_avatar']=asset($this->avatarOriginalImageUploadPath.$postcomment['fu_avatar']);
                        $subPost['post_time']=Helpers::humanTime(strtotime($postcomment['created_at']));
                        $val['subpost'][] = $subPost;
                    }
                }
                $reply[]=$val;
            }
        }
        $data['postreply'] = $reply;
        $outputArray['status'] = '1';
        $outputArray['message'] = 'Success';
        $outputArray['data'] = $data;

        echo json_encode($outputArray);
        exit;
    }

    public function news()
    {
        $detail=$this->NewsRepository->displayDetail();
        $data = array();
        foreach($detail as $k=>$v)
        {
            $value = array();
            $value['id'] = $v->id;
            $value['n_title'] = $v->n_title;
            $value['n_photo'] = asset($this->newsThumbImageUploadPath.$v->n_photo);
            $value['n_description'] = $v->n_description;
            $data[] = $value;
        }
        $outputArray['status'] = '1';
        $outputArray['message'] = 'Success';
        $outputArray['data'] = $data;

        echo json_encode($outputArray);
        exit;
    }

    public function newsComment($body)
    {
        $id = $body['id'];
        $data = $news = $nComment = array();
        $newsDetail = $this->NewsRepository->displayNewsDetail($id);

        if($newsDetail)
        {
            $news['n_title'] = $newsDetail->n_title;
            $news['n_description'] = $newsDetail->n_description;
            $video = '';
            if($newsDetail->n_video!='')
            {
                $video = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","//www.youtube.com/embed/$1",$newsDetail->n_video);
            }
            $news['n_video'] = $video;
        }
        $data['news'] = $news;
        $newsComment = $this->NewscommentRepository->displayNewsCommentDetail($id);

        foreach ($newsComment as $key => $value) {
           $val = array();
           $val['nc_comment'] = $value->nc_comment;
           $val['username'] = $value->username;
           $val['created_at'] = date('M j Y',strtotime($value->created_at));
           $nComment[] = $val;
        }
        $data['newsComment'] = $nComment;
        $outputArray['status'] = '1';
        $outputArray['message'] = 'Success';
        $outputArray['data'] = $data;

        echo json_encode($outputArray);
        exit;
    }
    public function home($body)
    {   
        $loginStatus = $body['is_login'];
        $data = array();

        if ($loginStatus){    
            $displayStatus='2';
            $id = $body['id'];
            $data['totalVouchers'] =  Helpers::getTotalVouchers($id);
            $data['totalRewardPoint'] = Helpers::getAvailableRewardPoints($id);
            $data['avatarPath'] = asset($this->avatarOriginalImageUploadPath);
        }
        else{
            $displayStatus='1';
        }      
        $detail = $this->SliderRepository->allSlider($displayStatus);
        $path=Config::get('constant.SLIDER_BIG_UPLOAD_PATH');
        $allSlider=array();
        foreach($detail as $k=>$v){
            $value = array();
            $value['hps_redirection_link'] = $v->hps_redirection_link;
            $value['hps_image'] = asset($path.$v->hps_image);
            $allSlider[] =$value;
        }
        $data['allSlider']=$allSlider;
        
        $outputArray['status'] = '1';
        $outputArray['message'] = 'Success';
        $outputArray['data'] = $data;
        echo json_encode($outputArray);
        exit;
    }
    public function allcountry()
{   $data = array();
    $data['country'] = Helpers::getCountries();
    $outputArray['status'] = '1';
    $outputArray['message'] = 'Success';
    $outputArray['data'] =$data; 
    echo json_encode($outputArray);
    exit;
}
public function allState($body)
{   $countryid=$body['id'];
    $data = array();
    $data['state'] = Helpers::getStates($countryid);
    $outputArray['status'] = '1';
    $outputArray['message'] = 'Success';
    $outputArray['data'] =$data;
    echo json_encode($outputArray);
    exit;
    
}
public function allcity($body)
{   
    $stateid=$body['id'];
    $data = array();
    $data['city'] = Helpers::getCities($stateid);
    $outputArray['status'] = '1';
    $outputArray['message'] = 'Success';
    $outputArray['data'] = $data;
    echo json_encode($outputArray);
    exit;
}
public function allAvatar()
{   $uploadAvatarPath = $this->avatarOriginalImageUploadPath;
    $data = array();
    $images = glob($uploadAvatarPath . "*.jpg");
    foreach ($images as $file) {
        $image_explode_array = explode('/', $file);
        $data['allAvatar'][] = end($image_explode_array);
    }
    $outputArray['status'] = '1';
    $outputArray['message'] = 'Success';
    $outputArray['data'] = $data;
    echo json_encode($outputArray);
    exit;
}
public function allGender()
{  
    $outputArray['status'] = '1';
    $outputArray['message'] = 'Success';
    $outputArray['data'] =Helpers::gender();;
    echo json_encode($outputArray);
    exit;
}

}
