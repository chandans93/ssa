<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\News;
use DB;
use File;
use App\Data\Meta\Models\Video;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Services\News\Contracts\NewsRepository;
use App\Services\Newscomment\Contracts\NewscommentRepository;
use Image;

class NewsManagementController extends Controller {

    public function __construct(NewsRepository $NewsRepository, NewscommentRepository $NewscommentRepository) {
        $this->middleware('auth.admin');
        $this->news = new news();
        $this->NewsRepository = $NewsRepository;
        $this->NewscommentRepository = $NewscommentRepository;
        $this->controller = 'NewsManagementController';
        $this->loggedInUser = Auth::admin()->get();
        $this->newsOriginalImageUploadPath = Config::get('constant.NEWS_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->newsThumbImageUploadPath = Config::get('constant.NEWS_THUMB_UPLOAD_PATH');
        $this->newsAdminImageHeight = Config::get('constant.NEWS_ADMIN_IMAGE_HEIGHT');
        $this->newsAdminImageWidth = Config::get('constant.NEWS_ADMIN_IMAGE_WIDTH');
        $this->newsBigImageHeight = Config::get('constant.NEWS_HOME_IMAGE_HEIGHT');
        $this->newsBigImageWidth = Config::get('constant.NEWS_HOME_IMAGE_WIDTH');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.ListNews')->with('controller', $this->controller);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add() {
        $newsDetail = [];
        return view('admin.EditNews', compact('newsDetail'))->with('controller', $this->controller);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(NewsRequest $NewsRequest) {

    	
        $newsDetail = [];
        $newsDetail['id'] = e(input::get('id'));
        $newsHiddenImage = e(input::get('news_hidden_image'));
        if (isset($newsHiddenImage) && !empty($newsHiddenImage) && $newsHiddenImage != '') {
            $newsDetail['n_photo'] = $newsHiddenImage;
        }
        $newsDetail['n_title'] = e(input::get('n_title'));
//        $video_id = '';
//        if($_POST['n_video']!='')
//    	{
//    		parse_str( parse_url( $_POST['n_video'], PHP_URL_QUERY ), $my_array_of_vars );
//    		$video_id = 'https://www.youtube.com/embed/'.$my_array_of_vars['v'].'?autoplay=1&enablejsapi=1';
//    	}  
        $newsDetail['n_video'] = e(input::get('n_video'));
        $newsDetail['n_description'] = input::get('n_description');
        $newsDetail['deleted'] = e(input::get('deleted'));
        if (Input::file()) {
            $file = Input::file('n_photo');
            if (!empty($file)) {

                if (isset($newsDetail['id']) && $newsDetail['id'] > 0) {
                    $newsImage = $this->news->find($newsDetail['id']);
                    if (isset($newsImage->n_photo) && $newsImage->n_photo != '') {
                        unlink($this->newsOriginalImageUploadPath . $newsImage->n_photo);
                        unlink($this->newsThumbImageUploadPath . $newsImage->n_photo);
                    }
                }
                $fileName = 'news_' . time() . '.' . $file->getClientOriginalExtension();
                $pathOriginal = public_path($this->newsOriginalImageUploadPath . $fileName);
                $pathThumb = public_path($this->newsThumbImageUploadPath . $fileName);
                Image::make($file->getRealPath())->save($pathOriginal);
                Image::make($file->getRealPath())->resize($this->newsAdminImageWidth, $this->newsAdminImageHeight)->save($pathThumb);
                $newsDetail['n_photo'] = $fileName;
            }
        }
        $response = $this->NewsRepository->saveNewsDetail($newsDetail);
        if ($response) {
            if ($response == 1) {
                return Redirect::to("admin/news")->with('success', trans('adminlabels.newsaddsuccess'));
            } elseif ($response == 2) {
                return Redirect::to("admin/news")->with('success', trans('adminlabels.newsupdatesuccess'));
            }
        } else {
            return Redirect::to("admin/news")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getdata() {
        $data = $this->NewsRepository->getDetail();
        $newscommentCount = '0';
        foreach ($data as $key => $val) {
            $val['comentcount'] = '0';
            if (isset($val['id']) && $val['id'] > '0') {
                $topicId['0'] = $val['id'];
                $newscommentCount = $this->NewscommentRepository->getnewscommentCount($topicId);
            }
            $val['comentcount'] = $newscommentCount;        }
        return Datatables::of($data)
                        ->add_column('View_Post', '<a href="{{ route(".admin.newscomment", $id) }}">{{$comentcount}}</a>')
                        
						 ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactivenews", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactivenews", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
						
                        ->editColumn('n_photo', '@if(File::exists(public_path("upload/news/thumb/".$n_photo)) && $n_photo != NULL) <img src="{{ asset("upload/news/thumb/".$n_photo) }}" height="{{ Config::get("constant.NEWS_ADMIN_LIST_IMAGE_HEIGHT") }}" width="{{ Config::get("constant.NEWS_ADMIN_LIST_IMAGE_WIDTH") }}" alt="" />

                        @else
                        <img src="{{ asset("/backend/images/avatar5.png")}}" class="user-image" height="{{ Config::get("constant.NEWS_ADMIN_LIST_IMAGE_HEIGHT") }}" width="{{ Config::get("constant.NEWS_ADMIN_LIST_IMAGE_WIDTH") }}" alt="">
                            @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editnews", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
						<a  href="{{ route(".data.deletenews", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }

    public function edit($id) {
        $newsDetail = $this->news->find($id);
        return view('admin.EditNews')->with('newsDetail', $newsDetail)->with('ThumbPath', $this->newsThumbImageUploadPath)->with('controller', $this->controller);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id) {
        $newsDetail = $this->news->find($id);
        $return = $this->NewsRepository->deleteNews($id, $newsDetail);
        if ($return) {
            return Redirect::to("admin/news")->with('success', trans('adminlabels.newsdeletesuccess'))->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/news")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editactive($id) {
        $return = $this->NewsRepository->editactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/news")->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/news")->with('error', trans('labels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

    public function editinactive($id) {
        $return = $this->NewsRepository->editinactiveStatus($id);
        if ($return) {
            return Redirect::to("admin/news")->with('controller', $this->controller);
        } else {
            return Redirect::to("admin/news")->with('error', trans('labels.commonerrormessage'))->with('controller', $this->controller);
        }
    }
}
