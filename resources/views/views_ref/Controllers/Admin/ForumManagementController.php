<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\Forum;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForumRequest;
use App\Services\Forum\Contracts\ForumRepository;
use App\Services\ForumPost\Contracts\ForumPostRepository;


class ForumManagementController extends Controller {

    public function __construct(ForumRepository $ForumRepository, ForumPostRepository $ForumPostRepository) {
        $this->middleware('auth.admin');
        $this->objforum = new Forum();
        $this->ForumRepository = $ForumRepository;
        $this->ForumPostRepository = $ForumPostRepository;
        $this->controller = 'ForumManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index() {

        return view('admin.ListForum')->with('controller',$this->controller);
    }
    public function getdata() {
        $data = $this->ForumRepository->getDetail();
        $postCount='0';
        foreach ($data as $key => $val) {
            $val['comentcount']='0';
            if (isset($val['id']) && $val['id']>'0') {
                   $topicId['0']=$val['id'];
                     $postCount =$this->ForumPostRepository->getpostCount($topicId);
                }
                $val['comentcount']=$postCount;
        }
         return Datatables::of($data)
                        ->add_column('View_Post', '<a href="{{ route(".admin.forumpost", $id) }}">{{$comentcount}}</a>'
                             )
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveforum", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveforum", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editforum", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                             <a  href="{{ route(".data.deleteforum", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        
                        ->make(true);
    }

     public function add() {
        $forumDetail = [];

        return view('admin.EditForum', compact('forumDetail'))->with('controller',$this->controller);
    }

    public function edit($id) {
        $forumDetail = $this->objforum->find($id);

        return view('admin.EditForum', compact('forumDetail'))->with('controller',$this->controller);
    }

    public function save(ForumRequest $ForumRequest) {
        $forumDetail = [];

        $forumDetail['id'] = e(input::get('id'));
        $forumDetail['f_forum_topic'] = e(input::get('f_forum_topic'));
        $forumDetail['f_description'] = input::get('f_description');
        $forumDetail['f_category_id'] = e(input::get('f_category_id'));
        $forumDetail['deleted'] = e(input::get('deleted'));
        $response = $this->ForumRepository->saveDetail($forumDetail);
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("admin/forum")->with('success', trans('adminlabels.forumaddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2) {
                return Redirect::to("admin/forum")->with('success', trans('adminlabels.forumupdatesuccess'))->with('controller',$this->controller);
            }
        } else {
            return Redirect::to("admin/forum")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id) {
        $return = $this->ForumRepository->deleteForum($id);
        if ($return) {
            
            return Redirect::to("admin/forum")->with('success', trans('adminlabels.forumdeletesuccess'))->with('controller',$this->controller);
        } else {
            
            return Redirect::to("admin/forum")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function editactive($id) {
        $return = $this->ForumRepository->editactiveStatus($id);
        if ($return) {
            
            return Redirect::to("admin/forum");
        } else {

            return Redirect::to("admin/forum")->with('error', trans('labels.commonerrormessage'));
        }
    }

    public function editinactive($id) {
        $return = $this->ForumRepository->editinactiveStatus($id);
        if ($return) {
            
            return Redirect::to("admin/forum")->with('controller',$this->controller);
        } else {
            
            return Redirect::to("admin/forum")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }


}
