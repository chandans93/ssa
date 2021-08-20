<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\Game;
use App\Order;
use DB;
use Datatables;
use File;
use Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Services\Game\Contracts\GameRepository;
use App\Services\GameCategory\Contracts\GameCategoryRepository;

class GameManagementController extends Controller {

    public function __construct(GameRepository $GameRepository, GameCategoryRepository $GameCategoryRepository) {
        $this->middleware('auth.admin');
        $this->objGame = new Game();
        $this->GameRepository = $GameRepository;
        $this->GameCategoryRepository = $GameCategoryRepository;
        $this->controller = 'GameManagementController';
        $this->loggedInUser = Auth::admin()->get();
        $this->gameOriginalImageUploadPath = Config::get('constant.GAME_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->gameThumbImageUploadPath = Config::get('constant.GAME_THUMB_IMAGE_UPLOAD_PATH');
        $this->gameThumbImageHeight = Config::get('constant.GAME_THUMB_IMAGE_HEIGHT');
        $this->gameThumbImageWidth = Config::get('constant.GAME_THUMB_IMAGE_WIDTH');
        $this->gameThumb_135_197_ImageUploadPath = Config::get('constant.GAME_THUMB_135_197_IMAGE_UPLOAD_PATH');
        $this->gameThumb_135_197_ImageHeight = Config::get('constant.GAME_THUMB_135_197_IMAGE_HEIGHT');
        $this->gameThumb_135_197_ImageWidth = Config::get('constant.GAME_THUMB_135_197_IMAGE_WIDTH');        
        $this->gameThumb_270_212_ImageUploadPath = Config::get('constant.GAME_THUMB_270_212_IMAGE_UPLOAD_PATH');
        $this->gameThumb_270_212_ImageHeight = Config::get('constant.GAME_THUMB_270_212_IMAGE_HEIGHT');
        $this->gameThumb_270_212_ImageWidth = Config::get('constant.GAME_THUMB_270_212_IMAGE_WIDTH');
        
    }

    public function index() {

        return view('admin.ListGame')->with('controller', $this->controller);
    }

    public function getdata() {
        $data = $this->GameRepository->getDetail();

        foreach ($data as $key => $val) {
            if (isset($val['g_category_id']) && $val['g_category_id'] > '0') {
                $Categoryid = $val['g_category_id'];
                $val['g_category_id'] = $g_category_id = $this->GameCategoryRepository->getparentname($Categoryid);
            }
        }

        return Datatables::of($data)
                        ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivegame", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivegame", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
                        ->editColumn('g_category_id', '@if ($g_category_id == 0) <span style="text-align: center;display: block; padding-right:50%;">{{$g_category_id}}</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">-</span> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editgame", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deletegame", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function add() {

        $gameDetail = [];
        $uploadGameImagePath = $this->gameThumbImageUploadPath;
        return view('admin.EditGames', compact('gameDetail', 'uploadGameImagePath'))->with('controller', $this->controller);
    }

    public function edit($id) {

        $gameDetail = $this->objGame->find($id);
        $uploadGameImagePath = $this->gameThumbImageUploadPath;
        return view('admin.EditGames', compact('gameDetail', 'uploadGameImagePath'))->with('controller', $this->controller);
    }

    public function save(GameRequest $GameRequest) {

        $gameDetail = [];
        $gameDetail['id'] = e(Input::get('id'));
        $gameDetail['g_title'] = e(Input::get('g_title'));
        $gameDetail['g_coin'] = e(Input::get('g_coin'));
        $hiddenProfile = e(Input::get('hidden_profile'));
        $productDetail['g_photo'] = $hiddenProfile;
        $gameDetail['g_category_id'] = e(Input::get('g_category_id'));
        $gameDetail['g_subcategory_id'] = e(Input::get('g_subcategory_id'));
        $gameDetail['g_description'] = (Input::get('g_description'));
        $gameDetail['g_embedded_script'] = (Input::get('g_embedded_script'));
        $gameDetail['deleted'] = e(Input::get('deleted'));

        if (Input::file()) {
            $file = Input::file('g_photo');

            if (isset($file) && !empty($file)) {
                $fileName = 'game_' . time() . '.' . $file->getClientOriginalExtension();
                $pathOriginal = public_path($this->gameOriginalImageUploadPath . $fileName);
                $pathThumb= public_path($this->gameThumbImageUploadPath . $fileName);
                $pathThumb_135_197= public_path($this->gameThumb_135_197_ImageUploadPath . $fileName);
                $pathThumb_270_212= public_path($this->gameThumb_270_212_ImageUploadPath . $fileName);
                
                Image::make($file->getRealPath())->save($pathOriginal);
                Image::make($file->getRealPath())->resize($this->gameThumbImageWidth, $this->gameThumbImageHeight)->save($pathThumb);
                Image::make($file->getRealPath())->resize($this->gameThumb_135_197_ImageWidth, $this->gameThumb_135_197_ImageHeight)->save($pathThumb_135_197);
                Image::make($file->getRealPath())->resize($this->gameThumb_270_212_ImageWidth, $this->gameThumb_270_212_ImageHeight)->save($pathThumb_270_212);
               
                if ($hiddenProfile != '') {
                    $imageOriginal = public_path($this->gameOriginalImageUploadPath . $hiddenProfile);
                    $imageThumb= public_path($this->gameThumbImageUploadPath . $hiddenProfile);
                    $imageThumb_135_197= public_path($this->gameThumb_135_197_ImageUploadPath . $hiddenProfile);
                    $imageThumb_270_212= public_path($this->gameThumb_270_212_ImageUploadPath . $hiddenProfile);
                    File::delete($imageOriginal, $imageThumb,$imageThumb_135_197,$imageThumb_270_212);
                    
                }
           
                
                $gameDetail['g_photo'] = $fileName;
                }
            
        }

        

        $response = $this->GameRepository->saveGameDetail($gameDetail);

        if ($response['flag'] == 2) {
            return Redirect::to("admin/game")->with('success', trans('adminlabels.gameupdatesuccess'))->with('controller', $this->controller);
        }
        if ($response['flag'] == 1) {

            return Redirect::to("admin/game")->with('success', trans('adminlabels.gameaddsuccess'))->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/game")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function delete($id) {
        $return = $this->GameRepository->deleteGame($id);
        if ($return) {

            return Redirect::to("admin/game")->with('success', trans('adminlabels.gamedeletesuccess'))->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/game")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editactive($id) {

        $return = $this->GameRepository->editactiveStatus($id);
        if ($return) {

            return Redirect::to("admin/game")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/game")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editinactive($id) {

        $return = $this->GameRepository->editinactiveStatus($id);
        if ($return) {

            return Redirect::to("admin/game")->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/game")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function getSubCategory($id) {
        $subCategory = $this->GameCategoryRepository->getsubCategoryById($id);
        return json_encode($subCategory);
    }

}
