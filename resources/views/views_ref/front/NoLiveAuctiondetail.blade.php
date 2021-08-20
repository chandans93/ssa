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
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="live_auction_content no_live_acution_view">
            <div class="live_auction_running_header">
                <h2>NO LIVE AUCTION CURRENLTY RUNNING</h2>      
            </div><!-- live_auction_running_header End -->
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
                                <p class="rece_vouch">Recently sold for 40 Vouchers, 104 Vouchers</p>
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
                        <div class="no_live_acution_content">
                            
                            <h2>{{ $productDetail['p_title'] }}</h2>
                           
                            
                            <h3>{{ $productDetail['p_condition'] }}</h3>
                            <ul>
                                <li>
                                    <?php $product = Helpers::getProductid(); ?>
                                    <?php foreach ($product as $key => $value) { ?>
                                        <?php if ($productDetail['p_category_id'] == $value->id) echo $value->pc_title; ?>
                                    <?php } ?>
                                </li>
                                <li>{{ $productDetail['p_platform'] }}</li>
                                <li>@if($productDetail['p_pre_order'] == 1) <?php echo "This Item Is Not Instock"; ?> @else  <?php echo "This Item Is Instock"; ?> @endif </li>
                                <li>@if($productDetail['p_delivery_method'] == 1) <?php echo "Courier Delivery"; ?> @else  <?php echo "Email Delivery"; ?> @endif</li>
                            </ul>
                            <a href="{{url('/product')}}">View in Store</a>
                        </div><!-- no_live_acution_content End -->
                    </div> <!-- col-md-8 col-sm-8 col-xs-12 End -->
                    
                            
                </div><!-- row End -->
                <div class="request_auction_cont clearfix">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="request_auction_img">
                                        <img src="/frontend/images/request_auction_img.png" alt="request_auction_img" class="">
                                        <p>Request Auction</p>
                                    </div><!-- request_auction_img End -->
                                </div><!-- col-md-2 col-sm-2 col-xs-12 End -->
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <div class="request_auction_blog">
                                        <p>
                                            ( User clicking on images will careate a STAT  in backend for management to see how many user reqest for item to be auctioned.  User 
                                            clicking on images will careate a STAT  in backend for management to see how many user reqest for item to be auctioned. )
                                        </p>
                                    </div><!-- request_auction_blog End -->
                                </div><!-- col-md-10 col-sm-10 col-xs-12 End -->
                            </div><!-- row End -->
                            <div class="read_write_content">
                                <div class="read_write_inner">
                                    <span>
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
                                            <div class="like_box"><i class="zmdi zmdi-thumb-up"></i><span>43</span> </div><!-- like_box End -->
                                            <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                                        </li>
                                        <li>
                                            <div class="like_box"><span>0</span> </div><!-- like_box End -->
                                            <a href="#"><i class="zmdi zmdi-twitter"></i></a>
                                        </li>
                                        <li>
                                            <div class="like_box"><span>0</span> </div><!-- like_box End -->
                                            <a href="#"><i class="zmdi zmdi-google-plus"></i></a>
                                        </li>
                                    </ul>
                                </div><!-- live_auc_social End -->
                            </div>
                        </div><!-- col-md-12 col-sm-12 col-xs-12 End -->
                    </div><!-- request_auction_cont End -->
                </div><!-- live_auction_running_blog End -->
            </div><!-- live_auction_content End -->
            <div class="live_auction_container">
                <h2>Live Auctions</h2>
                <p>Their are currently no live auctions for this item.</p>
            </div><!-- live_auction_container End -->
            <div class="item_descri">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="item_descri_view">
                            <h2>Item Description:</h2>
                            <p>{!! $productDetail['p_description'] !!}</p>
                        </div><!-- item_descri_view End -->
                    </div><!-- col-md-8 col-sm-8 col-xs-12 End -->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item_region">
                            <h2>Item Region</h2>
                            @if($productDetail['p_region'] ==1)
                            <img src="{{ asset('/frontend/images/usa.png') }}" alt="usa">
                            <p>North America</p>
                            @elseif($productDetail['p_region'] ==2)
                            <img src="{{ asset('/frontend/images/regionfree.png') }}" alt="usa">
                            <p>Region Free</p>
                            @else
                            <img src="{{ asset('/frontend/images/european.png') }}" alt="usa">
                            <p>European Union</p>
                            @endif
                        </div><!-- item_region End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                </div><!-- row End --> 
            </div><!-- item_descri End -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="live_add_infor">
                        <h2>Additional information:</h2>
                        <ul>
                            <li>Item Condition :  {{ $productDetail['p_condition'] }}</li>
                            <li>Item Platform : {{ $productDetail['p_platform'] }}</li>
                            <li>Item Delivery Method : @if($productDetail['p_delivery_method'] == 1) <?php echo "Courier Delivery"; ?> @else  <?php echo "Email Delivery"; ?> @endif</li>
                            <li>Item Return Policy</li>
                            <li>People who viewed this item also viewed</li>
                        </ul>
                    </div><!-- live_add_infor End -->
                </div>
            </div><!-- row End -->
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
            <div class="vw_advertisement_footer">
                <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
            </div>  
        </div><!-- container End -->
    </div><!-- live_auction_running End -->
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

<?php if (Auth::front()->check()) { ?>
                                            var userid = <?php echo Auth::front()->get()->id; ?>;
<?php } ?>

                                        var productid = <?php echo $p_id; ?>;

                                        $.ajax({
                                            type: 'get',
                                            url: '/getRequestAction/' + userid + '/' + productid,
                                            success: function (response) {

                                                if (response == 1)
                                                {

                                                }
                                                if (response == 2)
                                                {
                                                    $("#hiderequestAction").hide();
                                                }

                                            }

                                        });

                                        $.ajax({
                                            type: 'get',
                                            url: '/getitem/' + userid + '/' + productid,
                                            success: function (response) {

                                                if (response == 1)
                                                {

                                                }
                                                if (response == 2)
                                                {
                                                    $("#hidesaveitem").hide();
                                                }

                                            }

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

                                    function saveItem() {
<?php if (Auth::front()->check()) { ?>
                                            var userid = <?php echo Auth::front()->get()->id; ?>;
<?php } ?>
                                        var productid = <?php echo $p_id; ?>;
                                        $.ajax({
                                            type: 'POST',
                                            url: '/saveitem/' + userid + '/' + productid,
                                            success: function () {

                                                $("#success").text('Your Item Successfully Saved.');
                                                window.location.reload(true);
                                            }

                                        });
                                    }

                                    function addCart() {
<?php if (Auth::front()->check()) { ?>
                                            var userid = <?php echo Auth::front()->get()->id; ?>;
<?php } ?>
                                        var productid = <?php echo $p_id; ?>;
                                        var CSRF_TOKEN = "{{ csrf_token() }}";
                                        $.ajax({
                                            type: 'POST',
                                            url: '/saveaddcart/' + userid + '/' + productid,
                                            dataType: 'html',
                                            headers: {
                                                'X-CSRF-TOKEN': CSRF_TOKEN
                                            },
                                            data: {
                                                "atcp_quantity": 1,
                                            },
                                            success: function (response) {

                                                $("#success").text('Your Item Successfully Add In Cart.');
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

