@extends('front.Master')
@section('content')
 <div class="cst_welcome">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
      <div class="alien_ufo_header">
        @if ($message = Session::get('success'))
          <div class="row">
              <div class="col-md-12">
                  <div class="box-body">
                      <div class="alert alert-success alert-dismissable">
                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
                          <h4><i class="icon fa fa-check"></i> {{trans('validation.successlbl')}}</h4>
                          {{ $message }}
                      </div>
                  </div>
              </div>
          </div>
          @endif
        <h2>{!!$topic['f_forum_topic']!!}</h2>
      </div>
      <div class="cst_welcome_inner">
        <div class="row">
          <div class="col-md-7 col-sm-7 col-xs-12">
            <div class="cst_welcome_content">

              <h3>{!!$topic['f_forum_topic']!!}</h3>
              <p>{!!$topic['f_description']!!}</p>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="welcome_post">
              <h3>Client wise</h3>
              <h3>Site wise</h3>
              <div class="cst_post_detail">Post : <span>{{$topic['postCount']}}</span></div>
              <div class="cst_post_detail">Date : <span>{{date('F j Y',strtotime($topic['created_at']))}}</span></div>
            </div>
          </div>
        </div><!-- row End -->
      </div><!-- cst_welcome_inner End -->
      <div class="post_reply">
        <div class="alien_ufo_header">
          <h2>Post reply</h2>
        </div><!-- alien_ufo_header End -->
        
          @foreach ($reply as $key=>$postreply) 
        <div class="cst_post_reply">
          <div class="main_post clearfix">
            <div class="main_post_left">
              @if(!isset($postreply['fu_avatar'])||$postreply['fu_avatar']=='')
              <?php $postreply['fu_avatar']='ava20.jpg';?>
              @endif
              <img src="{{ asset($avatarPath.$postreply['fu_avatar']) }}" alt="alien_galley_info1" class="img-responsive">
            </div><!-- main_post_left End -->
            
            <div class="main_post_right">
              <h4>{{$postreply['username']}}</h4>
              <p>{!!$postreply['reply']!!}</p>
              <label> {{Helpers::humanTime(strtotime($postreply['post_time']))}}</label>
              @if (Auth::front()->check())
              <?php $fp_user_id= Auth::front()->get()->id; ?>
              <button type="button" id="displayform" onclick="ShowSubPostForm({{$postreply['id']}},{{$topic['id']}})" class="btn btn-lg btn-fb waves-effect waves-light reply1">Reply</button>
              <div id="subpost{{$postreply['id']}}" class="sub_post_form"></div>
              @endif 
            </div><!-- main_post_right End -->

          </div><!-- main_post End -->
                    
          <div class="min_post_inner clearfix">
           @if(isset($postreply['subpost']) && !empty($postreply['subpost']))
                @foreach ($postreply['subpost'] as $key1=>$subreply) 
            <div class="main_post clearfix">
              <div class="main_post_left">
               @if(!isset($subreply['fu_avatar'])||$subreply['fu_avatar']=='')
              <?php $subreply['fu_avatar']='ava3.jpg'; ?>
              @endif
                <img src="{{ asset($avatarPath.$subreply['fu_avatar']) }}" alt="alien_galley_info1" class="img-responsive">
              </div><!-- main_post_left End -->
              <div class="main_post_right">
                <h4>{{$subreply['username']}}</h4>
              <p>{!!$subreply['reply']!!}</p>
              <label>{{Helpers::humanTime(strtotime($subreply['post_time']))}}</label>
              </div><!-- main_post_right End -->
            </div><!-- main_post End -->
           @endforeach
           @endif 
          </div><!-- min_post_inner End -->
        </div><!-- cst_post_reply End -->
        @endforeach
      <a href="javascript:void(0)">View More Comments</a>
      </div><!-- post_reply End -->

      @if (Auth::front()->check())
      <div class="post_reply_form">
        <form id="forumcomment" method="post" action="{{ url('forum/saveComment') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="fp_forum_id" value="{{$topic['id']}}" />
          <input type="hidden" name="fp_parent_id" value="0">
          <div class="form-group">
            <label for="t1" class="control-label">Message</label>
            <textarea id="t1" name="fp_post_reply" class="form-control"></textarea>
          </div>
          <div class="post_replyform_submit">
            <button type="submit" class="btn btn-default">Save</button>
            <button type="reset" class="btn btn-default">Clear</button>
          </div>
        </form><!-- form End -->
      </div><!-- post_reply_form End -->
      @endif 
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
    </div><!-- container End -->
  </div><!-- cst_welcome End --> 
@stop 

@section('script')
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>


@if (Auth::front()->check())
<script type="text/javascript">
   function ShowSubPostForm(id , fp_forum_id) {

    $('.post_reply_sub_form').hide();
    $('.sub_post_form').html('');

    var data_html = '';
    var action_url = "{{ url('forum/saveComment') }}";
    var token="{{ csrf_token() }}";
    data_html +='<div class="post_reply_form post_reply_sub_form" id="post_reply_'+id+'">';
    data_html += '<form id="forumcomment" method="post" action="'+action_url+'" >';
    data_html += '<input type="hidden" name="_token" value="'+token+'">';
    data_html += '<input type="hidden" name="fp_forum_id" value="'+fp_forum_id+'">';
    data_html += '<input type="hidden" name="fp_parent_id" value="'+id+'">';
    data_html +='<div class="form-group">';
    data_html +='<label for="t1" class="control-label">Message</label>';
    data_html +='<textarea id="t2" name="fp_post_reply" class="form-control"></textarea>';
    data_html +='</div>';
    data_html +='<div class="post_replyform_submit">';
    data_html +='<button type="submit" class="btn btn-default">Save</button>';
    data_html +='<button type="reset" class="btn btn-default">Clear</button>';
    data_html +='</div>';
    data_html +='</form>';
    data_html +='</div>';
    $("#subpost"+id).html(data_html);
    $("#post_reply_"+id).show();
   } 
            jQuery(document).ready(function() {
    
            var adminvalidationRules = {
               fp_post_reply : {
                    required : true
                }
            }

        $("#forumcomment").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                fp_post_reply  : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
</script>
@endif 
@stop 