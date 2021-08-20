@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.CMS')}}
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
                     <h3 class="box-title"><?php echo (isset($cmsDetail) && !empty($cmsDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.CMS')}}</h3>
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

                <form id="addCMS" class="form-horizontal" method="post" action="{{ url('/admin/savecms') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($cmsDetail) && !empty($cmsDetail)) ? $cmsDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('cms_subject'))
                            $cms_subject = old('cms_subject');
                        elseif ($cmsDetail)
                            $cms_subject = $cmsDetail->cms_subject;
                        else
                            $cms_subject = '';
                        ?>
                        <div class="form-group">
                            <label for="cms_subject" class="col-sm-2 control-label">{{trans('adminlabels.formlblsubject')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="cms_subject" name="cms_subject" placeholder="{{trans('adminlabels.formlblsubject')}}" value="{{$cms_subject}}" minlength="6" maxlength="50">
                            </div>
                        </div>

                        <?php
                        if (old('cms'))
                            $cms_slug = old('cms_slug');
                        elseif ($cmsDetail)
                            $cms_slug = $cmsDetail->cms_slug;
                        else
                            $cms_slug = '';
                        ?>
                        <div class="form-group">
                            <label for="cms_slug" class="col-sm-2 control-label">{{trans('adminlabels.cmsblheadslug')}}</label>
                            <div class="col-sm-6">
                                <input type="text" readonly="true" class="form-control" id="cms_slug" name="cms_slug" placeholder="{{trans('adminlabels.formlblslug')}}" value="{{$cms_slug}}" minlength="6" maxlength="50">
                            </div>
                        </div>

                        <?php
                        if (old('cms_body'))
                            $cms_body = old('cms_body');
                        elseif ($cmsDetail)
                            $cms_body = $cmsDetail->cms_body;
                        else
                            $cms_body = '';
                        ?>
                        <div class="form-group">
                            <label for="cms_body" class="col-sm-2 control-label">{{trans('adminlabels.formlblbody')}}</label>
                            <div class="col-sm-6">
                                <textarea name="cms_body" id="cms_body">{{$cms_body}}</textarea>
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($cmsDetail)
                            $deleted = $cmsDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/cms') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
    CKEDITOR.replace( 'cms_body' );
    jQuery(document).ready(function() {
    jQuery.validator.addMethod("emptyetbody", function(value, element) {
    var cms_body_data = CKEDITOR.instances['cms_body'].getData();
     return cms_body_data != '';
    }, "<?php echo trans('adminvalidation.requiredfield')?>");

            var adminvalidationRules = {
                cms_subject : {
                    required : true
                },
                cms_slug : {
                    required : true
                },
                cms_body : {
                  emptyetbody: true
                },
                deleted : {
                    required : true
                }
            }

        $("#addCMS").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                cms_subject : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                cms_slug : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                cms_body : {
                    emptyetbody : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                deleted : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
</script>

    <?php if (empty($cmsDetail)){ ?>
    <script>
    $('#cms_subject').keyup(function ()
    {
        var str = $(this).val();
        str = str.replace(/[^a-zA-Z0-9\s]/g, "");
        str = str.toLowerCase();
        str = str.replace(/\s/g, '-');
        $('#cms_slug').val(str);
        $('#cms_slug').valid();
    });
    </script>
    <?php } ?>
@stop

