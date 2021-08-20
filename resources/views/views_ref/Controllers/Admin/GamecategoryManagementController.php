<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\GameCategory;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameCategoryRequest;
use App\Services\GameCategory\Contracts\GameCategoryRepository;

class GamecategoryManagementController extends Controller {

    public function __construct(GameCategoryRepository $GameCategoryRepository) {
        $this->middleware('auth.admin');
        $this->objgamecategory = new GameCategory();
        $this->GameCategoryRepository = $GameCategoryRepository; 
        $this->controller = 'GamecategoryManagementController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index() {
        return view('admin.ListGamecategory')->with('controller', $this->controller);
    }

    public function getdata() {
        $data = $this->GameCategoryRepository->getDetail();
        foreach ($data as $key => $val) {
            $Parentid = '0';
            if (isset($val['gc_parent_id']) && $val['gc_parent_id'] > '0') {
                $Parentid = $val['gc_parent_id'];
                $val['Parentname'] = $Parentname = $this->GameCategoryRepository->getparentname($Parentid);
            }
        }
        return Datatables::of($data)
                        ->editColumn('Parentname', '@if ($gc_parent_id == 0) <span style="text-align: center;display: block; padding-right:50%;">-</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">{{$Parentname}}</span> @endif')
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivegamecategory", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivegamecategory", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editgamecategory", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                        <a  href="{{ route(".data.deletegamecategory", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {
        $gamecategoryDetail = [];
        return view('admin.EditGamecategory', compact('gamecategoryDetail'))->with('controller', $this->controller);
    }

    public function edit($id) {
        $gamecategoryDetail = $this->objgamecategory->find($id);
        return view('admin.EditGamecategory', compact('gamecategoryDetail'))->with('controller', $this->controller);
    }

    public function save(GameCategoryRequest $GameCategoryRequest) {
        $gamecategoryDetail = [];
        $gamecategoryDetail['id'] = e(input::get('id'));
        $gamecategoryDetail['gc_title'] = e(input::get('gc_title'));
        $gamecategoryDetail['gc_parent_id'] = e(input::get('gc_parent_id'));
        $gamecategoryDetail['deleted'] = e(input::get('deleted'));
        $response = $this->GameCategoryRepository->saveDetail($gamecategoryDetail);

        if ($response) {
            if ($response == 1) {
                return Redirect::to("admin/gamecategory")->with('success', trans('adminlabels.gamecategoryaddsuccess'))->with('controller', $this->controller);
            } elseif ($response == 2) {
                return Redirect::to("admin/gamecategory")->with('success', trans('adminlabels.gamecategoryupdatesuccess'))->with('controller', $this->controller);
            }
        } else {
            return Redirect::to("admin/gamecategory")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function delete($id) {
        $return = $this->GameCategoryRepository->deleteGameCategory($id);
        if ($return) {
            return Redirect::to("admin/gamecategory")->with('success', trans('adminlabels.gamecategorydeletesuccess'))->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/gamecategory")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editactive($id) {
        $return = $this->GameCategoryRepository->editactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/gamecategory")->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/gamecategory")->with('error', trans('labels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editinactive($id) {
        $return = $this->GameCategoryRepository->editinactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/gamecategory")->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/gamecategory")->with('error', trans('labels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

}
