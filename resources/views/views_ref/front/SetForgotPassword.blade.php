<!DOCTYPE html>
<html>
    <head>
        <title>VW</title>
        <meta charset="utf-8">
        <meta  http-equiv="X-UA-Compatible" content="IE=edge">           
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('frontend/css/bootstrap-material-design.css')}}" rel="stylesheet">
        <link href="{{ asset('frontend/css/ripples.css')}}" rel="stylesheet">
        <link href="stylesheet" src="{{ asset('frontend/css/material-design-iconic-font.css')}}">
        <link href="{{ asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet" >
        <link href="{{ asset('frontend/css/style.css')}}" rel="stylesheet" >


    </head>
    <body>
        <div class="top_bar"></div><!-- top_bar -->
        <div class="login_main">
            <div class="container">
                <div class="login_header_logo">
                    <img src="{{ asset('frontend/images/login_logo.png')}}"  align="logo" class="img-responsive">
                </div><!-- login_header_logo End -->
                <div class="login_content">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">
                            <form class="registration_form" method="POST" id="new_password_form" action="{{url('/saveForgotPassword')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="{{$id}}" />
                                <div class="login_inner">

                                    <div class="login_from">
                                        <h2>Please Set Your New Password</h2>
                                        <div class="form-group label-floating is-empty">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                            <label for="i5i" class="control-label">password</label>
                                            <input type="password" class="form-control" name="new_password" id="new_password" minlength="6" maxlength="20">
                                        </div>
                                        <div class="form-group label-floating is-empty">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                            <label for="i5i" class="control-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" minlength="6" maxlength="20"/>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-default">Submit</button>
                                        </div>   

                                    </div><!-- login_from End -->

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

        <!-- End buy voucher popup -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="{{ asset('frontend/js/material.min.js')}}"></script>
        <script src="{{ asset('frontend/js/ripples.js')}}" ></script>
        <script src="{{ asset('frontend/js/main.js')}}"></script>
        <!-- backendLTE App -->
        <script src="{{ asset('backend/js/app.min.js')}}"></script>        
        <script src="{{ asset('backend/js/jquery.validate.min.js') }}"></script>
        <!-- Datepicker --> 
        <script src="{{ asset('backend/js/jquery-ui.js') }}"></script>
        <script type="text/javascript">


jQuery(document).ready(function () {

    var loginRules = {
        new_password: {
            required: true,
            minlength: 6,
            maxlength: 20
        },
         confirm_password: {
            required: true,
            minlength: 6,
            maxlength: 20,
            equalTo: '#new_password'
        }
    };
    $("#new_password_form").validate({
        rules: loginRules,
        messages: {
            new_password: {required: '<?php echo trans('validation.passwordrequired') ?>',
                maxlength: 'Password maximum range is 20',
                minlength: 'Password length is minimum 6'
            },
             confirm_password: {required: '<?php echo trans('validation.passwordrequired') ?>',
                equalTo: "<?php echo trans('validation.passwordnotmatch'); ?>",
                maxlength: 'Password maximum range is 20',
                minlength: 'Password length is minimum 6'
            }
        }
    });

});

        </script>


    </body>
</html>