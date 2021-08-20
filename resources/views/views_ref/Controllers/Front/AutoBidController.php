<?php

namespace App\Http\Controllers\Front;

use App\FrontUsers;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use DB;
use App\services\AutoBid\Contracts\AutoBidRepository;
use App\services\Bid\Contracts\BidRepository;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;
use App\PurchaseVouchers;

class AutoBidController extends Controller {

    public function __construct(AutoBidRepository $AutoBidRepository,BidRepository $BidRepository,PurchaseVoucherRepository $PurchaseVoucherRepository) {

    	$this->AutoBidRepository = $AutoBidRepository;
    	$this->BidRepository     = $BidRepository;
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;
        
    }
    public function insertautobid(){
        $autobid = [];
        $autobid['ab_userid']    = Input::get('userid'); 
        $autobid['ab_auctionid'] = Input::get('auction_id');
        $autobid['ab_voucher']   = Input::get('autobid_price');
        $bid_type                = Input::get('bid_type');
        $auc_fees                = Input::get('fees');

        $maxVoucherDetail = $this->BidRepository->getMaxVoucherPrice($autobid['ab_auctionid']);
        $maximumbid =  0;
        if(!empty($maxVoucherDetail)){
            foreach($maxVoucherDetail as $detail){
                $maximumbid = $detail->b_total_voucher;
            }
        }

        if($maximumbid >= $autobid['ab_voucher']){
            return $maximumbid;
        }else{

            //user does not bid previously and direct start with autobid than add 1 voucher in penny and 2 voucher in hybrid in au_b_bid table 
            $bid_result = $this->BidRepository->getUserBiddingDetail($autobid['ab_auctionid'],$autobid['ab_userid']);
            
            $bidDetail = [];
            $bidDetail['b_user_id']       = $autobid['ab_userid'];
            $bidDetail['b_auction_id']    = $autobid['ab_auctionid'];
            if(empty($bid_result)){

                //add bid voucher into au_b_bid table 1-peeny, 2-hybrid but check first if somebody has already add bid for this auction or not. If yes than add this maxbid into bid voucher according to auction type
                $bid_voucher = 0;
                
                if($bid_type == 1){ 
                    $bid_voucher = 1;
                }else{
                    $bid_voucher = 2; 
                }
                
                $bidDetail['b_total_voucher'] = $bid_voucher + $maximumbid;

                $id = $this->AutoBidRepository->saveDetail($autobid);
                $add_bid = $this->BidRepository->saveDetail($bidDetail);
                
                //add auction fees 
                if(isset($auc_fees) && $auc_fees != 0){
                    $used_voucher = [];
                    $used_voucher['pv_user_id']        = $bidDetail['b_user_id']; 
                    $used_voucher['pv_auctionid']      = $autobid['ab_auctionid']; 
                    $used_voucher['pv_total_voucher']  =  0;
                    $used_voucher['pv_total_spent']    =  0.0;
                    
                    $used_voucher['pv_used_voucher']   =  $auc_fees;
                    $used_voucher['pv_used_type']      =  1 ;//fees
                    $result = $this->PurchaseVoucherRepository->insertUsedVoucher($used_voucher);
                }
                
                $used_voucher['pv_used_voucher']   =  $bidDetail['b_total_voucher'];
                $used_voucher['pv_used_type']      =  2 ;//bid 
                $result = $this->PurchaseVoucherRepository->insertUsedVoucher($used_voucher);
                //echo "this is called";

                //count user who had already started autobid
                //$count =  2;
                //if($count >= 2 ){
                     //get secong highest bid from autobid table
                    $secondHighest_res = $this->AutoBidRepository->secondHighest($bidDetail['b_auction_id'],$bidDetail['b_user_id']);
                    if(!empty($secondHighest_res)){
                        foreach($secondHighest_res as $val){
                            $secondHighest = $val->ab_voucher;
                        }
                        
                        $res_UserAutobid = $this->checkOtherUserAutobid($bidDetail['b_auction_id'],$bidDetail['b_total_voucher'],$bid_type,$secondHighest);
                        }
                //}//if
                 

                return 0;
                 
            }else{
                $bidDetail['b_total_voucher'] = $autobid['ab_voucher'];
                //$add_bid = $this->BidRepository->saveDetail($bidDetail);

                $update = $this->AutoBidRepository->updateFlage($autobid['ab_auctionid'],$autobid['ab_userid']);

                $id = $this->AutoBidRepository->saveDetail($autobid);
                //echo "2nd is called";

                return 0;
            }  
        } 
     }


