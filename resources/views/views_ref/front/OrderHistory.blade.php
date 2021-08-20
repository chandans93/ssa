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
                <h2>Order History</h2>
                <form id="searchPurchaseVoucherHistory" action="{{ url('orderhistory')}}" method="get">
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
                            <th>Order Date</th>
                            <th>Order Number</th>
                            <th>Total Paid</th>
                            <th>Status</th>
                        </tr>
                        <?php $id = 0; ?>
                        @if(!empty($orderHistory) && isset($orderHistory))

                        @forelse($orderHistory as $orderHistorys)
                        <?php $id++; ?>

                        <tr>
                            <td>{{date('m/d/Y', strtotime($orderHistorys->o_order_date))}}</td>

                            <td>
                                <button class="order_number_modal commonClass" id="getorder" name="getorder" onclick="getOrderedProduct(this.value);" data-toggle="modal" value="{{$orderHistorys['o_order_number']}}" data-target=".order_popup">
                                    {{$orderHistorys->o_order_number}}
                                </button>    

                            </td>
                            <td>{{$orderHistorys->o_total_payble_amount}}</td>                            
                            <td>

                                @if($orderHistorys->o_order_status == 1)
                                <?php echo "Inprocessing"; ?>                  
                                @elseif($orderHistorys->o_order_status == 2)
                                <?php echo "Delivered"; ?>
                                @else
                                <?php echo "Cancelled"; ?>

                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No Records Found</td>
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

                {!! $orderHistory->render() !!}
                <!--<span><img src="{{ asset('/frontend/images/right_pagination.png') }}" alt="right_pagination" class="img-responsive"></span>-->
            </div><!-- End pagination -->
        </div><!-- End cst_pagination -->


        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}"  alt="vw_advertisement_footer">
        </div><!-- vw_advertisement_footer End -->

    </div><!-- container End -->
</div><!-- earned_voucher End -->

<!-- your order popup  -->
<div class="modal fade order_popup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal_close clearfix">
                    <img src="frontend/images/modal_close.png" alt="modal_close" class="img-responsive" data-dismiss="modal">
                </div>
                <div class="order_title">
                    <h4 class="modal-title" id="gridSystemModalLabel">Your Orders</h4>
                    <div class="order_search">
                        <div class="form-group search_box">
                            <i class="fa fa-search" aria-hidden="true"></i>
                           
                                <input type="text" name="searchText"  id="searchText" class="form-control col-md-8" placeholder="Search all orders">
                                </div>
                        <button type="button" onclick="getSearchData();" class="btn btn-default">Search orders<div class="ripple-container"></div></button>
                           
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="data">
                    <div class="order_tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">Orders</a></li>
                            <li><a href="#profile" data-toggle="tab">Open Orders</a></li>
                            <li><a href="#profile" data-toggle="tab">Cancelled Orders</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content" >
                            <div class="tab-pane fade active in" id="home">
                                <div class="table-responsive" id="oderedDetails">
                                    
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
    <!-- End popup  -->

    @stop

    @section('script')

    <script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>

    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#datetimepicker5').datetimepicker({
                                                format: 'MM/DD/YYYY'
                                            });
                                        });


                                        function getOrderedProduct(orderNumber)
                                        {

                                                <?php if (Auth::front()->check()) { ?>
                                                var userid = <?php echo Auth::front()->get()->id; ?>;
                                                <?php } ?>
                                            var CSRF_TOKEN = "{{ csrf_token() }}";
                                            $.ajax({
                                                type: 'GET',
                                                url: '/getOrderedProduct/',
                                                dataType: 'html',
                                                headers: {
                                                    'X-CSRF-TOKEN': CSRF_TOKEN
                                                },
                                                data: {
                                                    "order_number": orderNumber,
                                                    "user_id": userid,
                                                },
                                                success: function (response) {
                                                    
                                                  
                                                    $("#oderedDetails").html(response);
                                                }

                                            });
                                        }
                                        
                                        
                                        function getSearchData()
                                        {


                                            var searchtext = $("#searchText").val();
                                            
                                                <?php if (Auth::front()->check()) { ?>
                                                var userid = <?php echo Auth::front()->get()->id; ?>;
                                                <?php } ?>
                                            var CSRF_TOKEN = "{{ csrf_token() }}";
                                            $.ajax({
                                                type: 'GET',
                                                url: '/getOrderedProduct/',
                                                dataType: 'html',
                                                headers: {
                                                    'X-CSRF-TOKEN': CSRF_TOKEN
                                                },
                                                data: {
                                                    "searchtext": searchtext,
                                                    "user_id": userid,
                                                },
                                                success: function (response) {
                                                    
                                                   
                                                   $("#oderedDetails").html(response);
                                                   
                                                    }  
                                                   
                                                
                                            

                                            });
                                        }

    </script>


    @stop
