@extends('front.Master')
@section('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">
@stop
@section('content')
<div class="slider_main">
    <div class="container">
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
        <div id="owl-demo" class="owl-carousel owl-theme">
            @if(isset($allSlider) && !empty($allSlider))
            @foreach($allSlider as $Sliders)
            <a href="{{$Sliders->hps_redirection_link}}" target="blank"> <div class="item"><img src="{{ $path}}{{$Sliders->hps_image}}"></div></a>
            @endforeach
            @endif 
        </div> 
    </div><!-- Container End -->
</div><!-- slider_main End -->
<div class="vw_gallery_main">
    <div class="container">
        <div class="vw_gall_content">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="vw_advertisement">
                        <img src="{{ asset('/frontend/images/advertisement.jpg') }}" alt="advertisement">
                    </div><!-- vw_advertisement End --> 
                </div><!-- col-md-2 col-sm-2 col-xs-12 End -->
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="vw_gall_box clearfix">
                        @if (Auth::front()->check())
                        <div class="vw_box_small cst_35">
                            <div class="vw_box_img  sign_up_bg">
                                <a href="{{ asset('editprofile')}}">
                                    <img src="{{ asset('/frontend/images/my_profile.png') }}" alt="sign_up">
                                    <span>My Profile</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        @else
                        <div class="vw_box_small cst_35">
                            <div class="vw_box_img  sign_up_bg">
                                <a href="{{url('/signup')}}">
                                    <img src="{{ asset('/frontend/images/sign_up.png') }}" alt="sign_up">
                                    <span>Sign up</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        @endif
                        <div class="vw_box_small cst_65">
                            <div class="vw_box_img  my_account">
                                <a href="javascript:void(0)">
                                    <img src="{{ asset('/frontend/images/my_account.png') }}" alt="my_account">
                                    <span>My Account</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_large cst_65">
                            <div class="vw_box_img play_arcade">
                                <a href="{{url('/game')}}">
                                    <img src="{{ asset('/frontend/images/play_arcade.png') }}" alt="play_arcade">
                                    <span>Play Arcade and Earn!</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_small cst_35">
                            <div class="vw_box_img  live_action">
                                <a href="{{url('/auction')}}">
                                    <img src="{{ asset('/frontend/images/live_auctions.png') }}" alt="live_auctions">
                                    <span>Live Auctions</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_small cst_35">
                            <div class="vw_box_img buy_now_store">
                                <a href="{{url('/product')}}">
                                    <img src="{{ asset('/frontend/images/buy_now_store.png') }}" alt="buy_now_store">
                                    <span>Store</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_small cst_65">
                            <div class="vw_box_img my_rewards">
                                <a href="javascript:void(0)">
                                    <img src="{{ asset('/frontend/images/my_rewards.png') }}" alt="my_rewards">
                                    <span>My Rewards</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_small cst_65">
                            <div class="vw_box_img forum">
                                <a href="{{url('/forum')}}">
                                    <img src="{{ asset('/frontend/images/forum.png') }}" alt="forum">
                                    <span>Forum</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_small cst_35">
                            <div class="vw_box_img news">
                                <a href="{{url('/news') }}">
                                    <img src="{{ asset('/frontend/images/news.png') }}" alt="news">
                                    <span>News</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_large cst_35">
                            <div class="vw_box_img purchase">
                                <a href="#" data-toggle="modal" data-target="<?php if(Auth::front()->check()) { echo "#buy_coins"; } else { echo ""; } ?> ">
                                    <img src="{{ asset('/frontend/images/purchase.png') }}" alt="purchase">
                                    <span>Purchase Coins</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                        <div class="vw_box_small cst_65">
                            <div class="vw_box_img voucher">
                                <a href="#"  data-toggle="modal" data-target="<?php if(Auth::front()->check()) { echo "#buy_voucher"; } else { echo ""; } ?> ">
                                    <img src="{{ asset('/frontend/images/voucher.png') }}" alt="voucher">
                                    <span>Purchase Vouchers</span>
                                </a>
                            </div><!-- vw_box_img End -->
                        </div><!-- vw_box_large End -->
                    </div><!-- vw_gall_box End -->
                </div><!-- col-md-8 col-sm-8 col-xs-12 End -->
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="vw_advertisement">
                        <img src="{{ asset('/frontend/images/advertisement_1.jpg') }}" alt="advertisement">
                    </div><!-- vw_advertisement End --> 
                </div><!-- col-md-2 col-sm-2 col-xs-12 End -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="vw_advertisement_footer">
                        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
                    </div><!-- vw_advertisement_footer End -->
                </div><!-- col-md-12 End -->
            </div><!-- row End -->
        </div><!-- vw_gall_content End -->
        <div class="popular_auction_content">
            <h2>popular products and auctions</h2>
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-3 col-sm-4">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->
                            <div class="popular_auction_btn">
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                                <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                            </div><!-- popular_auction_btn End -->
                        </div><!-- doc_popular_auction_box End -->
                    </div><!-- doc_popular_auction End -->
                </div><!-- col-md-3 col-sm-3 End -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="vw_advertisement_footer">
                        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
                    </div><!-- vw_advertisement_footer End -->
                </div>
            </div><!-- row End -->
        </div><!-- popular_auction_content End -->
        <div class="mobi_auctions">
            <h2>Auctions</h2>
            <div id="mobi_auctions" class="owl-carousel owl-theme">
                <div class="item">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->

                        </div><!-- doc_popular_auction_box End -->
                        <div class="popular_auction_btn">
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                        </div><!-- popular_auction_btn End -->
                    </div>
                </div>
                <div class="item">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->

                        </div><!-- doc_popular_auction_box End -->
                        <div class="popular_auction_btn">
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                        </div><!-- popular_auction_btn End -->
                    </div>
                </div>
                <div class="item">
                    <div class="doc_popular_auction">
                        <div class="doc_popular_auction_box clearfix">
                            <h2>Product Title</h2>
                            <div class="products_img_cont">
                                <img src="{{ asset('/frontend/images/live_auction.jpg') }}" alt="live_auction">
                            </div><!-- products_img_cont End -->
                            <div class="products_sub_cont">
                                <lable class="sub_cont_vauchers">
                                    107 Vouchers
                                </lable><!-- sub_cont_vauchers End -->
                                <lable class="sub_cont_time">
                                    00 : 00 : 10
                                </lable><!-- sub_cont_time End -->
                                <lable class="sub_cont_lat_bidder">
                                    last bidder
                                </lable><!-- sub_cont_lat_bidder End -->
                                <lable class="sub_cont_not">
                                    Not Met
                                </lable><!-- sub_cont_not End -->
                            </div><!-- products_sub_cont End -->

                        </div><!-- doc_popular_auction_box End -->
                        <div class="popular_auction_btn">
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart</button>
                            <button type="button" class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button>
                        </div><!-- popular_auction_btn End -->
                    </div>
                </div>
            </div> 
        </div><!-- mobi_auctions End -->
        <div class="mobi_auctions">
            <h2>Popular Products</h2>
            <div id="mobi_popular" class="owl-carousel owl-theme">
                <div class="item">
                    <div class="popular_auction_box">
                        <img src="{{ asset('/frontend/images/popular_auction.jpg') }}" alt="popular_auction">
                    </div><!-- popular_auction_box End -->        
                </div>
                <div class="item">
                    <div class="popular_auction_box">
                        <img src="{{ asset('/frontend/images/popular_auction.jpg') }}" alt="popular_auction">
                    </div><!-- popular_auction_box End -->
                </div>
                <div class="item">
                    <div class="popular_auction_box">
                        <img src="{{ asset('/frontend/images/popular_auction.jpg') }}" alt="popular_auction">
                    </div><!-- popular_auction_box End -->
                </div>
            </div> 
        </div><!-- mobi_auctions End -->
    </div><!-- container End -->
</div><!-- vw_gallery_main End -->

<div class="modal fade forgotpass_modal buy_coinspopup buy_vouchr" id="buy_voucher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal_bg">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Buy Vouchers</h4>
                        <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('/frontend/images/close.png')}}" alt="close"></button>
                        <div class="reward_point">
                            <div class="reward_inner">
                                <h3>Reward Point Redemption</h3>
                                <ul>
                                    <li>
                                        <img src="{{ asset('/frontend/images/gift.png')}}" class="img-responsive">
                                    </li>
                                    <li class="rw_point">
                                        <p>500</p>
                                    </li>
                                    <li class="enter_rw">
                                        <input type="text">
                                    </li>
                                    <li class="reedem_btn">
                                        <button type="button" class="btn btn-lg submit_btn waves-effect waves-light">Redeem</button>
                                    </li>
                                </ul>
                                <p>Note: Must enter increments of 25 Reward Points</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="coin_main">
                            <ul>
                                @forelse($buyVoucherDetails as $buyVoucherDetail)
                                <li>
                                    <div class="coin_inner">
                                        <div class="coin_left">
                                            <span class="ws_coin"><p>was</p> <hr/>400,000</span>
                                            <span class="plus_coin">+{{$buyVoucherDetail->v_discount}}%</span>
                                        </div>
                                        <div class="coin_right">
                                            <span class="total_coin">{{$buyVoucherDetail->v_pack}}</span>
                                            <a href="{{ url('payment')}}/{{$buyVoucherDetail->id}}/voucher"><span class="coin_value">${{$buyVoucherDetail->v_price}}.00</span></a>
                                        </div>
                                    </div>
                                    <!--                                    <div class="best_value">
                                                                            <img src="{{ asset('/frontend/images/best_value.png')}}" alt="best_value" class="img-responsive">
                                                                        </div>-->

