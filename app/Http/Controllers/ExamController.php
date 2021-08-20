<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\anant_school_student2019_20;

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


class ExamController extends Controller
{
     public function index()
    {
        return view('front.result'); 
    } 

    public function submit( Request $request)
    {

    	$this->validate($request, [
        'grno'   => 'required',
        'dob' => 'required'
      ]);
    	$gr=strtoupper($request->grno);
    	//var_dump($gr);
    	//var_dump($request->dob);
    	
    	$filename =anant_school_student2019_20::where('RegistrationNumber',  $gr)->where('DateOfBirth',  $request->dob)->select('FileName')->get()->toArray();
    	//var_dump($filename); exit();
    	if(empty($filename))
    	{
    		
    		$message =' Either Registration Number or Date of birth is wrong';
    		return view('front.result')->with('message',$message ); 
    	}
    	else
    	{	
    		$path='/reportcard/'.$filename[0]['FileName'];
    		
    		return Redirect::to(asset($path));
    		 
    	}
    	//var_dump($filename);
        //return view('front.contact');
    }

    public function contact()
    {
        return view('front.contact');
    }

    
}


