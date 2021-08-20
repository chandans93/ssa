<?php
namespace App\Http\Controllers\Front;
use App\FrontUsers;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;
use App\Services\ForumCategory\Contracts\ForumCategoryRepository;
use App\Services\Forum\Contracts\ForumRepository;
use App\Services\ForumPost\Contracts\ForumPostRepository;



class ForumController extends Controller
{

	public function __construct(ForumCategoryRepository $Forum_categoryRepository,ForumRepository $ForumRepository,ForumPostRepository $ForumPostRepository) {
        $this->ForumCategoryRepository = $Forum_categoryRepository;
        $this->ForumRepository = $ForumRepository;
        $this->ForumPostRepository = $ForumPostRepository;
        $this->controller = 'ForumController';
        $this->avatarOriginalImageUploadPath = Config::get('constant.AVATAR_ORIGINAL_IMAGE_UPLOAD_PATH');              

    }

	public function index()
	{

		$detail=$this->ForumCategoryRepository->findForumCategoryDetail();
		$data = array();
		$postCount='0';
		$lastpostid='0';
		
		if (isset($detail) && !empty($detail)) {
			foreach ($detail as $key=>$val){
				$value = $topicId = array();
				$value['TopicCount']='0';
				$value['fc_name']=$val['fc_name'];
				$value['id']=$categoryId = $val['id'];
				$topicsId=$this->ForumRepository->getTopicsid($categoryId);
				$topicCount = isset($topicsId)?count($topicsId):0;
				$value['TopicCount']= $topicCount;
				//echo "<pre>";print_r($topicsId);
				if (isset($topicsId) && !empty($topicsId)) {
					foreach ($topicsId as $key1=>$topicdetail) {
						$topicId[]=$topicdetail['id'];						
					}
				$postCount =$this->ForumPostRepository->getpostCount($topicId);
				$lastpostid=$this->ForumPostRepository->getlastpostid($topicId);
				}
				$value['post']='';
				$value['username']='';
				$value['post_time']='';
				
				if($lastpostid>'0'){
					$lastpost= $this->ForumPostRepository-> getLastPostFront($lastpostid);
	    			if (isset($lastpost) && !empty($lastpost)) {
							$value['post']=$lastpost['fp_post_reply'];
							$value['username']=$lastpost['fu_user_name'];
							$value['post_time']=$lastpost['created_at'];
						
					}
				}

				$value['postCount']=$postCount;
				$data[] = $value;
			}
		} 
		
        return view('front.Forum')->with('data',$data)->with('controller',$this->controller);
	}
	 public function categoryDetail($id){

	 	$detail=$this->ForumRepository->findForumTopicsDetail($id);
		$data = array();
		$postCount='0';
		$lastpostid='0';
		if (isset($detail) && !empty($detail)) {
			foreach ($detail as $key=>$val){
				$value = array();
				$value['topic']=$val['f_forum_topic'];
				$value['date']=$val['created_at'];
				$value['topicid']=$val['id'];
				
				if (isset($val['id']) && $val['id']>'0') {
					$topicId['0']=$val['id'];	
					$postCount =$this->ForumPostRepository->getpostCount($topicId);
					$lastpostid=$this->ForumPostRepository->getlastpostid($topicId);
				}
				$value['post']='';
				$value['username']='';
				$value['post_time']='';

				if($lastpostid>'0'){
					$lastpost= $this->ForumPostRepository-> getLastPostFront($lastpostid);
	    			if (isset($lastpost) && !empty($lastpost)) {
							$value['post']=$lastpost['fp_post_reply'];
							$value['username']=$lastpost['fu_user_name'];
							$value['post_time']=$lastpost['created_at'];
					}
				}
				$value['postCount']=$postCount;
				$data[] = $value;
			}
		}
	 	 return view('front.ForumCategory')->with('data',$data)->with('controller',$this->controller);
		
	 }
	 public function comment($id){
	 	$detail=$this->ForumRepository->forumDetail($id);
	 	$data = array();
	 	$post=array();
	 	$reply=array();
		$postCount='0';
		if (isset($detail) && !empty($detail)) {
			if (isset($detail['id']) && $detail['id']>'0') {
				$topicId['0']=$detail['id'];
				$postCount =$this->ForumPostRepository->getpostCount($topicId);
				$post=$this->ForumPostRepository->getAllPost($topicId);
			}
		}
		$detail['postCount']=$postCount;
		if (isset($post) && !empty($post)) {
			foreach ($post as $key2=>$postreply){
				$val=array();
						$val['reply']=$postreply['fp_post_reply'];
						$val['username']=$postreply['username'];
						$val['post_time']=$postreply['created_at'];
						$val['fu_avatar']=$postreply['fu_avatar'];
				$val['id']=$id=$postreply['id'];
				$parentdetail= $this->ForumPostRepository-> getsubdetail($id);
				foreach ($parentdetail as $key3=>$postcomment){
					if (isset($postcomment) && !empty($postcomment)){
						$subPost['username']=$postcomment['username'];
						$subPost['reply']=$postcomment['fp_post_reply'];
						$subPost['fu_avatar']=$postcomment['fu_avatar'];
						$subPost['post_time']=$postcomment['created_at'];
						$val['subpost'][] = $subPost;
					}
				}
				$reply[]=$val;
			}
		}
	 	return view('front.ForumComment')->with('topic',$detail)->with('reply',$reply)->with('avatarPath', $this->avatarOriginalImageUploadPath);
	}
	public function saveComment(){
		
        $forumComment = [];
        $forumComment['fp_post_reply'] = input::get('fp_post_reply');
        $forumComment['fp_parent_id'] = e(input::get('fp_parent_id'));
        $forumComment['fp_forum_id'] = e(input::get('fp_forum_id'));
        $forumComment['fp_user_id'] = Auth::front()->get()->id;
        $forumComment['deleted'] = '1';
        $response = $this->ForumPostRepository->saveComment($forumComment);
       
            if($response == 1)
            {
                return Redirect::to("/forum/category/topic/".$forumComment['fp_forum_id'])->with('success', trans('adminlabels.commentsuccess'))->with('controller',$this->controller);
            }
            
        else {
            return Redirect::to("/forum/category/topic/".$forumComment['fp_forum_id'])->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
		
	}
		 

}

                     
