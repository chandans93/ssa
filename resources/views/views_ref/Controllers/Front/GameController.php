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
use App\PreviouslyViewItem;
use App\Services\Game\Contracts\GameRepository;
use App\Services\GameCategory\Contracts\GameCategoryRepository;
use App\Services\PurchaseCoins\Contracts\PurchaseCoinsRepository;
use App\Services\User\Contracts\UserRepository;
use App\Http\Requests\CheckoutRequest;
use File;
use DateTime;

class GameController extends Controller {

    public function __construct(GameRepository $GameRepository, PurchaseCoinsRepository $PurchaseCoinsRepository, UserRepository $UserRepository, GameCategoryRepository $GameCategoryRepository) {
        $this->GameRepository = $GameRepository;
        $this->controller = 'GameController';
        $this->GameCategoryRepository = $GameCategoryRepository;
        $this->UserRepository = $UserRepository;
        $this->PurchaseCoinsRepository = $PurchaseCoinsRepository;
        $this->gameOriginalImageUploadPath = Config::get('constant.GAME_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->gameThumbImageUploadPath = Config::get('constant.GAME_THUMB_IMAGE_UPLOAD_PATH');
        $this->gameThumb_135_197_ImageUploadPath = Config::get('constant.GAME_THUMB_135_197_IMAGE_UPLOAD_PATH');
        $this->gameThumb_270_212_ImageUploadPath = Config::get('constant.GAME_THUMB_270_212_IMAGE_UPLOAD_PATH');
    }

    public function index() {

        $gamethumbpath = $this->gameThumb_270_212_ImageUploadPath;
        $gameDetail = $this->GameRepository->getAllGameFront();
        
        
         foreach($gameDetail as $k=>$v)
        {
            if (Auth::front()->check()) {
            $uniqueid = Auth::front()->get()->id;
            }
            else{ $uniqueid = 0; }
            
            $Final_favorite[] = $this->GameRepository->getFavoriteGame($uniqueid, $v->id) ;
           
        }
        
        
        if (Auth::front()->check()) {
            $uniqueid = Auth::front()->get()->id;
            $checkDailyTime = Helpers::dailyTime($uniqueid);
             $time = DB::table(config::get('databaseconstants.TBL_PURCHASECOIN'))
                        ->select('created_at')
                        ->where('pc_user_id', $uniqueid)
                        ->where('pc_total_price', 0)
                        ->orderBy('id', 'desc')->first();
        if(isset($time) && !empty($time))
        {    
        $datetime = new DateTime($time->created_at);
        $datetime->modify('+1 day');
        $tommorow_date = $datetime->format('Y-m-d H:i:s');
        
        $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
        $Current_time = date('Y-m-d H:i:s', $time_now);
        
        $date_tommorow = strtotime($tommorow_date);
         
        $date_today = strtotime($Current_time);
        
        
        $dbSessionDuration = $date_tommorow - $date_today;
        
        $Current_time = date('H:i:s', $dbSessionDuration);
        $reset_time = $Current_time;  
        }
        else {
           $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
             
             $Current_time = date('H:i:s', $time_now);
            $reset_time = $Current_time; }
        
        

        } else {
            $checkDailyTime['final_date'] = 0;
             $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
             
             $Current_time = date('Y-m-d H:i:s', $time_now);
            
            $reset_time = $Current_time;
        }

        if ($checkDailyTime['final_date'] > 1440) {
            $Time = 1;
        } else {
            $Time = 2;
        }
        


        return view('front.Game', compact('gameDetail', 'Final_favorite','reset_time','gamethumbpath', 'Time'))->with('controller', $this->controller);
    }

    public function getgamebykeysearch() {
        $searchParamArray = array();
        $searchParamArray = Input::all();
        $gamesDetail = [];
                
        $gamethumbpath = $this->gameThumb_270_212_ImageUploadPath;
        $gameDetail = $this->GameRepository->getAllGame($searchParamArray);
        
        foreach($gameDetail as $k=>$v)
        {
            if (Auth::front()->check()) {
            $uniqueid = Auth::front()->get()->id;
            }
            else{ $uniqueid = 0; }
            
            $Final_favorite[] = array('favorite'=>$this->GameRepository->getFavoriteGame($uniqueid, $v->id)) ;
           
        }    
       
       
        if (Auth::front()->check()) {
            $uniqueid = Auth::front()->get()->id;
            $checkDailyTime = Helpers::dailyTime($uniqueid);
             $time = DB::table(config::get('databaseconstants.TBL_PURCHASECOIN'))
                        ->select('created_at')
                        ->where('pc_user_id', $uniqueid)
                        ->where('pc_total_price', 0)
                        ->orderBy('id', 'desc')->first();
        if(isset($time) && !empty($time))
        {    
        $datetime = new DateTime($time->created_at);
        $datetime->modify('+1 day');
        $tommorow_date = $datetime->format('Y-m-d H:i:s');
        
        $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
        $Current_time = date('Y-m-d H:i:s', $time_now);
        
        $date_tommorow = strtotime($tommorow_date);
         
        $date_today = strtotime($Current_time);
        
        
        $dbSessionDuration = $date_tommorow - $date_today;
        
        $Current_time = date('H:i:s', $dbSessionDuration);
        $reset_time = $Current_time;  
        }
        else {
           $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
             
             $Current_time = date('H:i:s', $time_now);
            $reset_time = $Current_time; }
        
        } else {
            $checkDailyTime['final_date'] = 0;
             $time_now = mktime(date('H') + 5, date('i') + 30, date('s'));
             
             $Current_time = date('Y-m-d H:i:s', $time_now);
            
            $reset_time = $Current_time;
        }

        if ($checkDailyTime['final_date'] > 1440) {
            $Time = 1;
        } else {
            $Time = 2;
        }
      
        return view('front.Game', compact('gameDetail','Time','reset_time','gamethumbpath'))->with('controller', $this->controller);
    }

    public function gamedetail($id) {

        $totalNumberOfReviews = $this->GameRepository->getTotalCountOfReviews($id);
        $reviewDetail = $this->GameRepository->getReviewDetails($id);
        $reviewSumProductWise = $this->GameRepository->getReviewSumAsPerGame($id);
        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
            $response = $this->GameRepository->getFavoriteGame($userid, $id);
            }
            else{ $userid = 0; 
            $response = 2;
            }
        
            

        $googlePlusFollowerCount = Helpers::googlePlusFollowersCount();
        $twitterFollowerCount = Helpers::twitterFollowersCount();

        return view('front.GameDetailPage', compact('twitterFollowerCount','response', 'googlePlusFollowerCount'))->with('controller', $this->controller)
                        ->with('gameDetail', $this->GameRepository->getDetailForIndividualGame($id))
                        ->with('thumbimagePath', $this->gameThumb_270_212_ImageUploadPath)
                        ->with('totalNumberOfReviews', $totalNumberOfReviews)
                        ->with('reviewSumProductWise', $reviewSumProductWise)
                        ->with('reviewDetail', $reviewDetail)
                        ->with('p_id', $id);
    }

