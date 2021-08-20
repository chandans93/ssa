<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\anant_school_student_class11;
use Datatables;
use Auth;
use Config;
use File;
use Image;
use Helpers;
use Redirect;
use DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


class EnquiryController extends Controller
{
    //->with('controller',$this->controller)
    public function index()
    {
        //$data =anant_school_stafflist::where('isRagistred', 2)->select('id','EmployeeNumber')->get();
        //return view('front.staff')->with('stafflist',$data); 
    }
    public function formsubmit(Request $req)
    {
        $cl = new anant_school_student_class11;
        if (isset($req->schoolch)) {
           $cl->schoolch=$req->schoolch;
        }
        else {
           $cl->schoolch='';
        }
        if (isset($req->name)) {
           $cl->name=$req->name;
        }
        else {
           $cl->name='';
        }

        
        if (isset($req->schoolname)) {
           $cl->schoolname=$req->schoolname;
        }
        else {
           $cl->schoolname='';
        }

        if (isset($req->email)) {
           $cl->email=$req->email;
        }
        else {
           $cl->email='';
        }
        
        if (isset($req->studentmobile)) {
           $cl->studentmobile=$req->studentmobile;
        }
        else {
           $cl->studentmobile='';
        }
        
        if (isset($req->city)) {
           $cl->city=$req->city;
        }
        else {
           $cl->city='';
        }
        
        if (isset($req->district)) {
           $cl->district=$req->district;
        }
        else {
           $cl->district='';
        }
        if (isset($req->state)) {
           $cl->state=$req->state;
        }
        else {
           $cl->state='';
        }
        if (isset($req->pincode)) {
           $cl->pincode=$req->pincode;
        }
        else {
           $cl->pincode='';
        }
        if (isset($req->dob)) {
           $cl->dob=$req->dob;
        }
        else {
           $cl->dob='';
        }
        if (isset($req->gender)) {
           $cl->gender=$req->gender;
        }
        else {
           $cl->gender='';
        }
        if (isset($req->fathname)) {
           $cl->fathname=$req->fathname;
        }
        else {
           $cl->fathname='';
        }

        if (isset($req->mothname)) {
           $cl->mothname=$req->mothname;
        }
        else {
           $cl->mothname='';
        }
        if (isset($req->fnumber)) {
           $cl->fnumber=$req->fnumber;
        }
        else {
           $cl->fnumber='';
        }
        if (isset($req->mmobnumber)) {
           $cl->mmobnumber=$req->mmobnumber;
        }
        else {
           $cl->mmobnumber='';
        }
        if (isset($req->stream)) {
           $cl->stream=$req->stream;
        }
        else {
           $cl->stream='';
        }
        if (isset($req->opp1)) {
           $cl->opp1=$req->opp1;
        }
        else {
           $cl->opp1='';
        }
        if (isset($req->opp2)) {
           $cl->opp2=$req->opp2;
        }
        else {
           $cl->opp2='';
        }if (isset($req->opp3)) {
           $cl->opp3=$req->opp3;
        }
        else {
           $cl->opp3='';
        }
        if (isset($req->opp4)) {
           $cl->opp4=$req->opp4;
        }
        else {
           $cl->opp4='';
        }

        if($cl->save()){
            $successmessage =' Thanks for Registration';
        return Redirect::to("/")->with('success',$successmessage );

        }
       
    }
   
}


