@extends('front.Master')
@section('content')


<div class="news_comment">
   <div class="container">
   <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
     <div class="news_comment_inner">
        <div class="alien_ufo_header">
          <h2>{{$newsDetail->n_title}}</h2>
        </div><!-- alien_ufo_header End -->
        
        
      @if(isset($newsDetail->n_video) && $newsDetail->n_video!='')
        <?php
            $video = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","//www.youtube.com/embed/$1",$newsDetail->n_video);
        ?>
        <div class="news_video">
          <iframe src="{{$video}}"> </iframe>
        </div>
        @endif

        <div class="comment_box clearfix cst_newcomnt">
          <p>{!!$newsDetail->n_description!!}</p>
         
        @if(Auth::front()->check())
          <h2>Comment</h2>
          <form id="newscomment" method="post" action="{{url('/news/postcomment/') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="nc_news_id" value="<?php echo $newsDetail->id;?>">

          <textarea class="form-control comment_text cont_are_box" rows="7"  id="textArea" name="nc_comment"></textarea>
          <button type="submit" class="btn btn-default submit_btn" data-dismiss="modal">Submit<div class="ripple-container"></div></button>
          </form>
          @endif
        </div><!-- comment_box End -->

<div class="view_comment">
        @if(isset($newsCommentDetail)&&!empty($newsCommentDetail))
        <?php $count = sizeof($newsCommentDetail); $temp=0;?>
        @foreach($newsCommentDetail as $key => $newsComment)
          @if (++$temp<= 3)
          <div class="cst_comments cst_newcomnt1">
            <p>{!!$newsComment->nc_comment!!}</p>
            <label>{{$newsComment->username}} {{date('M j Y',strtotime($newsComment->created_at))}}</label>
          </div><!-- cst_comments End -->
          @else
          @if($temp ==4)<div id="moreNews" style="display:none;"> @endif 
          <div class="cst_comments cst_newcomnt1">
            <p>{!!$newsComment->nc_comment!!}</p>
            <label>{{$newsComment->username}} {{date('M j Y',strtotime($newsComment->created_at))}}</label>
          </div><!-- cst_comments End -->
           @if($temp == $count) <a href="javascript:void(0)" onclick="viewMoreNews('moreNews')" class="view_less view_more">View Less....</a> </div> @endif
          @endif
          @endforeach
          @endif
          @if ($count>3)
         <div id="viewMore"> <a href="javascript:void(0)" onclick="viewMoreNews('moreNews')" class="view_more">View More....</a> </div>
           @endif
        </div><!-- view_comment End -->
     </div><!-- news_comment_inner End -->
     <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
   </div><!-- container End -->
 </div><!-- news_comment End -->
@stop

@section('script')
<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
     "<?php echo trans('adminvalidation.requiredfield')?>";
            var adminvalidationRules = {
                nc_comment : {
                    required : true
                },
            }
        $("#newscomment").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                nc_comment : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })

    });

  function viewMoreNews(moreNews) {
       var news = document.getElementById(moreNews);
       if(news.style.display == 'block')
          {news.style.display = 'none';
        viewMore.style.display = 'block';
      }
       else
       {
          news.style.display = 'block';
          viewMore.style.display = 'none';
       }
    }
</script>
@stop