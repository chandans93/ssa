<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\Vouchers;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherRequest;
use App\Services\Voucher\Contracts\VouchersRepository;

class VoucherManagementController extends Controller
{
    public function __construct(VouchersRepository $VouchersRepository)
    {
        $this->middleware('auth.admin');
        $this->objVoucher                = new Vouchers();
        $this->VouchersRepository         = $VouchersRepository;
        $this->controller = 'VoucherManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {
       return view('admin.ListVoucher')->with('controller',$this->controller);
    }
    
    public function  getdata()
    {    
        $data = Vouchers::select(['id', 'v_pack','v_discount','v_price','deleted'])->whereRaw('deleted IN (1,2)');
        return Datatables::of($data)
                 ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivevoucher", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivevoucher", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')                                                                                                                             
                 ->add_column('actions', '<a href="{{ route(".data.editvoucher", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                 <a  href="{{ route(".data.deletevoucher", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')   
                 ->make(true);
    }

    public function add()
    {
        $voucherDetail =[];
        return view('admin.EditVoucher', compact('voucherDetail'))->with('controller',$this->controller);
    }

    public function edit($id)
    {
        $voucherDetail = $this->objVoucher->find($id);
        return view('admin.EditVoucher', compact('voucherDetail'))->with('controller',$this->controller);
    }

    public function save(VoucherRequest $VoucherRequest)
    {
        $voucherDetail = [];
        $voucherDetail['id']  = e(input::get('id'));
        $voucherDetail['v_pack']   = e(input::get('v_pack'));
        $voucherDetail['v_discount']   = e(input::get('v_discount'));
		$voucherDetail['v_price']   = e(input::get('v_price'));
        $voucherDetail['deleted']  = e(input::get('deleted'));
        $response = $this->VouchersRepository->saveVoucherDetail($voucherDetail);
        if($response){
			if($response == 1)
        {   
            return Redirect::to("admin/vouchers")->with('success',trans('adminlabels.voucheraddsuccess'))->with('controller',$this->controller);
        }
		else if($response == 2)
        {   
            return Redirect::to("admin/vouchers")->with('success',trans('adminlabels.voucherupdatesuccess'))->with('controller',$this->controller);
        }
		}
        else
        {   
            return Redirect::to("admin/vouchers")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id)
    {
        $return = $this->VouchersRepository->deleteVoucher($id);
        if($return)
        {
            return Redirect::to("admin/vouchers")->with('success', trans('adminlabels.voucherdeletesuccess'))->with('controller',$this->controller);
        }
        else
        {
            return Redirect::to("admin/vouchers")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editactive($id)
    {
        $return = $this->VouchersRepository->editactiveStatus($id);
        if($return)
        {  
            return Redirect::to("admin/vouchers")->with('controller',$this->controller);
        }
        else
        {   
            return Redirect::to("admin/vouchers")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editinactive($id)
    {
        $return = $this->VouchersRepository->editinactiveStatus($id);
        if($return)
        {   
            return Redirect::to("admin/vouchers")->with('controller',$this->controller);
        }
        else
        {  
            return Redirect::to("admin/vouchers")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
}