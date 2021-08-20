<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use App\Services\PurchaseCoins\Contracts\PurchaseCoinsRepository;


class CoinsManagementController extends Controller {

    public function __construct(PurchaseCoinsRepository $PurchaseCoinsRepository) {
        //$this->middleware('auth.front');
        $this->PurchaseCoinsRepository = $PurchaseCoinsRepository;
        $this->controller = 'CoinsManagementController';
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
            $purchaseCoins = $this->PurchaseCoinsRepository->getAllPurchaseCoins($user_id, $searchedDate);
            return view('front.PurchasedCoins')->with('purchaseCoins',$purchaseCoins);
        }
        else {
            return Redirect::to('/');
        }
    }
}
