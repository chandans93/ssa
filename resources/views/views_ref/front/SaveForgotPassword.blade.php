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
                            <div class="login_inner">
                                <div class="login_from">
                                    <h3 class="header_text">Great! We just reset your password</h3>
                                    <center> <a href="{{ url('/login') }}"  class="btn btn-lg submit_btn waves-effect waves-light save_pass_web">Login<span></span></a></center>
                                </div><!-- login_from End -->
                            </div><!-- login_inner End -->
                            </form>
                        </div><!-- col-md-8 col-sm-12 col-xs-12 End -->
                    </div><!--  row End -->
                </div><!-- login_content End -->
                <a href="../../../public/frontend/sass/style.scss"></a>

            </div><!-- container End -->
        </div><!-- login_main End -->
        <div class="copyright_main login_footer">
            <div class="container">
                <p><i class="fa fa-copyright" aria-hidden="true"></i> VOUCHER WINS | All Right Reserved</p>
            </div><!-- container End -->
        </div><!-- copyright_main End -->

    </body>
</html>