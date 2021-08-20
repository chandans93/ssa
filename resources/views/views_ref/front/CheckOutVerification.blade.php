@extends('front.Master')
@section('css')
<link href="{{asset('/frontend/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@stop
@section('content')

        <div class="top_bar"></div><!-- top_bar -->
        <div class="login_main">
            <div class="container">
                <div class="login_header_logo">
                    
                </div><!-- login_header_logo End -->
                <div class="login_content">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">                            
                            <div class="login_inner">
                                <div class="login_from">
                                    <h3 class="header_text">Congratulation ! your Order has been placed successfully.</h3>
                                    
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
                
            </div><!-- container End -->
        </div><!-- copyright_main End -->
@stop