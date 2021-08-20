@extends('front.Master')
@section('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">
@stop
@section('content')

<?php
//foreach ($PrevioslyPurchadedItems as $key=>$value)
//{
//    echo "<pre/>";
//print_r($value->pi_image_name);
//}    
//
//die;

?>

<div class="prev_purchased_item">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="alien_ufo_header">
            <h2>Favorite Games</h2>
        </div>
        <div class="prev_purchased_item_inner">
            <div class="row">
<?Php //echo "<pre>"; print_r($PrevioslyPurchadedItems);?>

           
                @forelse($favoriteGameDetails as $favoriteGameDetail)

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="purchased_item">
                        <img src="{{ asset($gamethumbpath.'/'.$favoriteGameDetail->g_photo) }}"  alt="purchase_item1" class="img-responsive">
                    </div><!-- purchased_item End -->
                    <p><a href="{{url('gamedetail/'.$favoriteGameDetail->fg_game_id)}}">{{$favoriteGameDetail->g_title}}</a></p>
                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                @empty
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <div style="margin-top: 50px;">
                        <center>
                            <h3>No Record Found</h3>                                        
                        </center>
                    </div>
                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                @endforelse
                
                
               
            </div><!-- row End -->
            <div class="cst_pagination">
                <ul class="pagination pagination-sm">
                        {!! $favoriteGameDetails->render() !!}
                </ul><!-- End pagination -->
            </div><!-- End cst_pagination -->
            <div class="vw_advertisement_footer">
                <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
            </div>
        </div><!-- prev_purchased_item_inner End -->
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

