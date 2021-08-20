<?php

namespace App\Http\Controllers\Front;

use App\FrontUsers;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use App\Services\User\Contracts\UserRepository;
use App\Services\Template\Contracts\TemplatesRepository;
use App\Http\Requests\ContactUsMailRequest;
use Mail;

class ContactUsController extends Controller {

    public function __construct(UserRepository $UserRepository, TemplatesRepository $TemplatesRepository) {
        $this->UserRepository = $UserRepository;
        $this->TemplateRepository = $TemplatesRepository;
        $this->contactUsFileUploadPath = Config::get('constant.NEWS_VIDEO_UPLOAD_PATH');
        
    }

    public function index() {
        
        $contact_us = Helpers::contact_us_help();
        $contact_us_order = Helpers::contact_us_order();
        $contact_us_issue = Helpers::contact_us_issue();
        
        return view('front.ContactUs', compact('contact_us,contact_us_order,contact_us_issue'));
    }

    public function mail(ContactUsMailRequest $ContactUsMailRequest) {
        $replaceArray = [];
        
        $contact_us = Helpers::contact_us_help();
        $contact_us_order = Helpers::contact_us_order();
        $contact_us_issue = Helpers::contact_us_issue();
        
        $replaceArray['YEAR'] = date("Y");
        $replaceArray['SITE_NAME'] = 'VoucherWins';
        if (Auth::front()->check())
        {
            $username = Auth::front()->get()->fu_first_name;
            $email = Auth::front()->get()->fu_email;
            
            if(isset($email) && !empty($email))
            {
                $help = e(input::get('cn_help'));
                $replaceArray['HELP'] = $contact_us[$help];
                if($replaceArray['HELP'] != 'General Inquiry')
                {
                    $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.CONTACT_VAIRIFIED_EMAIL_TEMPLATE_NAME'));
                    $replaceArray['USER_NAME'] = $username;
                    $order = e(input::get('cn_orderNo'));
                    $replaceArray['ORDER_NO'] = $contact_us_order[$order];
                    $issue = e(input::get('cn_issue'));
                    $replaceArray['ISSUE'] = $contact_us_issue[$issue];
                }
                else
                {
                    $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.CONTACT_EMAIL_VAIRIFIED_EMAIL_TEMPLATE_NAME'));
                    $replaceArray['USER_NAME'] = $username;
                    $replaceArray['EMAIL'] = $email;
                    $replaceArray['COMMENT'] = e(input::get('cn_commentbox'));
                }
            }
            $content = $this->TemplateRepository->getEmailContent($emailTemplateContent->et_body, $replaceArray);
                    $data = array();
                    $data['subject'] = $emailTemplateContent->et_subject;
                    $data['toEmail'] = 'test.voucherwins@gmail.com';
                    $data['fromMail'] = $email;
                    $data['content'] = $content;
        }
        else
        {
            $emailTemplateContent = $this->TemplateRepository->getEmailTemplateDataByName(Config::get('constant.CONTACT_EMAIL_VAIRIFIED_EMAIL_TEMPLATE_NAME'));
            $help1 = e(input::get('cn_help'));
            $replaceArray['HELP'] = $contact_us[$help1];
            $replaceArray['EMAIL'] = e(input::get('cn_email'));
            $replaceArray['COMMENT'] = e(input::get('cn_commentbox'));
            $content = $this->TemplateRepository->getEmailContent($emailTemplateContent->et_body, $replaceArray);
                    $data = array();
                    $data['subject'] = $emailTemplateContent->et_subject;
                    $data['toEmail'] = 'test.voucherwins@gmail.com';
                    $data['fromMail'] = $replaceArray['EMAIL'];
                    $data['content'] = $content;
        }
        
        if(Input::file())
        {
            $file = Input::file('cn_image');
            $fileName = $file->getClientOriginalName();
            $pathOriginal = public_path($this->contactUsFileUploadPath . $fileName);
            move_uploaded_file($file->getRealPath(), $pathOriginal);   
            $data['Image'] = public_path($this->contactUsFileUploadPath . $fileName);        
        }
        
        if(Mail::send(['html' => 'emails.Template'], $data, function($message) use ($data) {
            $message->subject($data['subject']);
            $message->from($data['fromMail']);
            $message->to($data['toEmail']);
            if(isset($data['Image']) && !empty($data['Image']))
            {
                $message->attach($data['Image']);
            }
        }))
        {
            if(isset($fileName) && !empty($fileName))
            {
                unlink($this->contactUsFileUploadPath . $fileName);
            }
            return Redirect::to("/contact_us")->with('success', 'Mail sent successfully...');
        }
        else
        {
            return Redirect::to("/contact_us")->with('success', 'Mail not sent.....');
        }
        
        
    }

}
