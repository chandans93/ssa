@extends('front.Master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="game_arcade_container">
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

        <div class="game_arcade_header">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="game_arcade_header_title">
                        <h2>Game Arcade</h2>
                        <p>Play the arcade to earn reward points
                            redeemble for vouchers and much more!</p>
                    </div><!-- game_arcade_header_title End -->
                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                @if (Auth::front()->check())
                @if($Time == 1)                
                 <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="circle_area"  data-toggle="modal" data-target="#claimbonus-wheel">
                        <img src="/frontend/images/circle.png" alt="circle" class="img-responsive">
                        <span class="circle_area_title">Claim Bonus Spin</span><!-- circle_area_title End -->
                        <span class="circle_area_time"><?php
                            $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
                            echo $Current_time = date('H:i:s', $time_now);
                            ?></span><!-- circle_area_time End -->
                        <span class="circle_area_time">
                           <?php echo $reset_time; ?> 
                        </span><!-- circle_area_time End -->
                    </div><!-- circle_area End -->
                </div><!-- col-md-5 col-sm-5 col-xs-12 End -->
                
                @else
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="circle_area">
                        <img src="/frontend/images/circle.png" alt="circle" class="img-responsive">
                        <span class="circle_area_title">Claim Bonus Spin</span><!-- circle_area_title End -->
                        <span class="circle_area_time">
                           <?php echo $reset_time; ?> 
                        </span><!-- circle_area_time End -->
                    </div><!-- circle_area End -->
                </div><!-- col-md-5 col-sm-5 col-xs-12 End -->
                @endif
                @else
                 <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="circle_area">
                        <img src="/frontend/images/circle.png" alt="circle" class="img-responsive">
                        <span class="circle_area_title">Claim Bonus Spin</span><!-- circle_area_title End -->
                        <span class="circle_area_time"><?php
                            $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));
                            echo $Current_time = date('H:i:s', $time_now);
                            ?></span><!-- circle_area_time End -->
                    </div><!-- circle_area End -->
                </div><!-- col-md-5 col-sm-5 col-xs-12 End -->
                @endif
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="purchase_coin clearfix">
                        <img src="frontend/images/purchase_coin.png" alt="purchase_coin" class="img-responsive">
                        @if (Auth::front()->check())
                        <span class="total_coin"><?php $totalcoin = Helpers::getTotalCoins(Auth::front()->get()->id);
                            echo $totalcoin; ?></span><!-- total_coin End -->                        
                        @else
                        <span class="total_coin"><?php $totalcoin = 0;
                            echo $totalcoin; ?></span><!-- total_coin End -->
                        @endif

                        <span class="purchase_play_coin">Purchase Play Coins</span><!-- purchase_play_coin End -->
                    </div><!-- purchase_coin End -->
                </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
            </div><!-- row End -->
        </div><!-- game_arcade_header End -->
        <div class="game_arcade_selected">
            <div class="row">
                <form action="gamesearch" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown">

                                <?php
                                if (old('g_category_id'))
                                    $g_category_id = old('g_category_id');
                                else
                                    $g_category_id = '';
                                ?>
                                    <?php $game = Helpers::getGameid(); ?>
                                <select class="dropdown" tabindex="9" data-settings='{"wrapperClass":"flat"}' id="g_category_id" name="g_category_id" onchange="getDataOfSubCategory(this.value)">
                                    <option value="0">Category</option>
                                    <?php foreach ($game as $value) { ?>
                                        <option value="{{$value->id}}">{{$value->gc_title}}</option>
                                <?php } ?>
                                </select>                                                        
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->

                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="selected_box">
                            <div class="delivery_dropdown">
                                <select class="dropdown" tabindex="9" data-settings='{"wrapperClass":"flat"}' id="searchby" name="searchby" >
                                    <?php $gameOption = Helpers::productOption(); ?>
                                    <?php
                                    if (isset($gameOption) && !empty($gameOption)) {
                                        foreach ($gameOption as $key => $value) {
                                            ?>
                                            <option value="{{$key}}" >{{$value}}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>                                                                                                                    
                            </div><!-- delivery_information_from End -->
                        </div><!--  selected_box End -->
                    </div><!-- col-md-3 col-sm-3 col-xs-12 End -->

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="game_arcade_search">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchkeyword" id="usr" placeholder="Search by keyword">
                            </div>
                        </div><!-- game_arcade_search End -->
                    </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="game_arcade_enter_btn">
                            <button type="submit" class="btn btn-lg btn-fb waves-effect waves-light">Enter</button>
                        </div><!-- game_arcade_enter_btn End -->
                    </div><!-- col-md-2 col-sm-2 col-xs-12 End -->
                </form>
            </div><!-- row End -->
        </div><!-- game_arcade_selected End -->
        <div class="game_arcade_view">

            <div class="row">
                @if(isset($gameDetail)&&!empty($gameDetail))
                @forelse($gameDetail as $key => $gameDetails)

                <div class="col-md-3 col-sm-3 col-xs-6">

                    <div class="game_arcade_gallery">
                        @if((!isset($gameDetails->g_photo)||$gameDetails->g_photo=='')  && (!isset($gamethumbpath)))
                        <?php
                        $gameDetails['g_photo'] = 'product_img.jpg';
                        $gamethumbpath = 'frontend/images/'
                        ?>
                        @endif
                        <img src="{{ asset($gamethumbpath.'/'.$gameDetails->g_photo) }}" alt="product_img" class="img-responsive">
                        <span><h3><a href="{{url('gamedetail/'.$gameDetails->id)}}">{{$gameDetails->g_title}}</a></h3></span>
                        <span>
                            <h3>

                                <?php $game = Helpers::getGameCategoryName($gameDetails->g_category_id); ?>
                                <?php foreach ($game as $value) { ?>
                                    {{$value->gc_title}}
                                <?php } ?>

                            </h3>
                        </span>
                       
                        
                        
                        <div class="mobi_game_title"><img src="frontend/images/star.png"> Game name</div><!-- mobi_game_title End -->
                        <p>100 Coins required to play this game.</p>
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="zmdi zmdi-facebook"></i>
                                    <p>Share</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="zmdi zmdi-facebook"></i>
                                    <p>Share</p>
                                </a>
                            </li>
                        </ul>
                        @if (Auth::front()->check())
                       <a href="{{url('savefavoritegamehome/'.$gameDetails->id)}}" class="f_game"><img src="frontend/images/add-to-favorite.png"> </a>                                                    
                        @else
                        <a href="javascript:void(0)" class="f_game"><img src="frontend/images/add-to-favorite.png"> </a>
                        @endif
                    </div><!-- game_arcade_gallery End -->

                </div><!-- col-md-3 col-sm-3 col-xs-6 End -->
                @empty
                <div style="margin-top: 50px;">
                    <center>
                        <h3>No Record Found</h3>                                        
                    </center>
                </div>
                @endforelse
                @endif
            </div><!-- row End -->

        </div><!-- game_arcade_view End -->
        <div class="cst_pagination">
            <ul class="pagination pagination-sm">
                {!! $gameDetail->render() !!}
                <!--<span><img src="{{ asset('/frontend/images/right_pagination.png') }}" alt="right_pagination" class="img-responsive"></span>-->
            </ul><!-- End pagination -->
        </div>
        <div class="vw_advertisement_footer">
            <img src="frontend/images/vw_advertisement_footer.jpg" alt="vw_advertisement_footer">
        </div>
    </div><!-- container End -->
</div><!-- game_arcade_container End -->
<div id="claimbonus-wheel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <img src="frontend/images/bonus-wheel.png" alt="" title="">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <img src="frontend/images/wheel-body.png" class="wheel-position">
                <img src="frontend/images/spin.png" alt="" class="wheel-spin" id="spin" >
                <div id="venues"><div id="name"></div></div>

                <div id="wheel" class="scroll-wheel">
                    <canvas id="canvas" width="490" height="490"></canvas>
                </div>		
                <img src="frontend/images/top-point.png" class="pointer">
                <div class="total-win">
                    <span class="left">Total Win</span>
                    <span class="score"></span>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php 
$point = Helpers::getpoint(); 
if(isset($point) && !empty($point))
{
    foreach($point as $k=>$v)
{
    
   $value = $v->sw_reward_coins;
   $final[] = array('point' => "$value");
   $finaldailycoin = json_encode($final);
}
}    
    
else{
    $finaldailycoin = [];
}
        


?>
@stop
@section('script')
    <script type=text/javascript>
    var CSRF_TOKEN = "{{ csrf_token() }}";
    var venues = <?php echo $finaldailycoin; ?>        
    </script>
    
<script src="{{ asset('frontend/js/jquery.easydropdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/wheel.js') }}"></script>
<script type="text/javascript">
                                     
                                    function getDataOfSubCategory(CategoryId)
                                    {
                                        $("#g_subcategory_id").empty();
                                        $.ajax({
                                            type: 'GET',
                                            url: '/getGameSubCategory/' + CategoryId,
                                            dataType: "JSON",
                                            success: function (JSON) {
                                                $("#g_subcategory_id").empty()
                                                $("#g_subcategory_id").append($("<option>Sub Category</option>").val("0"))
                                                for (var i = 0; i < JSON.length; i++) {
                                                    $("#g_subcategory_id").append($("<option></option>").val(JSON[i].id).html(JSON[i].gc_title))
                                                }
                                            }
                                        });
                                    }
                                    function display_c() {
                                        var refresh = 1000; // Refresh rate in milli seconds
                                        mytime = setTimeout('display_ct()', refresh)
                                    }

                                    function display_ct() {
                                        var strcount
                                        var x = new Date()
                                        document.getElementById('ct').innerHTML = x;
                                        tt = display_c();
                                    }

</script>

@stop


