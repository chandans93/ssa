<!DOCTYPE html>
<html>
<head>
<title>SSA</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="All about Sanskardham Sports Acedemy">
<meta name="author" content="Chandan Singh">
<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css')}}">
<!-- <link rel="stylesheet" type="text/css" href="http://fezvrasta.github.io/bootstrap-material-design/dist/css/ripples.min.css"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.css')}}">
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@1,600;1,700;1,800&family=Roboto:wght@400;500&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
<!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

@yield('css')

</head>
<body>




@yield('content')

<!-- jQuery -->
<script src="assets/js/jquery-2.1.0.min.js"></script>

<!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

@yield('script')


</body>
</html>