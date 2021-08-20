<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\PurchaseCoins;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseCoinRequest;
use App\Services\PurchaseCoins\Contracts\PurchaseCoinsRepository;
use App\Services\User\Contracts\UserRepository;

class PurchasecoinManagementController extends Controller
{
    public function __construct(PurchaseCoinsRepository $PurchaseCoinsRepository, UserRepository $UserRepository)
    {
        $this->middleware('auth.admin');
        $this->objPurchaseCoins                = new PurchaseCoins();
        $this->PurchaseCoinsRepository        = $PurchaseCoinsRepository;
		$this->UserRepository        = $UserRepository;
        $this->controller = 'PurchasecoinRepositoryManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {	
		$purchasecoin = $this->PurchaseCoinsRepository->getAllPurchasecoin();
        return view('admin.ListPurchasedCoin',compact('purchasecoin'))->with('controller',$this->controller);
    }
    
	public function coindateSearch(){
		$searchedDate = $_POST['created_at'];
		$finalSearchedDate = date('Y-m-d', strtotime($searchedDate));
		$return =	DB::table(config::get('databaseconstants.TBL_PURCHASECOIN') . " AS purchasecoin ")
			          ->leftjoin(config::get('databaseconstants.TBL_FRONT_USER') . " AS user ", 'purchasecoin.pc_user_id', '=', 'user.id')
					  ->selectRaw('user.fu_user_name, purchasecoin.*')
			          ->where( DB::raw("DATE(purchasecoin.created_at)"), $finalSearchedDate)
					  ->where('purchasecoin.deleted', '1');
        return Datatables::of($return)
				      ->make(true);
	}
    public function  getdata()
    {  
		$data = $this->PurchaseCoinsRepository->getDetail();
        return Datatables::of($data)
                    ->make(true);
    }
}