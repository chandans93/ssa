@extends('front.Master')
@section('content')
<div class="game_arcade_container">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="game_arcade_selected cst_product">
            <div class="row">
                <form action="productsearch" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown new_select">
                                <?php
                                if (old('p_category_id'))
                                    $p_category_id = old('p_category_id');
                                else
                                    $p_category_id = '';
                                ?>
                                <?php $product = Helpers::getProductid(); ?>
                                <select class="select" id="p_category_id" name="p_category_id" onchange="getDataOfSubCategory(this.value)">
                                    <option value="0">Category</option>
                                    <?php foreach ($product as $value) { ?>
                                        <option value="{{$value->id}}">{{$value->pc_title}}</option>
                                    <?php } ?>
                                </select>
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
                    <div class="col-md-2 col-sm-3 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown new_select">
                                <?php
                                if (old('p_subcategory_id'))
                                    $p_subcategory_id = old('p_subcategory_id');
                                else
                                    $p_subcategory_id = '';
                                ?>  
                                <?php $product = Helpers::getSubCategory($p_category_id); ?>
                                <select class="select" id="p_subcategory_id" name="p_subcategory_id">
                                    <option value="0">Sub Category</option>
                                    <?php
                                    if (isset($product) && !empty($product)) {
                                        foreach ($product as $value) {
                                            ?>
                                            <option value="{{$value->id}}" <?php if ($p_subcategory_id == $value->id) echo 'selected'; ?> >{{$value->pc_title}}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="game_arcade_search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchkeyword" id="usr" placeholder="Search by keyword">
                            </div>
                        </div><!-- game_arcade_search End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->

                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown new_select search_btn_prod">
                                <select class="select" id="searchby" name="searchby" >
                                    <?php $productOption = Helpers::productOption(); ?>
                                    <?php
                                    if (isset($productOption) && !empty($productOption)) {
                                        foreach ($productOption as $key => $value) {
                                            ?>
                                            <option value="{{$key}}" >{{$value}}</option>
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
        <div class="product_store_content">
            <div class="row">
                <?php $id = 0; ?>
                @if(isset($productsDetail)&&!empty($productsDetail))
                @forelse($productsDetail as $key => $productDetail)
                <?php $id++; ?>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="pd_store">
                        <div class="ps_store_inner">
                            <div class="store_title">
                                <h2><a href="{{url('productdetail/'.$productDetail['id'])}}">{{$productDetail['p_title']}}</a></h2>
                            </div><!-- store_title End --> 
                            <div class="store_content clearfix">
                                <div class="store_left">
                                    @if((!isset($productDetail['pi_image_name'])||$productDetail['pi_image_name']=='')  && (!isset($imagePath)))
                                    <?php
                                    $productDetail['pi_image_name'] = 'product_img.jpg';
                                    $imagePath = 'frontend/images/'
                                    ?>
                                    @endif
                                    <img src="{{ asset($imagePath.'/'.$productDetail['pi_image_name']) }}" alt="product_img" class="img-responsive">
                                </div><!-- store_left End -->
                                <div class="store_right">
                                    <p>{{ str_limit(strip_tags($productDetail['p_description']), $limit = 200, $end = '...') }}</p>
                                    <div class="voucher_count">{{$productDetail['p_voucher']}} Vouchers</div>
                                </div><!-- store_right End -->
                            </div><!-- store_content End -->
                        </div><!-- ps_store_inner End -->
                        <div class="popular_auction_btn clearfix store_btn">

                            <div class="delivery_dropdown store_dpdown new_select">
                                <select class="select" name="item" id="item<?php echo $id; ?>" >
                                @for($i=1;$i<=3 && $i<= $productDetail['p_quantity'];$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                                </select>
                            </div>

                            <button type="button"   onclick="addCart(this.value,<?php echo $id; ?>);" id="productid" name="productid" value="{{$productDetail['id']}}" class="btn btn-lg btn-fb waves-effect waves-light"><i class="zmdi zmdi-shopping-cart"></i> Add to cart<div class="ripple-container"></div></button>
                            <button type="button" onclick="location.href ='{{url("productdetail/".$productDetail['id'])}}'" class="btn btn-lg btn-fb waves-effect waves-light">More Detail<div class="ripple-container"></div></button>
                            <a href="https://www.facebook.com/share.php?u={{url('product/')}}{{$productDetail['id']}}&title={{$productDetail['p_title']}}&description={{ strip_tags($productDetail['p_description']) }}&picture={{ asset($imagePath.$productDetail['pi_image_name']) }}"> <button class="btn btn-lg btn-fb waves-effect waves-light"><i class="fa fa-facebook left"></i> Share</button></a>
                        </div>
                    </div><!-- pd_store End -->
                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                @empty
                <div style="margin-top: 50px;">
                    <center>
                        <h3>No Record Found</h3>                                        
                    </center>
                </div>
                @endforelse
                @endif
            </div><!-- row End -->
            <div class="cst_pagination">
                <ul class="pagination pagination-sm">
                    {!! $productsDetail->render() !!}
                </ul><!-- End pagination -->
            </div><!-- End cst_pagination -->
        </div><!-- product_store_content End -->
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
    </div>
</div>

@stop
@section('script')
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script type="text/javascript">

                                function getDataOfSubCategory(CategoryId)
                                {
                                    $("#p_subcategory_id").empty();
                                    $.ajax({
                                        type: 'GET',
                                        url: '/getsubcategoryfront/' + CategoryId,
                                        dataType: "JSON",
                                        success: function (JSON) {
                                            $("#p_subcategory_id").empty()
                                            for (var i = 0; i < JSON.length; i++) {
                                                $("#p_subcategory_id").append($("<option></option>").val(JSON[i].id).html(JSON[i].pc_title))
                                            }
                                        }
                                    });
                                }
                                function addCart(productid,id) {
                                <?php if (Auth::front()->check()) { ?>
                                        var userid = <?php echo Auth::front()->get()->id; ?>;
                                <?php } ?>
                                    
                                    var item1 = $("#item"+id).val();
                                    
                                    var CSRF_TOKEN = "{{ csrf_token() }}";
                                    $.ajax({
                                        type: 'POST',
                                        url: '/saveaddcartlimite',
                                        dataType: 'html',
                                        headers: {
                                            'X-CSRF-TOKEN': CSRF_TOKEN
                                        },
                                        data: {
                                            "atcp_quantity": item1,
                                            "atc_user_id" : userid,
                                            "atcp_product_id" : productid,
                                        },
                                        success: function (response) {

                                            $("#success").text('Your Item Successfully Add In Cart.');
                                            window.location.reload(true);

                                        }

                                    });

                                }
</script>

@stop


