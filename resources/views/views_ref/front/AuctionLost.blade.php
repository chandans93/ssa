@extends('front.Master')
@section('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">
@stop
@section('content')

<?php
//$DetailPreviouslyViewItem)->with('imagePath' [id] => 10
//[p_title] => nkjnkjnkjn
//[pi_image_name] => product_1475676489.jpg
?>

<div class="prev_purchased_item">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="alien_ufo_header">
            <h2>Auction Lost Item</h2>
        </div>
        <div class="prev_purchased_item_inner">
            <div class="row">
                @forelse($lostAuctionProductDetails as $lostAuctionProductDetail)
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="purchased_item">
                        <img src="{{ asset($imagePath.'/'.$lostAuctionProductDetail->pi_image_name) }}"  alt="purchase_item1" class="img-responsive">
                    </div> <!-- purchased_item End -->
                    <p><a href="{{url('productdetail/'.$lostAuctionProductDetail->id)}}">{{$lostAuctionProductDetail->p_title}}</a></p>
                </div> <!-- col-md-4 col-sm-4 col-xs-12 End  -->
                @empty
                <div>
                    <center>
                        <h3>No Record Found</h3>                                        
                    </center>
                </div>
                @endforelse
            </div><!-- row End -->

            <div class="cst_pagination">
                <ul class="pagination pagination-sm">
                    {!! $lostAuctionProductDetails->render() !!}
                </ul><!-- End pagination -->
            </div><!-- End cst_pagination -->
            <div class="vw_advertisement_footer">
                <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
            </div>
        </div><!-- prev_purchased_item_inner End -->
        <div class="purchased_related_item">
            <div class="alien_ufo_header">
                <h2>Items related to your won Item</h2> 
            </div>
            <div class="prev_purchased_item_inner">
                <div class="row">
                    @forelse($relatedItemsDetail as $relatedItemsDetails)
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="purchased_item">
                            <img src="{{ asset($imagePath.'/'.$relatedItemsDetails->pi_image_name) }}"  alt="purchase_item1" class="img-responsive">
                        </div> <!-- purchased_item End -->
                        <p><a href="{{url('productdetail/'.$relatedItemsDetails->id)}}">{{$relatedItemsDetails->p_title}}</a></p>
                    </div> <!-- col-md-4 col-sm-4 col-xs-12 End  -->
                    @empty
                    <div style="margin-top: 50px;">
                        <center>
                            <h3>No Record Found</h3>                                        
                        </center>
                    </div>
                    @endforelse

                </div><!-- row End -->
                <div class="cst_pagination">
                    <ul class="pagination pagination-sm">
                        {!! $relatedItemsDetail->render() !!}
                    </ul><!-- End pagination -->
                </div><!-- End cst_pagination -->
                <div class="vw_advertisement_footer">
                    <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
                </div>
            </div><!-- prev_purchased_item_inner End -->
        </div>
    </div><!-- container End -->

</div><!-- prev_purchased_item End -->


@stop
@section('script')
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script type="text/javascript">
//$(document).on('click', '.pagination a', function () {
//   
//    $.ajax({
//        type: "get",
//        url: "{{url('previouslyvieweditem')}}",
//        success: function () {
//        }
//    });
//});
</script>
@stop

