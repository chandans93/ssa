<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\Coins;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoinRequest;
use App\Services\Coin\Contracts\CoinsRepository;

class CoinManagementController extends Controller
{
    public function __construct(CoinsRepository $CoinsRepository)
    {
        $this->middleware('auth.admin');
        $this->objCoin                = new Coins();
        $this->CoinsRepository         = $CoinsRepository;
        $this->controller = 'CoinManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {
       return view('admin.ListCoin')->with('controller',$this->controller);
    }
    
    public function  getdata()
    {    
        
        $data = Coins::select(['id', 'c_coins','c_price','c_discount','deleted'])->whereRaw('deleted IN (1,2)');
       
        return Datatables::of($data)
                 ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivecoin", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivecoin", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')                                                                                                                             
                 ->add_column('actions', '<a href="{{ route(".data.editcoin", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                 <a  href="{{ route(".data.deletecoin", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        
                   ->make(true);
                  
    }

    public function add()
    {
        $coinDetail =[];
        return view('admin.EditCoin', compact('coinDetail'))->with('controller',$this->controller);
    }

    public function edit($id)
    {
        $coinDetail = $this->objCoin->find($id);
        return view('admin.EditCoin', compact('coinDetail'))->with('controller',$this->controller);
    }

    public function save(CoinRequest $CoinRequest)
    {
        $coinDetail = [];
        $coinDetail['id']  = e(input::get('id'));
        $coinDetail['c_coins']   = e(input::get('c_coins'));
		$coinDetail['c_price']   = e(input::get('c_price'));
		$coinDetail['c_discount']   = e(input::get('c_discount'));
        $coinDetail['deleted']  = e(input::get('deleted'));
        $response = $this->CoinsRepository->saveCoinDetail($coinDetail);
        if($response){
		if($response == 1)
        {   
            return Redirect::to("admin/coins")->with('success',trans('adminlabels.coinaddsuccess'))->with('controller',$this->controller);
        }
		if($response == 2)
        {   
            return Redirect::to("admin/coins")->with('success',trans('adminlabels.coinupdatesuccess'))->with('controller',$this->controller);
        }
		}
        else
        {   
            return Redirect::to("admin/coins")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id)
    {
        $return = $this->CoinsRepository->deleteCoin($id);
        if($return)
        {
            return Redirect::to("admin/coins")->with('success', trans('adminlabels.coindeletesuccess'))->with('controller',$this->controller);
        }
        else
        {
            return Redirect::to("admin/coins")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editactive($id)
    {
        $return = $this->CoinsRepository->editactiveStatus($id);
        if($return)
        {  
            return Redirect::to("admin/coins")->with('controller',$this->controller);
        }
        else
        {   
            return Redirect::to("admin/coins")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editinactive($id)
    {
        $return = $this->CoinsRepository->editinactiveStatus($id);
        if($return)
        {   
            return Redirect::to("admin/coins")->with('controller',$this->controller);
        }
        else
        {  
            return Redirect::to("admin/coins")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
}