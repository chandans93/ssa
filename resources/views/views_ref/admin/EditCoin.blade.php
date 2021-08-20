@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.coin')}}
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
                     <h3 class="box-title"><?php echo (isset($coinDetail) && !empty($coinDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.coin')}}</h3>
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

                <form id="addCoin" class="form-horizontal" method="post" action="{{ url('/admin/savecoin') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($coinDetail) && !empty($coinDetail)) ? $coinDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('c_coins'))
                            $c_coins = old('c_coins');
                        elseif ($coinDetail)
                            $c_coins = $coinDetail->c_coins;
                        else
                            $c_coins = '';
                        ?>
                        <div class="form-group">
                            <label for="c_coins" class="col-sm-2 control-label">{{trans('adminlabels.coins')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control onlyNumber" name="c_coins" placeholder="{{trans('adminlabels.coins')}}" value="{{$c_coins}}" minlength="0" >
                            </div>
                        </div>
						
						<?php
                        if (old('c_price'))
                            $c_price = old('c_price');
                        elseif ($coinDetail)
                            $c_price = $coinDetail->c_price;
                        else
                            $c_price = '';
                        ?>
                        <div class="form-group">
                            <label for="c_price" class="col-sm-2 control-label">{{trans('adminlabels.coinprice')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control number" name="c_price" placeholder="{{trans('adminlabels.coinprice')}}" value="{{$c_price}}" minlength="0" >
                            </div>
							
                        </div>
						
						<?php
                        if (old('c_discount'))
                            $c_discount = old('c_discount');
                        elseif ($coinDetail)
                            $c_discount = $coinDetail->c_discount;
                        else
                            $c_discount = '';
                        ?>
                        <div class="form-group">
                            <label for="c_discount" class="col-sm-2 control-label">{{trans('adminlabels.coindiscount')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control onlyNumber" name="c_discount" placeholder="{{trans('adminlabels.coindiscount')}}" value="{{$c_discount}}" minlength="0" maxlength="3">
                            </div>
							
                        </div>
						
                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($coinDetail)
                            $deleted = $coinDetail->deleted;
                        else
                            $deleted = '';
                        ?>
                        <div class="form-group">
                            <label for="deleted" class="col-sm-2 control-label">{{trans('adminlabels.formlblstatus')}}</label>
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/coins') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')
<script>
    $('.onlyNumber').on('keyup', function () {
        this.value = this.value.replace(/[^0-9]/gi, '');
    });
$('.number').keypress(function(event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
       ((event.which < 48 || event.which > 57) &&
       (event.which != 0 && event.which != 8))) {
           event.preventDefault();
    }

    var text = $(this).val();
    if ((event.which == 46) && (text.indexOf('.') == -1)) {
        setTimeout(function() {
            if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
            }
        }, 1);
    }

    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
    }      
});
		
		
		
</script>
<script type="text/javascript">
    
    jQuery(document).ready(function() {

     "<?php echo trans('adminvalidation.requiredfield')?>";

            var adminvalidationRules = {
                c_coins : {
                    required : true,
					 digits : true,
					 min: 0
                },
                
                c_price : {
                    required : true,
					 min: 0
					 
                },
				 c_discount : {
                    required : true,
					digits : true,
					 min: 0
					 
                },
                
                deleted : {
                    required : true
                }
            }

        $("#addCoin").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                c_coins : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>",
					digits : "<?php echo trans('adminvalidation.validnumber')?>"
					
                },
               
                c_price : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
					
                },
				c_discount : {
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
