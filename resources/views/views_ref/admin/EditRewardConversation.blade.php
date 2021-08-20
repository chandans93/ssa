@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.Rewardconversation')}}
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
                     <h3 class="box-title"><?php echo (isset($rcDetail) && !empty($rcDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.Rewardconversation')}}</h3>
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

                <form id="addRewardconversation" class="form-horizontal" method="post" action="{{ url('/admin/saverewardconversation') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($rcDetail) && !empty($rcDetail)) ? $rcDetail->id : '0' ?>">
                    <div class="box-body">
                        <?php
                        if (old('vrc_voucher'))
                            $vrc_voucher = old('vrc_voucher');
                        elseif ($rcDetail)
                            $vrc_voucher = $rcDetail->vrc_voucher;
                        else
                            $vrc_voucher = '';
                        ?>
                        <div class="form-group">
                            <label for="vrc_voucher" class="col-sm-2 control-label">{{trans('adminlabels.rc_voucher')}}</label>
                            <div class="col-sm-6">
                                <input type="text"  class="form-control" id="vrc_voucher" name="vrc_voucher" placeholder="{{trans('adminlabels.rc_voucher')}}" value="{{$vrc_voucher}}">
                            </div>
                        </div>
                        
                        <?php
                        if (old('vrc_reward_point'))
                            $vrc_reward_point = old('vrc_reward_point');
                        elseif ($rcDetail)
                            $vrc_reward_point = $rcDetail->vrc_reward_point;
                        else
                            $vrc_reward_point = '';
                        ?>
                        <div class="form-group">
                            <label for="vrc_reward_point" class="col-sm-2 control-label">{{trans('adminlabels.rc_reward_point')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="vrc_reward_point" name="vrc_reward_point" placeholder="{{trans('adminlabels.rc_reward_point')}}" value="{{$vrc_reward_point}}" >
                            </div>
                        </div>

                        

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($rcDetail)
                            $deleted = $rcDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/rewardconversation') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
                vrc_reward_point : {
                    required : true,
                    digits : true
                },
                vrc_voucher : {
                    required : true,
                    digits : true
                },
                deleted : {
                    required : true
                }
            }

        $("#addRewardconversation").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                vrc_reward_point : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>",
                    digits : "<?php echo trans('adminvalidation.validnumber')?>"
                },
                vrc_voucher : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>",
                    digits : "<?php echo trans('adminvalidation.validnumber')?>"
                },
                deleted : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
</script>

@stop

