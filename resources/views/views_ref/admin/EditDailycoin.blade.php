@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.dailycoin')}}
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
                     <h3 class="box-title"><?php echo (isset($dailycoinDetail) && !empty($dailycoinDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.dailycoin')}}</h3>
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

                <form id="addDailycoin" class="form-horizontal" method="post" action="{{ url('/admin/savedailycoin') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($dailycoinDetail) && !empty($dailycoinDetail)) ? $dailycoinDetail->id : '0' ?>">
                    <div class="box-body">
						
						<?php
                        if (old('sw_reward_coins'))
                            $sw_reward_coins = old('sw_reward_coins');
                        elseif ($dailycoinDetail)
                            $sw_reward_coins = $dailycoinDetail->sw_reward_coins;
                        else
                            $sw_reward_coins = '';
                        ?>
						
                        <div class="form-group">
                            <label for="sw_reward_coins" class="col-sm-2 control-label">{{trans('adminlabels.dailyrewardcoin')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="sw_reward_coins" name="sw_reward_coins" placeholder="{{trans('adminlabels.dailyrewardcoin')}}" value="{{$sw_reward_coins}}" onClick="checkpostal()">
                            </div>
                        </div>
                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($dailycoinDetail)
                            $deleted = $dailycoinDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/dailycoins') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')
<script>
$("#sw_reward_coins").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
		
</script>
<script language="JavaScript1.2">
function checkpostal(){
	//alert('in');
var regexp=/^([1-9]|10|11|12|13|14|15|16)$/ //regular expression 
if (document.myform.sessionid.value.search(regexp)==-1) //if match failed
alert("wrong input")
}
</script>
<script type="text/javascript">
    
    jQuery(document).ready(function() {

     "<?php echo trans('adminvalidation.requiredfield')?>";

            var adminvalidationRules = {
                sw_category : {
                    required : true
					
                },
                
                sw_reward_coins : {
                    required : true,
					 number: true
                },
                
                deleted : {
                    required : true
                }
            }

        $("#addDailycoin").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                sw_category : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>",
					
                },
               
                sw_reward_coins : {
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
