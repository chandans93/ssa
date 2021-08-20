@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.product')}}
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
                    <h3 class="box-title"><?php echo (isset($productDetail) && !empty($productDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.product')}}</h3>
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

                <form id="addProduct" class="form-horizontal" method="post" action="{{ url('/admin/saveproduct') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($productDetail) && !empty($productDetail)) ? $productDetail->id : '0' ?>">
                    <input type="hidden" name="image_id" value="<?php echo (isset($productImageDetail) && !empty($productImageDetail)) ? $productImageDetail['0']['id'] : '0' ?>">
                    <input type="hidden" name="hidden_profile" value="<?php echo (isset($productImageDetail) && !empty($productImageDetail)) ? $productImageDetail['0']['pi_image_name'] : '' ?>">

                    <div class="box-body">
                        <?php
                        if (old('p_sku'))
                            $p_sku = old('p_sku');
                        elseif ($productDetail)
                            $p_sku = $productDetail->p_sku;
                        else
                            $p_sku = '';
                        ?>
                        <div class="form-group">
                            <label for="p_sku" class="col-sm-2 control-label">{{trans('adminlabels.formlblesku')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="p_sku" name="p_sku" placeholder="{{trans('adminlabels.formlblesku')}}" value="{{ $p_sku}}" minlength="3" maxlength="30"/>
                            </div>
                        </div>
                        <?php
                        if (old('p_title'))
                            $p_title = old('p_title');
                        elseif ($productDetail)
                            $p_title = $productDetail->p_title;
                        else
                            $p_title = '';
                        ?>
                        <div class="form-group">
                            <label for="p_title" class="col-sm-2 control-label">{{trans('adminlabels.formlbletitle')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="p_title" name="p_title" placeholder="{{trans('adminlabels.formlbletitle')}}" value="{{ $p_title}}" minlength="3" maxlength="100"/>
                            </div>
                        </div>
                        <!----- this is for product category -->
                        <?php
                        if (old('p_category_id'))
                            $p_category_id = old('p_category_id');
                        elseif ($productDetail)
                            $p_category_id = $productDetail->p_category_id;
                        else
                            $p_category_id = '';
                        ?>
                        <div class="form-group">
                            <label for="p_category_id" class="col-sm-2 control-label">{{trans('adminlabels.formlblecategory')}}</label>
                            <div class="col-sm-6">
                                <?php $product = Helpers::getProductid(); ?>
                                <select class="form-control" id="p_category_id" name="p_category_id" onchange="getDataOfSubCategory(this.value)">
                                    <option value="">{{trans('adminlabels.formlblecategory')}}</option>
                                    <?php foreach ($product as $value) { ?>
                                        <option value="{{$value->id}}" <?php if ($p_category_id == $value->id) echo 'selected'; ?> >{{$value->pc_title}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!----- end productcategory -->

                        <!----- this is for product Subcategory -->

                        <?php
                        if (old('p_subcategory_id'))
                            $p_subcategory_id = old('p_subcategory_id');
                        elseif ($productDetail)
                            $p_subcategory_id = $productDetail->p_subcategory_id;
                        else
                            $p_subcategory_id = '';
                        ?>                        

                        <div class="form-group" id="hide_show">
                            <label for="p_subcategory_id" class="col-sm-2 control-label">{{trans('adminlabels.formlblesubcategory')}}</label>
                            <div class="col-sm-6">
                                <?php $product = Helpers::getSubCategory($p_category_id); ?>
                                <select class="form-control" id="p_subcategory_id" name="p_subcategory_id">
                                    <option value="">{{trans('adminlabels.formlblesubcategory')}}</option>
                                    <?php
                                    if (isset($product) && !empty($product)) {
                                        foreach ($product as $value) {
                                            ?>
                                            <option value="{{$value->id}}" <?php if ($p_subcategory_id == $value->id) echo 'selected'; ?> >{{$value->pc_title}}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!----- end product Subcategory -->
                        <?php
                        if (old('p_price'))
                            $p_price = old('p_price');
                        elseif ($productDetail)
                            $p_price = $productDetail->p_price;
                        else
                            $p_price = '';
                        ?>
                        <div class="form-group">
                            <label for="p_price" class="col-sm-2 control-label">{{trans('adminlabels.formlbleprice')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control number" id="p_price" name="p_price" placeholder="{{trans('adminlabels.formlbleprice')}}" value="{{$p_price }}" minlength="1" maxlength="100"/>
                            </div>
                        </div>
                        <?php
                        if (old('p_voucher'))
                            $p_voucher = old('p_voucher');
                        elseif ($productDetail)
                            $p_voucher = $productDetail->p_voucher;
                        else
                            $p_voucher = '';
                        ?>
                        <div class="form-group">
                            <label for="p_voucher" class="col-sm-2 control-label">{{trans('adminlabels.formlblvoucher')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control onlyNumber" id="p_voucher" name="p_voucher" placeholder="{{trans('adminlabels.formlblvoucher')}}" value="{{ $p_voucher}}" minlength="1" maxlength="100"/>
                            </div>
                        </div>

                        <?php
                        if (old('p_quantity'))
                            $p_quantity = old('p_quantity');
                        elseif ($productDetail)
                            $p_quantity = $productDetail->p_quantity;
                        else
                            $p_quantity = '';
                        ?>
                        <div class="form-group">
                            <label for="p_quantity" class="col-sm-2 control-label">{{trans('adminlabels.formlblquantity')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control onlyNumber" id="p_quantity" name="p_quantity" placeholder="{{trans('adminlabels.formlblquantity')}}" value="{{$p_quantity}}" minlength="1" maxlength="100"/>
                            </div>
                        </div>

                        <?php
                        if (old('p_description'))
                            $p_description = old('p_description');
                        elseif ($productDetail)
                            $p_description = $productDetail->p_description;
                        else
                            $p_description = '';
                        ?>
                        <div class="form-group">
                            <label for="p_description" class="col-sm-2 control-label">{{trans('adminlabels.formlbldescription')}}</label>
                            <div class="col-sm-6">

                                <textarea name="p_description" id="p_description">{{$p_description}}</textarea>                               
                            </div>
                        </div>

                        <?php
                        if (old('pi_image_name'))
                            $pi_image_name = old('pi_image_name');
                        elseif ($productImageDetail)
                            $pi_image_name = $productImageDetail['0']['pi_image_name'];
                        else
                            $pi_image_name = '';
                        ?>

                        <div class="form-group">
                            <label for="p_image" class="col-sm-2 control-label">{{trans('adminlabels.formlblimage')}}</label>
                            <div class="col-sm-6">
                                <input type="file" name="pi_image_name" id="pi_image_name" class="productPhoto" accept=".png, .jpg, .jpeg, .bmp">

                                <?php
                                if (isset($productImageDetail['0']['id']) && $productImageDetail['0']['id'] != '0') {

                                    if (File::exists(public_path($uploadProductImagePath . $productImageDetail['0']['pi_image_name'])) && $productImageDetail['0']['pi_image_name'] != '') {
                                        ?><br>
                                        <img src="{{ url($uploadProductImagePath.$productImageDetail['0']['pi_image_name']) }}" alt="{{$productImageDetail['0']['pi_image_name']}}" height="45px" width="45px">
                                    <?php } else { ?>
                                        <img src="{{ asset('/upload/avatar/ava1.jpg')}}" class="user-image" alt="Default Image">
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (old('p_condition'))
                            $p_condition = old('p_condition');
                        elseif ($productDetail)
                            $p_condition = $productDetail->p_condition;
                        else
                            $p_condition = '';
                        ?>
                        <div class="form-group">
                            <label for="p_condition" class="col-sm-2 control-label">{{trans('adminlabels.formlblcondition')}}</label>
                            <div class="col-sm-6">
                                <textarea rows="4" id="p_condition" name="p_condition" minlength="3" maxlength="50" style="width:100%; padding:5px;">{{ $p_condition}}</textarea>                               
                            </div>
                        </div>

                        <?php
                        if (old('p_delivery_method'))
                            $p_delivery_method = old('p_delivery_method');
                        elseif ($productDetail)
                            $p_delivery_method = $productDetail->p_delivery_method;
                        else
                            $p_delivery_method = '';
                        ?>
                        <div class="form-group">
                            <label for="p_delivery_method" class="col-sm-2 control-label">{{trans('adminlabels.formlbldeliverymethod')}}</label>
                            <div class="col-sm-6">
                                <?php $deliveryMethod = Helpers::deliveryMethod(); ?>
                                <select class="form-control" id="p_delivery_method" name="p_delivery_method">
                                    <?php foreach ($deliveryMethod as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if ($p_delivery_method == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>                      

                        <?php
                        if (old('p_platform'))
                            $p_platform = old('p_platform');
                        elseif ($productDetail)
                            $p_platform = $productDetail->p_platform;
                        else
                            $p_platform = '';
                        ?>
                        <div class="form-group">
                            <label for="p_platform" class="col-sm-2 control-label">{{trans('adminlabels.formlblplatform')}}</label>
                            <div class="col-sm-6">
                                <textarea rows="4" id="p_platform" name="p_platform" minlength="3" maxlength="50" style="width:100%; padding:5px;">{{ $p_platform}}</textarea>                               
                            </div>
                        </div>

                        <?php
                        if (old('p_region'))
                            $p_region = old('p_region');
                        elseif ($productDetail)
                            $p_region = $productDetail->p_region;
                        else
                            $p_region = '';
                        ?>
                        <div class="form-group">
                            <label for="p_region" class="col-sm-2 control-label">{{trans('adminlabels.formlblregion')}}</label>
                            <div class="col-sm-6">
                                <?php $region = Helpers::region(); ?>
                                <select class="form-control" id="p_region" name="p_region">
                                    <?php foreach ($region as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if ($p_region == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>  

                        <?php
                        if (old('p_pre_order'))
                            $p_pre_order = old('p_pre_order');
                        elseif ($productDetail)
                            $p_pre_order = $productDetail->p_pre_order;
                        else
                            $p_pre_order = '';
                        ?>
                        <div class="form-group">
                            <label for="p_pre_order" class="col-sm-2 control-label">{{trans('adminlabels.formlblpreorder')}}</label>
                            <div class="col-sm-6">
                                <?php $order = Helpers::order(); ?>
                                <select class="form-control" id="p_pre_order" name="p_pre_order">
                                    <?php foreach ($order as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if ($p_pre_order == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('p_pre_order_date'))
                            $p_pre_order_date = old('p_pre_order_date');
                        elseif ($productDetail)
                            $p_pre_order_date = date('m/d/Y', strtotime($productDetail->p_pre_order_date));
                        else
                            $p_pre_order_date = '';
                        ?>
                        <div class="form-group pre_order_date_class">
                            <label for="p_pre_order_date" class="col-sm-2 control-label">{{trans('adminlabels.formlblorderdate')}}</label>
                            <div class="col-sm-6">
                                <input type="text"  class="form-control onlyNothing" id="p_pre_order_date"  name="p_pre_order_date" value="{{$p_pre_order_date}}" />
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($productDetail)
                            $deleted = $productDetail->deleted;
                        else
                            $deleted = '';
                        ?>
                        <div class="form-group">
                            <label for="deleted" class="col-sm-2 control-label">{{trans('adminlabels.formlblstatus')}}</label>
                            <div class="col-sm-6">
                                <?php $staus = Helpers::status(); ?>
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/product') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')
<script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>


<script type="text/javascript">
                                    CKEDITOR.replace('p_description');
                                    jQuery(document).ready(function () {
                                        var preOrder = $("#p_pre_order").val();
                                        if(preOrder == 1)
                                        {
                                            $('.pre_order_date_class').show();
                                        }
                                        else{
                                            $('.pre_order_date_class').hide();
                                        }
                                        
                                        jQuery.validator.addMethod("emptyetbody", function (value, element) {

                                            var p_description_data = CKEDITOR.instances['p_description'].getData();
                                            return p_description_data != '';
                                        }),
                                        $('.onlyNumber').on('keyup', function () {
                                            this.value = this.value.replace(/[^0-9]/gi, '');
                                        });
                                        $('.number').keypress(function (event) {
                                            var $this = $(this);
                                            if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                                                    ((event.which < 48 || event.which > 57) &&
                                                            (event.which != 0 && event.which != 8))) {
                                                event.preventDefault();
                                            }

                                            var text = $(this).val();
                                            if ((event.which == 46) && (text.indexOf('.') == -1)) {
                                                setTimeout(function () {
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

                                        $('.onlyNothing').on('keyup', function () {
                                            this.value = this.value.replace(/[^a-z]/gi, '');
                                        });

                                        $("#p_pre_order").change(function () {
                                                   if(this.value == 1){
                                                       $('.pre_order_date_class').show();
                                                   }
                                                   else
                                                   {
                                                       $('.pre_order_date_class').hide();
                                                   }
                                                });

                                        jQuery.noConflict();
                                        jQuery("#p_pre_order_date").datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            dateFormat: 'yy-mm-dd',
                                            minDate: 0, // 0 days offset = today


                                        }).on('change', function () {
                                            $(this).valid();
                                        });

<?php if (isset($productDetail->id) && $productDetail->id != '0') { ?>
                                            var adminvalidationRules = {
                                                p_sku: {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 30
                                                },
                                                p_title: {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 60
                                                },
                                                p_price: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                p_voucher: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                p_quantity: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                p_description: {
                                                    required: true,
                                                },
                                                p_category_id: {
                                                    required: true,
                                                },
                                                p_condition: {
                                                    required: true,
                                                },
                                                p_delivery_method: {
                                                    required: true,
                                                },
                                                p_platform: {
                                                    required: true,
                                                },
                                                p_pre_order: {
                                                    required: true,
                                                },
                                                p_pre_order_date: {
                                                    required: true,
                                                },
                                                p_region: {
                                                    required: true,
                                                },
                                                deleted: {
                                                    required: true
                                                }
                                            }
<?php } else { ?>
                                            var adminvalidationRules = {
                                                p_sku: {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 30
                                                },
                                                p_title: {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 60
                                                },
                                                p_price: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                p_voucher: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                p_quantity: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                p_description: {
                                                    required: true,
                                                },
                                                p_category_id: {
                                                    required: true,
                                                },
                                                pi_image_name: {
                                                    required: true,
                                                },
                                                p_condition: {
                                                    required: true,
                                                },
                                                p_delivery_method: {
                                                    required: true,
                                                },
                                                p_platform: {
                                                    required: true,
                                                },
                                                p_pre_order: {
                                                    required: true,
                                                },
                                                p_pre_order_date: {
                                                    required: true,
                                                },
                                                p_region: {
                                                    required: true,
                                                },
                                                deleted: {
                                                    required: true
                                                }
                                            }
<?php } ?>

                                        $("#addProduct").validate({
                                            rules: adminvalidationRules,
                                            messages: {
                                                p_sku: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>",
                                                },
                                                p_title: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_price: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_voucher: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_quantity: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_description: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_category_id: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_condition: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_delivery_method: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_platform: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_pre_order: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_pre_order_date:{
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                p_region: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                pi_image_name: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                deleted: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                }
                                            }
                                        });
                                    });
                                    function getDataOfSubCategory(CategoryId)
                                    {
                                        $("#p_subcategory_id").empty();
                                        $.ajax({
                                            type: 'GET',
                                            url: '/getSubCategory/' + CategoryId,
                                            dataType: "JSON",
                                            success: function (JSON) {

                                                $("#p_subcategory_id").empty()
                                                $("#p_subcategory_id").append($("<option>Product sub category</option>").val("0"))
                                                for (var i = 0; i < JSON.length; i++) {
                                                    $("#p_subcategory_id").append($("<option></option>").val(JSON[i].id).html(JSON[i].pc_title))
                                                }
                                            }
                                        });
                                    }
//                                    $(".productPhoto").change(function (e) {
//                                        var ext = this.value.match(/\.(.+)$/)[1];
//                                        switch (ext)
//                                        {
//                                            case 'jpg':
//                                            case 'bmp':
//                                            case 'png':
//                                            case 'jpeg':
//                                            case 'JPG':
//                                            case 'JPEG':
//
//                                                break;
//                                            default:
//                                                alert('Image type not allowed');
//                                                this.value = '';
//                                        }
//                                    });


</script>

@stop

