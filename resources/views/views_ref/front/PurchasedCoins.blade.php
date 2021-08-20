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
          <h2>Purchased Coins History</h2>
          <form id="searchPurchaseCoinsHistory" action="{{ url('purchasecoinshistory')}}" method="get">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="date_time_con clearfix">
            <div class="date_inner">
              <input type="text" id="datetimepicker5" name="searchDate" class="cst_datepicker"/>
              <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
               <button type="submit" name="btnSearch" >Search</button>
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
            @if(!empty($purchaseCoins) && isset($purchaseCoins))
            @forelse($purchaseCoins as $purchaseCoin)
            <tr>
              <td>{{date('m/d/Y', strtotime($purchaseCoin->pc_purchased_date))}}</td>
              <td>{{$purchaseCoin->pc_total_coins}}</td>
              <td>{{$purchaseCoin->pc_total_price}}</td>
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
            <ul class="pagination pagination-sm">
                
            {!! $purchaseCoins->render() !!}
            <!--<span><img src="{{ asset('/frontend/images/right_pagination.png') }}" alt="right_pagination" class="img-responsive"></span>-->
            </ul><!-- End pagination -->
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