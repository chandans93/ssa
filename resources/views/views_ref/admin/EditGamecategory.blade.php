@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.gamecategory')}}
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
                    <h3 class="box-title"><?php echo (isset($gamecategoryDetail) && !empty($gamecategoryDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.gamecategory')}}</h3>
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

                <form id="addgamecategory" class="form-horizontal" method="post" action="{{ url('/admin/savegamecategory') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($gamecategoryDetail) && !empty($gamecategoryDetail)) ? $gamecategoryDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('gc_title'))
                            $gc_title = old('gc_title');
                        elseif ($gamecategoryDetail)
                            $gc_title = $gamecategoryDetail->gc_title;
                        else
                            $gc_title = '';
                        ?>
                        <div class="form-group">
                            <label for="gc_title" class="col-sm-2 control-label">{{trans('adminlabels.formlblegametitle')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="gc_title" name="gc_title" placeholder="{{trans('adminlabels.formlblegametitle')}}" value="{{$gc_title}}" maxlength="50">
                            </div>
                        </div>

                        <?php
                        if (old('gc_parent_id'))
                            $gc_parent_id = old('gc_parent_id');
                        elseif ($gamecategoryDetail)
                            $gc_parent_id = $gamecategoryDetail->gc_parent_id;
                        else
                            $gc_parent_id = '';
                        ?>
                        <div class="form-group">
                            <label for="gc_parent_id" class="col-sm-2 control-label">{{trans('adminlabels.formlblegameparentcategory')}}</label>
                            <div class="col-sm-6">
                                <?php $gameCategory = Helpers::getGameid(); ?>
                                <select class="form-control" id="gc_parent_id" name="gc_parent_id">
                                    <option value="">{{trans('adminlabels.formlblegameparentcategory')}}</option>
                                    <?php foreach ($gameCategory as $value) { ?>
                                        <option value="{{$value->id}}" <?php if ($gc_parent_id == $value->id) echo 'selected'; ?> >{{$value->gc_title}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($gamecategoryDetail)
                            $deleted = $gamecategoryDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/gamecategory') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
            gc_title: {
                required: true
            },
            deleted: {
                required: true
            }
        }

        $("#addgamecategory").validate({
            ignore: "",
            rules: adminvalidationRules,
            messages: {
                gc_title: {
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

