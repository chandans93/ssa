<!DOCTYPE html>
<html>
    <head>
        <title>VW</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="frontend/css/bootstrap-material-design.css" rel="stylesheet">
        <link href="frontend/css/ripples.css" rel="stylesheet">
        <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="frontend/css/font-awesome.min.css">
        <link rel="stylesheet" href="frontend/css/material-design-iconic-font.css">
        <link rel="stylesheet" href="frontend/css/style.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css')}}">


    </head>
    <body>
        <div class="login_main voucher_joinform">
            <div class="container">
                <div class="login_header_logo">
                    <a href="{{url('/')}}"><img src="frontend/images/login_logo.png" align="logo" class="img-responsive"></a>
                </div><!-- login_header_logo End -->
                <div class="login_content">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
                            <form id="user_registration_form"   method="POST" class="login_form" action="{{ url('/dosignup') }}" autocomplete="off">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="content-wrapper">
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

                                    @if ($message = Session::get('error'))
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box-body">
                                                <div class="alert alert-error alert-dismissable">
                                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
                                                    <h4><i class="icon fa fa-check"></i> {{trans('validation.errorlbl')}}</h4>
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
                                    <div class="login_inner">
                                        <h2>Join VoucherWins</h2>
                                        <div class="join_vwform login_from">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="delivery_information_from">
                                                        <?php
                                                        $fu_first_name = $fu_last_name = $fu_email = $password = '';
                                                        if (old('fu_first_name')) {
                                                            $fu_first_name = old('fu_first_name');
                                                        } else {
                                                            $fu_first_name = '';
                                                        }
                                                        ?> 
                                                        <div class="form-group label-floating is-empty">
                                                            <i class="zmdi zmdi-account-o"></i>
                                                            <label for="i5i" class="control-label">First Name</label>
                                                            <input type="text" class="form-control" id="fu_first_name" name="fu_first_name"  value="{{$fu_first_name}}" minlength="3" maxlength="30"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="delivery_information_from">
                                                        <?php
                                                        if (old('fu_last_name')) {
                                                            $fu_last_name = old('fu_last_name');
                                                        } else {
                                                            $fu_last_name = '';
                                                        }
                                                        ?> 
                                                        <div class="form-group label-floating is-empty">
                                                            <i class="zmdi zmdi-account-o"></i>
                                                            <label for="i5i" class="control-label">Last Name</label>
                                                            <input type="text" class="form-control" id="fu_last_name" name="fu_last_name"  value="{{$fu_last_name}}" minlength="3" maxlength="30"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="delivery_information_from">
                                                        <?php
                                                        if (old('fu_email')) {
                                                            $fu_email = old('fu_email');
                                                        } else {
                                                            $fu_email = '';
                                                        }
                                                        ?>     
                                                        <div class="form-group label-floating is-empty">
                                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                                            <label for="i5i" class="control-label">Email</label>
                                                            <input type="text" class="form-control" id="fu_email" name="fu_email" value="{{ $fu_email}}" minlength="3" maxlength="30"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="delivery_information_from">
                                                        <div class="form-group label-floating is-empty">
                                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                                            <label for="i5i" class="control-label">Confirm Email</label>
                                                            <input type="text" class="form-control" id="confirm_email" name="confirm_email"  minlength="3" maxlength="30"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="delivery_information_from">
                                                        <?php
                                                        if (old('password')) {
                                                            $password = old('password');
                                                        } else {
                                                            $password = '';
                                                        }
                                                        ?> 
                                                        <div class="form-group label-floating is-empty">
                                                            <i class="zmdi zmdi-lock"></i>
                                                            <label for="i5i" class="control-label">Password</label>
                                                            <input type="password" class="form-control" id="password" name="password"  value="" minlength="6" maxlength="30"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="delivery_information_from">
                                                        <div class="form-group label-floating is-empty">
                                                            <i class="zmdi zmdi-lock"></i>
                                                            <label for="i5i" class="control-label">Confirm Password</label>
                                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" minlength="6" maxlength="20"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- row -->
                                            <input type="hidden" class="form-control" id="deleted" name="deleted"  value="1" minlength="6" maxlength="30"/>
                                            <div class="vw_conditions">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="pv_total_voucher	" name = "pv_total_voucher" checked="checked" disabled="disabled">Yes!, I Want My 3 Free Vouchers Just For Signing Up!
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="fu_term_services" name = "fu_term_services">I read, understand, and accept the Terms of Service and Privacy Policy of VoucherWins.com
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="fu_age" name="fu_age">Yes, I am at least 13 years of age or older.
                                                        </label>
                                                        
                                                </div>
                                            </div><!-- vw_conditions End -->
                                            <div class="cst_submit">

                                                <button type="submit" class="btn btn-lg submit_btn waves-effect waves-light">Submit</button>
                                            </div><!-- cst_submit End -->
                                            <div class="terms_condtn">
                                                <ul>
                                                    <li><a href="#" data-toggle="modal" data-target="#policy"> @if(isset($privacyPolicy)) {{$privacyPolicy->cms_subject}} @endif</a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#terms">@if(isset($termsOfService)) {{$termsOfService->cms_subject}} @endif</a></li>
                                                </ul>
                                            </div>
                                        </div><!-- join voucher wins form End -->
                                    </div><!-- login_inner End -->
                                </div><!-- col-md-8 col-sm-12 col-xs-12 End -->
                            </form>
                        </div><!--  row End -->
                    </div><!-- login_content End -->

                </div><!-- container End -->
            </div><!-- login_main End -->
        </div>
            <div class="copyright_main login_footer">
                <div class="container">
                    <p><i class="fa fa-copyright" aria-hidden="true"></i> VOUCHER WINS | All Right Reserved</p>
                </div><!-- container End -->
            </div><!-- copyright_main End -->

            <div class="modal fade forgotpass_modal cst_terms" id="terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                            </div>
                            <h4 class="modal-title" id="myModalLabel">{{$termsOfService->cms_subject}}</h4>
                            <div class="modal-body">
                                <div class="terms_of_service">
                                    <p>@if(isset($termsOfService)){!! $termsOfService->cms_body !!}@endif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End terms of service popup -->
            <div class="modal fade forgotpass_modal cst_terms" id="policy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                            </div>
                            <h4 class="modal-title" id="myModalLabel">{{$privacyPolicy->cms_subject}}</h4>
                            <div class="modal-body">
                                <div class="terms_of_service">
                                    <p>@if(isset($privacyPolicy)){!! $privacyPolicy->cms_body !!}@endif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End privacy policy popup -->
                
             <script src="{{ asset('frontend/js/app.min.js')}}"></script>
            
            <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>            
            <script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
            <script src="frontend/js/material.min.js"></script>
            <script src="frontend/js/ripples.js"></script>
            <script src="frontend/js/main.js"></script>
            <!-- backendLTE App -->
           <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
            <script type="text/javascript">