    public function checkOtherUserAutobid($auctionId,$totalVoucher,$bid_type,$secondHighest){

           //check if other user has set autobid for this auction. If yes than add +1 into last bid in case of penny auction and +2 into last bid in case of hybrid auction 
           
            $get_autobidDetail = $this->AutoBidRepository->getAutobid_ByAucId($auctionId);
            $i=0;
            //$autobid_user_amt = $totalVoucher;
            foreach($get_autobidDetail as $detail)
            {
                $i++;  
                $autobid['b_user_id']     = $detail->ab_userid;
                $user_voucher             = $detail->ab_voucher;
                $autobid['b_auction_id']  = $detail->ab_auctionid;  
                $auc_type = 0;
                if($bid_type == 1){ //penny
                    $auc_type = 1;
                }else{
                    $auc_type = 2;
                } 
                //add into bid table and add bid voucher into used voucher field into purchased voucher table
                if($i == 1){
                    $autobid_user_amt = $totalVoucher + $auc_type;
                }else{
                    //get last highest bid
                    $maxVoucherDetail = $this->BidRepository->getMaxVoucherPrice_new($auctionId);
                    if(!empty($maxVoucherDetail)){
                        $highestbid = $maxVoucherDetail->b_total_voucher;
                        $autobid_user_amt = $highestbid + $auc_type; 
                    }
                }

                //$autobid_user_amt += $auc_type;/
              
                //get autobid voucher from autobid table, get used voucher amount from pv_used_voucher table then compare the $autobid_user_amt and check it should not greater than autobid voucher amount
                $autobid_voucher = $detail->ab_voucher;
                 
                $obj = new PurchaseVouchers();
                $purchase_used_voucher = $obj->getTotalVouchers($autobid['b_user_id']);

                //echo $detail->ab_userid."->".$autobid_user_amt."->".$autobid_voucher."->".$purchase_used_voucher."====";

                if($autobid_voucher >= $autobid_user_amt && $purchase_used_voucher >= $autobid_user_amt ){

                    /*echo "If-> ".$detail->ab_userid."->".$autobid_user_amt."<br/>";*/

                    $autobid['b_total_voucher'] = $autobid_user_amt;
                    $id = $this->BidRepository->saveDetail($autobid);

                    $pv_usedvoucher = [];
                    $pv_usedvoucher['pv_user_id']        = $detail->ab_userid; 
                    $pv_usedvoucher['pv_auctionid']      = $auctionId ;
                    $pv_usedvoucher['pv_used_voucher']   = $autobid_user_amt ;
                    $pv_usedvoucher['pv_used_type']      = 2 ;//bid 
                    $result_pv = $this->PurchaseVoucherRepository->updateBidVoucher($pv_usedvoucher);
                }else{
                    //stop auction set flage = 1
                    $update = $this->AutoBidRepository->updateFlage($detail->ab_auctionid,$detail->ab_userid);
                }
             
            }//foreach
            /*echo "last amount".$autobid_user_amt;*/
            if($autobid_user_amt <= $secondHighest){
                $res_UserAutobid = $this->checkOtherUserAutobid($autobid['b_auction_id'],$autobid_user_amt,$bid_type,$secondHighest);
            }

            return 0;

    }
 
 }
