<!DOCTYPE html>
<html>
<head>
<title>VW</title>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/bootstrap-material-design.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/ripples.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/material-design-iconic-font.css')}}">
<link href="{{ asset('/frontend/css/jquery-ui-1.10.1.css')}}" rel="stylesheet">
<link href="{{ asset('/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('/frontend/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/frontend/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}">
</head>
<body>

<div class="top_bar"></div><!-- top_bar -->
<div class="login_main">
    <div class="container">
        <div class="login_header_logo">
            <a href="{{ url('/') }}"><img src="{{ asset('frontend/images/login_logo.png') }}" align="logo" class="img-responsive"></a>
        </div><!-- login_header_logo End -->
        <div class="login_content">
            <div class="row">
			<form id="completeprofile" name="editprofileform" method="post" action="{{ url('savecompleteprofile') }}" enctype="multipart/form-data">
                <div class="col-md-offset-1 col-md-10 col-sm-12 col-xs-12">
                    <div class="login_inner">
                        <h2>Complete Profile</h2>         
                       <div class="complete_profile_content">
						              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="comp_pro_user cst_choose_avtar_btn">
                                <div class="comp_pro_user_name clearfix">
                                   <div class="pro_user_name"><span class="cst_proname">{{trans('frontlabels.username')}} </span><span class="cst_pro">{{Auth::front()->get()->fu_user_name}}</span></div>
                               </div><!-- comp_pro_user_name End -->
                               
                               <?php 
                        if (old('fu_avatar'))
                            $fu_avatar = old('fu_avatar');
                        else
                            $fu_avatar = '';
                        ?>   
                            @if (old('fu_avatar'))
                            <div id="display_image" class="comp_pro_user_img avatar"></div>
                            @else
                           <div id="display_image" class=" comp_pro_user_img avatar">
                                        <img id="blah" src="{{ asset('/upload/avatar/ava1.jpg')}}" alt="Default Image"  height="100">
                            </div>
                            @endif
                               <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
                                  {{trans('frontlabels.chooseavatar')}}
                               <div class="ripple-container"></div></button>
                                <input type="hidden" name="fu_avatar" id="fu_avatar" value="{{$fu_avatar}}">
                           </div><!-- comp_pro_user End  -->
                        </div><!-- complete_profile_content End  -->
                        <div class="delivery_information new_select">
                            <h2>{{trans('frontlabels.deliveryinformation')}}</h2>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="delivery_information_from">
                                        <div class="form-group label-floating is-empty fu_address1">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <label for="i5i" class="control-label">{{trans('frontlabels.addressline1')}}</label>
                                            <input type="text" name="fu_address1" class="form-control" id="i5i" value="">
                                        </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-6 col-sm-6 col-xs-12 End -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="delivery_information_from">
                                        <div class="form-group label-floating is-empty">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <label for="i5i" class="control-label">{{trans('frontlabels.addressline2')}}</label>
                                                <input type="text" name="fu_address2" class="form-control" id="i5i" value="">
                                        </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-6 col-sm-6 col-xs-12 End -->

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <div class="delivery_information_from">
                                                            <div class="form-group label-floating is-empty delivery_dropdown">
                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                        <?php $countries = Helpers::getCountries(); ?>
                    <select class="select"  id="fu_country" name="fu_country" onchange="getDataOfState(this.value)">
                        <option value="">{{trans('adminlabels.formlblselectcountry')}}</option>
                        <?php foreach ($countries as $key => $value) { ?>
                            <option value="{{$value->id}}"  >{{$value->c_name}}</option>
                        <?php } ?>
                    </select>
                                    </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-6 col-sm-6 col-xs-12 End -->
                                
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="delivery_information_from">
                                        <div class="form-group label-floating is-empty delivery_dropdown">
                                <i class="zmdi zmdi-city-alt"></i>
                                <?php $states = Helpers::getStates(); ?>
                    <select class="select" id="fu_state" name="fu_state" onchange="getDataOfCity(this.value)">
                        <option value="">{{trans('adminlabels.formlblstate')}}</option>
                        <?php foreach ($states as $key => $value)  { ?>
                         <option value="{{$value->id}}"  >{{$value->s_name}}</option>
                        <?php } ?>
                    </select>
								</div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                               
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="delivery_information_from">
                                        <div class="form-group label-floating is-empty delivery_dropdown">
                                            <i class="zmdi zmdi-city-alt"></i>
                                           <?php $cities = Helpers::getCities(); ?>
                    <select class="select" id="fu_city" name="fu_city">
                        <option value="">{{trans('adminlabels.formlblcity')}}</option>
                        <?php foreach ($cities as $key => $value) { ?>
                            <option value="{{$value->id}}" >{{$value->c_name}}</option>
                        <?php } ?>
                    </select>
                                        </div>
                                      </div><!-- delivery_information_from End -->
                                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                                <div class="col-md-6 col-sm-4 col-xs-12">
                                    <div class="delivery_information_from">
                                        <div class="form-group label-floating is-empty">
                                          <i class="zmdi zmdi-city-alt"></i>
                                            <label for="i5i" class="control-label">{{trans('frontlabels.zipcode')}}</label>
                                            <input type="number" class="form-control" name="fu_zipcode" id="i5i" value="">
                                        </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-4 col-sm-4 col-xs-12 End -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="delivery_information_from">
                                        <div class="form-group label-floating is-empty">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <label for="i5i" class="control-label">{{trans('frontlabels.telephonenumber')}}</label>
                                            <input type="text" name="fu_phone"class="form-control" id="i5i" value="">
                                        </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-6 col-sm-6 col-xs-12 End -->
                            </div><!-- row End -->
                        </div><!-- delivery_information End -->
                        <div class="delivery_information new_select">
                            <h2>{{trans('frontlabels.personalinformation')}}</h2>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                     <!--<div class="date_time_con">
                                       <i class="fa fa-calendar" aria-hidden="true"></i>  
                                         <label for="i5i" class="control-label">{{trans('frontlabels.formlblbdate')}}</label>
                                         <input type="text" class="form-control" id="datetimepicker4"  name="fu_birthdate"value=""/>
                                     </div> date_time_con End --> 
                                     <div class="date_time_con">
                                        <div class="form-group label-floating is-empty">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <label for="i5i" class="control-label">{{trans('frontlabels.formlblbdate')}}</label>
                                            <input type="text" class="form-control" id="datetimepicker4"  name="fu_birthdate"value=""/>
                                        </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-6 col-sm-6 col-xs-12 End -->
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="delivery_dropdown delivery_information_from">
                <div class="form-group label-floating is-empty is-focused">
                                        <i class="zmdi zmdi-male-female"></i>
                                        <?php $gender = Helpers::gender(); ?>
                                      <select class="select" id="fu_gender" name="fu_gender">
                                        <?php foreach ($gender as $key => $value) { ?>
                                          <option value="{{$key}}" >{{$value}}</option>
                                        <?php } ?>
                                      </select>
                                      </div>
                                    </div><!-- delivery_information_from End -->
                                </div><!-- col-md-6 col-sm-6 col-xs-12 End -->
                            </div>
                        </div>
                        <div class="cst_submit comp_pro_btn">
                            <button type="submit" class="btn btn-lg submit_btn waves-effect waves-light">Submit<div class="ripple-container"></div></button>
                        </div>        
                    </div><!-- login_inner End -->
                </div><!-- col-md-8 col-sm-12 col-xs-12 End -->
                </form>
            </div><!--  row End -->
        </div><!-- login_content End -->
        
    </div><!-- container End -->
