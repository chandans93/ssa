@extends('front.Master')
@section('css')
<link href="{{asset('/frontend/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@stop
@section('content')

<div class="earned_voucher purchased_voucher">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}"  alt="vw_advertisement_footer">
      </div><!-- vw_advertisement_footer End -->
      <div class="earned_voucher_inner">
        <div class="alien_ufo_header">
          <h2>Purchased Voucher History</h2>
          <form id="searchPurchaseVoucherHistory" action="{{ url('purchasevoucherhistory')}}" method="get">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="date_time_con clearfix">
            <div class="date_inner">
              <input type="text" id="datetimepicker5" name="searchDate" class="cst_datepicker"/>
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
              <th>Date Purchased</th>
              <th>Vouchers Purchased</th>
              <th>Total Spent</th>
            </tr>
            @if(!empty($purchaseVouchers) && isset($purchaseVouchers))
            @forelse($purchaseVouchers as $purchaseVoucher)
            <tr>
              <td>{{date('m/d/Y', strtotime($purchaseVoucher->created_at))}}</td>
              <td>{{$purchaseVoucher->pv_total_voucher}}</td>
              <td>{{$purchaseVoucher->pv_total_spent}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No Records Found</td>
              </tr>
            @endforelse
            @else
              
            @endif
            
          </table><!-- table End --> 
        </div><!-- table-responsive End --> 
        </div><!-- earned_table End --> 
      </div><!-- earned_voucher_inner End -->
       
      <div class="cst_pagination">
            <div class="pagination pagination-sm">
                
            {!! $purchaseVouchers->render() !!}
            <!--<span><img src="{{ asset('/frontend/images/right_pagination.png') }}" alt="right_pagination" class="img-responsive"></span>-->
            </div><!-- End pagination -->
          </div><!-- End cst_pagination -->
      
          
            <div class="vw_advertisement_footer">
              <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}"  alt="vw_advertisement_footer">
            </div><!-- vw_advertisement_footer End -->
            
    </div><!-- container End -->
  </div><!-- earned_voucher End -->

@stop

@section('script')

<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#datetimepicker5').datetimepicker({
      format: 'MM/DD/YYYY'
        });
    });
    
   

 
</script>


@stop