jQuery(document).ready(function () {
    
    var form = $("#user_registration_form");
<?php if (isset($userDetail->id) && $userDetail->id != '0') { ?>
        var adminvalidationRules = {
            fu_email: {
                required: true,
                email: true
            },
            fu_first_name: {
                required: true,
            },
            fu_last_name: {
                required: true
            },
            confirm_email: {
                required: true,
                email: true
            },
            fu_term_services: {
                required: true
            },
            fu_age: {
                required: true
            },
        }
<?php } else { ?>
        var adminvalidationRules = {
            fu_email: {
                required: true,
                email: true
            },
            password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: '#password'
            },
            fu_first_name: {
                required: true,
            },
            fu_last_name: {
                required: true
            },
            confirm_email: {
                required: true,
                equalTo: '#fu_email'
            },
            fu_term_services: {
                required: true
            },
            fu_age: {
                required: true
            },
        }
<?php } ?>

    $("#user_registration_form").validate({
        rules: adminvalidationRules,
        messages: {
            fu_email: {
                required: "<?php echo trans('validation.requiredfield'); ?>",
                email: "<?php echo trans('validation.validemail'); ?>"
            },
            password: {
                required: "<?php echo trans('validation.requiredfield'); ?>"
            },
            confirm_password: {
                required: "<?php echo trans('validation.requiredfield'); ?>",
                equalTo: "<?php echo trans('validation.passwordnotmatch'); ?>"
            },
            fu_first_name: {
                required: "<?php echo trans('validation.requiredfield'); ?>"
            },
            fu_last_name: {
                required: "<?php echo trans('validation.requiredfield'); ?>"
            },
            confirm_email: {
                required: "<?php echo trans('validation.requiredfield'); ?>",
                equalTo: "<?php echo trans('validation.emailnotmatch'); ?>"
            },
            fu_term_services: {
                required: "<?php echo trans('validation.termservicesrequiredfield'); ?>"
            },
            fu_age: {
                required: "<?php echo trans('validation.agerequiredfield'); ?>"
            },
        }
    });
});
            </script>

    </body>

</html>