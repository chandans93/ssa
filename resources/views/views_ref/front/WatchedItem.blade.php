@extends('front.Master')

@section('css')
<link href="{{ asset('/frontend/css/jquery-ui-1.10.1.css') }}" rel="stylesheet">
<link href="{{ asset('/frontend/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/bootstrap-material-design.css')}}">
@stop

@section('content')
   <div class="earned_voucher watched_items_main">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div><!-- vw_advertisement_footer End -->
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
      
      <div class="earned_voucher_inner">
        <div class="alien_ufo_header clearfix">
          <h2>Watched Items</h2>
            <form id="searchWatchedItems" action="{{ url('watcheditems')}}" method="post">
                <?php $date = (!empty($searchParamArray) && $searchParamArray['searchDate'] != '') ? $searchParamArray['searchDate'] : ''; ?>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="date_time_con clearfix">
                  <div class="date_inner">
                      <input type="text" name="searchDate" id="datetimepicker5" class="cst_datepicker" value="<?php echo $date; ?>"/>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                  </div>
                  <button type="submit" name="btnSearch">Search</button>
                </div><!-- date_time_con End -->
            </form>
        </div><!-- alien_ufo_header End -->

        <div class="earned_table">
          <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Title and Image</th>
              <th>Current Voucher</th>
              <th>Dated Added</th>
              <th>Action</th>
            </tr>
            @if(isset($watchedItemsDetail)&&!empty($watchedItemsDetail))
                @forelse($watchedItemsDetail as $_watchedItemsDetail)
                    <tr>
                      <td>
                        <div class="watched_item">
                          <div class="watched_img">
                            @if((!isset($_watchedItemsDetail['pi_image_name']) || $_watchedItemsDetail['pi_image_name']==''))
                                <?php
                                    $_watchedItemsDetail['pi_image_name']='watched_item.jpg';
                                    $imagePath='frontend/images/'
                                ?>
                            @endif
                            <img src="{{asset($imagePath.'/'.$_watchedItemsDetail['pi_image_name']) }}"  alt="watched_item">
                          </div>
                          <div class="watched_name">
                            <h4>{{ $_watchedItemsDetail['p_title'] }}</h4>
                          </div>
                        </div>
                      </td>
                      <td>{{ $_watchedItemsDetail['p_voucher'] }}</td>
                      <?php $createdDate = date('d/m/Y', strtotime($_watchedItemsDetail['created_at'])); ?>
                      <td><?php echo $createdDate; ?></td>
                      <td>
                        <div class="action_btns">
                            <button type="button" class="btn btn-default rmvButton" data-dismiss="modal" data-value="<?php echo $_watchedItemsDetail['wi_product_id']; ?>">Remove<div class="ripple-container"></div></button>
                            @if($_watchedItemsDetail['liveAuction'] == 1)
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.href='{{url("checkforliveauction")}}/{{$_watchedItemsDetail["wi_product_id"]}}'">Bid Now<div class="ripple-container"></div></button>
                            @endif
                        </div>
                      </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4">No Records Found</td>
                </tr>
                @endforelse
            @else
              
            @endif
          </table>
        </div>
        </div><!-- earned_table End --> 
      </div><!-- earned_voucher_inner End -->
      <div class="cst_pagination">
            <ul class="pagination pagination-sm">
                {!! $watchedItemsDetail->appends(['searchDate' => $date])->render() !!}
            </ul><!-- End pagination -->
          </div><!-- End cst_pagination -->
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
      </div><!-- vw_advertisement_footer End -->
    </div><!-- container End -->
  </div><!-- earned_voucher End -->
@stop

@section('script')
<script src="{{ asset('frontend/js/jquery-ui-1.10.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/material.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var CSRF_TOKEN = "{{ csrf_token() }}";
    
    $('#datetimepicker5').datetimepicker({
      format: 'MM/DD/YYYY'
    });
    
    // Remove product from watched list
    $('.rmvButton').click(function(){
        if (confirm('Are you sure you want to delete this item?')){
            var productId = $(this).data('value');
            window.location.href="{{ url('removewatcheditem') }}/"+productId;
        } else {
            return false;
        }
    });
  });
</script>
@stop