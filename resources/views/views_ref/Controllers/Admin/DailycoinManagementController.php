<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\Dailycoins;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\DailycoinRequest;
use App\Services\Dailycoin\Contracts\DailycoinsRepository;

class DailycoinManagementController extends Controller
{
    public function __construct(DailycoinsRepository $DailycoinsRepository)
    {
        $this->middleware('auth.admin');
        $this->objDailycoin                = new Dailycoins();
        $this->DailycoinsRepository         = $DailycoinsRepository;
        $this->controller = 'DailycoinManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {
		$dailyCoin = $this->DailycoinsRepository->getAllDailycoins();
       return view('admin.ListDailycoin',compact('dailyCoin'))->with('controller',$this->controller);
    }
    
    public function  getdata()
    {   
        $data = Dailycoins::select(['id','sw_reward_coins','deleted'])->whereRaw('deleted IN (1,2)');
        return Datatables::of($data)
                ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivedailycoin", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivedailycoin", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')                                                                                               
                ->add_column('actions', '<a href="{{ route(".data.editdailycoin", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                <a  href="{{ route(".data.deletedailycoin", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                ->make(true);
    }

    public function add()
    {
        $dailycoinDetail =[];
        return view('admin.EditDailycoin', compact('dailycoinDetail'))->with('controller',$this->controller);
    }

    public function edit($id)
    {
        $dailycoinDetail = $this->objDailycoin->find($id);
        return view('admin.EditDailycoin', compact('dailycoinDetail'))->with('controller',$this->controller);
    }

    public function save(DailycoinRequest $DailycoinRequest)
    {
        $dailycoinDetail = [];
        $dailycoinDetail['id']  = e(input::get('id'));
        $dailycoinDetail['sw_reward_coins']   = e(input::get('sw_reward_coins'));
        $dailycoinDetail['deleted']  = e(input::get('deleted'));
        $response = $this->DailycoinsRepository->saveDailycoinDetail($dailycoinDetail);
        if($response){
		if($response == 1)
        {   
            return Redirect::to("admin/dailycoins")->with('success',trans('adminlabels.dailtcoinaddsuccess'))->with('controller',$this->controller);
        }
		else if($response == 2)
        {
			return Redirect::to("admin/dailycoins")->with('success',trans('adminlabels.dailtcoinupdatesuccess'))->with('controller',$this->controller);
        }
		}
        else
        {   
            return Redirect::to("admin/dailycoins")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id)
    {
        $return = $this->DailycoinsRepository->deleteDailycoin($id);
        if($return)
        {
            return Redirect::to("admin/dailycoins")->with('success', trans('adminlabels.dailycoindeletesuccess'))->with('controller',$this->controller);
        }
        else
        {
            return Redirect::to("admin/dailycoins")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editactive($id)
    {
        $return = $this->DailycoinsRepository->editactiveStatus($id);
        if($return)
        {  
            return Redirect::to("admin/dailycoins")->with('controller',$this->controller);
        }
        else
        {   
            return Redirect::to("admin/dailycoins")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editinactive($id)
    {
        $return = $this->DailycoinsRepository->editinactiveStatus($id);
        if($return)
        {   
            return Redirect::to("admin/dailycoins")->with('controller',$this->controller);
        }
        else
        {  
            return Redirect::to("admin/dailycoins")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
}