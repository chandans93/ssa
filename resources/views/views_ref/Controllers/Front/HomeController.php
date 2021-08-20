<?php

namespace App\Http\Controllers\Front;

use App\FrontUsers;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use App\Services\Slider\Contracts\SliderRepository;
use App\Services\Voucher\Contracts\VouchersRepository;
use App\Services\Coin\Contracts\CoinsRepository;

class HomeController extends Controller {

    public function __construct(SliderRepository $SliderRepository, VouchersRepository $VouchersRepository, CoinsRepository $CoinsRepository) {
        $this->SliderRepository = $SliderRepository;
        $this->VouchersRepository = $VouchersRepository;
        $this->CoinsRepository = $CoinsRepository;
    }

    public function index()
    {   $displayStatus ='0';
        if (Auth::front()->check())
                {    
                    $displayStatus='2';
                    $buyVoucherDetails = $this->VouchersRepository->getAllVouchersForBuy(); 
                    $buyCoinsDetails = $this->CoinsRepository->getAllCoinsForBuy();
                }
            
                        
                else{
                    $displayStatus='1';
                    $buyVoucherDetails = [];
                    $buyCoinsDetails =[];
                            
                }
            
                        
                
        $allSlider = $this->SliderRepository->allSlider($displayStatus);
        $path=Config::get('constant.SLIDER_BIG_UPLOAD_PATH');
        return view('front.Home')->with('allSlider',$allSlider)->with('path',$path)->with('buyVoucherDetails',$buyVoucherDetails)->with('buyCoinsDetails',$buyCoinsDetails);
    }

}
