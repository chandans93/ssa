@extends('front.Master')
@section('css')
 

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
@stop
@section('content')

</head>

<body>

    <div class="page-wrapper bg-gra-02 p-b-100 font-poppins">
        <div class="wrapper wrapper--w960">
            <div class="card card-4">
                <div class="card-menue">
                    <h2> <a href="{{ asset('/')}}" class="logo">HOME</a></h2>
                    
                </div>
            </div>
        </div>
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Enquiry form</h2>
                    <form method="POST" action="{{asset('/Enquiry/submit')}}" name="Enquiry_form">
                         {{ csrf_field() }}
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">first name</label>
                                    <input class="input--style-4" type="text" name="first_name">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">last name</label>
                                    <input class="input--style-4" type="text" name="last_name">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Birthday</label>
                                    <div class="input-group-icon">
                                        <input class="input--style-4 js-datepicker" type="text" name="birthday">
                                        <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" checked="checked" name="gender" value="Male">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" name="gender" value="Female">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" name="email">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number</label>
                                    <input class="input--style-4" type="text" name="phone">
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label class="label">Facilities Interested in</label>
                          
                           
                                <div class="checkbox">
                                    <label> <input type="checkbox" id="facilities1" name="facilities1" value="Football"> Football</label>
                                </div>
                                <div class="checkbox">
                                <label for="facilities1"><input type="checkbox" id="facilities2" name="facilities2" value="Volleyball"> Volleyball</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities3"><input type="checkbox" id="facilities3" name="facilities3" value="Tennis"> Tennis</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities4"><input type="checkbox" id="facilities4" name="facilities4" value="Shooting"> Shooting</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities5"><input type="checkbox" id="facilities5" name="facilities5" value="Horse riding"> Horse riding</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities6"><input type="checkbox" id="facilities6" name="facilities6" value="Badminton"> Badminton</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities6"><input type="checkbox" id="facilities6" name="facilities6" value="Badminton"> Badminton</label>
                                </div>
                                <div class="checkbox">
                                     <label for="facilities7"><input type="checkbox" id="facilities7" name="facilities7" value="Athletics"> Athletics</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities8"><input type="checkbox" id="facilities8" name="facilities8" value="Chess"> Chess</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities9"> <input type="checkbox" id="facilities9" name="facilities9" value="Judo">Judo</label>
                                </div>
                                <div class="checkbox">
                                    <label for="facilities10"><input type="checkbox" id="facilities10" name="facilities10" value="Table Tennis"> Table Tennis</label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" id="facilities11" name="facilities11" value="Karate"><label for="facilities11"> Karate</label>
                                </div>
                                
                                <div class="input-group">
                                    <label class="label">Other
                                    <input class="input--style-4" type="text" name="facilities12"> </label>
                                </div>
                          </div>
                          

                         <div class="input-group">
                            <label class="label">Address <input class="input--style-4" type="text" name="address"></label>
                            
                        </div>

                         
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     @stop  
    
    <!-- Global Init -->

@section('script')

   
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>
@stop 

<!-- end document-->