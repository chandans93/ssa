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

        <center><div id="favorite_game" style="color:green;font-size:20px;"> </div></center>
        <div class="product_detail_cont">
            {{ $gameDetail['g_title']}}
            
        </div><!-- product_detail_cont End -->

        <div class="live_auction_content no_live_acution_view">
            <div class="live_auction_running_blog">
                <div class="row">
                     
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <img src="{{ asset($thumbimagePath.$gameDetail->g_photo)}}" alt="live_auction_slider" class="img-responsive">
                        <div class="live_auction_running_slider no_live_acu_slider">
                            <div class="li_acu_slider_content">
                                <div id="sync1" class="owl-carousel">
                                </div>

                            </div><!-- li_acu_slider_content End -->
                        </div><!-- live_auction_running_slider End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                    <div class="col-md-8 col-sm-8 col-xs-12">   
                        <div class="product_voucher">
                            <div class="total_product_voucher">
                                #{{ $gameDetail['g_coin'] }}<span> Coin</span>
                            </div><!-- total_product_voucher End -->
                            <div class="row">  
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="buy_and_save">


                                        @if (Auth::front()->check()) 
                                        <button   onclick="playgame();"  data-toggle="modal"  data-target=".order_popup" class="add_vou">PLAY GAME</button>
                                        @if($response == 0)
                                        <div id="favorite_game_class">
                                        <span>
                                            <a href="{{url('/savefavoritegame/')}}/{{$p_id}}">
                                                <img src="{{asset('/frontend/images/add-to-favorite_pro.png')}}" alt="add-to-favorite" class="img-responsive">
                                            </a>
                                        </span>
                                            </div>
                                        @else
                                        @endif
                                        @else
                                        <a href="javascript:void(0)" class="add_vou">PLAY GAME</a>
                                        <span>
                                            <a href="javascript:void(0)">
                                                <img src="{{asset('/frontend/images/add-to-favorite_pro.png')}}" alt="add-to-favorite" class="img-responsive">
                                            </a>
                                        </span>
                                        @endif   

                                        
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
                                                        <div class="like_box"><i class="zmdi zmdi-thumb-up"></i><span>43</span> </div><!-- like_box End -->
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
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="live_auction_tabing">

                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade active in item_region clearfix" id="current">
                                        <h3>Item Description:</h3>
                                        <p>{!! $gameDetail['g_description'] !!}</p>
                                    </div>


                                </div>
                            </div><!-- live_auction_tabing End -->
                        </div><!-- col-md-8 col-sm-8 col-xs-12 End -->

                    </div>

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
                                            <input id="separateRating" name="separateRating" class="product_rating" value="{{$reviewDetails->gr_rating}}" class="rating-loading">

<!--                                            <i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star"></i><i class="zmdi zmdi-star-half"></i>-->
                                        </span>

                                        <p>By {{$reviewDetails->fu_first_name}} {{$reviewDetails->fu_last_name}} <span><!-- TOP 1000 REVIEWER --> </span>on {{ date('M j, Y',strtotime($reviewDetails->created_at)) }}</p>
                                        <p>{{$reviewDetails->gr_review}} </p>
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
    
    <!-- your order popup  -->
<div class="modal fade order_popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal_close clearfix">
                    <img src="/frontend/images/modal_close.png" alt="modal_close" class="img-responsive" data-dismiss="modal">
                </div>
               
                </div>
                <div class="modal-body" id="data">
                    <div class="order_tabs">
                       
                        <div id="myTabContent" class="tab-content" >
                            <div class="tab-pane fade active in" id="home">
                                <div class="table-responsive" id="gameDetails">
                                    
                                </div>
                                 
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    @stop


    @section('script')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('frontend/js/star-rating.js')}}"></script>
    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/material.min.js') }}"></script>

    <script type="text/javascript">
                                    $(document).ready(function () {
                                        
                                         <?php if (Auth::front()->check()) { ?>
                                                var userid = <?php echo Auth::front()->get()->id; ?>;
                                          <?php }  else { ?>  var userid = <?php echo 0; }  ?>;
                                            var gametid = <?php echo $p_id; ?>;
                                        
                                         $.ajax({
                                                type: 'get',
                                                url: '/getfavoritegame/' + userid + '/' + gametid,
                                                success: function (response) {
                                                    
                                                    if (response == 2)
                                                    {
                                                        $("#favorite_game_class").hide();
                                                    }

                                                }

                                            });

                                       
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
                                          <?php } else { ?>  var userid = <?php echo 0;}  ?>
                                              
                                            var productid = <?php echo $p_id; ?>;
                                            var dataString = 'review=' + review + '&userid=' + userid + '&productid=' + productid + '&rating=' + rating; //build a post data structure
                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                type: "post", // HTTP method POST or GET
                                                url: "{{url('insertgamereview')}}", //PHP Page where all your query will write
                                                data: dataString, //Form Field values
                                                success: function () {
                                                    window.location.reload(true);
                                                }
                                            });
                                        });

                                    });
                                    function playgame() {
                                        
                                        <?php if (Auth::front()->check()) { ?>
                                        var userid = <?php echo Auth::front()->get()->id; ?>;
                                        <?php } ?>
                                        var gameid = <?php echo $p_id; ?>;
                                        
                                       var gamevoucher = <?php echo $gameDetail->g_coin; ?>;
                                        var CSRF_TOKEN = "{{ csrf_token() }}";
                                        $.ajax({
                                            type: 'POST',
                                            url: '/playgame',
                                            dataType: 'html',
                                            headers: {
                                                'X-CSRF-TOKEN': CSRF_TOKEN
                                            },
                                            data: {
                                                "gamevoucher": gamevoucher,
                                                "gameid" : gameid
                                            },
                                            success: function (response) {
                                                
                                                if(response == 0)
                                                {
                                                    
                                                    $("#gameDetails").html(response);
                                                    return false;
                                                }
                                                else
                                                {
                                                    
                                                    $("#gameDetails").html(response);
                                                }    
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

