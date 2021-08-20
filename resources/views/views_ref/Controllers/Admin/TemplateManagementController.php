<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\Templates;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Services\Template\Contracts\TemplatesRepository;

class TemplateManagementController extends Controller
{
    public function __construct(TemplatesRepository $TemplatesRepository)
    {
        $this->middleware('auth.admin');
        $this->objTemplate                = new Templates();
        $this->TemplatesRepository         = $TemplatesRepository;
        $this->controller = 'TemplateManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {
       return view('admin.ListEmailTemplate')->with('controller',$this->controller);
    }
    
    public function  getdata()
    {    
        
        $data = Templates::select(['id', 'et_templatename','et_templatepseudoname','et_subject','deleted'])->whereRaw('deleted IN (1,2)');
       
        return Datatables::of($data)
                ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivetemplete", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivetemplete", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')                                                                                                                             
                 ->add_column('actions', '<a href="{{ route(".data.edittemplete", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deletetemplete", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        
                   ->make(true);
                  
    }

    public function add()
    {
        $templateDetail =[];

        return view('admin.EditTemplate', compact('templateDetail'))->with('controller',$this->controller);
    }

    public function edit($id)
    {
        $templateDetail = $this->objTemplate->find($id);

        return view('admin.EditTemplate', compact('templateDetail'))->with('controller',$this->controller);
    }

    public function save(TemplateRequest $TemplateRequest)
    {
        $templateDetail = [];

        $templateDetail['id']  = e(input::get('id'));
        $templateDetail['et_templatename']   = e(input::get('et_templatename'));
        $templateDetail['et_templatepseudoname']   = e(input::get('et_templatepseudoname'));
        $templateDetail['et_subject']  = e(input::get('et_subject'));
        $templateDetail['et_body']  = input::get('et_body');
        $templateDetail['deleted']  = e(input::get('deleted'));

        $response = $this->TemplatesRepository->saveTemplateDetail($templateDetail);
        if($response)
        {
            if($response == 1)
            {
                return Redirect::to("admin/templates")->with('success', trans('adminlabels.templateaddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2)
            {

                return Redirect::to("admin/templates")->with('success', trans('adminlabels.templateupdatesuccess'))->with('controller',$this->controller);

            }
        }
        else
        {
            return Redirect::to("admin/templates")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    public function delete($id)
    {
        $return = $this->TemplatesRepository->deleteTemplate($id);
        if($return)
        {

            return Redirect::to("admin/templates")->with('success', trans('adminlabels.templatedeletesuccess'))->with('controller',$this->controller);
        }
        else
        {
            return Redirect::to("admin/templates")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editactive($id)
    {
        $return = $this->TemplatesRepository->editactiveStatus($id);
        if($return)
        {
            return Redirect::to("admin/templates")->with('controller',$this->controller);
        }
        else
        {

            return Redirect::to("admin/templates")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editinactive($id)
    {
        $return = $this->TemplatesRepository->editinactiveStatus($id);
        if($return)
        {
            return Redirect::to("admin/templates")->with('controller',$this->controller);
        }
        else
        {
            return Redirect::to("admin/templates")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    

}