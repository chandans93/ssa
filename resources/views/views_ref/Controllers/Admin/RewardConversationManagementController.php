<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\RewardConversation;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\RewardConversationRequest;
use App\Services\RewardConversation\Contracts\RewardConversationRepository;

class RewardConversationManagementController extends Controller {

    public function __construct(RewardConversationRepository $RewardConversationRepository) {
        $this->middleware('auth.admin');
        $this->objRewardConversation = new RewardConversation();
        $this->RewardConversationRepository = $RewardConversationRepository;
        $this->controller = 'RewardConversationManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index() {

        return view('admin.ListRewardConversation')->with('controller',$this->controller);
    }

    public function getdata() {
        $data = RewardConversation::select(['id', 'vrc_reward_point','vrc_voucher', 'deleted'])->whereRaw('deleted IN (1,2)');

        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiverewardconversation", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiverewardconversation", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editrewardconversation", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deleterewardconversation", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {
        $rcDetail = [];
        return view('admin.EditRewardConversation', compact('rcDetail'))->with('controller',$this->controller);
    }

    public function edit($id) {
        $rcDetail = $this->objRewardConversation->find($id);
        return view('admin.EditRewardConversation', compact('rcDetail'))->with('controller',$this->controller);
    }

    public function save(RewardConversationRequest $RewardConversationRequest) {
        $rcDetail = [];

        $rcDetail['id'] = e(input::get('id'));
        $rcDetail['vrc_voucher'] = e(input::get('vrc_voucher'));
        $rcDetail['vrc_reward_point'] = e(input::get('vrc_reward_point'));
        $rcDetail['deleted'] = e(input::get('deleted'));

        $response = $this->RewardConversationRepository->saveRewardConversationDetail($rcDetail);
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("admin/rewardconversation")->with('success', trans('adminlabels.rcaddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2) {
                return Redirect::to("admin/rewardconversation")->with('success', trans('adminlabels.rcupdatesuccess'))->with('controller',$this->controller);
            }
        } else {
            return Redirect::to("admin/rewardconversation")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id) {
        $return = $this->RewardConversationRepository->deleteRewardConversation($id);
        if ($return) {
            return Redirect::to("admin/rewardconversation")->with('success', trans('adminlabels.rcdeletesuccess'))->with('controller',$this->controller);
        } else {
            return Redirect::to("admin/rewardconversation")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function editactive($id) {
        $return = $this->RewardConversationRepository->editactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/rewardconversation")->with('controller',$this->controller);
        } else {
            return Redirect::to("admin/rewardconversation")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function editinactive($id) {
        $return = $this->RewardConversationRepository->editinactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/rewardconversation")->with('controller',$this->controller);
        } else {
            return Redirect::to("admin/rewardconversation")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

}
