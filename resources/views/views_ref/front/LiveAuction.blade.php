@extends('front.Master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/bootstrap-material-design.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/ripples.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/material-design-iconic-font.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/star-rating.css') }} ">
@stop

@section('content')
 
<div class="live_auction_running">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="live_auction_content">
            <div class="live_auction_running_header">
                <h2>LIVE AUCTION CURRENLTY RUNNING</h2>      
            </div><!-- live_auction_running_header End -->
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="live_auction_running_title">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <?php  
                                    $getProductname= Helpers::getProductDetailbyId($auctionDetail['au_product_id']);
                                    $getSubCategoryname = Helpers::getsubCategorybyId($getProductname['p_category_id']);
                                ?>
                                <h5><?php echo $getProductname['p_title'];?></h5>
                            </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <h5><?php echo $getSubCategoryname['pc_title'];?></h5>
                            </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <h5><?php echo $getProductname['p_platform'];?></h5>
                            </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                        </div><!-- row End -->
                    </div><!-- live_auction_running_title End -->
                </div><!-- col-md-8 col-sm-8 col-xs-12 End -->
                <div class="col-md-4 col-sm-4 col-xs-12"></div><!-- col-md-4 col-sm-4 col-xs-12 End -->
            </div><!-- row End -->
            <div class="live_auction_running_blog">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-md-12">
                                <div class="live_auction_running_slider">
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
                                <div class="read_write_content">
                                    <div class="read_write_inner">
                                        <span>
                                            <!--<i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star-half"></i>-->
                                            <input id="combineRating" name="combineRating" class="product_rating" value="{{$reviewSumProductWise}}" class="rating-loading">
                                            <div>( {{$totalNumberOfReviews}} )</div>
                                        </span>
                                        <p><a href="#reviewDiv">Read Reviews</a>   
                                            @if (Auth::front()->check())
                                            | <a href="#"  data-toggle="modal" data-target="#comment-popup">Write Review</a>
                                            @endif
                                        </p>
                                    </div><!-- read_write_inner End -->
                                    <div class="live_auc_social">
                                        <ul>
                                            <li>
                                                <div class="like_box"><i class="zmdi zmdi-thumb-up"></i><span> {{$facebookPageFollowerCount}} </span> </div><!-- like_box End -->
                                                <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                                            </li>
                                            <li>
                                                <div class="like_box"><span>{{$twitterFollowerCount}}</span> </div><!-- like_box End -->
                                                <a href="javascript:;"><i class="zmdi zmdi-twitter"></i></a>
                                            </li>
                                            <li>
                                                <div class="like_box"><span>{{$googlePlusFollowerCount}}</span> </div><!-- like_box End -->
                                                <a href="javascript:;"><i class="zmdi zmdi-google-plus"></i></a>
                                            </li>
                                        </ul>
                                    </div><!-- live_auc_social End -->
                                </div><!-- read_write_content End -->
                            </div><!-- col-md-5 col-sm-5 col-md-12 End -->
                            <div class="col-md-4 col-sm-4 col-md-12">
                                <div class="vouchers_bid_blog">
                                    @if (Auth::front()->check())
                                        <h2><?php echo $totalVoucher." Vouchers";?></h2>
                                    @endif
                                    <h4><div data-countdown="{{$auctionDetail['au_end_time']}}"></div></h4>
                                    <div class="bid_avta_img">
                                         @if (Auth::front()->check())
                                            <?php
                                                $userimage = Auth::front()->get()->fu_avatar;
                                                $imagepath = "";
                                                if(isset($userimage) && $userimage != ""){
                                                    $imagepath = Config::get('constant.USER_THUMB_IMAGE').$userimage;
                                                }else{
                                                     $imagepath = asset('/frontend/images/bid_avta_img.jpg');
                                                }
                                                
                                            ?>
                                            @else
                                                <?php $imagepath = asset('/frontend/images/bid_avta_img.jpg'); ?>
                                         @endif 
                                        <img src="<?php echo $imagepath; ?>" alt="bid_avta_img.jpg" class="img-responsive">
                                    </div><!-- bid_avta_img End -->
                                    <p>Highest Bidder:<span><?php if(isset($maxvoucher_detail['high_bid_user']) && $maxvoucher_detail['high_bid_user'] != "" ){echo $maxvoucher_detail['high_bid_user'];}else{echo "No name";}   ?></span></p>
                                    <a href="#"  data-toggle="modal" data-target="#bidnow-popup" id="bidmodel">Bid Now</a>
                                    <span>OR</span>
                                    <a href="#">Buy Now #209.9 Voucher</a>
                                </div><!-- vouchers_bid_blog End -->
                            </div><!-- col-md-5 col-sm-5 col-md-12 End -->

                        </div>

                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">   
                        <div class="row">  
                            <div class="col-md-12 col-sm-12 col-md-12">
                                <div class="bidding_activity_content">
                                    <h2>Bidding Activity</h2>
                                    <div class="bidding_activity_table">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>User</th>
                                                        <th>Vouchers</th>
                                                        <th>Bid Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if(!empty($biddingactivity)){ 
                                                        foreach($biddingactivity as $activity){ ?>
                                                        <tr>
                                                            <?php 
                                                                $user = Helpers::getUsername($activity->b_user_id);
                                                                $image = $user['fu_avatar'];
                                                                $imagepath = Config::get('constant.USER_THUMB_IMAGE').$image;
                                                            ?>
                                                            <td><img src="<?php echo $imagepath; ?>" alt="bidding" class="img-responsive"><?php echo $user['fu_first_name'];?></td>

                                                            <td><?php echo $activity->b_total_voucher; ?></td>
                                                            <td>Single Bid</td>
                                                         </tr>
                                                        <?php } 
                                                    }else {  
                                                    ?>
                                                    <tr>
                                                        <td><?php echo  "No bid activity";?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- bidding_activity_table  End -->
                                    <div class="bidding_voucher_viper">
                                        <div class="voucher_viper_btn">
                                            <h3>Voucher Viper</h3>
                                            <span class="of_vouchers">
                                                <a href="#">#of Vouchers</a>
                                                <span class="total_vou_equ">0</span>
                                            </span>
                                            <span class="total_vouchers">
                                                <a href="#">Start after total Vouchers bid equal</a>
                                                <span class="total_vou_equ">0</span>
                                            </span>    
                                        </div><!-- voucher_viper_btn End -->
                                        <div class="voucher_viper_active">
                                            <img src="{{ asset('/frontend/images/Voucher_Viper_Head_Only.png') }}" alt="Voucher_Viper_Head_Only" class="img-responsive">
                                            <a href="#" data-toggle="modal" data-target="#autobid-popup" id="autobidmodel">Activate</a>
                                        </div><!-- voucher_viper_active End -->
                                        <p><a href="#">Learn more about Bid-O-Matic...</a></p>
                                    </div><!-- bidding_voucher_viper End -->
                                </div><!-- bidding_activity_content End -->
                            </div><!-- col-md-5 col-sm-5 col-md-12 End -->
                        </div>
                    </div> 
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="live_auction_blog">
                            <h2>Live Auction</h2>
                        </div><!-- live_auction_blog End -->
                        <div class="live_auction_tabing">
                            <ul class="nav nav-tabs">
                                <li><a href="#current" data-toggle="tab">Current</a></li>
                                <!-- <li><a href="#live2" data-toggle="tab">Live 2</a></li>
                                <li><a href="#live3" data-toggle="tab">Live 3</a></li> -->
                                <li><a href="#live4" data-toggle="tab">Live 4</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active in" id="current">
                                    <h3>Item Description:</h3>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                </div>
                                <!-- <div class="tab-pane fade" id="live2">
                                    <h3>Item Description:</h3>
                                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                                </div>
                                <div class="tab-pane fade" id="live3">
                                    <h3>Item Description:</h3>
                                     <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork.</p>
                                </div> -->
                                <div class="tab-pane fade" id="live4">
                                    <div class="live_auction_list">
                                        <h2>Live Auctions</h2>
                                        @if(!empty($similarAuction))
                                            @foreach($similarAuction as $_similarAuction)
                                                <div class="auction_blog_list">
                                                  <?php if((!isset($_similarAuction['pi_image_name']) || $_similarAuction['pi_image_name']=='')) {
                                                      $_similarAuction['pi_image_name']='product_img.jpg';
                                                      $imagePath='frontend/images/';
                                                  } ?>
                                                  <div class="auction_img">
                                                    <img src="{{asset($imagePath.'/'.$_similarAuction['pi_image_name']) }}">
                                                  </div><!-- auction_img End -->
                                                  <div class="auction_content">
                                                    <h4><div data-countdown="{{$_similarAuction['au_start_time']}}"></div></h4>
                                                    <h5>$0.00</h5>
                                                    <span>@ 17:51 CDT</span>
                                                    <button>View Auction</button>
                                                  </div><!-- auction_content  -->  
                                                </div>
                                            @endforeach
                                        @else
                                            <span> No Auction Found </span>
                                        @endif
                                    </div><!-- live_auction_list End -->
                                </div>
                            </div>
                        </div><!-- live_auction_tabing End -->
                    </div><!-- col-md-8 col-sm-8 col-xs-12 End -->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item_region">
                            <h2>Item Region</h2>
                            <img src="{{ asset('/frontend/images/usa.png') }}" alt="usa">
                            <p>USA Only</p>
                        </div><!-- item_region End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="live_add_infor">
                            <h2>Additional information:</h2>
                            <ul>
                                <li>Item Condition</li>
                                <li>Item Platform</li>
                                <li>Item Delivery Method</li>
                                <li>Item Return Policy</li>
                                <li>People who viewed this item also viewed</li>
                            </ul>
                        </div><!-- live_add_infor End -->
                    </div><!-- col-md-12 End -->

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="reviewDiv" class="live_add_infor cst_customer_review">
                            <h2>Customer Reviews on Item:</h2>
                            <div class="read_write_inner">

                               	<span>
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
            </div><!-- live_auction_running_blog End -->
        </div><!-- live_auction_content End -->
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
                        <button id="submit" type="button" class="btn btn-default" data-value="<?php echo $auctionDetail['au_product_id'] ?>" data-dismiss="modal">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade forgotpass_modal refer_modal" id="bidnow-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Bid Now:</h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                </div>
                <div id="bid_display"></div>
                 
                <form id="frm_bidnow">
                    <?php if($auc_fees > 0 ) { ?><div style="color:red;"><h3>Auction Fees</h3><input type="hidden" id="auc_fees" value="<?php echo $auc_fees?>"/><?php echo $auc_fees; ?></div><?php } ?>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                           <input type="text" id="bid_price" name="bid_price" class="form-control" placeholder="Enter Voucher"/> 
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button id="bidnowsubmit" type="button" class="btn btn-default" data-value="<?php echo $auctionDetail['au_product_id']; ?>">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
<div class="modal fade forgotpass_modal refer_modal" id="autobid-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Auto Bid:</h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                </div>
                 <div id="autobid_message"></div>
                <form id="frm_bidnow">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                           <input type="text" id="autobid_price" name="autobid_price" class="form-control" placeholder="Enter Voucher"/> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="autobidsubmit" type="button" class="btn btn-default" data-value="" data-dismiss="modal">Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@stop

@section('script')
<script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
<script src="{{ asset('frontend/js/ripples.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/material.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/star-rating.js')}}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.countdown.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>

<script>
    function hideComment() {
        $("#reset_review").hide();
    }
    
    $(document).ready(function () {
        var CSRF_TOKEN = "{{ csrf_token() }}";

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
        
        // User Rating
        $('.product_rating').rating({displayOnly: true, step: 0.5});
        
        $("#p_rating").rating().on("rating.change", function () {
            $("#reset_rating").hide();
        });

        // Insert user Review
        $("#submit").click(function () {
            var review = $('#p_comment_box').val();
            var rating = $('#p_rating').val();
            var flag;
            if (rating < 1) {
                $("#reset_rating").text('Rating required field.');
                flag = false;
            }
            if (!review) {
                $("#reset_review").text('Review is required field.');
                flag = false;
            }
            if (flag == false) {
                return false;
            }

            <?php if (Auth::front()->check()) { ?>
                var userid = <?php echo Auth::front()->get()->id; ?>;
            <?php } ?>
            var productid = $(this).data('value');
            var dataString = 'review=' + review + '&userid=' + userid + '&productid=' + productid + '&rating=' + rating; //build a post data structure
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                type: "post", // HTTP method POST or GET
                url: "{{url('insertreview')}}", //PHP Page where all your query will write
                data: dataString, //Form Field values
                success: function () {
                    window.location.reload(true);
                }
            });
        });
        
        // Countdown timer jquery function
        $('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%D days %H:%M:%S'));
            });
        });

        $( "#bidmodel" ).click(function() {
            
            var userid=0;
            <?php if (Auth::front()->check()) { ?>
                 userid = <?php echo Auth::front()->get()->id; ?>;
            <?php } ?>
            if(userid==0){
                $("#bidnow-popup").modal();
                $("#bid_price").val("");
                $("#bid_display").addClass("alert alert-error alert-danger");
                $("#bid_display").html("Please login first");
                return false;
            }

        });

        $( "#autobidmodel" ).click(function() {
            
            var userid=0;
            <?php if (Auth::front()->check()) { ?>
                 userid = <?php echo Auth::front()->get()->id; ?>;
            <?php } ?>
            if(userid==0){
                $("#autobid_price").val("");
                $("#autobid_message").addClass("alert alert-error alert-danger");
                $("#autobid_message").html("Please login first");
                $("#autobid-popup").modal();  
                return false;
            }

        });


        //insert bid now price
        $("#bidnowsubmit").click(function () {

            var userid = 0;
            <?php if (Auth::front()->check()) { ?>
                 userid = <?php echo Auth::front()->get()->id; ?>;
            <?php } ?>

            if(userid == 0){
                $("#bid_price").val("");
                $("#bid_display").addClass("alert alert-error alert-danger");
                $("#bid_display").html("Please login first");
                $("#bidnow-popup").modal();    
                 //window.location = "<?php url()?>";
                return false;
            }
            var fees = $('#auc_fees').val();
                
            var auction_id = <?php echo $auctionDetail['id']?>;

            var price = $("#bid_price").val();

            var bid_type = <?php echo $auctionDetail['au_bid_type']; ?>;

            if(price == ""){
                 
                $("#bid_price").val("");
                $("#bid_display").addClass("alert alert-error alert-danger");
                $("#bid_display").html("Please enter price");
                $("#bidnow-popup").modal();    
                return false;
            }else{
            if(isNaN(price)){
                 
                $("#bid_price").val("");
                $("#bid_display").addClass("alert alert-error alert-danger");
                $("#bid_display").html("Please enter number only");
                $("#bidnow-popup").modal(); 
                return false;
                }
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                type: "POST", // HTTP method POST or GET
                url: "{{url('/insertbidnow')}}", //PHP Page where all your query will write
                data: {price:price,userid:userid,auction_id:auction_id,bid_type:bid_type,fees:fees}, //Form Field values
                success: function (data) {
                    console.log(data);//return false; 
                    if(data == 0){
                        $("#bid_price").val("");
                        $("#bid_display").addClass("alert alert-success alert-dismissable");
                        $("#bid_display").html("Bid inserted successfully");
                        $("#bidnow-popup").modal();    
                        setTimeout(function(){
                          window.location = '/liveauction/' + auction_id;
                        }, 2000);
                        //window.location = '/liveauction/' + auction_id; 
                    }else if(data == "No sufficient balance in your account"){
                        /*alert(data);*/
                        $("#bid_price").val("");
                        $("#bid_display").addClass("alert alert-error alert-danger");
                        $("#bid_display").html("No sufficient balance in your account");
                        $("#bidnow-popup").modal();    
                    }
                    else{
                        var msg = "Please insert greater than this amount " + data ;
                        $("#bid_price").val("");
                        $("#bid_display").addClass("alert alert-error alert-danger");
                        $("#bid_display").html(msg);
                        $("#bidnow-popup").modal();  
                        //console.log(data);
                    }
                }
            });

        });

        $('#autobidsubmit').click(function(){ 

            var userid = 0;
            <?php if (Auth::front()->check()) { ?>
                 userid = <?php echo Auth::front()->get()->id; ?>;
            <?php } ?>

            if(userid == 0){
                $("#autobid_price").val("");
                $("#autobid_message").addClass("alert alert-error alert-danger");
                $("#autobid_message").html("Please login first");
                $("#autobid-popup").modal();  
                return false;
            }
                           
            var auction_id = <?php echo $auctionDetail['id']?>;

            var autobid_price = $('#autobid_price').val();

            var bid_type = <?php echo $auctionDetail['au_bid_type'];?>;

            var fees = $('#auc_fees').val();

            if(autobid_price == ""){
                $("#autobid_price").val("");
                $("#autobid_message").addClass("alert alert-error alert-danger");
                $("#autobid_message").html("Please enter price");
                $("#autobid-popup").modal(); 
                return false;
            }else{
                if(isNaN(autobid_price)){   
                    $("#autobid_price").val("");
                    $("#autobid_message").addClass("alert alert-error alert-danger");
                    $("#autobid_message").html("Please enter number only");
                    $("#autobid-popup").modal(); 
                    return false;
                }
            }

            if(autobid_price > 50){
                $("#autobid_price").val("");
                $("#autobid_message").addClass("alert alert-error alert-danger");
                $("#autobid_message").html("You can set upto 50 vouchers only");
                $("#autobid-popup").modal(); 
                return false;
            }

            $.ajax({
                     headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    type: "get", // HTTP method POST or GET
                    url: "{{url('/insertautobid')}}", //PHP Page where all your query will write
                    data: {autobid_price:autobid_price,userid:userid,auction_id:auction_id,bid_type:bid_type,fees:fees}, //Form Field values
                    success: function (data) {
                                console.log(data);
                                if(data == 0){
                                    alert("Autobid activate successfully");

                                    window.location = '/liveauction/' + auction_id; 
                                }else{
                                    alert("Please insert autobid greater than this voucher " +data);
                                }
                            }
            });

        });

    });
</script>

@stop

