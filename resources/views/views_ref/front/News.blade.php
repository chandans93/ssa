@extends('front.Master')
@section('content')

	<div class="vw_news">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
     <div class="alien_ufo_header">
       <h2>News</h2>
      </div><!-- alien_ufo_header End -->
      <div class="new_main clearfix">
      @if(isset($newsDetail)&&!empty($newsDetail))
      <?php $count = sizeof($newsDetail); $temp=0;?>
      @foreach($newsDetail as $key => $news)
      <?php $temp++; ?>
        <label><a href="{{url('news/comment/'.$news->id)}}">{{$news->n_title}}</a></label>        
        <div class="news_main_inner clearfix">
          <div class="new_left">
          <div class="news_img">
            <img src="{{ $filePath.$news->n_photo }}" alt="{{$news->n_photo}}" class="img-responsive">
          </div>
          <a href="https://www.facebook.com/share.php?u={{url('news/')}}{{$news->id}}&title={{$news->n_title}}&description={{strip_tags($news->n_description)}}&picture={{ asset($filePath.$news->n_photo) }}" class="btn btn-lg btn-fb waves-effect waves-light fb-share"><i class="fa fa-facebook left"></i> Share<div class="ripple-container"></div></a>
        </div><!-- new_left End -->
        <div class="new_right">
          <div class="news_content"> 
            <label><a href="{{url('news/comment/'.$news->id)}}">{{$news->n_title}}</a></label>        
            <div class="comment more" id="main{{$news->id}}">
              <p>{{ str_limit(strip_tags($news->n_description), $limit = 300, $end = '...') }} </p>
            </div>
              @if(strlen(strip_tags($news->n_description))>300)
            <div id="{{$news->id}}" style="display:none;" class="cst_viewless"> 
                 <div class="comment more">
                  <p>{!!$news->n_description!!} </p>
                </div>
                <a href="javascript:void(0)" onclick="viewMoreNews('{{$news->id}}')" class="view_less view_more">View Less....</a> 
            </div>
            <div id="viewMore{{$news->id}}"> <a href="javascript:void(0)" onclick="viewMoreNews('{{$news->id}}')" class="view_more">View More....</a> 
            </div>
            @endif
          </div><!-- news_content End -->
        </div><!-- new_right End -->
        </div><!-- news_main_inner End -->
         @if($temp=='2')
         </div><!-- new_main End -->
         @if($count>'2')
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div> 
      @endif
      <div class="new_main clearfix">
        @endif
  @endforeach
  @endif
  </div><!-- new_main End -->
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div><!-- vw_advertisement_footer End -->
      <div class="cst_pagination">
            <ul class="pagination pagination-sm">
            {!! $newsDetail->render() !!}
            </ul><!-- End pagination -->
          </div><!-- End cst_pagination -->
    </div><!-- container End -->
  </div><!-- vw_news End -->
@stop

@section('script')
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script>
  function viewMoreNews(moreNewsId) {
       var more = document.getElementById(moreNewsId);
       var less =document.getElementById('viewMore'+moreNewsId);
       var main=document.getElementById('main'+moreNewsId);
       if(more.style.display == 'block'){
          more.style.display = 'none';
          main.style.display = 'block';
          less.style.display = 'block';
       }
       else{
          more.style.display = 'block';
          less.style.display = 'none';
          main.style.display = 'none';
       }
  }
</script>

@stop