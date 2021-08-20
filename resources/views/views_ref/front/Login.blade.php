<!DOCTYPE html>
<html>
    <head>
        <title>VW</title>
        <meta charset="utf-8">
        <meta  http-equiv="X-UA-Compatible" content="IE=edge">   
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('frontend/css/bootstrap-material-design.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/ripples.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('frontend/css/material-design-iconic-font.css') }}">
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    </head>
    <body>
        <div class="top_bar"></div><!-- top_bar -->
        <div class="login_main">
            <div class="container">
                <div class="login_header_logo">
                    <a href="{{url('/')}}"> <img src="{{ asset('frontend/images/login_logo.png') }}" align="logo" class="img-responsive"></a>
                </div><!-- login_header_logo End -->
                <div class="content-wrapper">
                    <div class="login_content">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">
                                <form id="login_form" role="form" method="POST" class="login_form" action="{{ url('/logincheck') }}" autocomplete="off">
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
                                        <div class="col-md-12" >
                                            <div class="box-body">
                                                <div class="alert alert-error alert-danger">
                                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
                                                    <h4><i class="icon fa fa-check"></i> {{trans('validation.errorlbl')}}</h4>
                                                    {{ $message }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="login_inner">
                                        <h2>Login</h2>
                                        <div class="login_from">
                                            <div class="form-group label-floating is-empty">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                <label for="fu_email" class="control-label">Email</label>
                                                <input type="text" class="form-control" id="fu_email" name="email"  value="{{$email}}"" minlength="3" maxlength="50"/>
                                            </div>
                                            <div class="form-group label-floating is-empty">
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                                <label for="i5i" class="control-label">Password</label>
                                                <input type="password" minlength="6" maxlength="30" id="password" value="{{$password}}" name="password"  class="form-control">
                                            </div>
                                            <div class="clearfix">
                                                <a href="/signup" class="new_user">New user? Register now!</a>
                                                <a href="#" class="forgot_pass"  data-toggle="modal" data-target="#myModal">Forgot your password?</a>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"  name="remember" id="remember"> Remember me
                                                    </label>
                                                </div>
                                            </div>
                                        </div><!-- login_from End -->
                                        <div class="login_socila">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-4 col-sm-12">
                                                    <div class="face_book">
                                                        <a href="{{url('/facebook')}}">
                                                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">Sign in with facebook</button>
                                                            <i class="fa fa-facebook left"></i>
                                                        </a>
                                                    </div><!-- face_book End -->
                                                </div><!-- col-md-4 col-sm-4 col-sm-12 End -->
                                                <div class="col-md-4 col-sm-4 col-sm-12">
                                                    <div class="face_book goo_gle">
                                                        <a href="{{url('/google')}}">
                                                        <button type="button" class="btn btn-lg btn-gplus waves-effect waves-light">Sign in with Google</button>
                                                            <i class="fa fa-google-plus left"></i>
                                                        </a>                                                        
                                                    </div><!-- face_book End -->
                                                </div><!-- col-md-4 col-sm-4 col-sm-12 End -->
                                                <div class="col-md-4 col-sm-4 col-sm-12">
                                                    <div class="face_book login_btn">
                                                        <button type="submit"  class="btn btn-lg btn-fb waves-effect waves-light">Login</button>                                                    
                                                        <i class=""></i>
                                                    </div><!-- face_book End -->
                                                </div><!-- col-md-4 col-sm-4 col-sm-12 End -->
                                            </div><!-- row End -->
                                        </div><!-- login_socila End -->
                                    </div><!-- login_inner End -->
                                </form>
                            </div><!-- col-md-8 col-sm-12 col-xs-12 End -->
                        </div><!--  row End -->
                    </div><!-- login_content End -->

                </div><!-- container End -->
            </div><!-- login_main End -->
            <div class="copyright_main login_footer">
                <div class="container">
                    <p><i class="fa fa-copyright" aria-hidden="true"></i> VOUCHER WINS | All Right Reserved</p>
                </div><!-- container End -->
            </div><!-- copyright_main End -->
            <div class="modal fade forgotpass_modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                            </div>
                            <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
                            <div class="modal-body">
                                <div class="form-group label-floating is-empty">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <label for="i5i" class="control-label">Email</label>
                                    <input type="email" name="email" id="fu_email1"  onfocus="hidetext(this)" class="form-control">
                                    <span style="color:red" id="reset_validation">  </span>
                                    <span style="color:green" id="success">  </span>
                                    <span style="color:red" id="notexit">  </span>
                                </div></div>
                            <div class="modal-footer">
                                <button type="button" onclick="getEmail();" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.content-wrapper -->
        <!-- End buy voucher popup -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery-ui.js') }}"></script>
        <script src="{{ asset('frontend/js/material.min.js') }}"></script>
        <script src="{{ asset('frontend/js/ripples.js') }}"></script>
        <script src="{{ asset('frontend/js/main.js') }}"></script>




        <script type="text/javascript">


                                    jQuery(document).ready(function () {
                                        $.ajaxSetup({
                                            headers:
                                                    {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                                        });
                                        var loginRules = {
                                            email: {
                                                required: true,
                                                email: true
                                            },
                                            password: {
                                                required: true,
                                                minlength: 6,
                                                maxlength: 20
                                            }
                                        };
                                        $("#login_form").validate({
                                            rules: loginRules,
                                            messages: {
                                                email: {required: '<?php echo trans('validation.emailrequired') ?>'
                                                },
                                                password: {required: '<?php echo trans('validation.passwordrequired') ?>',
                                                    maxlength: 'Password maximum range is 20',
                                                    minlength: 'Password length is minimum 6'
                                                }
                                            }
                                        });

                                    });

                                    function getEmail() {
                                        var email = $("#fu_email1").val();
                                        if (!email)
                                        {

                                            $("#reset_validation").text('This is required field.');

                                            return false;
                                        }
                                        if (email.length < 6)
                                        {
                                            $("#reset_validation").text('Email Address must be at least 6 characters');
                                            return false;
                                        }
                                        var emailReg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/;
                                        if (emailReg.test(email) == false)
                                        {

                                            $("#reset_validation").text('Invalid Email Address.');
                                            return false;
                                        }

                                        $.ajax({
                                            type: 'POST',
                                            url: '/forgotPasswordOTP/' + email,                                                                                                                                  
                                             error: function (response)
                                            {             
                                                $("#notexit").text('Email does not exist.');                                                                                           									   
                                            },
                                            success: function () {

                                                $("#success").text('Your Reset Password was Succesfully send.Please check your Email Address for Reset Password.');
                                            }   
                                            
                                        });

                                    }

        </script>
        <script>
            function hidetext(x) {
                $("#reset_validation").hide();
            }
            
            
        </script>   

    </body>
</html>