@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.productimage')}}
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
                    <h3 class="box-title"><?php echo (isset($productDetail) && !empty($productDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.productimage')}}</h3>
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

                <form id="addProduct" class="form-horizontal" method="post" action="{{ url('/admin/saveproductimage')}}/{{$productId}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php if(isset($id)) echo $id; ?>">
                   
                    <input type="hidden" name="hidden_profile" value="<?php echo (isset($productImageDetail) && !empty($productImageDetail)) ? $productImageDetail['0']['pi_image_name'] : '' ?>">

                    <div class="box-body">

                        
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/image') }}/{{$productId}}">{{trans('adminlabels.cancelbtn')}}</a>
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


<script type="text/javascript">

jQuery(document).ready(function () {

    $('.onlyNumber').on('keyup', function () {
        this.value = this.value.replace(/[^0-9]/gi, '');
    });


<?php if (isset($productDetail->id) && $productDetail->id != '0') { ?>
        var adminvalidationRules = {
           pi_image_name: {
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
            pi_image_name: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            deleted: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            }
        }
    });



});

$(".productPhoto").change(function (e) {
    var ext = this.value.match(/\.(.+)$/)[1];
    switch (ext)
    {
        case 'jpg':
        case 'bmp':
        case 'png':
        case 'jpeg':
            break;
        default:
            alert('Image type not allowed');
            this.value = '';
    }
});


</script>

@stop

