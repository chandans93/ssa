<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\ForumPost;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForumPostRequest;
use App\Services\ForumPost\Contracts\ForumPostRepository;

class ForumPostManagementController extends Controller {

    public function __construct(ForumPostRepository $ForumPostRepository) {
        $this->middleware('auth.admin');
        $this->objforumPost = new ForumPost();
        $this->ForumPostRepository = $ForumPostRepository;
        $this->controller = 'ForumPostManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index($topicid) {

        return view('admin.ListForumPost')->with('topicid',$topicid)->with('controller',$this->controller);
    }

    public function getdata($topicid) {
       $data = $this->ForumPostRepository->getDetail($topicid);
       
        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveforumpost", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveforumpost", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->editColumn('fp_post_reply', '{!! $fp_post_reply !!}')
                        ->add_column('actions', '<a href="{{ route(".data.editforumpost", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                             <a  href="{{ route(".data.deleteforumpost", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

   

    public function edit($id) {
        $forumPostDetail = $this->objforumPost->find($id);
        return view('admin.EditForumPost', compact('forumPostDetail'))->with('controller',$this->controller);
    }

    public function save(ForumPostRequest $ForumPostRequest) {
        $forumPostDetail = [];

        $id=$forumPostDetail['id'] = e(input::get('id'));
        $forumPostDetail['fp_post_reply'] = input::get('fp_post_reply');
        $forumPostDetail['deleted'] = e(input::get('deleted'));
        $response = $this->ForumPostRepository->saveDetail($forumPostDetail);
        $topicid= $this->ForumPostRepository->getForumId($id);
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("/admin/forumpost/".$topicid)->with('success', trans('adminlabels.slideraddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2) {
                return Redirect::to("/admin/forumpost/".$topicid)->with('succe/admin/".$topicid."/forumpostss', trans('adminlabels.sliderupdatesuccess'))->with('controller',$this->controller);
            }
        } else {
            return Redirect::to("/admin/forumpost/".$topicid)->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id) {
        $return = $this->ForumPostRepository->deleteForumPost($id);
        $topicid= $this->ForumPostRepository->getForumId($id);

        if ($return) {
            
            return Redirect::to("/admin/forumpost/".$topicid)->with('success', trans('adminlabels.forumPostdeletesuccess'))->with('controller',$this->controller);
        } else {
            
            return Redirect::to("/admin/forumpost/".$topicid)->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function editactive($id) {
        $return = $this->ForumPostRepository->editactiveStatus($id);
        $topicid= $this->ForumPostRepository->getForumId($id);
        if ($return) {
            
            return Redirect::to("/admin/forumpost/".$topicid)->with('controller',$this->controller);
        } else {

            return Redirect::to("/admin/forumpost/".$topicid)->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function editinactive($id) {
        $return = $this->ForumPostRepository->editinactiveStatus($id);
        $topicid= $this->ForumPostRepository->getForumId($id);

        if ($return) {
            
            return Redirect::to("/admin/forumpost/".$topicid)->with('controller',$this->controller);
        } else {
            
            return Redirect::to("/admin/forumpost/".$topicid)->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }


}
