@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.Voucher')}}
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
                     <h3 class="box-title"><?php echo (isset($voucherDetail) && !empty($voucherDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.Voucher')}}</h3>
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

                <form id="addVoucher" class="form-horizontal" method="post" action="{{ url('/admin/savevoucher') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($voucherDetail) && !empty($voucherDetail)) ? $voucherDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('v_pack'))
                            $v_pack = old('v_pack');
                        elseif ($voucherDetail)
                            $v_pack = $voucherDetail->v_pack;
                        else
                            $v_pack = '';
                        ?>
                        <div class="form-group">
                            <label for="v_pack" class="col-sm-2 control-label">{{trans('adminlabels.voucherpack')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="v_pack" name="v_pack" placeholder="{{trans('adminlabels.voucherpack')}}" value="{{$v_pack}}" >
                            </div>
                        </div>
						
						<?php
                        if (old('v_discount'))
                            $v_discount = old('v_discount');
                        elseif ($voucherDetail)
                            $v_discount = $voucherDetail->v_discount;
                        else
                            $v_discount = '';
                        ?>
                        <div class="form-group">
                            <label for="v_discount" class="col-sm-2 control-label">{{trans('adminlabels.voucherdiscount')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="v_discount" name="v_discount" placeholder="{{trans('adminlabels.voucherdiscount')}}" value="{{$v_discount}}" minlength="0" maxlength="3" >
                            </div>
							
                        </div>
						
						<?php
                        if (old('v_price'))
                            $v_price = old('v_price');
                        elseif ($voucherDetail)
                            $v_price = $voucherDetail->v_price;
                        else
                            $v_price = '';
                        ?>
                        <div class="form-group">
                            <label for="v_price" class="col-sm-2 control-label">{{trans('adminlabels.voucherprice')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="v_price" name="v_price" placeholder="{{trans('adminlabels.voucherprice')}}" value="{{$v_price}}" >
                            </div>
                        </div>

                        
                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($voucherDetail)
                            $deleted = $voucherDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/vouchers') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')
<script>
$("#v_pack").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57 || event.which == 8 )) {
                event.preventDefault();
            }
        });
		
$("#v_discount").on("keypress keyup blur",function (event) {    
          $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57 || event.which == 8 )) {
                event.preventDefault();
            }
        });
		
$("#v_price").on("keypress keyup blur",function (event) {    
          $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57 || event.which == 8 )) {
                event.preventDefault();
            }
        });
		
		
		
</script>
<script type="text/javascript">
    
    jQuery(document).ready(function() {

     "<?php echo trans('adminvalidation.requiredfield')?>";

            var adminvalidationRules = {
                v_pack : {
                    required : true,
					 digits: true
                },
                v_discount : {
                    required : true,
					  digits: true
					 
                },
                v_price : {
                    required : true,
					 number: true,
					 min : 0
                },
                
                deleted : {
                    required : true
                }
            }

        $("#addVoucher").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                v_pack : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>",
					 digits : "<?php echo trans('adminvalidation.validnumber')?>"
					
                },
                v_discount : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>",
					 digits : "<?php echo trans('adminvalidation.validnumber')?>"
                },
                v_price : {
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
