<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\Newscomment;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewscommentRequest;
use App\Services\Newscomment\Contracts\NewscommentRepository;

class NewscommentManagementController extends Controller
{
    public function __construct(NewscommentRepository $NewscommentRepository)
    {
        $this->middleware('auth.admin');
        $this->objNewscomment                = new Newscomment();
        $this->NewscommentRepository         = $NewscommentRepository;
        $this->controller = 'NewscommentManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index($topicid)
    {
		$newscomment = $this->NewscommentRepository->getAllNewscomment();
        return view('admin.ListNewscomment',compact('newscomment'))->with('topicid',$topicid)->with('controller',$this->controller);
    }
     public function add()
    {
        $newscommentDetail =[];
        return view('admin.EditNewscomment', compact('newscommentDetail'))->with('controller',$this->controller);
    }

    public function  getdata($topicid)
    {    
        $data = $this->NewscommentRepository->getDetail($topicid);
        return Datatables::of($data)
                ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivenewscomment", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivenewscomment", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                ->add_column('actions', '<a href="{{ route(".data.editnewscomment", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                <a  href="{{ route(".data.deletenewscomment", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                ->make(true);
    }

    public function edit($id)
    {
        $newscommentDetail = $this->objNewscomment->find($id);
        return view('admin.EditNewscomment', compact('newscommentDetail'))->with('controller',$this->controller);
    }

    public function save(NewscommentRequest $NewscommentRequest)
    {   
		$newscommentDetail = [];
        $id = $newscommentDetail['id']  = e(input::get('id'));
		$newscommentDetail['nc_comment']   = input::get('nc_comment');
        $newscommentDetail['deleted']  = e(input::get('deleted'));
        $response = $this->NewscommentRepository->saveNewscommentDetail($newscommentDetail);
		$topicid= $this->NewscommentRepository->getNewscommentId($id);
        return Redirect::to("admin/".$topicid."/newscomment")->with('success',trans('adminlabels.newscommentupdatesuccess'))->with('controller',$this->controller);
    }

    public function delete($id)
    {
        $return = $this->NewscommentRepository->deleteNewscomment($id);
		$topicid= $this->NewscommentRepository->getNewscommentId($id);
        if($return)
        {
            return Redirect::to("admin/".$topicid."/newscomment")->with('success', trans('adminlabels.newscommentdeletesuccess'))->with('controller',$this->controller);
        }
        else
        {
            return Redirect::to("admin/".$topicid."/newscomment")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editactive($id)
    {
        $return = $this->NewscommentRepository->editactiveStatus($id);
		$topicid= $this->NewscommentRepository->getNewscommentId($id);
        if($return)
        {  
            return Redirect::to("admin/".$topicid."/newscomment")->with('controller',$this->controller);
        }
        else
        {   
            return Redirect::to("admin/".$topicid."/newscomment")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editinactive($id)
    {
        $return = $this->NewscommentRepository->editinactiveStatus($id);
		$topicid= $this->NewscommentRepository->getNewscommentId($id);
        if($return)
        {   
            return Redirect::to("admin/".$topicid."/newscomment")->with('controller',$this->controller);
        }
        else
        {  
            return Redirect::to("admin/".$topicid."/newscomment")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
}