<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\CMS;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMSRequest;
use App\Services\CMS\Contracts\CMSRepository;

class CMSManagementController extends Controller {

    public function __construct(CMSRepository $CMSRepository) {
        $this->middleware('auth.admin');
        $this->objCMS = new CMS();
        $this->CMSRepository = $CMSRepository;
        $this->controller = 'CMSManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index() {

        return view('admin.ListCMS')->with('controller',$this->controller);
    }

    public function getdata() {
        $data = CMS::select(['id', 'cms_slug', 'cms_subject', 'deleted'])->whereRaw('deleted IN (1,2)');

        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivecms", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivecms", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.edit", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.delete", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {
        $cmsDetail = [];

        return view('admin.EditCMS', compact('cmsDetail'))->with('controller',$this->controller);
    }

    public function edit($id) {
        $cmsDetail = $this->objCMS->find($id);

        return view('admin.EditCMS', compact('cmsDetail'))->with('controller',$this->controller);
    }

    public function save(CMSRequest $CMSRequest) {
        $cmsDetail = [];

        $cmsDetail['id'] = e(input::get('id'));
        $cmsDetail['cms_subject'] = e(input::get('cms_subject'));
        $cmsDetail['cms_slug'] = e(input::get('cms_slug'));
        $cmsDetail['cms_body'] = input::get('cms_body');
        $cmsDetail['deleted'] = e(input::get('deleted'));

        $response = $this->CMSRepository->saveCMSDetail($cmsDetail);
        if ($response) {

            if($response == 1)
            {
                return Redirect::to("admin/cms")->with('success', trans('adminlabels.cmsaddsuccess'));
            }
            elseif ($response == 2)
            {

                return Redirect::to("admin/cms")->with('success', trans('adminlabels.cmsupdatesuccess'));


        } else {

            return Redirect::to("admin/cms")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }
  }

    public function delete($id) {
        $return = $this->CMSRepository->deleteCMS($id);
        if ($return) {

                return Redirect::to("admin/cms")->with('success', trans('adminlabels.cmsdeletesuccess'));



        } else {

            return Redirect::to("admin/cms")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }

    public function editactive($id) {
        $return = $this->CMSRepository->editactiveStatus($id);
        if ($return) {
            
            return Redirect::to("admin/cms");
        } else {

            return Redirect::to("admin/cms")->with('error', trans('labels.commonerrormessage'));
        }
    }

    public function editinactive($id) {
        $return = $this->CMSRepository->editinactiveStatus($id);
        if ($return) {
            
            return Redirect::to("admin/cms");
        } else {
            
            return Redirect::to("admin/cms")->with('error', trans('labels.commonerrormessage'));
        }
    }

}
