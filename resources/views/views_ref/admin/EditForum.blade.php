@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.forum')}}
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
                     <h3 class="box-title"><?php echo (isset($forumDetail) && !empty($forumDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.forum')}}</h3>
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

                <form id="addforum" class="form-horizontal" method="post" action="{{ url('/admin/saveforum') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($forumDetail) && !empty($forumDetail)) ? $forumDetail->id : '0' ?>">
                    <div class="box-body">
                                    
                                    

                        <?php
                        if (old('f_forum_topic'))
                            $f_forum_topic = old('f_forum_topic');
                        elseif ($forumDetail)
                            $f_forum_topic = $forumDetail->f_forum_topic;
                        else
                            $f_forum_topic = '';
                        ?>
                        <div class="form-group">
                            <label for="f_forum_topic" class="col-sm-2 control-label">{{trans('adminlabels.f_forum_topic')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="f_forum_topic" name="f_forum_topic" placeholder="{{trans('adminlabels.f_forum_topic')}}" value="{{$f_forum_topic}}">
                            </div>
                        </div>

                        
                        <?php
                        if (old('f_description'))
                            $f_description = old('f_description');
                        elseif ($forumDetail)
                            $f_description = $forumDetail->f_description;
                        else
                            $f_description = '';
                        ?>
                        <div class="form-group">
                            <label for="f_description" class="col-sm-2 control-label">{{trans('adminlabels.formlblbody')}}</label>
                            <div class="col-sm-6">
                                <textarea name="f_description" id="f_description">{{$f_description}}</textarea>
                            </div>
                        </div>
                        <?php
                        if (old('f_category_id'))
                            $f_category_id = old('f_category_id');
                        elseif ($forumDetail)
                            $f_category_id = $forumDetail->f_category_id;
                        else
                            $f_category_id = '';
                        ?>
                        <div class="form-group">
                            <label for="f_category_id" class="col-sm-2 control-label">{{trans('adminlabels.forum_category')}}</label>
                            <div class="col-sm-6">
                                <?php $f_category = Helpers::forumcategory();
                                ?>
                                <select class="form-control" id="f_category_id" name="f_category_id">
                                    <?php foreach ($f_category as $value) { ?>
                                        <option value="{{$value->id}}" <?php if($f_category_id == $value->id) echo 'selected'; ?> >{{$value->fc_name}}</option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($forumDetail)
                            $deleted = $forumDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/forum') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
    CKEDITOR.replace( 'f_description' );
    jQuery(document).ready(function() {
    jQuery.validator.addMethod("emptyetbody", function(value, element) {
    var f_description_data = CKEDITOR.instances['f_description_body'].getData();
     return f_description_data != '';
    }, "<?php echo trans('adminvalidation.requiredfield')?>");

            var adminvalidationRules = {
                f_forum_topic : {
                    required : true
                },
                f_description : {
                  emptyetbody: true
                },
                deleted : {
                    required : true
                },
                f_category_id : {
                    required : true  
                }
            }

        $("#addforum").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                f_forum_topic : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                
                
                 f_category_id : {
                    emptyetbody : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                f_description : {
                    emptyetbody : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                deleted : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
</script>
@stop