    public function insertGameReview() {
        $review = Input::get('review');
        $user_id = Input::get('userid');
        $id = Input::get('productid');
        $rating = Input::get('rating');
        DB::table('vw_gr_game_review')->insert(
                ['gr_user_id' => $user_id, 'gr_game_id' => $id, 'gr_rating' => $rating, 'gr_review' => $review]);
    }

    public function playGame() {

        $GameCoin = Input::get('gamevoucher');


        if (Auth::front()->check()) {
            $id = Auth::front()->get()->id;
            $totalcoin = Helpers::getTotalCoins($id);
        } else {
            $totalcoin = 0;
        }

        if ($GameCoin == $totalcoin || $GameCoin < $totalcoin) {
            $purchaseDetail['pc_used_coin'] = Input::get('gamevoucher');
            $purchaseDetail['pc_user_id'] = Auth::front()->get()->id;
            $game_id = Input::get('gameid');
            $return = $this->PurchaseCoinsRepository->deductCoin($purchaseDetail);
            $return = $this->GameRepository->getGameEmbedded($game_id);


            $htmlStr = $return;
        } else {
            $htmlStr = ' <div style="background:red; color:white;" class="order_deliver_detail">
                             <div class="order_detail_inner">
                        
                        <div style="color:white;" class="order_desc">
                        
                       <div> Error ! </div>  ' . trans('You have not enough coin for play this game.') . '
                         
                        </div>
                        
                      </div>';
            $htmlStr.= '</div>';
        }
        echo $htmlStr;
        exit;
    }

    public function favoritegame($id) {

        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
        }
        $favoriteDetails['fg_game_id'] = $id;
        $favoriteDetails['fg_user_id'] = $userid;
        $return = $this->GameRepository->saveFavoriteGame($favoriteDetails);

        if ($return) {
            return Redirect::to("/gamedetail/" . $id)->with('success', trans('Game Successfully Added In Favorite Game.'));
        }
    }
    
    
    public function favoritegamehome($id) {

        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
        }
        $favoriteDetails['fg_game_id'] = $id;
        $favoriteDetails['fg_user_id'] = $userid;
        $return = $this->GameRepository->saveFavoriteGame($favoriteDetails);

        if ($return) {
            return Redirect::to("/game")->with('success', trans('Game Successfully Added In Favorite Game.'));
        }
    }

    public function getFavoriteGame($userid, $gameid) {
        $response = $this->GameRepository->getFavoriteGame($userid, $gameid);
        return $response;
    }

    public function dailycoin() {


        if (Auth::front()->check()) {
            $id = Auth::front()->get()->id;
        }
        $dailyCoinDetails['pc_total_coins'] = Input::get('dailycoin');
        $dailyCoinDetails['pc_user_id'] = $id;
        $return = $this->GameRepository->saveDailyCoin($dailyCoinDetails);

        if ($return) {
            return 1;
        }
    }

    public function favoritegamebyuser() {
        $favoriteGameDetails = [];
        $gamethumbpath = $this->gameOriginalImageUploadPath;
        if (Auth::front()->check()) {
            $id = Auth::front()->get()->id;
            $favoriteGameDetails = $this->GameRepository->getFavoriteGamebyUser($id);
        }
        return view('front.FavoriteGame', compact('favoriteGameDetails', 'gamethumbpath'))->with('controller', $this->controller);
    }

}
