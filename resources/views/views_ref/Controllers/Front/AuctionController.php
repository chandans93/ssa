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
use App\Services\Product\Contracts\ProductRepository;
use App\Services\ProductCategory\Contracts\ProductCategoryRepository;
use App\Services\Auction\Contracts\AuctionRepository;
use App\WatchedItems;
use App\Auction;
use App\Services\Bid\Contracts\BidRepository;
use App\PurchaseVouchers;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;
use App\Services\AutoBid\Contracts\AutoBidRepository;

class AuctionController extends Controller {

    public function __construct(ProductRepository $ProductRepository, ProductCategoryRepository $ProductCategoryRepository, AuctionRepository $AuctionRepository, BidRepository $BidRepository, PurchaseVoucherRepository $PurchaseVoucherRepository,AutoBidRepository $AutoBidRepository) {
        //$this->ProductRepository = $ProductRepository;
        $this->ProductRepository = $ProductRepository;
        $this->ProductCategoryRepository = $ProductCategoryRepository;
        $this->AuctionRepository = $AuctionRepository;
        $this->controller = 'AuctionController';
        
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;

        $this->BidRepository = $BidRepository;
 
        $this->objAuction = new Auction();
 

        $this->productThumb_90_50_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_90_50_IMAGE_UPLOAD_PATH');

        $this->productThumb_135_197_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_135_197_IMAGE_UPLOAD_PATH');

        $this->productThumb_270_212_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_270_212_IMAGE_UPLOAD_PATH');

        $this->AutoBidRepository = $AutoBidRepository;
    }

    public function index() {
        
        $watchedProducts = [];
        if(Auth::front()->check()) {
            $watchedProduct = WatchedItems::getProductId(Auth::front()->get()->id);
            if(!empty($watchedProduct)) {
                foreach ($watchedProduct as $_watchedProduct) {
                    $watchedProducts[] = $_watchedProduct['wi_product_id'];
                }
            }
        }
        $controller = $this->controller;
        $imagePath = $this->productThumb_135_197_ImageUploadPath;
        $searchParamArray = Input::all();
        $auctionDetail = $this->AuctionRepository->getAllAuctionProduct($searchParamArray);
        return view('front.Auction',compact('controller', 'imagePath', 'searchParamArray', 'auctionDetail', 'watchedProducts'));
        
     }
    
    public function liveAuction($auctionId) {

        $checkForLiveAuction = DB::table('vw_au_auction')->where('id', $auctionId)->where('au_status', 3)->where('deleted', 1)->count();

        if($checkForLiveAuction == 0) {
            return redirect('auction')->with('error', 'Live auction for this product is expired or not found.');
        } else {

            $auctionDetail = Auction::find($auctionId);
            $similarAuction = $this->AuctionRepository->getSimilarAuction($auctionDetail->au_product_id)->toArray();
            $controller = $this->controller;
            $googlePlusFollowerCount = Helpers::googlePlusFollowersCount();
            //$twitterFollowerCount = Helpers::twitterFollowersCount(); 
            $twitterFollowerCount = 0;
            $facebookPageFollowerCount = Helpers::facebookPageFollowerCount(); 
            $images = $this->AuctionRepository->getProductImage($auctionId);
            $imagePath = $this->productThumb_270_212_ImageUploadPath;
            $thumbimagePath = $this->productThumb_90_50_ImageUploadPath;
            $totalNumberOfReviews = $this->ProductRepository->getTotalCountOfReviews($auctionDetail->au_product_id);
            $reviewDetail = $this->ProductRepository->getReviewDetails($auctionDetail->au_product_id);
            $reviewSumProductWise = $this->ProductRepository->getReviewSumAsPerProduct($auctionDetail->au_product_id);
            
            
            //get data for bidding activity section
            $biddingactivity = $this->BidRepository->getBiddingDetail($auctionId);
            
            if(Auth::front()->check()){
               //get login user id
                $userid = Auth::front()->get()->id;

                //get total voucher from  vw_pv_purchased_vouchers
                $obj = new PurchaseVouchers();
                $totalVoucher = $obj->getTotalVouchers($userid); 
                
            }else{
                $totalVoucher = 0;
            }
            
            //get hybrid auction fees
            $auc_result = $this->AuctionRepository->getAuctionById($auctionId);
            $auc_fees =  $auc_result->au_fees;
             
           
            //get higher bidder name
            $maxVoucherDetail = $this->BidRepository->getMaxVoucherPrice($auctionId);
            $maxvoucher_detail = [];
            foreach($maxVoucherDetail as $detail){
                $maxvoucher_detail['b_user_id'] = $detail->b_user_id;
                $bid_username = Helpers::getUsername($maxvoucher_detail['b_user_id']);
                $maxvoucher_detail['high_bid_user'] =  $bid_username['fu_first_name'];
                $maxvoucher_detail['b_total_voucher'] = $detail->b_total_voucher;
            }
             
            return view('front.LiveAuction',compact('controller', 'images', 'imagePath', 'thumbimagePath', 'totalNumberOfReviews', 'reviewSumProductWise', 'reviewDetail', 'auctionDetail', 'similarAuction','biddingactivity','totalVoucher','maxvoucher_detail', 'googlePlusFollowerCount', 'twitterFollowerCount','auc_fees','facebookPageFollowerCount'));
 
        }
    }
    
