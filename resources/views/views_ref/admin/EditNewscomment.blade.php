@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.newscomment')}}
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
                     <h3 class="box-title"><?php echo (isset($newscommentDetail) && !empty($newscommentDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.newscomment')}}</h3>
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

                <form id="addNewscomment" class="form-horizontal" method="post" action="{{ url('/admin/savenewscomment') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($newscommentDetail) && !empty($newscommentDetail)) ? $newscommentDetail->id : '0' ?>">
                    <div class="box-body">
						<?php
                        if (old('nc_comment'))
                            $nc_comment = old('nc_comment');
                        elseif ($newscommentDetail)
                            $nc_comment = $newscommentDetail->nc_comment;
                        else
                            $nc_comment = '';
						?>
                        <div class="form-group">
                            <label for="nc_comment" class="col-sm-2 control-label">{{trans('adminlabels.newscommentcomment')}}</label>
                            <div class="col-sm-6">
                                <textarea name="nc_comment" id="nc_comment">{{$nc_comment}}</textarea>
                            </div>
                        </div>

						
					    <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($newscommentDetail)
                            $deleted = $newscommentDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/newscomment') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
    CKEDITOR.replace( 'nc_comment' );
    jQuery(document).ready(function() {

    jQuery.validator.addMethod("emptyetbody", function(value, element) {
    var nc_comment_data = CKEDITOR.instances['nc_comment'].getData();

  return nc_comment_data != '';
}, "<?php echo trans('adminvalidation.requiredfield')?>");

            var adminvalidationRules = {
                nc_comment : {
                    emptyetbody : true
                },
               
                deleted : {
                    required : true
                }
            }

        $("#addNewscomment").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                nc_comment : {
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
