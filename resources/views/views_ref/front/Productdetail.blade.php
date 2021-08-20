@extends('front.Master')

@section('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/css/star-rating.css') }} ">
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="live_auction_running">
    <div class="container">
        <div class="col-md-6 col-sm-6 col-xs-12"  id="success" style="background-color: green;"></div>
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">

        </div>
@if (Auth::admin()->check())
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

                @yield('content')
            </div><!-- /.content-wrapper -->
            @else
            @yield('content')
            @endif

        <div class="product_detail_cont">
            {{ $productDetail['p_title']}}
        </div><!-- product_detail_cont End -->

        <div class="live_auction_content no_live_acution_view">
            <div class="live_auction_running_blog">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="live_auction_running_slider no_live_acu_slider">
                            <div class="li_acu_slider_content">
                                <div id="sync1" class="owl-carousel">

                                    @if(isset($images) && !empty($images))
                                    @foreach($images as $key => $image)
                                    <div class="item">
                                        <img src="{{ asset($imagePath.$image->pi_image_name)}}" alt="live_auction_slider" class="img-responsive">
                                    </div>
                                    @endforeach 
                                    @endif


                                </div>
                                <div id="sync2" class="owl-carousel">
                                    @if(isset($images) && !empty($images))
                                    @foreach ($images as $key => $image)
                                    <div class="item">
                                        <img src="{{ asset($thumbimagePath.$image->pi_image_name)}}" alt="live_auction_slider" class="img-responsive">
                                    </div>
                                    @endforeach 
                                    @endif

                                </div>
                            </div><!-- li_acu_slider_content End -->
                        </div><!-- live_auction_running_slider End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                    <div class="col-md-8 col-sm-8 col-xs-12">   
                        <div class="product_voucher">
                            <div class="total_product_voucher">
                                #{{ $productDetail['p_voucher'] }}<span> Voucher</span>
                            </div><!-- total_product_voucher End -->
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="buy_and_save">


                                        @if (Auth::front()->check()) 
                                        
                                        
                                        <form class="form-horizontal" method="post" action="{{ url('/saveaddcart') }}" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">                                            
                                            <input type="hidden" name="product_id" value="{{$p_id}}">
                                            <input type="hidden" name="product_amount" value="{{$productDetail['p_voucher']}}">
                                            <button  type="submit" class="add_vou">Add to cart</button>
                                        </form>
                                        
                                        @if(isset($ItemAlredySaved) && $ItemAlredySaved == 1)
                                        <form class="form-horizontal" method="post" action="{{ url('/saveitem') }}" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">                                            
                                            <input type="hidden" name="product_id" value="{{$p_id}}">                                            
                                            <button  id="hidesaveitem" class="add_vou">Save item</button>  
                                        </form>
                                       @else
                                       @endif
                                       @if(isset($AlreadyRequestedAction) && $AlreadyRequestedAction == 1) 
                                       <form class="form-horizontal" method="post" action="{{ url('/saveRequestAction') }}" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">                                            
                                            <input type="hidden" name="product_id" value="{{$p_id}}">                                            
                                            <button  id="hiderequestAction" class="add_vou">Request for Auction</button>  
                                        </form>
                                       @else
                                       @endif
                                        @else
                                        <a href="javascript:void(0)" class="add_vou">Add to cart</a>
                                        <a href="javascript:void(0)" class="add_vou">Save item</a>
                                        <a href="javascript:void(0)" class="add_vou">Request for Auction</a>


                                        @endif   

                                        <span>
                                            <a href="#">
                                                <img src="{{asset('/frontend/images/add-to-favorite_pro.png')}}" alt="add-to-favorite" class="img-responsive">
                                            </a>
                                        </span>
                                    </div><!-- buy_and_save End -->
                                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="product_detail_revi">
                                        <div class="read_write_content">
                                            <div class="read_write_inner">
                                                <span>
                                                    <!--<i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star-half"></i>-->
                                                    <input id="combineRating" name="combineRating" class="product_rating" value="{{$reviewSumProductWise}}" class="rating-loading">
                                                    <div>( {{$totalNumberOfReviews}} )</div>
                                                </span>
                                                <p><a href="#reviewDiv">Read Reviews</a>   
                                                    @if (Auth::front()->check())

                                                    | <a href="#"  data-toggle="modal" data-target="#comment-popup">Write Review</a></p>
                                                @endif
                                            </div><!-- read_write_inner End -->
                                            <div class="live_auc_social">
                                                <ul>
                                                    <li>
                                                        <div class="like_box"><i class="zmdi zmdi-thumb-up"></i><span>{{$facebookPageFollowerCount}}</span> </div><!-- like_box End -->
                                                        <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                                                    </li>
                                                    <li>
                                                        <div class="like_box"><span>{{$twitterFollowerCount}}</span> </div><!-- like_box End -->
                                                        <a href="#"><i class="zmdi zmdi-twitter"></i></a>
                                                    </li>
                                                    <li>
                                                        <div class="like_box"><span>{{$googlePlusFollowerCount}}</span> </div><!-- like_box End -->
                                                        <a href="#"><i class="zmdi zmdi-google-plus"></i></a>
                                                    </li>
                                                </ul>
                                            </div><!-- live_auc_social End -->
                                        </div>
                                    </div><!-- product_detail_revi End -->
                                </div><!-- col-md-8 col-sm-8 col-xs-12 End -->
                            </div><!-- row End -->
                            
                        </div><!-- product_voucher End -->
                    </div> <!-- col-md-8 col-sm-8 col-xs-12 End -->
                    <div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        
                        <div class="live_auction_tabing">
                           
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active in item_region clearfix" id="current">
                                    <h3>Item Description:</h3>
                                    <p>{!! $productDetail['p_description'] !!}</p>
                                </div>
                                
                                
                            </div>
                        </div><!-- live_auction_tabing End -->
                    </div><!-- col-md-8 col-sm-8 col-xs-12 End -->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item_region">
                            <h2>Item Region</h2>
                            @if($productDetail['p_region'] ==1)
                            <img src="{{ asset('/frontend/images/regionfree.png') }}" alt="regionfree">
                            <p>Region Free</p>
                            @elseif($productDetail['p_region'] ==2)
                            <img src="{{ asset('/frontend/images/usa.png') }}" alt="North America">
                            <p>North America</p>
                            @elseif($productDetail['p_region'] ==3)
                            <img src="{{ asset('/frontend/images/european.png') }}" alt="european">
                            <p>European Union</p>
                            @else
                            <p>N/A</p>
                            @endif
                        </div><!-- item_region End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="live_add_infor">
                            <h2>Additional information:</h2>
                            <ul>
                                <li> Condition : {{ $productDetail['p_condition'] }}</li>
                                <li> Platform  : {{ $productDetail['p_platform'] }}</li>
                                <li> Delivery Method : @if($productDetail['p_delivery_method'] == 1) <?php echo "Courier Delivery";  ?> @else  <?php echo "Email Delivery";  ?> @endif</li>
                                <li> Item Return Policy</li>
                                
                            </ul>
                        </div><!-- live_add_infor End -->
                    </div><!-- col-md-12 End -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="reviewDiv" class="live_add_infor cst_customer_review">
                            <h2>Customer Reviews on Item:</h2>
                            <div class="read_write_inner">

                               	<span>
