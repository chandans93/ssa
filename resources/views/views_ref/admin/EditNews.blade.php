@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.news')}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                     <h3 class="box-title"><?php echo (isset($newsDetail) && !empty($newsDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.news')}}</h3>
                </div><!-- /.box-header -->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('adminvalidation.whoops')}}</strong>{{trans('adminvalidation.someproblems')}}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="addnews" class="form-horizontal" method="post" action="{{ url('/admin/savenews') }}" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($newsDetail) && !empty($newsDetail)) ? $newsDetail->id : '0' ?>">
                    <input type="hidden" name="news_hidden_image" value="<?php echo (isset($newsDetail) && !empty($newsDetail)) ? $newsDetail->n_photo : '' ?>">
                   
                    <div class="box-body">

                       <?php
                        if (old('n_title'))
                            $n_title = old('n_title');
                        elseif ($newsDetail)
                            $n_title = $newsDetail->n_title;
                        else
                            $n_title = '';
                        ?>
                        <div class="form-group">
                            <label for="n_title" class="col-sm-2 control-label">{{trans('adminlabels.newslbltitle')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="n_title" name="n_title" placeholder="{{trans('adminlabels.newslbltitle')}}" value="{{$n_title}}" >
                            </div>
                        </div>
						
						<?php
                        if (old('n_photo'))
                            $n_photo = old('n_photo');
                        elseif ($newsDetail)
                            $n_photo = $newsDetail->n_photo;
                        else
                            $n_photo = '';
                        ?>
                        <div class="form-group">
                            <label for="n_photo" class="col-sm-2 control-label">{{trans('adminlabels.newslblimage')}}</label>
                            <div class="col-sm-6">
                                <input type="file" id="n_photo" name="n_photo"/>
                               <?php
                                    if(isset($newsDetail->id) && $newsDetail->id != '0'){
                                        if(File::exists(public_path($ThumbPath.$newsDetail->n_photo)) && $newsDetail->n_photo != '') { ?><br>
                                            <img src="{{ url($ThumbPath.$newsDetail->n_photo) }}" alt="{{$newsDetail->n_photo}}" >
                                        <?php }else{ ?>
                                        <img src="{{ asset('/backend/images/avatar5.png')}}" class="user-image" alt="Default Image" height="<?php echo Config::get('constant.NEWS_ADMIN_IMAGE_HEIGHT');?>" width="<?php echo Config::get('constant.NEWS_ADMIN_IMAGE_WIDTH');?>">
                                <?php   }
                                    }
                                ?>
                            </div>
                        </div>
						<?php
                        if (old('n_video'))
                            $n_video = old('n_video');
                        elseif ($newsDetail)
                            $n_video = $newsDetail->n_video;
                        else
                            $n_video = '';
                        ?>
						 <div class="form-group">
                            <label for="n_video" class="col-sm-2 control-label">{{trans('adminlabels.newslblvideo')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" id="n_video" name="n_video" placeholder="{{trans('adminlabels.newslblvideolink')}}" value="{{$n_video}}" >
                            </div>
                        </div>
                        <input type="hidden" id="hidden_newsVideoid" name="hidden_newsVideo" >
						
						<?php
                        if (old('n_description'))
                            $n_description = old('n_description');
                        elseif ($newsDetail)
                            $n_description = $newsDetail->n_description;
                        else
                            $n_description = '';
                        ?>
                        <div class="form-group">
                            <label for="n_description" class="col-sm-2 control-label">{{trans('adminlabels.newslbldescription')}}</label>
                            <div class="col-sm-6">
                                <textarea name="n_description" id="n_description">{{$n_description}}</textarea>
                            </div>
                        </div>
						<?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($newsDetail)
                            $deleted = $newsDetail->deleted;
                        else
                            $deleted = '';
                        ?>
                         <div class="form-group">
                            <label for="deleted" class="col-sm-2 control-label">{{trans('adminlabels.lblstatus')}}</label>
                            <div class="col-sm-6">
                                <?php $staus = Helpers::status();
                                ?>
                                <select class="form-control" id="deleted" name="deleted">
                                    <?php foreach ($staus as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if($deleted == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary btn-flat" >{{trans('adminlabels.savebtn')}}</button>
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/news') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop
@section('script')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'n_description' );
    jQuery(document).ready(function() {

    jQuery.validator.addMethod("emptyetbody", function(value, element) {
    var n_description_data = CKEDITOR.instances['n_description'].getData();

  return n_description_data != '';
}, "<?php echo trans('adminvalidation.requiredfield')?>");

            var adminvalidationRules = {
                n_title : {
                    required : true
                },
                n_video : {
                    youtube_url : true
                },
                n_description: {
                    emptyetbody : true
                },
                deleted : {
                    required : true
                }
            }

        $("#addnews").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                n_title : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                n_video : {
                    youtube_url : "Please eneter valid youtube url"
                },
                n_description : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                
                deleted : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
    
    function validateYouTubeUrl() {    
    var url = $('#n_video').val();
    if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
            var finalVideoLink = 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1';            
            $("#hidden_newsVideoid").val(finalVideoLink);
            return true;
        } else {
            return false;
        }
    }
}
</script>
@stop
