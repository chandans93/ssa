@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.slider')}}
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
                     <h3 class="box-title"><?php echo (isset($sliderDetail) && !empty($sliderDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.slider')}}</h3>
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

                <form id="addslider" class="form-horizontal" method="post" action="{{ url('/admin/saveslider') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($sliderDetail) && !empty($sliderDetail)) ? $sliderDetail->id : '0' ?>">
                    <div class="box-body">

                        <?php
                        if (old('hps_image'))
                            $hps_image = old('hps_image');
                        elseif ($sliderDetail)
                            $hps_image = $sliderDetail->hps_image;
                        else
                            $hps_image = '';

                         if (old('hps_redirection_link'))
                            $hps_redirection_link = old('hps_redirection_link');
                        elseif ($sliderDetail)
                             $hps_redirection_link = $sliderDetail->hps_redirection_link;
                        else
                            $hps_redirection_link = '';

                        if (old('hps_display_status'))
                            $hps_display_status = old('hps_display_status');
                        elseif ($sliderDetail)
                             $hps_display_status = $sliderDetail->hps_display_status;
                        else
                            $hps_display_status = '';
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($sliderDetail)
                            $deleted = $sliderDetail->deleted;
                        else
                            $deleted = '';
                        ?>
                        <div class="form-group">
                            <label for="hps_image" class="col-sm-2 control-label">{{trans('adminlabels.formlblimage')}}</label>
                            <div class="col-sm-6">
                                <input type="file" value="{{$hps_image}}" name="hps_image" id="hps_image" class="sliderPhoto" accept=".png, .jpg, .jpeg, .bmp,.JPEG,.JPG">
                               <?php
                                    if(isset($sliderDetail->id) && $sliderDetail->id != '0'){
                                        if(File::exists(public_path($ThumbPath.$sliderDetail->hps_image)) && $sliderDetail->hps_image != '') { ?><br>
                                            <img src="{{ url($ThumbPath.$sliderDetail->hps_image) }}" alt="{{$sliderDetail->hps_image}}" >
                                        <?php }else{ ?>
                                        <img src="{{ asset('/backend/images/avatar5.png')}}" class="user-image" alt="Default Image" height="<?php echo Config::get('constant.SLIDER_ADMIN_IMAGE_HEIGHT');?>" width="<?php echo Config::get('constant.SLIDER_ADMIN_IMAGE_WIDTH');?>">
                                <?php   }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hps_redirection_link" class="col-sm-2 control-label">{{trans('adminlabels.link')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" id="hps_redirection_link" name="hps_redirection_link" placeholder="{{trans('adminlabels.formlbllink')}}" value="{{$hps_redirection_link}}" maxlength="100" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="displayStatus" class="col-sm-2 control-label">{{trans('adminlabels.displayStatus')}}</label>
                            <div class="col-sm-6">
                                <select  name="hps_display_status" id="hps_display_status" class="form-control" required>
                                <?php $displayStatus = Helpers::displayStatus(); ?>
                                <?php foreach ($displayStatus as $key => $value) { ?>
                                    <option value="{{$key}}" <?php if($hps_display_status == $key) echo 'selected'; ?> >{{$value}}</option>
                                <?php } ?>

                                </select>
                            </div>
                        </div>
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/slider') }}">{{trans('adminlabels.cancelbtn')}}</a>
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
    <?php if (isset($sliderDetail->id) && $sliderDetail->id != '0') { ?>
            var adminvalidationRules = {
               hps_redirection_link : {
                    required : true
                },
                hps_display_status : {
                    required : true
                },
                deleted : {
                    required : true
                }
            }
    <?php } else { ?>
         var adminvalidationRules = {
               hps_redirection_link : {
                    required : true
                },
                hps_image: {
                   required : true 
                },
                hps_display_status : {
                    required : true
                },
                deleted : {
                    required : true
                }
            }
<?php } ?>
        $("#addslider").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                hps_redirection_link : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                hps_display_status : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                hps_image: {
                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                },
                deleted : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
//            $(".sliderPhoto").change(function (e) {
//                var ext = this.value.match(/\.(.+)$/)[1];
//                switch (ext)
//                {
//                    case 'jpg':
//                    case 'bmp':
//                    case 'png':
//                    case 'jpeg':
//                        break;
//                    default:
//                        alert('Image type not allowed');
//                        this.value = '';
//                }
//            });
</script>


@stop

