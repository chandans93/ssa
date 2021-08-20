<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\Product;
use App\Order;
use App\ProductImage;
use DB;
use Datatables;
use File;
use Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\Product\Contracts\ProductRepository;
use App\Services\ProductCategory\Contracts\ProductCategoryRepository;

class ProductManagementController extends Controller {

    public function __construct(ProductRepository $ProductRepository, ProductCategoryRepository $ProductCategoryRepository) {
        $this->middleware('auth.admin');
        $this->objProduct = new Product();
        $this->ProductRepository = $ProductRepository;
        $this->ProductCategoryRepository = $ProductCategoryRepository;
        $this->controller = 'ProductManagementController';
        $this->loggedInUser = Auth::admin()->get();
        $this->productOriginalImageUploadPath = Config::get('constant.PRODUCT_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->productThumb_90_50_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_90_50_IMAGE_UPLOAD_PATH');
        $this->productThumb_90_50_ImageHeight = Config::get('constant.PRODUCT_THUMB_90_50_IMAGE_HEIGHT');
        $this->productThumb_90_50_ImageWidth = Config::get('constant.PRODUCT_THUMB_90_50_IMAGE_WIDTH');
        $this->productThumb_135_197_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_135_197_IMAGE_UPLOAD_PATH');
        $this->productThumb_135_197_ImageHeight = Config::get('constant.PRODUCT_THUMB_135_197_IMAGE_HEIGHT');
        $this->productThumb_135_197_ImageWidth = Config::get('constant.PRODUCT_THUMB_135_197_IMAGE_WIDTH');
        $this->productThumb_270_212_ImageUploadPath = Config::get('constant.PRODUCT_THUMB_270_212_IMAGE_UPLOAD_PATH');
        $this->productThumb_270_212_ImageHeight = Config::get('constant.PRODUCT_THUMB_270_212_IMAGE_HEIGHT');
        $this->productThumb_270_212_ImageWidth = Config::get('constant.PRODUCT_THUMB_270_212_IMAGE_WIDTH');
    }

    public function index() {

        return view('admin.ListProduct')->with('controller', $this->controller);
    }

