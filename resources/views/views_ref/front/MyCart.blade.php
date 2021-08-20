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
        <center><div id="low_balance" style="color:red;font-size:20px;"> </div></center>
        <div class="live_auction_content no_live_acution_view">
            <div class="live_auction_running_blog">

                <div class="add_to_cart">
                    <div class="container">

                        <div class="alien_ufo_header">
                            <h2>My Cart</h2>
                        </div>

                        @if(isset($data) && !empty($data))
                        <div class="add_to_cart_table">
                            <div class="table-responsive">

                                <table class="table">
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Voucher</th>
                                        <th>Delivery Details</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    <?php
                                    $total = 0;
                                    $id = 0;
                                    ?>


                                    @forelse($data as $value)
                                    <?php
                                    $id = $id + 1;
                                    $total = $total + $value->atcp_quantity * $value->p_voucher;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="cart_item">
                                                <div class="cart_item_left">


                                                    <?php if (File::exists(public_path($productOriginalImageUploadPath . $value->pi_image_name)) && $value->pi_image_name != '') { ?>
                                                        <img src="{{ url($productOriginalImageUploadPath.$value->pi_image_name) }}" alt="{{$value->pi_image_name}}" height="70px" width="70px">
                                                    <?php } else { ?>
                                                        <img src="{{ asset('/frontend/images/ava5.png')}}" class="user-image" alt="Default Image">
                                                    <?php } ?>	
                                                </div>
                                                <div class="cart_item_right">
                                                    <label class="cart_item_title">{{ $value->p_title }}</label>
                                                    <label class="cart_item_desc">{!! $value->p_description !!}</label>
                                                    <?php
                                                    if (isset($checkquantity) && !empty($checkquantity)) {
                                                        foreach ($checkquantity as $k => $v) {
                                                            if ($k == $value->p_title) {
                                                                ?> 
                                                                <div id="Quantity_data" style="color: red;font-size: 10px;"> 
                                                                    <?php
                                                                    echo "Sorry, " . $k . " is out of stock.";
                                                                }
                                                            }
                                                        } else {
                                                            
                                                        }
                                                        ?> 
                                                    </div>                                                    
                                                    <div class="remove_item">
                                                        <a href="{{url('/deletecart')}}/{{$value->id}}">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>

                                            <form class="form-horizontal" method="post" action="{{ url('/savequantity') }}" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="id" value="{{$value->id}}">
                                                <input class="cart_qty onlyNumber" type="text" name="atcp_quantity" id="atcp_quantity" value="{{$value->atcp_quantity}}">
                                                <input type="submit"  value="save">
                                            </form>
                                        </td>
                                        <td>
                                            <div class="cart_price">{{$value->p_voucher}}</div>
                                        </td>
                                        <td>
                                            <div class="cart_item_delivery">
                                                <label class="cart_item_delivery_type"> <?php
                                                    if ($value->p_delivery_method) {
                                                        echo "Courier Delivery";
                                                    } else {
                                                        echo "Email Delivery";
                                                    }
                                                    ?></label>

                                            </div>
                                        </td>
                                        <td>

                                            <div class="cart_item_subtotal"><?php echo $value->atcp_quantity * $value->p_voucher; ?> </div>


                                        </td>
                                    </tr><!-- tr End -->


                                    @empty


                                    @endforelse

                                    <tr>
                                        <td colspan="5" class="cst_cart_item_total">
                                            <div class="cart_item_total_amount">

                                                <label class="amount_payable">Amount Payable : <span><?php echo $total; ?></span></label>
                                                <?php $order = Helpers::getOrderNumber(); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="cst_border0 td_align">
                                            <div class="cart_item_placeorder">
                                                <div class="cart_item_payment">
                                                    <ul>
                                                        <li>

                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-1.png') }}" alt="secure_payment" class="img-responsive"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-2.png') }}" alt="ssl" class="img-responsive"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-3.png') }}" alt="ssl" class="img-responsive"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-4.png') }}" alt="ssl" class="img-responsive"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-5.png') }}" alt="ssl" class="img-responsive"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-6.png') }}" alt="ssl" class="img-responsive"></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><img src="{{ asset('/frontend/images/payment-7.png') }}" alt="ssl" class="img-responsive"></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </td>
                                        <td colspan="3" class="cst_border0">
                                            <div class="cart_conti_btn">
                                                <button type="submit" onclick="location.href ='{{url("/product")}}'" class="conti_shop btn btn-lg btn-fb waves-effect waves-light">Continue Shopping</button>
                                                <?php
                                                if (isset($data) && !empty($data)) {
                                                    foreach ($data as $key => $value) {
                                                        $surveyicon[] = array('op_product_id' => $value->atcp_product_id, 'op_shipping_type' => $value->p_delivery_method, 'op_quantity' => $value->atcp_quantity, 'op_product_amount' => $value->p_voucher);
                                                    }
                                                    ?>
                                                    <?php
                                                    $product = json_encode($surveyicon);
                                                } else {
                                                    $product = [];
                                                }
                                                ?>  
                                                
                                                <form class="form-horizontal" method="post" action="{{ url('/placeorder') }}/{{$product}}" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                                            
                                                    <input type="hidden" name="total_amount" value="<?php if (isset($total) && $total != '') { echo $total; } else { echo $total = 0; } ?>">
                                                    <input type="hidden" name="total_amount" value="<?php if (isset($total) && $total != '') { echo $total; } else { echo $total = 0; } ?>">
                                                    <input type="hidden" name="orderno" value="<?php if (isset($order) && $order != '') { echo $order; } else {  echo $order = 0; } ?>">
                                                    <input type="hidden" name="product" value="<?php  if (isset($product) && !empty($product)) { print_r($product); } else { echo $product = 0; } ?>;">
                                                    <button type="submit" class="place_order btn btn-lg btn-fb waves-effect waves-light">Place Order</button>
                                                </form>




                                            </div>
                                        </td>
                                    </tr>
                                </table><!-- table End -->
                            </div><!-- table-responsive End -->
                        </div><!-- add_to_cart_table End -->

                    </div><!-- container End -->
                </div><!-- add_to_cart End -->
                @else
                <div style="margin-top: 50px;">
                    <center>
                        <h3>There are no items in this cart.</h3>                                        
                    </center>
                </div>

                @endif        

                <div class="vw_advertisement_footer">
                    <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">

                </div>  
            </div><!-- container End -->
        </div><!-- live_auction_running End -->



        @stop

        @section('script')

        <script src="{{ asset('frontend/js/star-rating.js')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
        <script src="{{ asset('frontend/js/star-rating.js')}}"></script>
        <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('frontend/js/material.min.js') }}"></script>

        <script type="text/javascript">

                                                    $(document).ready(function () {

                                                        $('.onlyNumber').on('keyup', function () {
                                                            this.value = this.value.replace(/[^0-9]/gi, '');
                                                        });

                                                    });

                                                    function placeOrder() {

                                                        var quantity = $("#Quantity_data").val();
                                                        if (quantity == '')
                                                        {
                                                            return false;
                                                        } else
                                                        {

                                                        }

<?php if (Auth::front()->check()) { ?>
                                                            var userid = <?php echo Auth::front()->get()->id; ?>;

<?php } ?>
                                                        var orderno = <?php
if (isset($order) && $order != '') {
    echo $order;
} else {
    echo $order = 0;
}
?>;
                                                        var total_amount = <?php
if (isset($total) && $total != '') {
    echo $total;
} else {
    echo $total = 0;
}
?>;
                                                        var product = <?php
if (isset($product) && !empty($product)) {
    echo $product;
} else {
    echo $product = 0;
}
?>;
        alert(product);
                                                        var CSRF_TOKEN = "{{ csrf_token() }}";
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '/placeorder',
                                                            dataType: 'html',
                                                            headers: {
                                                                'X-CSRF-TOKEN': CSRF_TOKEN
                                                            },
                                                            data: {
                                                                userid: userid,
                                                                orderno: orderno,
                                                                total_amount: total_amount,
                                                                product: product,
                                                            },
                                                            success: function (JSON) {
                                                                if (JSON == 0)
                                                                {

                                                                    $("#low_balance").text("You don't have enough voucher for purchase this item");
                                                                    return false;
                                                                } else
                                                                {
                                                                    var obj = $.parseJSON(JSON);
                                                                    window.location.href = "/checkout/" + obj.id + "/" + obj.o_total_payble_amount;
                                                                }


                                                            }
                                                        });

                                                    }

        </script>

        @stop  