<!--                                    <i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star-half"></i>-->
                                    <input id="combineRating" name="combineRating" class="product_rating" value="{{$reviewSumProductWise}}" class="rating-loading">
                                    <div>( {{$totalNumberOfReviews}} )</div>
                                </span>
                                <p>
                                    {{ $reviewSumProductWise }} &nbsp; out of 5 stars
                                </p>
                            </div><!-- read_write_inner End -->
                            <div class="cst_all_review">
                                <div class="cst_cust_inner">
                                    <h3>Top Customer Reviews:</h3>
                                    @forelse($reviewDetail as $reviewDetails)
                                    <div class="read_write_inner">
                                        <span>
                                            <input id="separateRating" name="separateRating" class="product_rating" value="{{$reviewDetails->pr_rating}}" class="rating-loading">

<!--                                            <i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star-half"></i>-->
                                        </span>

                                        <p>By {{$reviewDetails->fu_first_name}} {{$reviewDetails->fu_last_name}} <span><!-- TOP 1000 REVIEWER --> </span>on {{ date('M j, Y',strtotime($reviewDetails->created_at)) }}</p>
                                        <p>{{$reviewDetails->pr_review}} </p>
                                    </div><!-- read_write_inner End -->
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div><!-- live_add_infor End -->
                    </div><!-- col-md-12 End -->
                </div><!-- row End -->

                <div class="vw_advertisement_footer">
                    <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">

                </div>  
            </div><!-- container End -->
        </div><!-- live_auction_running End -->
    </div>
        <form id="p_addComment">
            <div class="modal fade forgotpass_modal refer_modal" id="comment-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="vertical-alignment-helper">
                    <div class="modal-dialog vertical-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Comment:</h4>
                                <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <input id="p_rating" name="p_rating" type="text"  class="rating rating-loading" value="" data-size="xl" title="">
                                    <span style="color:red" id="reset_rating">  </span>
                                    <textarea id="p_comment_box" name="p_comment_box" onfocus="hideComment()" class="form-control" rows="10" ></textarea>
                                    <span style="color:red" id="reset_review">  </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="submit" type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
        @stop


        @section('script')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
        <script src="{{ asset('frontend/js/star-rating.js')}}"></script>
        <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('frontend/js/material.min.js') }}"></script>

        <script type="text/javascript">
                                        $(document).ready(function () {

                                            $.material.options.autofill = true
                                            var sync1 = $("#sync1");
                                            var sync2 = $("#sync2");

                                            sync1.owlCarousel({
                                                singleItem: true,
                                                slideSpeed: 1000,
                                                navigation: true,
                                                pagination: false,
                                                afterAction: syncPosition,
                                                responsiveRefreshRate: 200,
                                                autoPlay: true,
                                                navigationText: [
                                                    "<i class='icon-chevron-left icon-white'></i>",
                                                    "<i class='icon-chevron-right icon-white'></i>"
                                                ]
                                            });

                                            sync2.owlCarousel({
                                                items: 15,
                                                itemsDesktop: [1199, 10],
                                                itemsDesktopSmall: [979, 10],
                                                itemsTablet: [768, 8],
                                                itemsMobile: [479, 4],
                                                pagination: false,
                                                responsiveRefreshRate: 100,
                                                afterInit: function (el) {
                                                    el.find(".owl-item").eq(0).addClass("synced");
                                                }
                                            });

                                            function syncPosition(el) {
                                                var current = this.currentItem;
                                                $("#sync2")
                                                        .find(".owl-item")
                                                        .removeClass("synced")
                                                        .eq(current)
                                                        .addClass("synced")
                                                if ($("#sync2").data("owlCarousel") !== undefined) {
                                                    center(current)
                                                }
                                            }

                                            $("#sync2").on("click", ".owl-item", function (e) {
                                                e.preventDefault();
                                                var number = $(this).data("owlItem");
                                                sync1.trigger("owl.goTo", number);
                                            });

                                            function center(number) {
                                                var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
                                                var num = number;
                                                var found = false;
                                                for (var i in sync2visible) {
                                                    if (num === sync2visible[i]) {
                                                        var found = true;
                                                    }
                                                }

                                                if (found === false) {
                                                    if (num > sync2visible[sync2visible.length - 1]) {
                                                        sync2.trigger("owl.goTo", num - sync2visible.length + 2)
                                                    } else {
                                                        if (num - 1 === -1) {
                                                            num = 0;
                                                        }
                                                        sync2.trigger("owl.goTo", num);
                                                    }
                                                } else if (num === sync2visible[sync2visible.length - 1]) {
                                                    sync2.trigger("owl.goTo", sync2visible[1])
                                                } else if (num === sync2visible[0]) {
                                                    sync2.trigger("owl.goTo", num - 1)
                                                }

                                            }

                                            $('.product_rating').rating({displayOnly: true, step: 0.5});

                                            $.ajaxSetup({
                                                headers:
                                                        {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                                            });
                                            // send add record Ajax call request to YourResponse.php 

                                            $("#submit").click(function () {
                                                var review = $('#p_comment_box').val();
                                                var rating = $('#p_rating').val();
                                                var flag;
                                                if (rating < 1)
                                                {
                                                    $("#reset_rating").text('Rating required field.');
                                                    flag = false;
                                                }
                                                if (!review)
                                                {
                                                    $("#reset_review").text('Review is required field.');
                                                    flag = false;
                                                }
                                                if (flag == false)
                                                {
                                                    return false;
                                                }

<?php if (Auth::front()->check()) { ?>
                                                    var userid = <?php echo Auth::front()->get()->id; ?>;
<?php } ?>
                                                var productid = <?php echo $p_id; ?>;
                                                var dataString = 'review=' + review + '&userid=' + userid + '&productid=' + productid + '&rating=' + rating; //build a post data structure
                                                $.ajax({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    type: "post", // HTTP method POST or GET
                                                    url: "{{url('insertreview')}}", //PHP Page where all your query will write
                                                    data: dataString, //Form Field values
                                                    success: function () {
                                                        window.location.reload(true);
                                                    }
                                                });
                                            });

                                        });

                                        function requestAction() {
                                        <?php if (Auth::front()->check()) { ?>
                                                var userid = <?php echo Auth::front()->get()->id; ?>;
                                         <?php } ?>
                                            var productid = <?php echo $p_id; ?>;

                                            $.ajax({
                                                type: 'POST',
                                                url: '/saveRequestAction/' + userid + '/' + productid,
                                                success: function () {

                                                    $("#success").text('You Are Successfully Send Request Auction for This Item.');
                                                    window.location.reload(true);

                                                }

                                            });

                                        }
                                                        function hideComment() {
                                                        $("#reset_review").hide();
                                                        }


                                                        $("#p_rating").rating().on("rating.change", function () {
                                                        $("#reset_rating").hide();
                                                        });



        </script>
        @stop  

