@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->
<link href="{{ asset('/backend/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">

<link href="{{ asset('backend/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.formlblauction')}}
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
                    <h3 class="box-title"> <?php echo (isset($auctiondetail) && !empty($auctiondetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.formlblauction')}}  </h3>
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

                <form id="addAuction" class="form-horizontal" method="post" action="{{ url('admin/saveauction') }}" enctype="multipart/form-data">
                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($auctiondetail) && !empty($auctiondetail)) ? $auctiondetail->id : '0' ?>">

                    <div class="box-body">
	                    <div class="form-group">
	                    		<?php
			                        if (old('au_product_id'))
			                            $au_product_id = old('au_product_id');
			                        elseif ($auctiondetail)
			                            $au_product_id = $auctiondetail->au_product_id;
			                        else
			                            $au_product_id = '';
		                        ?>
		                        <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.product')}}</label>
		                        <div class="col-sm-6">
		                           <?php $product = Helpers::getPrdouctlist(); ?>
		                            <select class="form-control" id="a_product" name="a_product">
	                                    <option value="">{{trans('adminlabels.product')}}</option>
	                                    <?php
	                                    if (isset($product) && !empty($product)) {
	                                        foreach ($product as $value) {
	                                            ?>
	                                            <option value="{{$value->id}}" <?php if ($au_product_id == $value->id) echo 'selected'; ?> >{{$value->p_title}}</option>
	                                            <?php
	                                        }
	                                    }
	                                    ?>
	                                </select>
		                        </div> 
	                        </div>
	                        <?php
			                    if (old('au_start_time'))
			                        $au_start_time = old('au_start_time');
			                    elseif ($auctiondetail)
			                        $au_start_time = $auctiondetail->au_start_time;
			                    else 
			                        $au_start_time = '';
		                    ?>
	                        <div class="form-group">
		                     	    <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.formlblstarttime')}}</label>
					                <div class="col-sm-6 controls input-append date form_datetime1" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
					                    <input size="16" type="text" value="{{$au_start_time}}" class="form-control" readonly name="a_starttime" id="a_starttime">
					                    <span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
					              	</div>
									<input type="hidden" id="dtp_input1" value="" /><br/>

		                     </div>


		                    <?php
			                    if (old('au_status'))
			                        $au_status = old('au_status');
			                    elseif ($auctiondetail)
			                        $au_status = $auctiondetail->au_status;
			                    else 
			                        $au_status = '';
		                    ?>
	                        <div class="form-group">
	                        	 <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.lblstatus')}}</label>
		                         <div class="col-sm-6">
		                          	<?php $status = Helpers::getAuctionstatus();?>
	                                <select class="form-control" id="a_status" name="a_status">
		                            	<option value="">Auction Status</option>
	                                    <?php
	                                    if (isset($status) && !empty($status)) {
	                                        foreach ($status as $key=>$value) {
	                                            ?>
	                                            <option value="{{$key}}" <?php if ($au_status == $key) echo 'selected'; ?>>{{$value}}</option>
	                                            <?php
	                                        }
	                                    }
	                                    ?>
	                                </select>
		                        </div>
		                    </div>
		                    <?php
			                    if (old('au_bid_type'))
			                        $au_bid_type = old('au_bid_type');
			                    elseif ($auctiondetail)
			                        $au_bid_type = $auctiondetail->au_bid_type;
			                    else 
			                        $au_bid_type = '';
		                    ?>
		                    <div class="form-group">
		                    	 <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.formlblauctiontype')}}</label>
		                        <div class="col-sm-6">
		                        	<?php $type = Helpers::getBidtype();?>
		                            <select class="form-control" id="a_bidtype" name="a_bidtype">
		                            	<option value="">Bid Type</option>
	                                   <?php
	                                    if (isset($type) && !empty($type)) {
	                                        foreach ($type as $key=>$value) {
	                                            ?>
	                                            <option value="{{$key}}" <?php if ($au_bid_type == $key) echo 'selected'; ?>>{{$value}}</option>
	                                            <?php
	                                        }
	                                    }
	                                    ?>
	                                </select>
		                        </div>
		                    </div>

		                    <?php
			                    if (old('au_fees'))
			                        $au_fees = old('au_fees');
			                    elseif ($auctiondetail)
			                        $au_fees = $auctiondetail->au_fees;
			                    else 
			                        $au_fees = '';
		                    ?>
		                    <div class="form-group" id="auc_fee" style="<?php if($au_fees == 0 &&  $au_bid_type != 2 ){ echo "display:none;"; }?>">
		                    	 <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.formlblauctionfees')}}</label>
		                        <div class="col-sm-6">
		                        	<input class="form-control onlyNumber" type="text" id="a_fees" name="a_fees" value="{{$au_fees}}" />   
		                        </div>
		                    </div>

		                     <?php
			                    if (old('au_bid_voucher'))
			                        $au_bid_voucher = old('au_bid_voucher');
			                    elseif ($auctiondetail)
			                        $au_bid_voucher = $auctiondetail->au_bid_voucher;
			                    else 
			                        $au_bid_voucher = '';
		                    ?>
		                    <div class="form-group">
	                        	 <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.formlblbidvoucher')}}</label>
		                         <div class="col-sm-6">
		                             <input class="form-control" type="text" id="a_bidvoucher" name="a_bidvoucher" value="{{$au_bid_voucher}}" />    
		                        </div>
		                    </div>
		                    <?php
			                    if (old('au_end_time'))
			                        $au_end_time = old('au_end_time');
			                    elseif ($auctiondetail)
			                        $au_end_time = $auctiondetail->au_end_time;
			                    else 
			                        $au_end_time = '';
		                    ?>
		                    <div class="form-group">
		                     	    <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.formlblendtime')}}</label>
					                <div class="col-sm-6 controls input-append date form_datetime2" data-date-format="dd MM yyyy - HH:mm:ss p" data-link-field="dtp_input1">
					                    <input size="16" type="text" value="{{$au_end_time}}" class="form-control" name="a_endtime" readonly id="a_endtime">
					                    <span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
					              	</div>
									<input type="hidden" id="dtp_input1" value="" /><br/>

		                     </div>
		                     
		                    <div class="box-footer">
		                        <button type="submit" id="submit" class="btn btn-primary btn-flat" >{{trans('adminlabels.savebtn')}}</button>
		                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/auction') }}">{{trans('adminlabels.cancelbtn')}}</a>

		                        

		                    </div><!-- /.box-footer -->
 	            </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->
@stop

@section('script')
   
    <script type="text/javascript">

    	$( "#a_bidtype" ).change(function() {
    			
    		 var bidtype = $( "#a_bidtype" ).val(); 
		  	 if(bidtype == 2){
		  	 	$( "#auc_fee" ).show();
		  	 }else{
		  	 	$( "#auc_fee" ).hide();
		  	 }
		});
 
 		var isAfterStartDate = function(startDateStr, endDateStr) {
           
         	var startDateTime = $('#a_starttime').val();
	        var endDateTime = $('#a_endtime').val();

	        var splitStartDate = startDateTime.split(' ');
	        var splitEndDate = endDateTime.split(' ');

	        var startDateArray = splitStartDate[0].split('/');
	        var endDateArray = splitEndDate[0].split('/');

	        var startDateTime = new Date(startDateArray[2] + '/ ' + startDateArray[1] + '/' + startDateArray[0] + ' ' + splitStartDate[1]);
	        var endDateTime = new Date(endDateArray[2] + '/ ' + endDateArray[1] + '/' + endDateArray[0] + ' ' + splitEndDate[1]);

	        if (startDateTime > endDateTime) {
	           return false;
	        }
	        else {
	            return true;
	        }
		};
		jQuery.validator.addMethod("isAfterStartDate", function(value, element) {
	        return isAfterStartDate($('#a_starttime').val(), $('#a_endtime').val());
	    }, "End date should be after start date");
	 
		 
    	var FromEndDate = new Date();  
    	$('.form_datetime1').datetimepicker({
            weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	        startDate: new Date(), 
	        format: 'yyyy-mm-dd hh:ii:ss'
    	});

    	$('.form_datetime2').datetimepicker({
            weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1,
	        startDate: new Date(),
		     format: 'yyyy-mm-dd hh:ii:ss'
    	});
 
 	    
		jQuery(document).ready(function () {

			 $('.onlyNumber').on('keyup', function () {
                                            this.value = this.value.replace(/[^0-9]/gi, '');
                                        });
			var adminvalidationRules = {
	            a_product: {
	                required: true
	            },
	            a_starttime: {
	                required: true
	               
	            },
	            a_status: {
	                required: true
	            },
	            a_bidtype: {
	                required: true
	            },
	            a_fees: {
	                digits: true,
	                maxlength: 11
	            },
	            a_bidvoucher: {
	                required: true,
	                digits : true,
	                maxlength: 11

	            },
	            a_endtime: {
	                required: true,
	                isAfterStartDate: true
	            },
 
 	        }

	        $("#addAuction").validate({
	            ignore: "hidden",
	            rules: adminvalidationRules,
	            messages: {
	            	a_product: {
	                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
	                },
	                a_starttime: {
	                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
	                },
	                a_bidvoucher: {
	                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>",
	                    digits : '<?php echo trans('adminvalidation.validnumber')?>' ,
	                    maxlength : '<?php echo trans('adminvalidation.maxlength')?>'   
	                },
	                a_status: {
	                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
	                },
	                a_bidtype: {
	                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
	                },
	                a_fees: {
	                    digits : '<?php echo trans('adminvalidation.validnumber')?>' ,
	                    maxlength : '<?php echo trans('adminvalidation.maxlength')?>' 
	                },
	                a_endtime: {
	                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>" 
	                } 
	            }
	        })
    	});
 	</script>
@stop