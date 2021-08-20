<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{trans('adminlabels.appname')}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/dataTables.bootstrap.css')}}" /> 
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/jquery.dataTables.min.css')}}" />
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="{{ asset('/backend/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('/backend/css/bootstrap.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('/backend/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('/backend/css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/backend/css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{ asset('/backend/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/css/jquery-ui.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/css/custom.css')}}">      
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-datetimepicker.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/dataTables.bootstrap.css')}}" /> 
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/jquery.dataTables.min.css')}}" />       

        @yield('header')
    </head>
    @if (Auth::admin()->check())
    <body class="hold-transition skin-blue sidebar-mini">
        @else
    <body class="hold-transition login-page">
        @endif

        <div class="wrapper">
            @if (Auth::admin()->check())
            <?php
            if (isset($controller) && !empty($controller))
                ;
            else
                $controller = ''
                ?>

            <header class="main-header">
                <!-- Logo -->
                <a href="{{ url('/admin')}}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>{{trans('adminlabels.appshortname')}}</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>{{trans('adminlabels.appname')}}</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">{{trans('adminlabels.togglenav')}}</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset('/backend/images/avatar5.png')}}" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{{Auth::admin()->get()->name}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="{{ asset('/backend/images/avatar5.png')}}" class="img-circle" alt="User Image">
                                        <p>
                                            {{Auth::admin()->get()->name}}
                                        </p>
                                    </li>

                                    <li class="user-footer">
                                        <div style="text-align: center;">
                                            <a href="{{ url('/admin/logout')}}" class="btn btn-default btn-flat">{{trans('adminlabels.logout')}}</a>
                                        </div>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset('/backend/images/avatar5.png')}}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{Auth::admin()->get()->name}}</p>
                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="<?php
                        if (Route::current()->getUri() == 'admin/dashboard') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.dashboard')}}</span>
                            </a>
                        </li>
                        <li class="<?php
                        if ($controller == 'UserManagementController') {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/user') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.user')}}</span>
                            </a>
                        </li>

                        <li class="<?php
                        if ($controller == 'CMSManagementController' || $controller == 'TemplateManagementController') {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/cms') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.templates')}}</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'CMSManagementController') {
                                    echo 'active';
                                }
                                ?> "><a href="{{ url('admin/cms') }}"><i class="fa fa-circle-o"></i>{{trans('adminlabels.cms')}}</a></li>
                                <li class="<?php
                                if ($controller == 'TemplateManagementController') {
                                    echo 'active';
                                }
                                ?> "><a href="{{ url('admin/templates') }}"><i class="fa fa-circle-o"></i>{{trans('adminlabels.emailtemplates')}}</a></li>
                            </ul>

                        </li>



                        <li class="<?php
                        if ($controller == 'VoucherManagementController' || $controller == 'PurchasevoucherManagementController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/vouchers') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.Voucher')}}</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'VoucherManagementController') {
                                    echo 'active';
                                }
                                ?>">
                                    <a href="{{url('admin/vouchers') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.Voucher')}}</span>
                                    </a>
                                </li>


                                <li class="<?php
                                if (Request::is('admin/purchasevoucher')) {
                                    echo 'active';
                                }
                                ?> treeview">

                                    <a href="{{ url('admin/purchasevoucher') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.formlblepruchasevoucher')}}</span>
                                    </a>
                                </li>

                                <li class="<?php
                                if (Request::is('admin/earnedvoucher')) {
                                    echo 'active';
                                }
                                ?> treeview">

                                    <a href="{{ url('admin/earnedvoucher') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.formlbleearnvoucher')}}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="<?php
                        if ($controller == 'CoinManagementController' || $controller == 'DailycoinManagementController' || $controller == 'PurchasecoinManagementController') {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/coins') }}">
                                <i class="fa fa-angle-left pull-right"></i>  <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.coin')}}</span>
                            </a>

                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'CoinManagementController') {
                                    echo 'active';
                                }
                                ?> "><a href="{{ url('admin/coins') }}"><i class="fa fa-circle-o"></i>{{trans('adminlabels.coin')}}</a></li>

                                <li class="<?php
                                if ($controller == 'DailycoinManagementController') {
                                    echo 'active';
                                }
                                ?>"><a href="{{ url('admin/dailycoins') }}"><i class="fa fa-circle-o"></i>{{trans('adminlabels.dailycoin')}}</a></li>
                                <li class="<?php
                                if ($controller == 'PurchasecoinManagementController') {
                                    echo 'active';
                                }
                                ?>"><a href="{{ url('admin/purchasecoin') }}"><i class="fa fa-circle-o"></i>{{trans('adminlabels.formlblepruchasecoin')}}</a></li>
                            </ul>	
                        </li>
                        </li>  
                        <li class="<?php
                        if ($controller == 'SliderManagementController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/slider') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('labels.slider')}}</span>
                            </a>
                        </li>
                        <li class="<?php
                        if ($controller == 'RewardConversationManagementController') {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/rewardconversation') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.Rewardconversation')}}</span>
                            </a>
                        </li>

                        <li class="<?php
                        if ($controller == 'ForumManagementController' || $controller == 'ForumCategoryManagementController' || $controller == 'ForumPostManagementController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/forumcategory') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.forum')}}</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'ForumCategoryManagementController') {
                                    echo 'active';
                                }
                                ?>">
                                    <a href="{{url('admin/forumcategory') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.forum_category')}}</span>
                                    </a>
                                </li>
                                <li class="<?php
                                if ($controller == 'ForumManagementController') {
                                    echo 'active';
                                }
                                ?>">
                                    <a href="{{ url('admin/forum') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.forum')}}</span>
                                    </a>
                                </li>

                            </ul>

                        </li> 

                        <li class="<?php
                        if ($controller == 'ProductManagementController' || $controller == 'ProductcategoryManagementController' || $controller == 'ProductManagementController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/product') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.product')}}</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'ProductManagementController') {
                                    echo 'active';
                                }
                                ?>">
                                    <a href="{{url('admin/product') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.product')}}</span>
                                    </a>
                                </li>
                                <li class="<?php
                                if ($controller == 'ProductcategoryManagementController') {
                                    echo 'active';
                                }
                                ?> treeview">

                                    <a href="{{ url('admin/productcategory') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.productcategory')}}</span>
                                    </a>
                                </li>

                            </ul>

                        </li>



                        <li class="<?php
                        if ($controller == 'AuctionController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/auction') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.formlblauction')}}</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'AuctionController') {
                                    echo 'active';
                                }
                                ?>  treeview">
                                    <a href="{{ url('admin/auction') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.formlblauction')}}</span>
                                    </a>
                                </li>
                                <li class="<?php
                                if (Request::is('admin/request')) {
                                    echo 'active';
                                }
                                ?>  treeview">
                                    <a href="{{ url('admin/request') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.auctionrequest')}}</span>
                                    </a>
                                </li>

                            </ul>

                        </li>


                        <li class="<?php
                        if ($controller == 'GameManagementController' || $controller == 'GamecategoryManagementController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/game') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.game')}}</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php
                                if ($controller == 'GameManagementController') {
                                    echo 'active';
                                }
                                ?>">
                                    <a href="{{url('admin/game') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.game')}}</span>
                                    </a>
                                </li>
                                <li class="<?php
                                if ($controller == 'GamecategoryManagementController') {
                                    echo 'active';
                                }
                                ?> treeview">

                                    <a href="{{ url('admin/gamecategory') }}">
                                        <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.gamecategory')}}</span>
                                    </a>
                                </li>

                            </ul>

                        </li>

                        <li class="<?php
                        if ($controller == 'NewsManagementController') {
                            echo 'active';
                        }
                        ?> treeview">
                            <a href="{{ url('admin/news') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.news')}}</span>
                            </a>
                        </li>


                        <li class="<?php
                        if (Request::is('admin/order')) {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/order') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.orderhistory')}}</span>
                            </a>
                        </li>

                        <li class="<?php
                        if ($controller == 'GeneralSettingController') {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/setting') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.setting')}}</span>
                            </a>
                        </li>

                        <li class="<?php
                        if ($controller == 'TransactionsController') {
                            echo 'active';
                        }
                        ?>  treeview">
                            <a href="{{ url('admin/transactions') }}">
                                <i class="fa fa-dashboard"></i> <span>{{trans('adminlabels.transactios')}}</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            @endif

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

            @if (Auth::admin()->check())

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    {!! trans('adminlabels.version') !!}
                </div>
                <strong>Copyright &copy; {{date("Y")}}-{{date("Y")+1}} <a href="{{url('/')}}">VoucherWins</a>.</strong> All rights reserved.
            </footer>
            @endif
            @yield('footer')
        </div>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script src="{{ asset('backend/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="{{ asset('backend/js/bootstrap.min.js')}}"></script>
        <!-- SlimScroll -->
        <script src="{{ asset('backend/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{ asset('backend/plugins/fastclick/fastclick.min.js')}}"></script>               
        <!-- Datatable -->        
        <script type="text/javascript" src="{{ asset('backend/js/jquery.dataTables.min.js') }}"></script>   
        <script type="text/javascript" src="{{ asset('backend/js/dataTables.bootstrap.min.js') }}"></script>  
        <script type="text/javascript" src="{{ asset('backend/js/dataTables.bootstrap.js') }}"></script> 
        <!-- backendLTE App -->
        <script src="{{ asset('backend/js/app.min.js')}}"></script>
        <script src="{{ asset('backend/js/jquery.validate.min.js') }}"></script>
        <!-- Datepicker --> 
        <script src="{{ asset('backend/js/jquery-ui.js') }}"></script>

        <script type="text/javascript" src="{{ asset('backend/js/bootstrap-datetimepicker.min.js')}}"  charset="UTF-8"></script>



        @yield('script')

    </body>
</body>
</html>