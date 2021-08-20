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
use App\Services\WatchedItems\Contracts\WatchedItemsRepository;
use App\WatchedItems;
use App\Auction;

class WatchedItemsController extends Controller {

    public function __construct(ProductRepository $ProductRepository, ProductCategoryRepository $ProductCategoryRepository, AuctionRepository $AuctionRepository, WatchedItemsRepository $WatchedItemsRepository) {
        $this->middleware('auth.front');
        $this->ProductRepository = $ProductRepository;
        $this->ProductCategoryRepository = $ProductCategoryRepository;
        $this->AuctionRepository = $AuctionRepository;
        $this->WatchedItemsRepository = $WatchedItemsRepository;
        $this->controller = 'WatchedItemsController';
        $this->productThumb_135_197_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_135_197_IMAGE_UPLOAD_PATH');
    }

    public function index() {
        $controller = $this->controller;
        $imagePath = $this->productThumb_135_197_ImageUploadPath;
        $searchParamArray = Input::all();
        $watchedItemsDetail = $this->WatchedItemsRepository->getUsersWatchedItems($searchParamArray);
        if(!empty($watchedItemsDetail)) {
            foreach ($watchedItemsDetail as $_watchedItemsDetail) {
                $checkForLiveAuction = DB::table('vw_au_auction')->where('au_product_id', $_watchedItemsDetail['wi_product_id'])->where('au_status', 3)->where('deleted', 1)->select('id')->first();
                if(empty($checkForLiveAuction)) {
                    $_watchedItemsDetail['liveAuction'] = 0;
                } else {
                    $_watchedItemsDetail['liveAuction'] = 1;
                }
            }
        }
        return view('front.WatchedItem',compact('imagePath', 'searchParamArray', 'watchedItemsDetail'))->with('controller', $this->controller);
    }
    
    public function removeWatchedItem($productId){
        $deleteWatchedItem = DB::table('vw_wi_watched_item')->where('wi_product_id', $productId)->update(['deleted' => 3]);
        if ($deleteWatchedItem) {
            return Redirect::to("watcheditems")->with('success', 'Product successfully deleted from watched list.!')->with('controller', $this->controller);
        } else {
            return Redirect::to("watcheditems")->with('error', 'Problem occured during delete product from watched list.!')->with('controller', $this->controller);
        }
    }

    public function checkForLiveAuction($productId) {
        $checkForLiveAuction = DB::table('vw_au_auction')->where('au_product_id', $productId)->where('au_status', 3)->where('deleted', 1)->select('id')->first();
        if(empty($checkForLiveAuction)) {
            return redirect()->back()->with('error', 'Live auction for this product is expired.')->with('controller', $this->controller);
            exit;
        } else {
            return redirect('liveauction/'.$checkForLiveAuction->id)->with('controller', $this->controller);
            exit;
        }
    }
    
}
