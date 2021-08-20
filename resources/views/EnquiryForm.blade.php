@extends('Master')
@section('css')

<!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
<!-- Template Stylesheet -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet">    





@stop
@section('content')
  <div class="wrapper">
            <!-- Top Bar Start -->
            <div class="top-bar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="logo">
                                <a href="{{asset('/')}}">
                                    <h1>Sanskardham Sports Academy</h1>
                                    <!-- <img src="img/logo.jpg" alt="Logo"> -->
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->

            <!-- Nav Bar Start -->
            
            <!-- Nav Bar End -->
            
            
            <!-- Page Header Start -->
            <div class="page-header">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3>Enquiry Form</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page Header End -->


            <!-- About Start -->
            <div class="about">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12">
                          <form action="{{asset('enquiry/submit')}}" method="post" name="enquiryform" onsubmit="return validateForm()">
                               {{ csrf_field() }}
                          </form>
                            <div class="col-md-12 col-lg-12 col-sm-12">
                              <div class="col-md-3 col-lg-3 col-sm-12">                
                                <label for="name">Name</label>
                              </div>
                              <div class="col-md-9 col-lg-9 col-sm-12" > 
                                <div class="form-group">                        
                                  <input type="text" class="form-control" id="name" placeholder="Student's Full Name (As Per GR.)" required name="name">
                                </div>    
                              </div>             
                            </div>
                             
                            
                        </div>
                    </div>
                </div>
            </div>
            
<!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="{{asset('lib/easing/easing.min.js')}}"></script>
        <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
        <script src="{{asset('lib/isotope/isotope.pkgd.min.js')}}"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>

    <script>
      function validateForm() {  
        var f = document.forms["class11"]["fathname"].value;
        var m = document.forms["class11"]["mothname"].value;
        if (f == "" && m == "") {
        alert("Please Provide any of the Parents details");
        return false;
        }
      }
    </script>
@stop