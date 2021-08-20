<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\PurchaseVouchers;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseVoucherRequest;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;
use App\Services\User\Contracts\UserRepository;

class PurchasevoucherManagementController extends Controller
{
    public function __construct(PurchaseVoucherRepository $PurchaseVoucherRepository , UserRepository $UserRepository)
    {
        $this->middleware('auth.admin');
        $this->objPurchaseVouchers                = new PurchaseVouchers();
        $this->PurchaseVoucherRepository        = $PurchaseVoucherRepository;
		$this->UserRepository        = $UserRepository;
        $this->controller = 'PurchasevoucherManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {
		$purchasevoucher = $this->PurchaseVoucherRepository->getAllPurchasevoucher();
        return view('admin.ListPurchasedVoucher',compact('purchasevoucher'))->with('controller',$this->controller);
    }
	public function dateSearch(){
	
		$searchedDate = $_POST['created_at'];
		$finalSearchedDate = date('Y-m-d', strtotime($searchedDate));
				 
		$return =	DB::table(config::get('databaseconstants.TBL_PURCHASEVOUCHER') . " AS purchasevoucher ")
								->leftjoin(config::get('databaseconstants.TBL_FRONT_USER') . " AS user ", 'purchasevoucher.pv_user_id', '=', 'user.id')
								->where( DB::raw("DATE(purchasevoucher.created_at)"), $finalSearchedDate)
								->selectRaw('purchasevoucher.*,user.fu_user_name')
								->where('pv_total_spent','!=',0);
		return Datatables::of($return)
								->make(true);
	}
	
	public function dateSearchearnvoucher(){
		$searchedDate = $_POST['created_at'];
		$finalSearchedDate = date('Y-m-d', strtotime($searchedDate));
		$return =	DB::table(config::get('databaseconstants.TBL_PURCHASEVOUCHER') . " AS purchasevoucher ")
								->leftjoin(config::get('databaseconstants.TBL_FRONT_USER') . " AS user ", 'purchasevoucher.pv_user_id', '=', 'user.id')
								->where( DB::raw("DATE(purchasevoucher.created_at)"), $finalSearchedDate)
								->selectRaw('purchasevoucher.*,user.fu_user_name')
								->where('pv_total_spent',0);
        return Datatables::of($return)
							    ->make(true);
	}
	
	public function earnedvoucher()
    {
		$purchasevoucher = $this->PurchaseVoucherRepository->getAllEarnedvoucher();
        return view('admin.ListPurchasedearnedVoucher',compact('purchasevoucher'))->with('controller',$this->controller);
    }
    
    public function  getdata()
    {    
        $data = $this->PurchaseVoucherRepository->getDetail();
        return Datatables::of($data)
                     ->make(true);	
    }
	 public function  getearndvoucherdata()
    {    
        $data = $this->PurchaseVoucherRepository->getearnDetail();
		$Parentname = [];
		        foreach ($data as $key => $val) {
				if (isset($val->pv_user_id) && $val->pv_user_id > 0) {
                    $Parentid=$val->pv_user_id;
                    $Parentname[]= $this->UserRepository->getUserById($Parentid);
				}
				}
        return Datatables::of($data)
		     ->make(true);
                  
    }
}