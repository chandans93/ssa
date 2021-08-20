@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.productcategory')}}
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
                    <h3 class="box-title"><?php echo (isset($productcategoryDetail) && !empty($productcategoryDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.productcategory')}}</h3>
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

                <form id="addproductcategory" class="form-horizontal" method="post" action="{{ url('/admin/saveproductcategory') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($productcategoryDetail) && !empty($productcategoryDetail)) ? $productcategoryDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('pc_title'))
                            $pc_title = old('pc_title');
                        elseif ($productcategoryDetail)
                            $pc_title = $productcategoryDetail->pc_title;
                        else
                            $pc_title = '';
                        ?>
                        <div class="form-group">
                            <label for="pc_title" class="col-sm-2 control-label">{{trans('adminlabels.formlbleproducttitle')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="pc_title" name="pc_title" placeholder="{{trans('adminlabels.formlbleproducttitle')}}" value="{{$pc_title}}" maxlength="50">
                            </div>
                        </div>

                        <?php
                        if (old('pc_parent_id'))
                            $pc_parent_id = old('pc_parent_id');
                        elseif ($productcategoryDetail)
                            $pc_parent_id = $productcategoryDetail->pc_parent_id;
                        else
                            $pc_parent_id = '';
                        ?>
                        <div class="form-group">
                            <label for="pc_parent_id" class="col-sm-2 control-label">{{trans('adminlabels.formlbleparentcategory')}}</label>
                            <div class="col-sm-6">
                                <?php $cities = Helpers::getProductid(); ?>
                                <select class="form-control" id="pc_parent_id" name="pc_parent_id">
                                    <option value="">{{trans('adminlabels.formlbleparentcategory')}}</option>
                                    <?php foreach ($cities as $value) { ?>
                                        <option value="{{$value->id}}" <?php if ($pc_parent_id == $value->id) echo 'selected'; ?> >{{$value->pc_title}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($productcategoryDetail)
                            $deleted = $productcategoryDetail->deleted;
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
                                        <option value="{{$key}}" <?php if ($deleted == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary btn-flat" >{{trans('adminlabels.savebtn')}}</button>
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/productcategory') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')

<script type="text/javascript">
    jQuery(document).ready(function () {

        var adminvalidationRules = {
            pc_title: {
                required: true
            },
            deleted: {
                required: true
            }
        }

        $("#addproductcategory").validate({
            ignore: "",
            rules: adminvalidationRules,
            messages: {
                pc_title: {
                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                deleted: {
                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
</script>
@stop

