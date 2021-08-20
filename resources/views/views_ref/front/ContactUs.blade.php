@extends('front.Master')

@section('content')

<div class="contact_us">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="alien_ufo_header">
            <h2>Contact Us</h2>
        </div>
        <form id="contact_us" name="contact_us" method="post" action="{{ url('contactmail')}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="contact_content">
                
                @if ($message = Session::get('success'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
                                <h4><i class="icon fa fa-check"></i> {{trans('validation.successlbl')}}</h4>
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @if (count($errors) > 0)
                                     <div class="alert alert-danger">
                                        <strong>{{trans('validation.whoops')}}</strong>{{trans('validation.someproblems')}}<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                
                @if (Auth::front()->check())
                    <?php $class = 'contact_with_login'; ?>
                @else
                    <?php $class = 'contact_without_login'; ?>
                @endif
                                    
                <div class="contact_content_inner {{$class}}">
                    <div class="contact_dropdown cont_drop_int">
                        <label>What can we help you with?</label>
                        <div class="delivery_dropdown">
                            <?php $staus = Helpers::contact_us_help(); //echo '<pre>'; print_r($staus);?>
                            <select id="helpOptions" class="dropdown" tabindex="9"  id="help" name="cn_help" data-settings='{"wrapperClass":"flat"}' >
                                @if (Auth::front()->check())
                                <?php foreach ($staus as $key => $value) { ?>
                                    <option value="{{$key}}" <?php if($key) { echo 'selected="selected"'; } ?> >{{$value}}</option>
                                <?php } ?>
                                @else
                                <option value="5">General Inquiry</option>
                                @endif

                            </select>
                        </div><!-- delivery_dropdown End -->
                    </div><!-- contact_dropdown End -->
                  
                    @if (Auth::front()->check())
                    
                    <?php $staus = Helpers::contact_us_help(); ?>
                    <?php foreach ($staus as $key => $value) { ?><?php if ($key == 5) { ?>

                            <div class="contact_dropdown hideForGeneral">
                                <label>Order No.</label>
                                <div class="delivery_dropdown">
                                    <?php $staus = Helpers::contact_us_order(); //echo '<pre>'; print_r($staus);?>
                                    <select class="dropdown" tabindex="9" id="order_no" name="cn_orderNo" data-settings='{"wrapperClass":"flat"}'>

                                        <?php foreach ($staus as $key => $value) { ?>
                                            <option value="{{$key}}" <?php if ($key) echo 'selected'; ?>>{{$value}}</option><?php } ?>

                                    </select>
                                </div><!-- delivery_dropdown End -->
                            </div><!-- contact_dropdown End --><?php
                        }
                    }
                    ?>
                    
                    
                    <div class="contact_dropdown hideForGeneral">
                        <label>Select issue</label>
                        <div class="delivery_dropdown">
                            <?php $staus = Helpers::contact_us_issue(); ?>
                            <select class="dropdown" tabindex="9" id="issue" name="cn_issue" data-settings='{"wrapperClass":"flat"}'>
                                <?php foreach ($staus as $key => $value) { ?>
                                    <option value="{{$key}}" <?php if ($key) echo 'selected'; ?>>{{$value}}</option><?php } ?>
                            </select>
                        </div><!-- delivery_dropdown End -->
                    </div><!-- contact_dropdown End -->
                   
                    @else
                    
                    <div class="inquiry_email showForGeneral">
                        <div class="delivery_information_from">
                            <div class="form-group label-floating is-empty cst_email">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <label for="i5i" class="control-label">Email</label>
                                <input type="email" class="form-control  onlyemail" id="em" name="cn_email">
                            </div>
                        </div>
                    </div>
                    
                    @endif

                    <div class="contact_dropdown">
                        <label>Attach image or document</label>
                        <div class="attach_file delivery_dropdown">
                            <input type='file' class="filetomail" id="imgInp" name="cn_image" accept=".png, .jpg, .jpeg, .bmp,.JPEG,.JPG,.pdf,.doc,.docx,.xlsx,.xls,.csv,.txt"  />
                            <div id="user_img" class="comp_pro_user_btn" name="user_img">
                                Browse
                            </div><!-- comp_pro_user_btn End -->
                        </div>
                    </div><!-- contact_dropdown End -->
                    <!-- contact_content_inner End -->

                    <p>Please provide any additional details about your order issue and a customer support specialist will respond back to you within one business day. </p>

                    <div class="commentbox showForGeneral">
                        <textarea class="form-control comment_text cont_are_box" rows="7"  id="address" name="cn_commentbox"></textarea>
                    </div>

                </div>
                <div class="contact_us_btns">
                    <button type="submit" class="btn btn-default" >Submit<div class="ripple-container"></div></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="myFunction()">Reset<div class="ripple-container"></div></button>
                </div>
            </div><!-- contact_content End -->
            </form>
    </div>
</div>

@stop

@section('script')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script>
    function myFunction() {
        document.getElementById("contact_us").reset();
    }



    $('#helpOptions').on('change', function () {
        if (this.value == 5)
        {
            $('.hideForGeneral').hide();
            $('.showForGeneral').show();
        } else {
            $('.showForGeneral').hide();
            $('.hideForGeneral').show();
        }
    });

    $(document).ready(function () {
        var num = $('#helpOptions').val();
        if (num == 5)
        {
            $('.hideForGeneral').hide();
            $('.showForGeneral').show();
        } else {
            $('.showForGeneral').hide();
            $('.hideForGeneral').show();
        }
        
        var adminvalidationRules = {
                cn_help : {
                    required : true
                }
	};
            
        $("#contact_us").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                cn_help : {
                    required : "<?php echo trans('adminvalidation.requiredfield'); ?>"
                }
            }
        })
    });
    <input type='file' id="imgInp" name="cn_image" accept=".png, .jpg, .jpeg, .bmp,.JPEG,.JPG,.pdf,.doc,.docx"  />
    $(".filetomail").change(function (e) {
                var ext = this.value.match(/\.(.+)$/)[1];
                switch (ext)
                {
                    case 'jpg':
                    case 'bmp':
                    case 'png':
                    case 'jpeg':
                    case 'JPEG':
                    case 'JPG':
                    case 'PDF':
                    case 'doc':
                    case 'docx':
                    case 'xlsx':
                    case 'xls':
                    case 'csv':
                    case 'txt':
                        break;
                    default:
                        alert('File not allowed');
                        this.value = '';
                }
            });
    $('.onlyemail').on('keyup', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9._@]/gi,'');
    });
</script>
<script src="{{ asset('frontend/js/material.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>


@stop