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
use App\Services\Product\Contracts\ProductRepository;
use App\Services\ProductCategory\Contracts\ProductCategoryRepository;
use App\Services\AddCart\Contracts\AddCartRepository;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;
use App\Services\User\Contracts\UserRepository;
use App\Http\Requests\CheckOutRequest;
use File;

class ProductController extends Controller {

    public function __construct(ProductRepository $ProductRepository, PurchaseVoucherRepository $PurchaseVoucherRepository, UserRepository $UserRepository, ProductCategoryRepository $ProductCategoryRepository, AddCartRepository $AddCartRepository) {
        $this->ProductRepository = $ProductRepository;
        $this->controller = 'ProductController';
        $this->ProductCategoryRepository = $ProductCategoryRepository;
        $this->AddCartRepository = $AddCartRepository;
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;
        $this->UserRepository = $UserRepository;

        $this->productOriginalImageUploadPath = Config::get('constant.PRODUCT_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->productThumb_90_50_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_90_50_IMAGE_UPLOAD_PATH');
        $this->productThumb_135_197_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_135_197_IMAGE_UPLOAD_PATH');
        $this->productThumb_270_212_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_270_212_IMAGE_UPLOAD_PATH');
    }

    public function index() {
        return view('front.ProductPage')->with('controller', $this->controller)->with('imagePath', $this->productThumb_135_197_ImageUploadPath)->with('productsDetail', $this->ProductRepository->getAllProductFront());
    }

    public function previoslyPurchadedItems() {
        if (Auth::front()->check()) {
            $id = Auth::front()->get()->id;
            $PrevioslyPurchadedItems = $this->ProductRepository->getPreviouslyPurchasedItems($id);
            $itemsRelatedToPrevioslyPurchadedItems = $this->ProductRepository->getItemsRelatedToPrevioslyPurchadedItems($id);
        } else {
            $PrevioslyPurchadedItems = [];
            $itemsRelatedToPrevioslyPurchadedItems = [];
        }




        return view('front.PreviouslyPurchasedItem', compact('PrevioslyPurchadedItems', 'itemsRelatedToPrevioslyPurchadedItems'))->with('controller', $this->controller)->with('imagePath', $this->productThumb_135_197_ImageUploadPath);
        ;
    }

    public function getSubCategory($id) {

        $subCategory = $this->ProductCategoryRepository->getsubCategoryById($id);
        return json_encode($subCategory);
    }

    public function insertReview() {
        $review = Input::get('review');
        $user_id = Input::get('userid');
        $id = Input::get('productid');
        $rating = Input::get('rating');
        DB::table('vw_pr_product_review')->insert(
                ['pr_user_id' => $user_id, 'pr_product_id' => $id, 'pr_rating' => $rating, 'pr_review' => $review]);
    }

