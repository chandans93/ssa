@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
         {{trans('adminlabels.forum_category')}}
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
                     <h3 class="box-title"><?php echo (isset($forum_categoryDetail) && !empty($forum_categoryDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.forum_category')}}</h3>
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

                <form id="addforumcategory" class="form-horizontal" method="post" action="{{ url('/admin/saveforumcategory') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($forum_categoryDetail) && !empty($forum_categoryDetail)) ? $forum_categoryDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('fc_name'))
                            $fc_name = old('fc_name');
                        elseif ($forum_categoryDetail)
                            $fc_name = $forum_categoryDetail->fc_name;
                        else
                            $fc_name = '';
                        ?>
                        <div class="form-group">
                            <label for="fc_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblname')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fc_name" name="fc_name" placeholder="{{trans('adminlabels.formlblname')}}" value="{{$fc_name}}" maxlength="50">
                            </div>
                        </div>
                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($forum_categoryDetail)
                            $deleted = $forum_categoryDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/forumcategory') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')

<script type="text/javascript">
    jQuery(document).ready(function() {

            var adminvalidationRules = {
                fc_name : {
                    required : true
                },
                deleted : {
                    required : true
                }
            }

        $("#addforumcategory").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                fc_name : {
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

