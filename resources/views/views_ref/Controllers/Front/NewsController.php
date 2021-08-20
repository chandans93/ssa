<?php
namespace App\Http\Controllers\Front;
use App\FrontUsers;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use App\Services\News\Contracts\NewsRepository;
use App\Services\Newscomment\Contracts\NewscommentRepository;
use App\Http\Requests\NewscommentRequest;





class NewsController extends Controller
{

	public function __construct(NewsRepository $NewsRepository , NewscommentRepository $NewscommentRepository) {
        $this->newsThumbImageUploadPath = Config::get('constant.NEWS_THUMB_UPLOAD_PATH');
        $this->NewsRepository = $NewsRepository;
		$this->NewscommentRepository = $NewscommentRepository;
        $this->controller = 'NewsController';
    }

	public function index()
	{
		 return view('front.News')->with('controller',$this->controller)
		 ->with('filePath',$this->newsThumbImageUploadPath)
		 ->with('newsDetail',$this->NewsRepository->displayDetail());
	}
	public function newsComment($id){
		return view('front.NewsComment')
		->with('newsDetail',$this->NewsRepository->displayNewsDetail($id))
		->with('newsCommentDetail',$this->NewscommentRepository->displayNewsCommentDetail($id));
	}
	public function  newsPostComment(NewscommentRequest $NewscommentRequest){
		$newsComment = [];
        $id=$newsComment['nc_news_id'] = input::get('nc_news_id');
         $newsComment['nc_user_id']=Auth::front()->get()->id;
        $newsComment['nc_comment'] =input::get('nc_comment');
        $newsComment['deleted'] = '1';
        $response = $this->NewscommentRepository->saveComment($newsComment);
       
            if($response == 1)
            {
                return Redirect::to("/news/comment/".$id
                	)->with('success', trans('adminlabels.commentsuccess'))->with('controller',$this->controller);
            }
            
        else {
            return Redirect::to("/news/comment/".$id)->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
		

	}
}