<!--                                    <div class="best_value"><img src="{{ asset('/frontend/images/most_popular.png')}}" alt="most_popular" class="img-responsive"></div>-->

                                </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="payment_cards">
                            <ul class="clearfix">
                                <li><a href="#"><img src="{{ asset('/frontend/images/secure_payment.png')}}" alt="secure_payment"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/ssl.png')}}" alt="ssl"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/paypal.png')}}" alt="paypal"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/master_card.png')}}" alt="master_card"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/visa_card.png')}}" alt="visa_card"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/american_exp.png')}}" alt="american_exp"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/discover.png')}}" alt="discover"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Buy Coin Popup-->

<div class="modal fade forgotpass_modal buy_coinspopup" id="buy_coins" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal_bg">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Buy Coins</h4>
                        <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('/frontend/images/close.png')}}" alt="close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="coin_main">
                            <ul>
                                @forelse($buyCoinsDetails as $buyCoinsDetail)
                                <li>
                                    <div class="coin_inner">
                                        <div class="coin_left">
                                            <span class="ws_coin"><p>was</p> <hr/>400,000</span>
                                            <span class="plus_coin">+{{$buyCoinsDetail->c_discount}}%</span>
                                        </div>
                                        <div class="coin_right">
                                            <span class="total_coin">{{$buyCoinsDetail->c_coins}}</span>
                                            <a href="/payment/{{$buyCoinsDetail->id}}/coin"><span class="coin_value">${{$buyCoinsDetail->c_price}}.00</span></a>
                                        </div>
                                    </div>
                                    <!--                                    <div class="best_value">
                                                                            <img src="{{ asset('/frontend/images/best_value.png')}}" alt="best_value" class="img-responsive">
                                                                            
                                                                        </div>
                                                                          <div class="best_value"><img src="{{ asset('/frontend/images/most_popular.png')}}" alt="most_popular" class="img-responsive"></div>-->
                                </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="payment_cards">
                            <ul class="clearfix">
                                <li><a href="#"><img src="{{ asset('/frontend/images/secure_payment.png')}}" alt="secure_payment"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/ssl.png')}}" alt="ssl"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/paypal.png')}}" alt="paypal"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/master_card.png')}}" alt="master_card"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/visa_card.png')}}" alt="visa_card"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/american_exp.png')}}" alt="american_exp"></a></li>
                                <li><a href="#"><img src="{{ asset('/frontend/images/discover.png')}}" alt="discover"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@stop

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
<script>

$(document).ready(function () {
    $("#owl-demo").owlCarousel({
        autoPlay: true,
        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        pagination: true,
        paginationSpeed: 400,
        singleItem: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ]
    });
    $("#mobi_auctions").owlCarousel({
        autoPlay: true,
        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        pagination: false,
        paginationSpeed: 400,
        singleItem: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ]
    });
    $("#mobi_popular").owlCarousel({
        autoPlay: true,
        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        pagination: false,
        paginationSpeed: 400,
        singleItem: true,
        navigationText: [
            "<i class='icon-chevron-left icon-white'></i>",
            "<i class='icon-chevron-right icon-white'></i>"
        ]
    });
});
</script>
@stop