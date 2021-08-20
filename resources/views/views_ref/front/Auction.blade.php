@extends('front.Master')
@section('content')

<div class="game_arcade_container">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
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

        <div class="game_arcade_selected cst_product">
            <div class="row">
                <form action="auction" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown new_select">
                                <?php
                                if (old('p_category_id')) {
                                    $p_category_id = old('p_category_id');
                                } else if (!empty($searchParamArray)) {
                                    $p_category_id = $searchParamArray['p_category_id'];
                                } else {
                                    $p_category_id = '';
                                }
                                ?>
                                <?php $product = Helpers::getProductid(); ?>
                                <select class="select" id="p_category_id" name="p_category_id" onchange="getDataOfSubCategory(this.value)">
                                    <option value="0">Category</option>
                                    <?php foreach ($product as $value) { ?>
                                        <option value="{{$value->id}}" <?php if (!empty($searchParamArray) && $value->id == $searchParamArray['p_category_id']) { ?> selected <?php } ?>> {{$value->pc_title}}</option>
                                    <?php } ?>
                                </select>
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown new_select">
                                <?php
                                if (old('p_subcategory_id')) {
                                    $p_subcategory_id = old('p_subcategory_id');
                                } else if (!empty($searchParamArray)) {
                                    $p_subcategory_id = $searchParamArray['p_subcategory_id'];
                                } else {
                                    $p_subcategory_id = '';
                                }
                                ?>  
                                <?php $product = Helpers::getSubCategory($p_category_id); ?>
                                <select class="select" id="p_subcategory_id" name="p_subcategory_id">
                                    <option value="0">Sub Category</option>
                                    <?php
                                    if (isset($product) && !empty($product)) {
                                        foreach ($product as $value) {
                                            ?>
                                            <option value="{{$value->id}}" <?php if (!empty($searchParamArray) && $value->id == $searchParamArray['p_subcategory_id']) { ?> selected <?php } ?>>{{$value->pc_title}}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
                    <?php $searchkeyword = (!empty($searchParamArray) && $searchParamArray['searchkeyword'] != '') ? $searchParamArray['searchkeyword'] : ''; ?>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="game_arcade_search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchkeyword" id="usr" value="<?php echo $searchkeyword; ?>" placeholder="Search by keyword">
                            </div>
                        </div><!-- game_arcade_search End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->

                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown new_select search_btn_prod">
                                <select class="select" id="searchby" name="searchby" >
                                    <?php $productOption = Helpers::productOption(); ?>
                                    <?php
                                    $searchby = (!empty($searchParamArray) && $searchParamArray['searchby'] != '') ? $searchParamArray['searchby'] : 1;
                                    if (isset($productOption) && !empty($productOption)) {
                                        foreach ($productOption as $key => $value) {
                                            ?>
                                            <option value="{{$key}}" <?php if ($key == $searchby) { ?> selected <?php } ?>>{{$value}}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <button type="submit" value="Search" name="search">Search</button>
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
                </form>
            </div><!-- row End -->
        </div><!-- game_arcade_selected End -->
        <div class="product_main">
            <div class="row">
                @if(isset($auctionDetail)&&!empty($auctionDetail))
                @foreach($auctionDetail as $key => $_auctionDetail)

                    @if($_auctionDetail['au_status'] == 3)
                    <div class="col-md-4 col-sm-4" id="<?php echo $_auctionDetail['id']; ?>">
                        <div class="doc_popular_auction" >
                            <input type="hidden" id="auction_Id" value="<?php echo $_auctionDetail['id']; ?>"/>
                            <input type="hidden" id="live" value="1">
                            <div class="doc_popular_auction_box clearfix">
                                <div class="pd_title" > 
                                    <h2>{{ $_auctionDetail['p_title'] }}</h2>
                                    <input type="hidden" id="auc_title" value="<?php echo $_auctionDetail['p_title'];?>">
                                    <div>
                                        <span class="live_auction">
                                            <span class="live_auction_inner"></span>
                                        </span>
                                    </div>
                                     
                                </div>
                                <div class="product_desc clearfix">
                                    <div class="products_img_cont">
                                        @if((!isset($_auctionDetail['pi_image_name']) || $_auctionDetail['pi_image_name']==''))
                                        <?php
                                        $_auctionDetail['pi_image_name'] = 'product_img.jpg';
                                        $imagePath = 'frontend/images/'
                                        ?>
                                        @endif
                                        <img src="{{asset($imagePath.'/'.$_auctionDetail['pi_image_name']) }}"  alt="product_img" class="img-responsive">
                                        <input type="hidden" id="image_name" value="{{asset($imagePath.'/'.$_auctionDetail['pi_image_name']) }}">
                                        <input type="hidden" id="prooduct_Id" value="<?php echo $_auctionDetail["au_product_id"];?>">
                                    </div><!-- products_img_cont End -->
                                    <div class="products_sub_cont" id="liveProductDiv">
                                        <label class="product_auctn">
                                            Live Auction
                                        </label><!-- sub_cont_vauchers End -->
                                        <label class="sub_cont_vauchers">
                                            {{ $_auctionDetail['au_bid_voucher'] }} Vouchers
                                        </label><!-- sub_cont_vauchers End -->
                                        <label class="sub_cont_time">
                                            <div data-countdown="{{$_auctionDetail['au_end_time']}}"></div>
                                        </label><!-- sub_cont_time End -->
                                        <label class="sub_cont_lat_bidder" >
                                            {{ $_auctionDetail['p_sku'] }}
                                        </label><!-- sub_cont_lat_bidder End -->
                                        <input type="hidden" id="skucode" value="<?php echo $_auctionDetail['p_sku']; ?>">
                                        <label class="sub_cont_not">
                                            Not Met
                                        </label><!-- sub_cont_not End -->
                                    </div><!-- products_sub_cont End -->
                                </div>
                                <?php
                                $watchClass = '';
                                if (Auth::front()->check()) {
                                    if (!in_array($_auctionDetail['au_product_id'], $watchedProducts)) {
                                        $watchClass = 'watchItem';
                                    }
                                }
                                ?>                                    
                                <div class="popular_auction_btn clearfix">
                                    <button type="button" <?php if (Auth::front()->check()) { ?> onclick="location.href ='{{url("liveauction")}}/{{$_auctionDetail["id"]}}'" <?php } ?> class="btn btn-lg btn-fb waves-effect waves-light">bid</button>
                                    <button type="button" data-class="product_<?php echo $_auctionDetail['au_product_id']; ?>" data-value="<?php echo $_auctionDetail['au_product_id']; ?>" class="btn btn-lg btn-fb waves-effect waves-light <?php echo $watchClass; ?>">Watch</button>
                                    <button type="button" class="btn btn-lg btn-fb waves-effect waves-light" <?php if (Auth::front()->check()) { ?> onclick="window.open('https://www.facebook.com/share.php?u={{url("productdetail")}}/{{$_auctionDetail["au_product_id"]}}& title={{$_auctionDetail["p_title"]}}& picture={{ asset($imagePath.$_auctionDetail["pi_image_name"]) }}')" <?php } ?>><i class="fa fa-facebook left"></i> Share</button>
                                </div><!-- popular_auction_btn End -->
                            </div><!-- doc_popular_auction_box End -->
                        </div><!-- doc_popular_auction End -->
                    </div><!-- col-md-4 col-sm-4 End -->
                    @elseif ($_auctionDetail['au_status'] == 2)
                    <div class="col-md-4 col-sm-4">
                        <div class="doc_popular_auction end_auction">
                            <div class="product_overlay"></div>
                            <div class="doc_popular_auction_box clearfix">
                                <div class="pd_title">
                                    <h2><a href="{{url('/moredetails')}}/{{$_auctionDetail['id']}}">{{ $_auctionDetail['p_title'] }}</a></h2>
                                    <div>
                                        <span class="live_auction">
                                            <span class="live_auction_inner"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="product_desc clearfix">
                                    <div class="products_img_cont">
                                        @if((!isset($_auctionDetail['pi_image_name']) || $_auctionDetail['pi_image_name']=='')  && (!isset($imagePath)))
                                        <?php
                                        $_auctionDetail['pi_image_name'] = 'product_img.jpg';
                                        $imagePath = 'frontend/images/'
                                        ?>
                                        @endif
                                        <img src="{{asset($imagePath.'/'.$_auctionDetail['pi_image_name']) }}"  alt="product_img" class="img-responsive">
                                    </div><!-- products_img_cont End -->
                                    <div class="products_sub_cont">
                                        <label class="product_auctn">
                                            Auction Ended
                                        </label><!-- sub_cont_vauchers End -->
                                        <label class="sub_cont_vauchers">
                                            Winnig voucher count
                                        </label><!-- sub_cont_vauchers End -->
                                        <label class="sub_cont_lat_bidder">
                                            {{ $_auctionDetail['p_sku'] }}
                                        </label><!-- sub_cont_lat_bidder End -->
                                    </div><!-- products_sub_cont End -->
                                </div>
                                <div class="sold_pd">
                                    <img src="{{ asset('/frontend/images/sold.png') }}"  alt="sold">
                                </div><!-- sold_pd End -->
                                <?php
                                $watchClass = '';
                                if (Auth::front()->check()) {
                                    if (!in_array($_auctionDetail['au_product_id'], $watchedProducts)) {
                                        $watchClass = 'watchItem';
                                    }
                                }
                                ?>                                    
                                <div class="popular_auction_btn clearfix">
                                    <button type="button" data-class="product_<?php echo $_auctionDetail['au_product_id']; ?>" data-value="<?php echo $_auctionDetail['au_product_id']; ?>" class="btn btn-lg btn-fb waves-effect waves-light <?php echo $watchClass; ?>"><a href="{{url('/moredetails')}}/{{$_auctionDetail['id']}}">Watch</a></button>
                                </div><!-- popular_auction_btn End -->
                            </div><!-- doc_popular_auction_box End -->
                        </div><!-- doc_popular_auction End 88888888-->
                    </div><!-- col-md-4 col-sm-4 End -->
                    @else
                    <div class="col-md-4 col-sm-4">
                        <div class="doc_popular_auction auct_coming_soon">
                            <div class="doc_popular_auction_box clearfix">
                                <div class="pd_title">
                                    <h2><a href="{{url('/moredetails')}}/{{$_auctionDetail['id']}}"> {{ $_auctionDetail['p_title'] }}</a></h2>
                                    <div>
                                        <span class="live_auction">
                                            <span class="live_auction_inner"></span>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" id="comingsoon" value="2">
                                <div class="product_desc clearfix">
                                    <div class="products_img_cont">
                                        @if((!isset($_auctionDetail['pi_image_name']) || $_auctionDetail['pi_image_name']=='')  && (!isset($imagePath)))
                                        <?php
                                        $_auctionDetail['pi_image_name'] = 'product_img.jpg';
                                        //$imagePath = 'frontend/images/'; 
                                        $imagePath = 'frontend/images/';
                                        ?>
                                        @endif
                                        <img src="{{asset($imagePath.'/'.$_auctionDetail['pi_image_name']) }}"  alt="product_img" class="img-responsive">
                                        </div><!-- products_img_cont End -->
                                    <div class="products_sub_cont">
                                        <label class="product_auctn">
                                            Auction Comming Soon
                                        </label><!-- sub_cont_vauchers End -->
                                        <label class="sub_cont_time">
                                            <div data-countdown="{{$_auctionDetail['au_start_time']}}"></div>
                                        </label><!-- sub_cont_time End -->
                                    </div><!-- products_sub_cont End -->
                                </div>
                                <?php
                                $watchClass = '';
                                if (Auth::front()->check()) {
                                    if (!in_array($_auctionDetail['au_product_id'], $watchedProducts)) {
                                        $watchClass = 'watchItem';
                                    }
                                }
                                ?>                                    
                                <div class="popular_auction_btn clearfix">
                                    <button type="button" data-class="product_<?php echo $_auctionDetail['au_product_id']; ?>" data-value="<?php echo $_auctionDetail['au_product_id']; ?>" class="btn btn-lg btn-fb waves-effect waves-light <?php echo $watchClass; ?>">Watch</button>
                                </div><!-- popular_auction_btn End -->
                            </div><!-- doc_popular_auction_box End -->
                        </div><!-- doc_popular_auction End -->
                    </div><!-- col-md-4 col-sm-4 End -->
                    @endif
 
                @endforeach
                @endif
            </div><!-- End row -->
        </div><!-- End product_main -->
        <div class="product_sign">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="auction_legend">
                        <h3>Auction Legend:</h3>
                        <ul>
                            <li class="auction_one">
                                <span class="live_auction">
                                    <span class="live_auction_inner"></span>
                                </span>Live Auction</li>
                            <li class="auction_two">
                                <span class="live_auction">
                                    <span class="live_auction_inner"></span>
                                </span>Auction Starting Soon</li>
                            <li class="auction_three">
                                <span class="live_auction">
                                    <span class="live_auction_inner"></span>
                                </span>Auction Ended</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="cst_pagination">
                        <ul class="pagination pagination-sm">
                            {!! $auctionDetail->appends(['p_category_id' => $p_category_id, 'p_subcategory_id' => $p_subcategory_id, 'searchkeyword' => $searchkeyword, 'searchby' => $searchby])->render() !!}
                        </ul><!-- End pagination -->
                    </div><!-- End cst_pagination -->
                </div>
            </div>
        </div>
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
    </div><!-- container End -->
</div><!-- game_arcade_container End -->

@stop
@section('script')
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="{{ asset('frontend/js/jquery.countdown.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>

<script type="text/javascript">
    function getDataOfSubCategory(CategoryId) {
        if (CategoryId != 0) {
            $("#p_subcategory_id").empty();
            $.ajax({
                type: 'GET',
                url: '/getsubcategoryfront/' + CategoryId,
                dataType: "JSON",
                success: function (JSON) {
                    $("#p_subcategory_id").empty();
                    $("#p_subcategory_id").append($("<option></option>").val(0).html('Sub Category'));
                    for (var i = 0; i < JSON.length; i++) {
                        $("#p_subcategory_id").append($("<option></option>").val(JSON[i].id).html(JSON[i].pc_title));
                    }
                }
            });
        } else {
            $("#p_subcategory_id").empty();
            $("#p_subcategory_id").append($("<option></option>").val(0).html('Sub Category'));
        }
    }

    $(document).ready(function(){
        var CSRF_TOKEN = "{{ csrf_token() }}";
   

        // Add as watched item list of user
        $('.watchItem').click(function(){
            var productId = $(this).data('value');
            var _class = $(this).data('class');
            $.ajax({
                url: "{{ url('addaswatchedItem') }}",
                type: 'POST',
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                cache: false,
                data: {
                    "productId": productId,
                },
                success: function(response) {
                    if (response == 0) {
                        window.location.href = "{{ url('/completeProfile') }}";
                    } else if (response == 2) {
                        window.location.href = "{{ url('/editprofile') }}";
                    } else {
                        $('[data-class="'+ _class +'"]').css('pointer-events', 'none');
                    }
                },
            });
        });
        
        // Countdown timer jquery function
        $('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%D days %H:%M:%S'));

            }).on('finish.countdown', function() {

                var live = $("#live").val();
                if(live == 1){
                    
                    var auctionId = $("#auction_Id").val();  
                    var imagename = $("#image_name").val();
                    var productId = $("#prooduct_Id").val();
                    var skucode   = $("#skucode").val();  
                    var auc_title = $("#auc_title").val();
                    $.ajax({
                        url: "{{ url('updateauctionstatussold') }}",
                        type: 'get',
                        dataType: 'html',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        cache: false,
                        data: {
                            "auctionId" : auctionId,
                            "imagename" : imagename,
                            "productId" : productId,
                            "auc_title" : auc_title,
                            "skucode"   : skucode,
                        },
                        success: function(response) {
                            if (response) {
                                $("#"+auctionId).html(response);
                            }  
                        },
                    });
                }//live 

              /*  var comingsoon = $("#comingsoon").val();
                if(comingsoon == 2){

                    alert("comingsoon");
                    var auctionId = $("#auction_Id").val();  
                    var imagename = $("#image_name").val();
                    var productId = $("#prooduct_Id").val();
                    var skucode   = $("#skucode").val();  
                    var auc_title = $("#auc_title").val();
                    $.ajax({
                        url: "{{ url('updateauctionstatuslive') }}",
                        type: 'get',
                        dataType: 'html',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        cache: false,
                        data: {
                            "auctionId" : auctionId,
                            "imagename" : imagename,
                            "productId" : productId,
                            "auc_title" : auc_title,
                            "skucode"   : skucode,
                        },
                        success: function(response) {
                            if (response) {
                                $("#"+auctionId).html(response);
                            }  
                        },
                    });

                }//comming sooon*/
                
            });
            
        });
    });
</script>

@stop

