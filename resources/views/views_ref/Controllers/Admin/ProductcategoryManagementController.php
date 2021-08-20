<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\ProductCategory;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Services\ProductCategory\Contracts\ProductCategoryRepository;

class ProductcategoryManagementController extends Controller {

    public function __construct(ProductCategoryRepository $ProductcategoryRepository) {
        $this->middleware('auth.admin');
        $this->objproductcategory = new ProductCategory();
        $this->ProductCategoryRepository = $ProductcategoryRepository;
        $this->controller = 'ProductcategoryManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index() {
		 return view('admin.ListProductcategory')->with('controller',$this->controller);
    }

    public function getdata() {
		$data = $this->ProductCategoryRepository->getDetail();
        foreach ($data as $key => $val) {
          $Parentid='0';
            if (isset($val['pc_parent_id']) && $val['pc_parent_id']>'0') {
                   $Parentid=$val['pc_parent_id'];
                      $val['Parentname']=$Parentname =$this->ProductCategoryRepository->getparentname($Parentid);
                }   
        } 
        return Datatables::of($data)
                        ->editColumn('Parentname', '@if ($pc_parent_id == 0) <span style="text-align: center;display: block; padding-right:50%;">-</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">{{$Parentname}}</span> @endif')
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveproductcategory", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveproductcategory", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editproductcategory", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                        <a  href="{{ route(".data.deleteproductcategory", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {
        $productcategoryDetail = [];
        return view('admin.EditProductcategory', compact('productcategoryDetail'))->with('controller',$this->controller);
    }

    public function edit($id) {
        $productcategoryDetail = $this->objproductcategory->find($id);
        return view('admin.EditProductcategory', compact('productcategoryDetail'))->with('controller',$this->controller);
    }
    public function save(ProductCategoryRequest $ProductcategoryRequest) {
        $productcategoryDetail = [];
        $productcategoryDetail['id'] = e(input::get('id'));
        $productcategoryDetail['pc_title'] = e(input::get('pc_title'));
		$productcategoryDetail['pc_parent_id'] = e(input::get('pc_parent_id'));
        $productcategoryDetail['deleted'] = e(input::get('deleted'));
        $response = $this->ProductCategoryRepository->saveDetail($productcategoryDetail);
		
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("admin/productcategory")->with('success', trans('adminlabels.productcategoryaddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2) {
                return Redirect::to("admin/productcategory")->with('success', trans('adminlabels.productcategoryupdatesuccess'))->with('controller',$this->controller);
            }
        } else {
            return Redirect::to("admin/productcategory")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id) {
        $return = $this->ProductCategoryRepository->deleteProductCategory($id);
        if ($return) {
            return Redirect::to("admin/productcategory")->with('success', trans('adminlabels.productcategorydeletesuccess'))->with('controller',$this->controller);
        } else {
            return Redirect::to("admin/productcategory")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    public function editactive($id) {
        $return = $this->ProductCategoryRepository->editactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/productcategory")->with('controller',$this->controller);
        } else {
            return Redirect::to("admin/productcategory")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    public function editinactive($id) {
        $return = $this->ProductCategoryRepository->editinactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/productcategory")->with('controller',$this->controller);
        } else {
            return Redirect::to("admin/productcategory")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
}