</div><!-- login_main End -->
<div class="copyright_main login_footer">
    <div class="container">
        <p>VOUCHER WINS | All Right Reserved</p>
    </div><!-- container End -->
</div><!-- copyright_main End -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Select Your Avatar</h4>
            </div>
            <div class="modal-body">
                <?php
                $images = glob($uploadAvatarPath . "*.jpg");
                foreach ($images as $file) {
                    $image_explode_array = explode('/', $file);
                    $image_name = end($image_explode_array);
                    ?>
                    <a href="javascript:void(0);" class="avtar" data-image="{{$image_name}}" data-image_url="{{ url($file) }}" >
                        <img src="{{ url($file) }}" alt="">
                    </a>
                    <?php
                }
                ?>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="{{ asset('frontend/js/ripples.js') }}"></script>
<script src="{{ asset('frontend/js/material.min.js') }}"></script>
<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>   
   <script type="text/javascript">
   $.material.options.autofill = true

     $(document).ready(function(){
        $('#datetimepicker4').datetimepicker({
      useCurrent: false,
      format: 'MM/DD/YYYY',
      maxDate: moment().add(-4749, 'days'),
     });
     });
     function getDataOfState(countryId)
      {
          $.ajax({
              type: 'GET',
              url: '/getState/' + countryId,
              dataType: "JSON",
              success: function (JSON) {
                  $("#fu_state").empty()
                  for (var i = 0; i < JSON.length; i++) {
                      $("#fu_state").append($("<option></option>").val(JSON[i].id).html(JSON[i].s_name))
                  }
              }
          });
      }
      function getDataOfCity(stateId)
      {
          $.ajax({
              type: 'GET',
              url: '/getcity/' + stateId,
              dataType: "JSON",
              success: function (JSON) {
                  $("#fu_city").empty();
                  for (var i = 0; i < JSON.length; i++) {
                      $("#fu_city").append($("<option></option>").val(JSON[i].id).html(JSON[i].c_name));
                  }
              }
          });

      }
     $('body').on('click','.avtar',function(){
        var image_name = $(this).data('image');
        $('#fu_avatar').val(image_name);
        var image_url = $(this).data('image_url');
        $('#display_image').html('<img src="'+image_url+'" />');
        $('#myModal').modal('hide');

    });
     jQuery(document).ready(function() {
                var adminvalidationRules = {
                    fu_address1: {
                        required: true
                    },
                    fu_city: {
                        required: true
                    },
                    fu_state: {
                        required: true
                    },
                    fu_country: {
                        required: true
                    },
                    fu_zipcode: {
                        required: true,
                        digits : true,
                        minlength: 6,
                        maxlength: 12
                    },
                    fu_phone: {
                        required: true,
                        digits : true,
                        minlength: 10,
                        maxlength: 12
                    },
                    fu_avatar: {
                        required: true
                    },
                    fu_birthdate: {
                        required: true
                    },
                    fu_gender: {
                        required: true
                    }
                }
            

        $("#completeprofile").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
                    fu_address1: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                    fu_city: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                    fu_state: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                    fu_country: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                    fu_phone: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                    fu_birthdate: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                    fu_gender: {
                        required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                    },
                }
        })
    });
         

   </script>
   
</body>
</html>