    public function getdata() {
        $data = $this->ProductRepository->getDetail();


        foreach ($data as $key => $val) {
            if (isset($val['p_category_id']) && $val['p_category_id'] > '0') {
                $Categoryid = $val['p_category_id'];
                $val['p_category_id'] = $p_category_id = $this->ProductCategoryRepository->getparentname($Categoryid);
            }
        }

        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveproduct", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveproduct", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->editColumn('p_category_id', '@if ($p_category_id == 0) <span style="text-align: center;display: block; padding-right:50%;">{{$p_category_id}}</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">-</span> @endif')
                        ->add_column('images', '<a href={{ route(".image",$id) }}>Add Photo</a>')
                        ->add_column('actions', '<a href="{{ route(".data.editproduct", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deleteproduct", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {

        $productDetail = [];
        $productImageDetail = [];
        $uploadProductImagePath = $this->productOriginalImageUploadPath;
        return view('admin.EditProducts', compact('productDetail', 'productImageDetail', 'uploadProductImagePath'))->with('controller', $this->controller);
    }

    public function edit($id) {

        $productDetail = $this->objProduct->find($id);
        $productImageDetail = $this->ProductRepository->getImage($id);
        $productImageDetail = json_decode(json_encode($productImageDetail), true);
        $uploadProductImagePath = $this->productOriginalImageUploadPath;
        return view('admin.EditProducts', compact('productDetail', 'productImageDetail', 'uploadProductImagePath'))->with('controller', $this->controller);
    }

    public function save(ProductRequest $ProductRequest) {

        $productDetail = [];
        $productDetail['id'] = e(Input::get('id'));
        $productDetail['p_sku'] = e(Input::get('p_sku'));
        $productDetail['p_title'] = e(Input::get('p_title'));
        $productDetail['p_price'] = e(Input::get('p_price'));
        $productDetail['p_voucher'] = e(Input::get('p_voucher'));
        $productDetail['p_quantity'] = e(Input::get('p_quantity'));
        $productDetail['p_category_id'] = e(Input::get('p_category_id'));
        $productDetail['p_subcategory_id'] = e(Input::get('p_subcategory_id'));
        $productDetail['p_description'] = (Input::get('p_description'));
        $productDetail['p_condition'] = (Input::get('p_condition'));
        $productDetail['p_delivery_method'] = (Input::get('p_delivery_method'));
        $productDetail['p_platform'] = (Input::get('p_platform'));
        $productDetail['p_pre_order'] = (Input::get('p_pre_order'));
        $productDetail['p_pre_order_date'] = (Input::get('p_pre_order_date'));
        $productDetail['p_region'] = (Input::get('p_region'));        
        $productDetail['deleted'] = e(Input::get('deleted'));
       
        $ProductDetailbyId = $this->ProductRepository->saveProductDetail($productDetail);


        $hiddenProfile = e(Input::get('hidden_profile'));
        $productDetail['pi_image_name'] = $hiddenProfile;


        if (Input::file()) {
            $file = Input::file('pi_image_name');

            if (isset($file) && !empty($file)) {
                $fileName = 'product_' . time() . '.' . $file->getClientOriginalExtension();
                $pathOriginal = public_path($this->productOriginalImageUploadPath . $fileName);
                $pathThumb_90_50 = public_path($this->productThumb_90_50_ImageUploadPath . $fileName);
                $pathThumb_135_197 = public_path($this->productThumb_135_197_ImageUploadPath . $fileName);
                $pathThumb_270_212 = public_path($this->productThumb_270_212_ImageUploadPath . $fileName);

                Image::make($file->getRealPath())->save($pathOriginal);
                Image::make($file->getRealPath())->resize($this->productThumb_90_50_ImageWidth, $this->productThumb_90_50_ImageHeight)->save($pathThumb_90_50);
                Image::make($file->getRealPath())->resize($this->productThumb_135_197_ImageWidth, $this->productThumb_135_197_ImageHeight)->save($pathThumb_135_197);
                Image::make($file->getRealPath())->resize($this->productThumb_270_212_ImageWidth, $this->productThumb_270_212_ImageHeight)->save($pathThumb_270_212);

                if ($hiddenProfile != '') {
                    $imageOriginal = public_path($this->productOriginalImageUploadPath . $hiddenProfile);
                    $imageThumb_90_50 = public_path($this->productThumb_90_50_ImageUploadPath . $hiddenProfile);
                    $imageThumb_135_197 = public_path($this->productThumb_135_197_ImageUploadPath . $hiddenProfile);
                    $imageThumb_270_212 = public_path($this->productThumb_270_212_ImageUploadPath . $hiddenProfile);
                    File::delete($imageOriginal, $imageThumb_90_50, $imageThumb_135_197, $imageThumb_270_212);
                }
                if ($file != '') {
                    $productDetail['pi_image_name'] = $fileName;
                } else {
                    $productDetail['pi_image_name'] = $hiddenProfile;
                }
            }
        }

        $productDetail['pi_product_id'] = $ProductDetailbyId['id'];
        $productDetail['pi_main_image'] = 1;
       

        $response = $this->ProductRepository->saveProductImage($productDetail);


        if ($response['flag'] == 2) {
            return Redirect::to("admin/product")->with('success', trans('adminlabels.productupdatesuccess'))->with('controller', $this->controller);
        }
        if ($response['flag'] == 1) {

            return Redirect::to("admin/product")->with('success', trans('adminlabels.productaddsuccess'))->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/product")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function delete($id) {
        $return = $this->ProductRepository->deleteProduct($id);
        if ($return) {

            return Redirect::to("admin/product")->with('success', trans('adminlabels.productdeletesuccess'))->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/product")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editactive($id) {

        $return = $this->ProductRepository->editactiveStatus($id);
        if ($return) {

            return Redirect::to("admin/product")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/product")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editinactive($id) {

        $return = $this->ProductRepository->editinactiveStatus($id);
        if ($return) {

            return Redirect::to("admin/product")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/product")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function getSubCategory($id) {
        $subCategory = $this->ProductCategoryRepository->getsubCategoryById($id);
        return json_encode($subCategory);
    }

    public function image($id) {

        return view('admin.ListMoreProductImage', compact('id'))->with('controller', $this->controller);
    }

    public function getimage($productId) {



        $uploadProductImagePath = $this->productOriginalImageUploadPath;
        $data = ProductImage::select(['id', 'pi_image_name', 'pi_product_id', 'pi_main_image', 'deleted'])->Where('pi_product_id', $productId)->whereRaw('deleted IN (1,2)');
        

        return Datatables::of($data)
                        ->editColumn('pi_image_name', '@if(File::exists(public_path("upload/product/original/".$pi_image_name)) && $pi_image_name != NULL) <img src="{{ asset("upload/product/original/".$pi_image_name) }}" height="45" width="45" alt="" />
                            @else
                            <img src="{{ asset("/backend/images/avatar5.png")}}" class="user-image" height="45px" width="45px" alt="">
                            @endif')
                        ->editColumn('pi_main_image', '@if ($pi_main_image == 1) <?php echo "Main Image"; ?> @elseif($pi_main_image == 0) <?php echo "-"; ?> @endif')
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveproductimage",$pi_product_id."/".$id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveproductimage", $pi_product_id."/".$id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->editColumn('deleted', '@if($pi_main_image == 1) <?php echo "-"; ?>@elseif ($deleted == 1) <a href="{{ route(".data.editinactiveproductimage", $pi_product_id."/".$id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveproductimage", $pi_product_id."/".$id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '@if($pi_main_image == 1) <?php echo "-"; ?> @else <a href="{{ route(".data.editproductimage",$id."/".$pi_product_id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deleteproductimage",$pi_product_id."/".$id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a> @endif')
                        ->make(true);
    }

    public function addimage($productId) {

        $productDetail = [];
        $id = '';
        $productImageDetail = [];
        $uploadProductImagePath = $this->productOriginalImageUploadPath;
        return view('admin.EditProductImage', compact('productDetail', 'id', 'productId', 'productImageDetail', 'uploadProductImagePath'))->with('controller', $this->controller);
    }

    public function saveImage($productId) {

        $productDetail = [];
        $productDetail['id'] = e(Input::get('id'));
        $productDetail['deleted'] = e(Input::get('deleted'));
        $hiddenProfile = e(Input::get('hidden_profile'));
        $productDetail['pi_image_name'] = $hiddenProfile;

        if (Input::file()) {
            $file = Input::file('pi_image_name');

            if (isset($file) && !empty($file)) {
                $fileName = 'product_' . time() . '.' . $file->getClientOriginalExtension();
                $pathOriginal = public_path($this->productOriginalImageUploadPath . $fileName);
                $pathThumb_90_50 = public_path($this->productThumb_90_50_ImageUploadPath . $fileName);
                $pathThumb_270_212 = public_path($this->productThumb_270_212_ImageUploadPath . $fileName);

                Image::make($file->getRealPath())->save($pathOriginal);
                Image::make($file->getRealPath())->resize($this->productThumb_90_50_ImageWidth, $this->productThumb_90_50_ImageHeight)->save($pathThumb_90_50);
                Image::make($file->getRealPath())->resize($this->productThumb_270_212_ImageWidth, $this->productThumb_270_212_ImageHeight)->save($pathThumb_270_212);

                if ($hiddenProfile != '') {
                    $imageOriginal = public_path($this->productOriginalImageUploadPath . $hiddenProfile);
                    $imageThumb_90_50 = public_path($this->productThumb_90_50_ImageUploadPath . $hiddenProfile);
                    $imageThumb_270_212 = public_path($this->productThumb_270_212_ImageUploadPath . $hiddenProfile);
                    File::delete($imageOriginal, $imageThumb_90_50, $imageThumb_270_212);
                }

                $productDetail['pi_image_name'] = $fileName;
            }
        }

        $productDetail['pi_product_id'] = $productId;
        $productDetail['pi_main_image'] = 0;
        $return = $productDetail['pi_product_id'];

        $response = $this->ProductRepository->saveMoreImage($productDetail);


        if ($response['flag'] == 2) {
            return Redirect::to("admin/image/" . $productId)->with('success', trans('adminlabels.productimageupdatesuccess'))->with('controller', $this->controller);
        }
        if ($response['flag'] == 1) {

            return Redirect::to("admin/image/" . $productId)->with('success', trans('adminlabels.productimageaddsuccess'))->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/image" . $productId)->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editimage($id, $productId) {



        $productDetail = $this->objProduct->find($productId);
        $productImageDetail = $this->ProductRepository->getImageById($id);
        $productImageDetail = json_decode(json_encode($productImageDetail), true);

        $uploadProductImagePath = $this->productOriginalImageUploadPath;
        return view('admin.EditProductImage', compact('productDetail', 'id', 'productId', 'productImageDetail', 'uploadProductImagePath'))->with('controller', $this->controller);
    }

    public function deleteImage($productId, $id) {
        $return = $this->ProductRepository->deleteProductImage($id);
        if ($return) {

            return Redirect::to("admin/image/" . $productId)->with('success', trans('adminlabels.productimagedeletesuccess'))->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/image/" . $productId)->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }
    
    
    public function editactiveimage($productId,$id) {

        $return = $this->ProductRepository->editactiveimageStatus($id);
        if ($return) {

            return Redirect::to("admin/image/".$productId)->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/image/".$productId)->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editinactiveimage($productId,$id) {

        $return = $this->ProductRepository->editinactiveimageStatus($id);
        if ($return) {

            return Redirect::to("admin/image/".$productId)->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/image/".$productId)->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    
    
    
    public function orderHistory() {

        return view('admin.ListOrderHistory')->with('controller', $this->controller);
    }
    
    public function getOrderHistoryData() {
       
       
        $request_details = DB::table(config::get('databaseconstants.TBL_ORDER') . " AS order ")
                ->leftjoin(config::get('databaseconstants.TBL_DELIVERY_INFORMATION') . " AS delivetyinfo ", 'order.o_delivery_info_id', '=', 'delivetyinfo.id')
                ->leftjoin(config::get('databaseconstants.TBL_FRONT_USER') . " AS user ", 'order.o_user_id', '=', 'user.id')                
                ->selectRaw('user.fu_user_name,order.id,order.o_order_number,order.o_order_date,order.o_delivery_date,order.o_total_payble_amount,order.o_order_status,delivetyinfo.di_address1,delivetyinfo.di_address2,delivetyinfo.di_city,delivetyinfo.di_state,delivetyinfo.di_country,delivetyinfo.di_zipcode,delivetyinfo.di_phone')
                ->where('user.deleted', 1)
                ->where('order.deleted', 1)                
                ->get();
             $data= collect($request_details);
             
        return Datatables::of($data)                        
                        ->addColumn('address', '{{$di_address1}} <br> {{$di_address2}} <br>
                                    <?php $cities = Helpers::getCities($di_state); ?>
                                    <?php foreach ($cities as $key => $value) { ?>
                                    <?php if ($di_city == $value->id) echo $value->c_name; ?>
                                    <?php } ?> <br>                                    
                                    <?php $states = Helpers::getStates($di_country); ?>
                                    <?php foreach ($states as $key => $value) { ?>
                                    <?php if ($di_state == $value->id) echo $value->s_name; ?>
                                    <?php } ?> <br>
                                    <?php $countries = Helpers::getCountries(); ?>
                                    <?php foreach ($countries as $key => $value) { ?>
                                    <?php if ($di_country == $value->id) echo $value->c_name; ?>
                                    <?php } ?> <br>
                                    {{$di_zipcode}}<br>{{$di_phone}}')
                        ->editColumn('o_order_status', '@if ($o_order_status == 1) <a href="{{ route(".data.editorderstatus", $id) }}"> <button>Inprocess</button></a> @elseif($o_order_status == 2)  <?php echo "Delivered"; ?> @else <?php echo "Cancelled"; ?>  @endif')
                       
                        ->make(true);
        
    }

    public function editorderstatus($id) {

        $return = $this->ProductRepository->editOrderStatus($id);
        if ($return) {

            return Redirect::to("admin/order")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/order")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }
    
    public function saveDate() {
        
          $data = $_POST['data'];
          
          $orderDetails['o_delivery_date'] = $data['o_delivery_date'];
          $orderDetails['id']= $data['id'];
          
        $return = $this->ProductRepository->editDeliveryDate($orderDetails);
        if ($return) {

            return Redirect::to("admin/order")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/order")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }
    

}
