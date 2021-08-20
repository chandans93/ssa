<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\staffdetail;
use App\attendance_report;
use DataTables;
use Config;
use File;
use Image;
use Helpers;
use Redirect;
use DB;
use Response;
use Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    //->with('controller',$this->controller)
    public function asestaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'ASE')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function gmisstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'GMIS')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function lgpsstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'LGPS')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function lgmsstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'LGMS')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function sdsmstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'SMDR')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function lgpthstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'LGPTH')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function hostelstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', 'HSTL')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }
    public function sdhamstaff()
    {
        $data =staffdetail::where('deleted', 1)->where('site_name', '1')->select('id','employee_no','employee_name','designation')->get();
        //var_dump($data);
        //exit();
        return view('attendancesheet')->with('staffdetail',$data); 
    }

    public function findname($id)
    {
       $data =anant_school_stafflist::where('id', $id)->select('Name')->get()->toArray();
        if(!empty($data)){
            return $data[0]['Name'];    
        }else{
            return '';
        }
    }
    public function staffotp($id)
    {
       $record=anant_school_stafflist::where('id',$id)->select('emailaddress','Name')->get()->toArray();
       $otp = rand(100000,999999); 
       $user = anant_school_stafflist::find($id);
       $user->OTP = $otp;
       $user->save();
        $mail = new SMTPMailer();
        $mail->addTo($record[0]['emailaddress']);
        $mail->Subject('OTP for the Quiz Competition ASE- Staff Registration for Competition COVID-19');
        $mail->Body(
            '<h2><strong>Dear '.$record[0]['Name'].'</strong></h2>
            <p>Thanks for Registration for Competition COVID-19 your OTP is <span style="color: #ff0000;">'.$otp.'</span></p>
            <p> Please verify your OTP to get your registration Confirm</p>
            <h2>Ignore this mail if you are not registered.</h2>
            <h2>Please don&rsquo;t reply this mail</h2>');

        if ($mail->Send()) {
            return 'Please check your Mail for OTP ';
        }
        else{
            return '';
        }  
    }
    public function otpverify(Request $request)
    {   
        $this->validate($request, [
        'otp'   => 'required',
      ]);

        $otp=anant_school_stafflist::where('id',$request->id)->select('OTP')->get()->toArray();
        if(!empty($otp)){
            if($request->otp==$otp[0]['OTP'])
            {
                $otpverify = anant_school_stafflist::find($request->id);
                $otpverify->isRagistred = 1;
                $otpverify->save();
                $successmessage="OTP verified Thanks for Registration";
                return Redirect::to("/")->with('success',$successmessage );
            }
            else{
                    $errormessage="OTP not verified Please check your mail or contact to Administrator";
                    return Redirect::to("/staff")->with('error',$errormessage); 
            }

        }else{
             $successmessage="we are faciing some difculties please contact to Administrator";
                return Redirect::to("/staff")->with('error',$successmessage );
        }

        
    }
    
    //studet
    public function student()
    {
        $data =anant_school_class::where('isActive', 1)->select('class')->get();
        return view('front.student')->with('class',$data);
    }
    public function eventname($id)
    {
       $data =anant_school_event::where('class', $id)->select('Event_Name')->get()->toArray();
       foreach ($data as $key => $value) {
         $Event_Name[]=$value['Event_Name'];
       }
        if(!empty($data)){
            return $Event_Name;    
        }else{
            return '';
        }
    }

    
}