    public function addAsWatchedItem() {
        try {
            $productId = Input::get('productId');
            if (Auth::front()->get()) {
                $user = Auth::front()->get();
                if($user->fu_first_name != '' && $user->fu_last_name !='' && $user->fu_email !='' && $user->fu_user_name !='' && $user->fu_avatar !='' && $user->fu_address1 !='' && $user->fu_address2 !='' && $user->fu_city !='' && $user->fu_state !='' && $user->fu_country !='' && $user->fu_zipcode !='' && $user->fu_phone !='' && $user->fu_birthdate !='' && $user->fu_gender !='') {
                    $watchedItems = new WatchedItems();
                    $watchedItems->wi_user_id = $user->id;
                    $watchedItems->wi_product_id = $productId;
                    $watchedItems->deleted = 1;
                    if ($watchedItems->save()) {
                        return 1;
                    }
                } else {
                    if($user->fu_social_provider != 1)
                        return 2;
                    else
                        return 0; 
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function insertbidnow(){

        try{
            $biddetail = [];
            $biddetail['b_user_id']        = Input::get('userid');
            $biddetail['b_total_voucher']  = Input::get('price');
            $biddetail['b_auction_id']     = Input::get('auction_id');
            $bid_type                      = Input::get('bid_type');
            $auc_fees                      = Input::get('fees');

            //check sufficient balance is there or not
            $obj = new PurchaseVouchers();
            $totalPurchaseVoucher = $obj->getTotalVouchers($biddetail['b_user_id']);
            if($totalPurchaseVoucher < $biddetail['b_total_voucher']){
                return  "No sufficient balance in your account";
            }

            //new bid has to be greater than previous one 
            $maxVoucherDetail = $this->BidRepository->getMaxVoucherPrice_new($biddetail['b_auction_id']);
            //var_dump($maxVoucherDetail);  
            if(!empty($maxVoucherDetail)){
                $highestbid = $maxVoucherDetail->b_total_voucher;
                if($highestbid >= $biddetail['b_total_voucher']){
                    return $highestbid;
                }
            }


            //deduct auc_participation fees from user account for that only add fees into used voucher field but before that check if this user has already bid into this auction or not. if yes than skip this step but if not than add auction_fees into purchasedvoucher table
            $previous_bid_detail = $this->BidRepository->getUserBiddingDetail($biddetail['b_auction_id'],$biddetail['b_user_id']);
            if(empty($previous_bid_detail)){
                if(isset($auc_fees) && $auc_fees != 0){
                    $pv_voucher = [];
                    $pv_voucher['pv_user_id'] = $biddetail['b_user_id']; 
                    $pv_voucher['pv_auctionid']      = $biddetail['b_auction_id'] ;
                    $pv_voucher['pv_total_voucher']  =  0;
                    $pv_voucher['pv_total_spent']    =  0.0;

                    $pv_voucher['pv_used_voucher']   = $auc_fees ;
                    $pv_voucher['pv_used_type']      = 1 ;//auction fees
                    $feesresult = $this->PurchaseVoucherRepository->insertUsedVoucher($pv_voucher);//insert auction fees

                    $pv_voucher['pv_used_voucher']   = $biddetail['b_total_voucher'];
                    $pv_voucher['pv_used_type']      = 2 ;//bid
                    $bidresult = $this->PurchaseVoucherRepository->insertUsedVoucher($pv_voucher);//insert bid amount

                    $id = $this->BidRepository->saveDetail($biddetail);//add bid into bid table

                    //get secong highest bid from autobid table
                    $secondHighest_res = $this->AutoBidRepository->secondHighest($biddetail['b_auction_id'],$biddetail['b_user_id']);
                    if(!empty($secondHighest_res)){
                        foreach($secondHighest_res as $val){
                            $secondHighest = $val->ab_voucher;
                        }
                        
                        $res_UserAutobid = $this->checkOtherUserAutobid($biddetail['b_auction_id'],$biddetail['b_total_voucher'],$bid_type,$secondHighest);
                        }
                   return 0;
                }
            }

            $used_voucher = [];
            $used_voucher['pv_user_id']        = $biddetail['b_user_id']; 
            $used_voucher['pv_auctionid']      = $biddetail['b_auction_id'] ;
            $used_voucher['pv_total_voucher']  =  0;
            $used_voucher['pv_total_spent']    =  0.0;
            $used_voucher['pv_used_voucher']   = $biddetail['b_total_voucher'] ;
            $used_voucher['pv_used_type']      = 2 ;//bid 


            //check if this user has already set autobid or not. If not than add bid otherwise stop autobid set flage = 1 and add bid into bid table
            $checkAuctionByUserId = $this->AutoBidRepository->checkAuctionByUserId($biddetail['b_auction_id'],$biddetail['b_user_id']);
            if(!empty($checkAuctionByUserId)){
                $update = $this->AutoBidRepository->updateFlage($biddetail['b_auction_id'],$biddetail['b_user_id']);
            }

            //insert bid and add bid voucher into used voucher field into purchased voucher table
            $id = $this->BidRepository->saveDetail($biddetail);
            
            //check if this user has already bid once previously or not. Now update current bid voucher into purchased voucher table.
            $pv_result = $this->PurchaseVoucherRepository->updateBidVoucher($used_voucher);

             
            //get secong highest bid from autobid table
            $secondHighest_res = $this->AutoBidRepository->secondHighest($biddetail['b_auction_id'],$biddetail['b_user_id']);
            
            if(!empty($secondHighest_res)){
                foreach($secondHighest_res as $val){
                    $secondHighest = $val->ab_voucher;
                }
                
                $res_UserAutobid = $this->checkOtherUserAutobid($biddetail['b_auction_id'],$biddetail['b_total_voucher'],$bid_type,$secondHighest);
            }
            
            

            return  0; 

        }
        catch(Exception $ex){
            throw $ex;
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

    public function getnetvouchers(){

        $auctionId = 1;
        $userId = 3;
        //get total vouchers from Bid table
        $totalBidVoucher = $this->BidRepository->getBidTotalVoucher($auctionId,$userId);

         //get total voucher from  vw_pv_purchased_vouchers
        $obj = new PurchaseVouchers();
        $totalPurchaseVoucher = $obj->getTotalVouchers($userId);

        $netvoucher = $totalPurchaseVoucher - $totalBidVoucher;

        echo $netvoucher;
        //return view('front.GetNetVoucher');
    }
    
    public function auctionWon(){
        
//       $DetailPreviouslyViewItem = [];
//       $relatedItemsDetail  = [];
        if (Auth::front()->check()) {
            $wonAuctionDetails = $this->AuctionRepository->getAuctionWonDetail(Auth::front()->get()->id);
            $productId = [];
            foreach ($wonAuctionDetails as $key => $val) {
                $productId[] = $val['au_product_id'];
            }
             $relatedItemsDetail = $this->AuctionRepository->getDetailsForItemsRelatedToWonItems($productId);
        }
        return View('front.AuctionWon')->with('wonAuctionDetails', $wonAuctionDetails)->with('relatedItemsDetail', $relatedItemsDetail)->with('imagePath', $this->productThumb_135_197_ImageUploadPath)->with('controller', $this->controller);
    }
    
    public function auctionLost(){
        if (Auth::front()->check()) {
            $lostAuctionId = $this->AuctionRepository->getLostAuctionIds(Auth::front()->get()->id);
            $auction_id = [];
            foreach ($lostAuctionId as $key => $val) {
                $auction_id[] = $val['id'];
            }
            $finalAuctionId = array_unique($auction_id);
            $checkFromBidTable = $this->AuctionRepository->checkLostAuctionsBid(Auth::front()->get()->id, $finalAuctionId);
            $auctionIdFromBid = [];
            foreach ($checkFromBidTable as $key => $val) {
                $auctionIdFromBid[] = $val->b_auction_id;
            }
            $finalAuctionIdFromBid = array_unique($auctionIdFromBid);
            $lostAuctionProductDetails = $this->AuctionRepository->getAuctionLostDetail(Auth::front()->get()->id, $finalAuctionIdFromBid);
            $productId = [];
            foreach ($lostAuctionProductDetails as $key => $val) {
                $productId[] = $val->au_product_id;
            }
            $finalProductId = array_unique($productId);
            $relatedItemsDetail = $this->AuctionRepository->getDetailsForItemsRelatedToWonItems($finalProductId);
            return View('front.AuctionLost')->with('lostAuctionProductDetails', $lostAuctionProductDetails)->with('relatedItemsDetail', $relatedItemsDetail)->with('imagePath', $this->productThumb_135_197_ImageUploadPath)->with('controller', $this->controller);;
        }
    }
    
    
    
     public function moredetails($id) {
        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
            $this->ProductRepository->saveDataForPreviouslyViewItem($id, $userid);
        }
        $totalNumberOfReviews = $this->ProductRepository->getTotalCountOfReviews($id);
        $reviewDetail = $this->ProductRepository->getReviewDetails($id);
        $reviewSumProductWise = $this->ProductRepository->getReviewSumAsPerProduct($id);

        return view('front.NoLiveAuctiondetail')->with('controller', $this->controller)
                        ->with('productDetail', $this->ProductRepository->getDetailForIndividualProduct($id))
                        ->with('images', $this->ProductRepository->getImage($id))
                        ->with('imagePath', $this->productThumb_270_212_ImageUploadPath)
                        ->with('thumbimagePath', $this->productThumb_90_50_ImageUploadPath)
                        ->with('totalNumberOfReviews', $totalNumberOfReviews)
                        ->with('reviewSumProductWise', $reviewSumProductWise)
                        ->with('reviewDetail', $reviewDetail)
                        ->with('p_id', $id);
        }
    
    public function auctiondetail(){
        return view('front.DemoAuctiondetail');
    }
    
    public function newbidprocedure(){
        //echo "hiee".'<br/>';
        try{
            $bidData['b_auction_id']         = Input::get('auctionid');
            $bidData['b_user_id']            = Input::get('userid');
            $bidData['b_total_voucher']      = Input::get('singlebid_price');
            $usedVoucher['pv_user_id']       = $bidData['b_user_id'];
            $usedVoucher['pv_total_voucher'] = 0;
            $usedVoucher['pv_total_spent']   = 0.0;
            $usedVoucher['pv_used_voucher']  = $bidData['b_total_voucher'];

            $auc_detail = $this->AuctionRepository->getAuctionById($bidData['b_auction_id']);
            $aucType  = $auc_detail->au_bid_type;
            $aucFees  = $auc_detail->au_fees;

            //new bid has to be greater than previous one 
            $maxVoucherDetail = $this->BidRepository->getMaxVoucherPrice_new($bidData['b_auction_id']);
            //var_dump($maxVoucherDetail);  
            if(!empty($maxVoucherDetail)){
                $highestbid = $maxVoucherDetail->b_total_voucher;
                if($aucType == 1){
                    if($highestbid >= $bidData['b_total_voucher']){
                        echo "Please enter greater than ".$highestbid;
                        exit;
                    }
                }else{
                    $maxvalue = $highestbid + 2;
                    if($maxvalue >= $bidData['b_total_voucher']){
                        echo "Please enter greater than ".$maxvalue;
                        exit;
                    }
                }
                
            }
            
            //check sufficient balance is there or not
            $obj = new PurchaseVouchers();
            $totalPurchaseVoucher = $obj->getTotalVouchers($bidData['b_user_id']);
            if($totalPurchaseVoucher < $bidData['b_total_voucher']){
                echo "No sufficient balance in your account";
                exit;
            }

            //check auction type and deduct participant fees from user account
            if($aucType == 2){
                $previous_bid_detail = $this->BidRepository->getUserBiddingDetail($bidData['b_auction_id'],$bidData['b_user_id']);
                if(empty($previous_bid_detail)){
                    $usedVoucher['pv_used_voucher']  = $aucFees;
                    $result = $this->PurchaseVoucherRepository->insertUsedVoucher($usedVoucher);
                }
            }

            //add into bid table and add this voucher into userd voucher table
            $usedVoucher['pv_used_voucher']  = $bidData['b_total_voucher'];
            $id = $this->BidRepository->saveDetail($bidData);
            $result = $this->PurchaseVoucherRepository->insertUsedVoucher($usedVoucher);

             
            $totalPurchaseVoucher = $obj->getTotalVouchers($bidData['b_user_id']);
             
            //penny auction - check autobid functionality for other user
             if($aucType == 1){  
                $result = $this->AutoBidRepository->getAutobid_ByAucId($bidData['b_auction_id']);
                var_dump($result);
                if(!empty($result)){
                    foreach($result as $value){
                            $startlimit = $value->ab_startvoucher;
                            $usedVC = $value->ab_usedvoucher;
                        if($bidData['b_total_voucher'] >= $startlimit){
                            //add bid into bid voucher, into purchased_vouchers, calculate the total remaining vouchers
                            $b_bid['b_auction_id']      = $bidData['b_auction_id'];
                            $b_bid['b_user_id']         = $value->ab_userid;
                            $b_bid['b_total_voucher']   = $bidData['b_total_voucher'] + 1;

                            $pv_usedVoucher['pv_user_id']       = $value->ab_userid;
                            $pv_usedVoucher['pv_total_voucher'] = 0;
                            $pv_usedVoucher['pv_total_spent']   = 0.0;
                            $pv_usedVoucher['pv_used_voucher']  = $b_bid['b_total_voucher'];
                            
                            //check limit and then update used voucher into autobid
                            $usedVC   = $usedVC - $b_bid['b_total_voucher'];  
                            if($usedVC > 0){
                                $a_update = $this->AutoBidRepository->updateUsedVoucher($b_bid['b_auction_id'],$b_bid['b_user_id'],$usedVC);

                                $id = $this->BidRepository->saveDetail($b_bid);
                                $result = $this->PurchaseVoucherRepository->insertUsedVoucher($pv_usedVoucher);
                            }else{
                                
                            }
                        }//if
                    }//foreach
                }//if 
            }//if

        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function newautobidprocedure(){
        //echo "hi".'<br/>';
        try{

            $bidData['ab_auctionid']    = Input::get('auctionid');
            $bidData['ab_userid']       = Input::get('userid');
            $bidData['ab_startvoucher'] = Input::get('start_voucher');
            $bidData['ab_totalvoucher'] = Input::get('end_voucher');
            $bidData['ab_usedvoucher']  = Input::get('end_voucher');

            $id = $this->AutoBidRepository->saveDetail($bidData);

        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    //update auction status  from live to sold - auction end
    public function updateauctionstatussold(){

        $auctionId  = Input::get('auctionId');
        $imagename  = Input::get('imagename'); 
        $productId  = Input::get('productId');
        $sku        = Input::get('skucode');
        $auc_title  = Input::get('auc_title');

        //update in auction table au_status=2 
        $res_update = $this->AuctionRepository->updateAuctionStatus($auctionId);
        
        $href = '/moredetails/'.$auctionId;
        $soldimage = '/frontend/images/sold.png';

        $watchedProducts = [];
        if(Auth::front()->check()) {
            $watchedProduct = WatchedItems::getProductId(Auth::front()->get()->id);
            if(!empty($watchedProduct)) {
                foreach ($watchedProduct as $_watchedProduct) {
                    $watchedProducts[] = $_watchedProduct['wi_product_id'];
                }
            }
        }
        
        $watchClass = '';
        if (Auth::front()->check()) {
            if (!in_array($productId, $watchedProducts)) {
                $watchClass = 'watchItem';
            }
        }


       

        $response  = '<div class="doc_popular_auction end_auction"><div class="product_overlay"></div>';
        $response  .= '<div class="doc_popular_auction_box clearfix">';
        $response .= '<div class="pd_title">';
        $response .= '<h2><a href="'.$href.'">'.$auc_title.'</a></h2>';
        $response .= ' <div><span class="live_auction"><span class="live_auction_inner"></span>
                        </span></div>';
        $response .= '</div><div class="product_desc clearfix"><div class="products_img_cont">';
        $response .= '<img src="'.$imagename.'"  alt="product_img" class="img-responsive">';
        $response .= ' </div><div class="products_sub_cont"><label class="product_auctn">
                        Auction Ended</label><label class="sub_cont_vauchers">
                        Winnig voucher count</label><label class="sub_cont_lat_bidder">'.$sku.'
                        </label></div></div>';
        $response .= '<div class="sold_pd"><img src="'.$soldimage.'"  alt="sold"></div>';
        $response .= '<div class="popular_auction_btn clearfix"><button type="button" data-class="product_'.$productId.'"           data-value="'.$productId.'" class="btn btn-lg btn-fb waves-effect waves-light '.$watchClass.'"><a href="'.$href.'">Watch</a></button></div>';
        $response .= '</div></div></div>';
       
        return $response;
    }

    public function updateauctionstatuslive(){

        $auctionId  = Input::get('auctionId');
        $imagename  = Input::get('imagename'); 
        $productId  = Input::get('productId');
        $sku        = Input::get('skucode');
        $auc_title  = Input::get('auc_title');

    }
    
        
}