    public function productdetail($id) {
        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
            $this->ProductRepository->saveDataForPreviouslyViewItem($id, $userid);
        } else {
            $userid = 0;
        }
        $ItemAlredySaved = $this->ProductRepository->getItem($userid, $id);
        $AlreadyRequestedAction = $this->ProductRepository->getRequestAuction($userid, $id);
        $totalNumberOfReviews = $this->ProductRepository->getTotalCountOfReviews($id);
        $reviewDetail = $this->ProductRepository->getReviewDetails($id);
        $reviewSumProductWise = $this->ProductRepository->getReviewSumAsPerProduct($id);
        $googlePlusFollowerCount = Helpers::googlePlusFollowersCount();
        $twitterFollowerCount = 0;
        $facebookPageFollowerCount = Helpers::facebookPageFollowerCount();
        return view('front.Productdetail', compact('googlePlusFollowerCount', 'ItemAlredySaved', 'AlreadyRequestedAction', 'twitterFollowerCount', 'facebookPageFollowerCount'))->with('controller', $this->controller)
                        ->with('productDetail', $this->ProductRepository->getDetailForIndividualProduct($id))
                        ->with('images', $this->ProductRepository->getImage($id))
                        ->with('imagePath', $this->productThumb_270_212_ImageUploadPath)
                        ->with('thumbimagePath', $this->productThumb_90_50_ImageUploadPath)
                        ->with('totalNumberOfReviews', $totalNumberOfReviews)
                        ->with('reviewSumProductWise', $reviewSumProductWise)
                        ->with('reviewDetail', $reviewDetail)
                        ->with('p_id', $id);
    }

    public function getproductbykeysearch() {
        $searchParamArray = array();
        $searchParamArray = Input::all();
        $productsDetail = [];
        return view('front.ProductPage')->with('controller', $this->controller)->with('imagePath', $this->productThumb_135_197_ImageUploadPath)->with('productsDetail', $this->ProductRepository->getAllProduct($searchParamArray));
    }

    public function saveRequestAuction() {

        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
        }
        $requestAuctionDetail = [];
        $requestAuctionDetail['id'] = e(Input::get('id'));
        $requestAuctionDetail['ar_user_id'] = $userid;
        $requestAuctionDetail['ar_product_id'] = e(Input::get('product_id'));
        $productid = e(Input::get('product_id'));
        $response = $this->ProductRepository->saveRequestAuction($requestAuctionDetail);

        if ($response) {
            return Redirect::to("/productdetail/" . $productid)->with('success', trans('You Are Successfully Send Request Auction for This Item.'));
        }
    }

    public function previouslyViewedItem() {
        $DetailPreviouslyViewItem = [];
        $relatedItemsDetail = [];
        if (Auth::front()->check()) {

            $obj = new PreviouslyViewItem();
            $productid = array_unique($obj->detailPreviouslyViewItem(Auth::front()->get()->id));
            $DetailPreviouslyViewItem = $this->ProductRepository->DataForPreviouslyViewItem($productid);
            $p_category_id = [];
            foreach ($DetailPreviouslyViewItem as $key => $val) {
                $p_category_id[] = $val['p_category_id'];
            }
            $p_category_id = array_unique($p_category_id);
            $relatedItemsDetailID = $this->ProductRepository->allrelatedItemsDetail($p_category_id);
            $relatedItemsDetailID = array_diff($relatedItemsDetailID, $productid);
            $relatedItemsDetail = $this->ProductRepository->DataForPreviouslyViewRelatedItem($relatedItemsDetailID);
        }
        return view('front.PreviouslyViewedItem')->with('controller', $this->controller)
                        ->with('DetailPreviouslyViewItem', $DetailPreviouslyViewItem)
                        ->with('relatedItemsDetail', $relatedItemsDetail)
                        ->with('imagePath', $this->productThumb_135_197_ImageUploadPath);
    }

    public function saveItem() {

        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
        }
        $item = [];
        $itemDetails['id'] = e(Input::get('id'));
        $itemDetails['si_user_id'] = $userid;
        $itemDetails['si_product_id'] = e(Input::get('product_id'));

        $productid = e(Input::get('product_id'));

        $response = $this->ProductRepository->saveItem($itemDetails);

        if ($response) {
            return Redirect::to("/productdetail/" . $productid)->with('success', trans('Your Item Successfully Saved.'));
        }
    }

    public function saveCart() {

        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
        }
        $productid = e(Input::get('product_id'));
        $cartDetails = [];
        $cartDetails['id'] = e(Input::get('id'));
        $cartDetails['atc_user_id'] = $userid;
        $cartDetails['atc_is_ordered'] = e(Input::get('atc_is_ordered'));
        $cartDetails['atc_total_payble_amount'] = e(Input::get('product_amount'));
        $cartDetails['atcp_product_id'] = e(Input::get('product_id'));
        $cartDetails['deleted'] = 1;

        $response = $this->AddCartRepository->saveCart($cartDetails);
        $cartDetails['atcp_add_to_cart_id'] = $response['id'];
        $cartDetails['atcp_product_id'] = e(Input::get('product_id'));
        $cartDetails['atcp_product_amount'] = e(Input::get('product_amount'));
        $cartDetails['atcp_quantity'] = 1;

        $responseData = $this->AddCartRepository->saveCartProduct($cartDetails);

        if ($responseData) {
            return Redirect::to("/productdetail/" . $productid)->with('success', trans('Your Item Successfully Added to Cart.'));
        }
    }

    public function saveCartlimite() {

        if (Auth::front()->check()) {
            $userid = Auth::front()->get()->id;
        }

        $cartDetails = [];
        $cartDetails['id'] = e(Input::get('id'));
        $cartDetails['atc_user_id'] = e(Input::get('atc_user_id'));
        $cartDetails['atc_is_ordered'] = e(Input::get('atc_is_ordered'));
        $cartDetails['atc_total_payble_amount'] = e(Input::get('product_amount'));
        $cartDetails['atcp_product_id'] = e(Input::get('atcp_product_id'));
        $cartDetails['deleted'] = 1;

        $response = $this->AddCartRepository->saveCart($cartDetails);
        $cartDetails['atcp_add_to_cart_id'] = $response['id'];
        $cartDetails['atcp_product_id'] = e(Input::get('atcp_product_id'));
        $cartDetails['atcp_product_amount'] = e(Input::get('product_amount'));
        $cartDetails['atcp_quantity'] = e(Input::get('atcp_quantity'));


        $responseData = $this->AddCartRepository->saveCartProduct($cartDetails);

        if ($responseData) {
            return 1;
        }
    }

    public function getSavedItems() {
        if (Auth::front()->check()) {
            $savedProductDetails = $this->ProductRepository->getSavedProductUserWise(Auth::front()->get()->id);
            $itemsRelatedTosavedItems = $this->ProductRepository->getItemsRelatedToSavedItems(Auth::front()->get()->id);
        } else {
            $savedProductDetails = [];
            $itemsRelatedTosavedItems = [];
        }
        return view('front.SavedItems')->with('controller', $this->controller)
                        ->with('savedProductDetails', $savedProductDetails)
                        ->with('itemsRelatedTosavedItems', $itemsRelatedTosavedItems)
                        ->with('imagePath', $this->productThumb_135_197_ImageUploadPath);
    }

    public function myCart() {

        $id = Auth::front()->get()->id;
        $data = $this->AddCartRepository->myCart($id);
        $productOriginalImageUploadPath = $this->productOriginalImageUploadPath;
        if (isset($data) && !empty($data)) {
            foreach ($data as $k => $v) {

                $QuantityDetails[] = array('product_id' => $v->productId, 'product_quantity' => $v->atcp_quantity);
            }

            $checkquantity = Helpers::checkQuantity($QuantityDetails);
        } else {
            $checkquantity = 0;
        }


        return view('front.MyCart', compact('data', 'productOriginalImageUploadPath', 'checkquantity'))->with('controller', $this->controller);
    }

    public function deleteCart($id) {
        $return = $this->AddCartRepository->deleteCart($id);
        if ($return) {

            return Redirect::to("/mycart")->with('success', trans('adminlabels.productdeletesuccess'))->with('controller', $this->controller);
        } else {

            return Redirect::to("/mycart")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function saveQuantity() {

        $quantityDetails = [];
        $quantityDetails['id'] = e(Input::get('id'));
        $quantityDetails['atcp_quantity'] = e(Input::get('atcp_quantity'));

        $return = $this->AddCartRepository->saveQuantity($quantityDetails);

        if ($return) {

            return Redirect::to("/mycart")->with('controller', $this->controller);
        } else {

            return Redirect::to("/mycart")->with('controller', $this->controller);
        }
    }

    public function savePlaceOrder($id) {

        if (Auth::front()->check()) {
            $user_id = Auth::front()->get()->id;
            $orderAddress = $this->UserRepository->getUserById($user_id);
        }
        $orderDetails['id'] = Input::get('id');
        $orderDetails['o_order_number'] = Input::get('orderno');
        $orderDetails['o_total_payble_amount'] = Input::get('total_amount');
        $orderDetails['o_user_id'] = Input::get('userid');
        
        $user_voucher = Helpers::getTotalVouchers($user_id);
        if ($user_voucher >= $orderDetails['o_total_payble_amount']) {
            return view('front.PlaceOrder', compact('orderAddress', 'orderDetails', 'user_id','id'));
        } else {
            return Redirect::to("/mycart")->with('error', trans('you have not enough voucher for purchase this product.'));
        }

    }

    public function orderHistory() {
        if (Auth::front()->check()) {
            $id = Auth::front()->get()->id;
            if (isset($_GET['searchDate']) && !empty($_GET['searchDate'])) {

                $searchedDate = $_GET['searchDate'];
            } else {
                $searchedDate = '';
            }

            $orderHistory = $this->AddCartRepository->getAllOrderHistory($id, $searchedDate);

            $productOriginalImageUploadPath = $this->productThumb_90_50_ImageUploadPath;



            return view('front.OrderHistory', compact('orderHistory', 'orderProductDetails', 'productOriginalImageUploadPath'));
        } else {
            return Redirect::to('/');
        }
    }

    public function checkout($id, $amount) {

        if (Auth::front()->check()) {
            $user_id = Auth::front()->get()->id;
            $orderAddress = $this->UserRepository->getUserById($user_id);
        }

        return view('front.PlaceOrder', compact('orderAddress', 'id', 'amount'));
    }

    public function saveCheckout(CheckOutRequest $CheckOutRequest,$id) {

        if (Auth::front()->check()) {
            $user_id = Auth::front()->get()->id;
        } else {
            $user_id = 0;
        }

        $checkoutDetails = [];
        $checkoutDetails['id'] = Input::get('id');
        $checkoutDetails['di_user_id'] = $user_id;
        $checkoutDetails['di_address1'] = Input::get('di_address1');
        $checkoutDetails['di_address2'] = Input::get('di_address2');
        $checkoutDetails['di_city'] = Input::get('di_city');
        $checkoutDetails['di_state'] = Input::get('di_state');
        $checkoutDetails['di_country'] = Input::get('di_country');
        $checkoutDetails['di_zipcode'] = Input::get('di_zipcode');
        $checkoutDetails['di_phone'] = Input::get('di_phone');

        $responseData = $this->ProductRepository->saveCheckOut($checkoutDetails);

        //---------------------------- order details start----------------------//             

        $orderDetails['id'] = Input::get('id');
        $orderDetails['o_user_id'] = $user_id;
        $orderDetails['o_delivery_info_id'] = $responseData['id'];
        $orderDetails['o_order_number'] = Input::get('o_order_number');
        $orderDetails['o_total_payble_amount'] = Input::get('o_total_payble_amount');
        $orderDetails['deleted'] = 1;
        
        $response = $this->AddCartRepository->savePlaceOrder($orderDetails);

        $op_order_id = $response['id'];
        $productDetails = $id;
        $responseData = $this->AddCartRepository->saveOrderProduct($productDetails, $op_order_id);        
        $response['id'];

        //---------------------------- order details end----------------------//     

        if (Auth::front()->check()) {
            $user_id = Auth::front()->get()->id;
        } else {
            $user_id = 0;
        }
        
        $orderStatus['atc_is_ordered'] = 1;
        $orderStatus['atc_user_id'] = $user_id;
        $orderStatus['atc_total_payble_amount'] = Input::get('o_total_payble_amount');
        $responseData = $this->AddCartRepository->updateOrderStatus($orderStatus);

        $purchaseDetail['pv_user_id'] = $user_id;
        $purchaseDetail['pv_used_voucher'] = Input::get('o_total_payble_amount');
        $responseData = $this->PurchaseVoucherRepository->savePurchaseVoucharDetail($purchaseDetail);

        return view('front.CheckOutVerification');
    }

    public function getOrderedProduct() {


        $user_id = $_GET['user_id'];
        if (isset($_GET['order_number'])) {
            $order = $_GET['order_number'];
            $OrderedProducts = $this->AddCartRepository->getOrderedProduct($order, $user_id);
        } else {
            $searchtext = $_GET['searchtext'];
            $OrderedProducts = $this->AddCartRepository->getSerachProduct($searchtext, $user_id);
        }

        $total = 0;
        if (isset($OrderedProducts) && !empty($OrderedProducts)) {
            foreach ($OrderedProducts as $k => $v) {
                $OrderedProduct = $v;
                $Count = $OrderedProduct->op_quantity;
                $total = $Count + $total;
            }

            if ($OrderedProduct->o_order_status = 1) {
                $status = 'InProcess';
            } elseif ($OrderedProduct->o_order_status = 2) {
                $status = 'Delivered';
            } else {
                $status = 'Cancelled';
            }
            $htmlStr = '';
            $htmlStr = '<table class="table">
                <tr>
                  <th>
                    <div class="order_deliver_detail">
                      <div class="order_detail_inner">
                        <label>' . $status . '</label>
                        <div class="order_desc">
                          <div class="order_no">Order No : <span>' . $OrderedProduct->o_order_number . '</span></div>
                          <div class="order_no">Placed On : <span>' . $OrderedProduct->o_order_date . ' /$' . $OrderedProduct->o_total_payble_amount . '/' . $total . ' items</span></div>
                        </div>
                      </div>
                      <div class="ship_to">
                        <div class="ship_person">
                          Ship to 
                          <div class="ship_person_name">
                            ' . $OrderedProduct->fu_user_name . '
                          </div>
                        </div>
                        <div class="ship_data">
                          <p>8486 Sherwood Drive Lancaster, NY 14086</p>
                        </div>
                      </div>
                    </div>  
                  </th>
                </tr>
                <tr>
                  <td>
                    <div class="shipment_detail">
                        <div>Shipment 1 : <span>' . $total . ' items</span><span>   Delivered On ' . $OrderedProduct->o_delivery_date . '</span></div>
                    </div>
                  </td>
                </tr>';



            if (!empty($OrderedProducts)) {
                foreach ($OrderedProducts as $k => $OrderedProduct) {


                    if (File::exists(public_path($this->productThumb_90_50_ImageUploadPath . $OrderedProduct->pi_image_name)) && $OrderedProduct->pi_image_name != '') {
                        $imageUrlProduct = url($this->productThumb_90_50_ImageUploadPath . $OrderedProduct->pi_image_name);
                    } else {
                        $imageUrlProduct = asset('/frontend/images/ava5.png');
                    }


                    $htmlStr .= '<tr>
                  <td>
                    <div class="order_item_desc">
                      <div class="order_table">
                        <div class="order_image">
                          <img src="' . $imageUrlProduct . '" alt="' . $OrderedProduct->pi_image_name . '" class="img-responsive">
                        </div>
                        <div class="order_details">
                          <h3>' . $OrderedProduct->p_title . '</h3>
                          
                          <div><label>Qty :</label>' . $OrderedProduct->op_quantity . '</div>
                          
                        </div>
                        <div class="order_price">
                          ' . $OrderedProduct->op_product_amount . '
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>';
                }
            } else {
                $htmlStr = '<tr><td class="list" colspan="3">' . trans('lable.norecordfound') . '</td></tr>';
            }

            $htmlStr .= '</table>';
        } else {
            $htmlStr = '<table class="table">
                
                <tr>
                  
                    <div class="order_deliver_detail">
                      <div class="order_detail_inner">
                        
                        <div class="order_desc">
                        <center>
                          ' . trans('frontlabels.NoRecordFound') . '
                        </center>  
                        </div>
                        
                      </div>
                      </div>
                 
                 </tr>';
            $htmlStr.= '</table>';
        }
        echo $htmlStr;
        exit;
    }

}
