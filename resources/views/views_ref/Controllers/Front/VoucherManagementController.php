<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use Illuminate\Pagination\Paginator;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;


class VoucherManagementController extends Controller {

    public function __construct(PurchaseVoucherRepository $PurchaseVoucherRepository) {
        //$this->middleware('auth.front');
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;
        $this->controller = 'VoucherManagementController';
    }
    
    public function index(){
        if (Auth::front()->check()) {
            $user_id = Auth::front()->get()->id; 
            if(isset($_GET['searchDate']) && !empty($_GET['searchDate']))
            {
                $searchedDate = $_GET['searchDate'];
            }
            else
            {
                $searchedDate = '';
            }
            $purchaseVouchers = $this->PurchaseVoucherRepository->getAllPurchaseVouchers($user_id, $searchedDate);
            return view('front.PurchasedVoucher')->with('purchaseVouchers',$purchaseVouchers);
        }
        else {
            return Redirect::to('/');
        }
    }
}
