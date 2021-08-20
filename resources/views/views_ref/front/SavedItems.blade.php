@extends('front.Master')
@section('css')
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/owl.transitions.css">
@stop

@section('content')
<div class="prev_purchased_item">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div>
      <div class="alien_ufo_header">
        <h2>Saved Items</h2>
      </div>
      <div class="prev_purchased_item_inner">
        
        <div class="row">
          @forelse($savedProductDetails as $savedProductDetail)
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="purchased_item">
              <img src="{{ asset($imagePath.$savedProductDetail->pi_image_name)}}" alt="purchase_item1" class="img-responsive">
                        
            </div><!-- purchased_item End -->
            <p><a href="{{url('productdetail/'.$savedProductDetail->id)}}">{{$savedProductDetail->p_title}}</a></p>
          </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
          @empty
          <center> <h3>  No Record Found </h3> </center>
          @endforelse
        </div><!-- row End -->
        
        <div class="cst_pagination pagination-sm">
            {!! $savedProductDetails->render() !!}
        </div><!-- End cst_pagination -->
        <div class="vw_advertisement_footer">
          <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
      </div><!-- prev_purchased_item_inner End -->
      
      <div class="purchased_related_item">
        <div class="alien_ufo_header">
          <h2>Items related to your saved items</h2>
        </div>
        <div class="prev_purchased_item_inner">
          <div class="row">
            @forelse($itemsRelatedTosavedItems as $itemsRelatedTosavedItem)
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="purchased_item">
                <img src="{{ asset($imagePath.$itemsRelatedTosavedItem->pi_image_name)}}" alt="purchase_item1" class="img-responsive">
              </div><!-- purchased_item End -->
              <p><a href="{{url('productdetail/'.$itemsRelatedTosavedItem->id)}}">{{ $itemsRelatedTosavedItem->p_title}}</a></p>
           </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
           @empty
           <center> <h3> No Records Found </h3> </center>
           @endforelse
        </div><!-- row End -->
          <div class="cst_pagination pagination-sm">
            {!! $itemsRelatedTosavedItems->render() !!}
          </div><!-- End cst_pagination -->
          
        </div><!-- prev_purchased_item_inner End -->
      </div>
    </div><!-- container End -->
  </div><!-- prev_purchased_item End -->

    
<div class="modal fade forgotpass_modal refer_modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="zmdi zmdi-close"></i></button>
                </div>
                <h4 class="modal-title" id="myModalLabel">Refer to a friend</h4>
                <div class="modal-body">
                    <div class="form-group label-floating is-empty">
                         <i class="zmdi zmdi-account-o"></i>
                         <label for="i5i" class="control-label">Friend Name</label>
                         <input type="email" class="form-control" id="i5i">
                    </div>
                    <div class="form-group label-floating is-empty">
                         <i class="fa fa-envelope-o" aria-hidden="true"></i>
                         <label for="i5i" class="control-label">Email</label>
                         <input type="email" class="form-control" id="i5i">
                    </div>
                    <div class="form-group">
                        <label for="comment" class="message">Message</label>
                        <textarea class="form-control" rows="5" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
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
                        <i class="zmdi zmdi-star-outline"></i><i class="zmdi zmdi-star-outline"></i>
                        <i class="zmdi zmdi-star-outline"></i><i class="zmdi zmdi-star-outline"></i>
                        <i class="zmdi zmdi-star-outline"></i>
                        <textarea class="form-control" rows="10" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script>
    
</script>
@stop