<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\ForumCategory;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForumCategoryRequest;
use App\Services\ForumCategory\Contracts\ForumCategoryRepository;

class ForumCategoryManagementController extends Controller {

    public function __construct(ForumCategoryRepository $ForumCategoryRepository) {
        $this->middleware('auth.admin');
        $this->objforum_category = new ForumCategory();
        $this->ForumCategoryRepository = $ForumCategoryRepository;
        $this->controller = 'ForumCategoryManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index() {

        return view('admin.ListForumCategory')->with('controller',$this->controller);
    }

    public function getdata() {
        $data = ForumCategory::select(['id','fc_name', 'deleted'])->whereRaw('deleted IN (1,2)');

        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveforumcategory", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveforumcategory", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editforumcategory", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                             <a  href="{{ route(".data.deleteforumcategory", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {
        $forum_categoryDetail = [];

        return view('admin.EditForumCategory', compact('forum_categoryDetail'))->with('controller',$this->controller);
    }

    public function edit($id) {
        $forum_categoryDetail = $this->objforum_category->find($id);

        return view('admin.EditForumCategory', compact('forum_categoryDetail'))->with('controller',$this->controller);
    }

    public function save(ForumCategoryRequest $ForumCategoryRequest) {
        $forum_categoryDetail = [];
        $forum_categoryDetail['id'] = e(input::get('id'));
        $forum_categoryDetail['fc_name'] = e(input::get('fc_name'));
        $forum_categoryDetail['deleted'] = e(input::get('deleted'));
        $response = $this->ForumCategoryRepository->saveDetail($forum_categoryDetail);
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("admin/forumcategory")->with('success', trans('adminlabels.forumcataddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2) {
                return Redirect::to("admin/forumcategory")->with('success', trans('adminlabels.forumcatupdatesuccess'))->with('controller',$this->controller);
            }
        } else {
            return Redirect::to("admin/forumcategory")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id) {
        $return = $this->ForumCategoryRepository->deleteForumCategory($id);
        if ($return) {
            
            return Redirect::to("admin/forumcategory")->with('success', trans('adminlabels.forum_categorydeletesuccess'))->with('controller',$this->controller);
        } else {
            
            return Redirect::to("admin/forumcategory")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    public function editactive($id) {
        $return = $this->ForumCategoryRepository->editactiveStatus($id);
        if ($return) {
            
            return Redirect::to("admin/forumcategory")->with('controller',$this->controller);
        } else {

            return Redirect::to("admin/forumategory")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function editinactive($id) {
        $return = $this->ForumCategoryRepository->editinactiveStatus($id);
        if ($return) {
            
            return Redirect::to("admin/forumcategory")->with('controller',$this->controller);
        } else {
            
            return Redirect::to("admin/forumcategory")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }

    }
}
