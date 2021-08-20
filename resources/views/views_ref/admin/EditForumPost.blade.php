@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.forumPost')}}
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
                     <h3 class="box-title"><?php echo (isset($forumPostDetail) && !empty($forumPostDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.forumPost')}}</h3>
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

                <form id="addforumPost" class="form-horizontal" method="post" action="{{ url('/admin/saveforumpost') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($forumPostDetail) && !empty($forumPostDetail)) ? $forumPostDetail->id : '0' ?>">
                    <div class="box-body">
                                    
                                    

                        <?php
                        if (old('fp_post_reply'))
                            $fp_post_reply = old('fp_post_reply');
                        elseif ($forumPostDetail)
                            $fp_post_reply = $forumPostDetail->fp_post_reply;
                        else
                            $fp_post_reply = '';
                        ?>
                        <div class="form-group">
                            <label for="fp_post_reply" class="col-sm-2 control-label">{{trans('adminlabels.lblreply')}}</label>
                            <div class="col-sm-6">
                                <textarea name="fp_post_reply" id="fp_post_reply">{{$fp_post_reply}}</textarea>
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($forumPostDetail)
                            $deleted = $forumPostDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/forumPost') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
    CKEDITOR.replace( 'fp_post_reply' );
    jQuery(document).ready(function() {
    jQuery.validator.addMethod("emptyetbody", function(value, element) {
    var fp_post_reply_data = CKEDITOR.instances['fp_post_reply_body'].getData();
     return fp_post_reply_data != '';
    }, "<?php echo trans('adminvalidation.requiredfield')?>");

            var adminvalidationRules = {
                fp_post_reply : {
                    required : true
                },
                deleted : {
                    required : true
                }
            }

        $("#addforumPost").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                fp_post_reply : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                deleted : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
</script>
@stop

