<!DOCTYPE html>
<html>
<head>
<title>VW</title>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- <link rel="stylesheet" type="text/css" href="http://fezvrasta.github.io/bootstrap-material-design/dist/css/ripples.min.css"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/bootstrap-material-design.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/ripples.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/material-design-iconic-font.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{('/frontend/css/owl.transitions.css')}}">


<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
@yield('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}">
</head>
<body>
<?php  if(isset($controller)&&!empty($controller)) ; else $controller=''?>
    <div class="nav_main">
        <div class="navbar navbar-default">
          <div class="container">
            <div class="nav_inner">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand active" href="{{url('/')}}"><img src="{{ asset('/frontend/images/logo.png') }}" alt="logo"></a>
              </div><!-- End navbar-header -->
                @if (!Auth::front()->check())
                <div class="cst_signup">
                <ul class="nav navbar-nav navbar-right">
                  <li>
                    <a href="{{url('/login')}}">Login</a>
                  </li>
                </ul>
              </div>
                  @endif
              <div class="navbar-collapse collapse navbar-responsive-collapse">
               
                   @if (Auth::front()->check())
                    <ul class="nav navbar-nav navbar-right cst_default_user">
                     <li class="dropdown">
                <a href="javascript:void(0)" data-target="#" class="dropdown-toggle cst_username" data-toggle="dropdown" aria-expanded="false">{{Auth::front()->get()->fu_user_name}}
                  </a>
                    <ul class="dropdown-menu cst_logout">
                      <li><a href="{{ url('/logout')}}">Logout</a></li>
                    </ul>
                  </li>
                  <li>
                  <?php 
                    $userAvtarUrl = Helpers::userAvatarUrl();
                  ?>
                    <a href="{{ asset('editprofile')}}" class="user_img"><img src="{{ asset( $userAvtarUrl)}}" alt="user profile"></a>
                  </li>
                  </ul>
                  @endif
                <ul class="nav navbar-nav cst_menu">
                  <li class="dropdown">
                      <a href="javascript:void(0)" data-target="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">My Account
                      <b class="caret"></b></a>
                       @if (Auth::front()->check())
                      <ul class="dropdown-menu">
                          <li><a href="{{ asset('editprofile')}}">Edit Profile</a></li>
                          <li><a href="javascript:void(0)">My Rewards</a></li>
                          <li><a href="{{ asset('purchasevoucherhistory')}}">My Vouchers</a></li>
                          <li><a href="{{ asset('purchasecoinshistory')}}">My Play Coins</a></li>
                          <li><a href="{{ asset('orderhistory')}}">Order History</a></li>
                          <li><a href="{{ asset('purchasevoucherhistory')}}">Purchase Vouchers</a></li>
                          <li><a href="{{ asset('purchasecoinshistory')}}">Purchase Play Coins</a></li>
                      </ul>
                      @else
                      <ul class="dropdown-menu">
                          <li><a href="javascript:void(0)">Edit Profile</a></li>
                          <li><a href="javascript:void(0)">My Rewards</a></li>
                          <li><a href="javascript:void(0)">My Vouchers</a></li>
                          <li><a href="javascript:void(0)">My Play Coins</a></li>
                          <li><a href="javascript:void(0)">Order History</a></li>
                          <li><a href="javascript:void(0)">Purchase Vouchers</a></li>
                          <li><a href="javascript:void(0)">Purchase Play Coins</a></li>
                      </ul>
                      @endif
                  </li>
                  
                  <li class="dropdown <?php if ($controller == 'GameController') {echo 'active';}?>">
                      <a href="javascript:void(0)" data-target="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Game Arcade
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a href="{{url('/game')}}">Play Arcade</a></li>
                          @if (Auth::front()->check())
                            <li><a href="{{url('/favoritegame')}}">Favorite Games</a></li>
                          @else
                            <li><a href="javascript:void(0)">Favorite Games</a></li>
                          @endif
                      </ul>
                  </li>
                  
                  <li class="dropdown <?php if ($controller == 'ProductController') {echo 'active';}?>">
                      <a href="javascript:void(0)" data-target="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" <?php if ($controller == 'ProductController') {echo 'active';}?> >Store
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a href="{{url('/product') }}">View Products</a></li>
                          
                          @if (Auth::front()->check())
                          
                          
                          <li><a href="/saveditems">Saved Items</a></li>
                          <li><a href="{{url('/previouslyvieweditem') }}">Previously Viewed Items</a></li>
                          <li><a href="{{url('/mycart')}}">My Cart</a></li>
                      @else
                            <li><a href="javascript:void(0)">My Cart</a></li>
                           <li><a href="javascript:void(0)">Saved Items</a></li>                           
                          <li><a href="javascript:void(0)">Previously Viewed Items</a></li>
                          
                      @endif
                       @if (Auth::front()->check())
                          <li><a href="{{url('/purchechased') }}">Previously Purchased Items</a></li>
                      @else
                          <li><a href="javascript:void(0)">Previously Purchased Items</a></li>
                      @endif

                      </ul>
                  </li>
                  <li class="dropdown <?php if ($controller == 'AuctionController' || $controller == 'WatchedItemsController') {echo 'active';}?>">
                      <a href="javascript:void(0)" data-target="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Auctions
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a href="{{url('/auction') }}">View Auctions</a></li>
                          <li><a href="javascript:void(0)">Bidding Activity</a></li>
                          @if (Auth::front()->check())
                            <li><a href="{{url ('/auctionwon') }}">Auctions Won</a></li>
                          @else
                            <li><a href="javascript:void(0)">Auctions Won</a></li>
                          @endif
                          
                          @if (Auth::front()->check())
                            <li><a href="{{ url('/auctionlost')}}">Auctions Lost</a></li>
                          @else
                            <li><a href="javascript:void(0)">Auctions Lost</a></li>
                          @endif
                          
                          <li><a href="{{url('/watcheditems') }}">Watched Auctions</a></li>
                          
                          
                          
                          
                          
<!--                          <li><a href="javascript:void(0)">Previously Viewed Items</a></li>-->
                      </ul>
                  </li>
                  <li class="<?php if ($controller == 'ForumController') {echo 'active';}?>"><a href="{{url('/forum') }}">Forum </a></li>
                  <li class="<?php if ($controller == 'NewsController') {echo 'active';}?>" ><a href="{{url('/news') }}">News</a></li>
                  <li class="<?php if ($controller == 'ContactUSController') {echo 'active';}?>"><a href="{{ url('/contact_us')}}">Contact Us</a></li>
                  <li>
                 @if (Auth::front()->check())
                    <ul class="nav navbar-nav navbar-right cst_user_list">
                  <li class="dropdown">
                  <a href="javascript:void(0)" data-target="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{Auth::front()->get()->fu_user_name}}
                    </a>
                       <ul class="dropdown-menu cst_logout">
                        <li><a href="{{ url('/logout')}}">Logout</a></li>
                      </ul>
                  </li>
                  <?php 
                    $userAvtarUrl = Helpers::userAvatarUrl();
                  ?>
                  <li>
                    <a href="{{ asset('editprofile')}}" class="user_img"><img src="{{ asset( $userAvtarUrl)}}" alt="user profile"></a>
                  </li>
                  </ul>
                  @endif
                  </li>
                    </ul>
              </div><!-- End navbar-collapse -->
              @if (Auth::front()->check())
              <div class="user_points">
                 <ul>
                  <li><a href="javascript:void(0)">Vouchers  <span><?php echo Helpers::getTotalVouchers(Auth::front()->get()->id); ?></span></a></li>
                  <li><a href="javascript:void(0)">Reward Points <span><?php echo Helpers::getAvailableRewardPoints(Auth::front()->get()->id); ?></span></a></li>
                </ul>
              </div><!-- End user_points -->
              <div class="user_cart">
                <ul>
                  <li><a href="javascript:void(0)"><i class="fa fa-bell-o" aria-hidden="true"></i></a></li>
                  <li><a href="{{url('/mycart')}}"><i class="fa fa-shopping-cart" aria-hidden="true"><?php echo Helpers::getCartItem(Auth::front()->get()->id); ?></a></i></li>
                </ul>
              </div>
              @endif
            </div><!-- End nav_inner -->
          </div><!-- End container -->
        </div><!-- End navbar-default -->
    </div><!-- End nav_main -->



  @yield('content')

  <div class="social_main">
      <div class="container">
          <div class="social_content">
               <div class="social_content_box">
                   <a href="{{url('https://www.facebook.com/VoucherWins/')}}" target="blank" class="btn btn-raised face"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
               </div><!-- social_content_box End -->
               <div class="social_content_box">
                   <a href="{{url('https://plus.google.com/u/1/110186228999869821425/')}}" target="blank" class="btn btn-raised go"><i class="fa fa-google-plus" aria-hidden="true"></i> Google</a>
               </div><!-- social_content_box End -->
               <div class="social_content_box">
                   <a href="{{url('https://twitter.com/VoucherWins')}}" target="blank" class="btn btn-raised tw"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a>
               </div><!-- social_content_box End -->
               <div class="social_content_box">
                   <a href="{{url('https://www.youtube.com/channel/UCmXLW50Vk1c687CDY2P9blA')}}" target="blank" class="btn btn-raised yo"><i class="fa fa-youtube" aria-hidden="true"></i> Youtube</a>
               </div><!-- social_content_box End -->
           </div><!-- social_content End -->
      </div><!-- container End -->
  </div><!-- social_main End -->

  <div class="footer_main">
      <div class="container">
          <div class="row">
              <div class="col-md-3 col-sm-3 col-xs-12">
                   <div class="footer_box">
                   <?php $about_us_footer = Helpers::about_us_footer();
                    ?>
                      <a href="{{ url('/CMS/about-us')}}"><h2>{{$about_us_footer->cms_subject}}</h2></a>
                       
                       {!! str_limit(strip_tags($about_us_footer->cms_body), $limit = 250, $end = '...') !!} 
                   </div><!-- footer_box End -->
              </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
               <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="footer_box">
                      <h2>Account Services</h2>
                      <ul>
                      @if (Auth::front()->check())
                          <li><a href="{{url('/editprofile')}}">My Account</a></li>
                          <li><a href="{{ asset('orderhistory')}}">Order History</a></li>
                          <li><a href="{{url('/watcheditems') }}">Watched Auctions</a></li>
                          <li><a href="{{url('/previouslyvieweditem') }}">Previously Viewed Items</a></li>
                      @else
                          <li><a href="javascript:void(0)">My Account</a></li>
                          <li><a href="javascript:void(0)">Order History</a></li>
                          <li><a href="javascript:void(0)">Watched Auctions</a></li>
                          <li><a href="javascript:void(0)">Previously Viewed Items</a></li>
                      @endif
                          
                      </ul>
                  </div><!-- footer_box End -->
              </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
              <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="footer_box">
                      <h2>Support</h2>
                      <ul>
                          <li><a href="{{ url('/CMS/support-center')}}">Support Center</a></li>
                          <li><a href="{{ url('/CMS/how-it-works')}}">How It Works</a></li>
                          <li><a href="{{ url('/contact_us')}}">Contact Us</a></li>
                          <li><a href="{{ url('/CMS/delivery')}}">Delivery</a></li>
                      </ul>
                  </div><!-- footer_box End -->
              </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
              <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="footer_box">
                      <h2>Information</h2>
                      <ul>
                          <li><a href="{{ url('/CMS/frequently-asked-questions')}}">FAQ</a></li>
                          <li><a href="{{ url('/CMS/site-rules')}}">Site Rules</a></li>
                          <li><a href="{{ url('/CMS/privacy--policy')}}">Privacy & Policy</a></li>
                          <li><a href="{{ url('/CMS/terms-of-service')}}">Terms & Service</a></li>
                      </ul>
                  </div><!-- footer_box End -->
              </div><!-- col-md-3 col-sm-3 col-xs-12 End -->
            </div><!-- row End -->
      </div><!-- container End -->
  </div><!-- footer_main End -->
 
  <div class="copyright_main">
      <div class="container">
          <p><i class="fa fa-copyright" aria-hidden="true"></i> VOUCHER WINS  | All Right Reserved</p>
      </div><!-- container End -->
  </div><!-- copyright_main End -->

  <div class="mb_social">
    <div class="container">
      <div class="mb_sicon">
        <ul>
          <li>
            <div class="m_fb"><a href="javascript:void(0)" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            </div>
          </li>
          <li>
            <div class="m_gp"><a href="javascript:void(0)" class="fb"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
            </div>
          </li>
          <li>
            <div class="m_tw"><a href="javascript:void(0)" class="fb"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </div>
          </li>
          <li>
            <div class="m_yt"><a href="javascript:void(0)" class="fb"><i class="fa fa-youtube" aria-hidden="true"></i></a>
            </div>
          </li>
        </ul>
      </div><!-- mb_sicon End -->
      <div class="cst_conditions">
        <ul>
          <li><a href="{{ url('/CMS/privacy--policy')}}" class="condtn_name">Privacy & Policy</a></li>
          <li><a href="{{ url('/CMS/terms-of-service')}}" class="condtn_name">Terms & Service</a></li>
        </ul>
      </div><!-- cst_conditions End -->
    </div><!-- container End -->
  </div><!-- mb_social End -->

  <div class="footer_advt">
    <img src="{{ asset('/frontend/images/footer_advertise.png') }}" alt="advertisement">
    <span><i class="fa fa-times" aria-hidden="true"></i></span>    
  </div><!-- footer_advt End -->
    

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{ asset('frontend/js/ripples.js') }}"></script>
<script src="{{ asset('frontend/js/material.min.js') }}"></script>

@yield('script')
<script src="{{ asset('frontend/js/main.js') }}"></script>


</body>
</html>
