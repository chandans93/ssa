@extends('front.Master')
@section('css')
<link href="{{asset('/frontend/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
@stop
@section('content')
 <div class="contact_information">
    <div class="container">
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}"  alt="vw_advertisement_footer">
      </div>
      <?php
      if(!isset($userdetail->id)){
        $userdetail->id ='0';
      }
      if(!isset( $userdetail->fu_first_name)){
        $userdetail->fu_first_name ='';
      } 
      if(!isset( $userdetail->fu_last_name)){
        $userdetail->fu_first_name ='';
      } 
      if(!isset($userdetail->fu_email)){
        $userdetail->fu_email ='';
      } 
      if(!isset($userdetail->fu_user_name)){
        $userdetail->fu_user_name ='';
      } 
      if(!isset($userdetail->fu_address1)){
        $userdetail->fu_address1 ='';
      } 
      if(!isset($userdetail->fu_phone)){
        $userdetail->fu_phone ='';
      }  
      if(!isset($userdetail->fu_address2)){
        $userdetail->fu_address2 ='';
      } 
      if(!isset($userdetail->fu_zipcode)){
        $userdetail->fu_zipcode ='';
      }
      if(!isset($userdetail->fu_country)){
        $userdetail->fu_country = '';
      }
      if(!isset($userdetail->fu_state)){
       $userdetail->fu_state = '';
      }
      if(!isset($userdetail->fu_gender)){
        $userdetail->fu_gender= '';
      }
      if(!isset($userdetail->fu_birthdate)){
        $userdetail->fu_birthdate =  '';
      }
?>
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
	<form id="editprofile" name="editprofileform" method="post" action="{{ url('updateprofile') }}" enctype="multipart/form-data">
      <div class="alien_ufo_header">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$userdetail->id}}">
        <h2>{{trans('frontlabels.customerinformation')}}</h2>
      </div>
      <?php
          if (old('fu_avatar'))
              $fu_avatar = old('fu_avatar');
          elseif ($userdetail)
              $fu_avatar = $userdetail->fu_avatar;
          else
              $fu_avatar = '';
          ?>
      <div class="customer_profile cst_change_avtar_btn">
              <?php
              if (isset($userdetail->id) && $userdetail->id != '0') {
                  if (File::exists(public_path($uploadAvatarPath . $userdetail->fu_avatar)) && $userdetail->fu_avatar != '') {
                      ?>
                      <div id="display_image_r" class="avatar comp_pro_user_img">
                          <img id="blah" src="{{ url($uploadAvatarPath.$userdetail->fu_avatar) }}"  alt="{{$userdetail->fu_avatar}}" height="150">
                      </div>
                  <?php } else { ?>
                 <div id="display_image_r" class="avatar comp_pro_user_img">
                      <img id="blah" src="{{asset('/upload/avatar/ava1.jpg')}}" alt="Default Image" class="avatar" height="150" >
                      </div>
                      <?php
                  }
              }
              else
              { ?>
              <div id="display_image_r" class="avatar comp_pro_user_img"></div>
              <?php }
              ?>
            <h3>My Avatar</h3>
            <button type="button" class="comp_pro_user_btn" data-toggle="modal" data-target="#myModal">{{trans('frontlabels.changeavatar')}}</button>
              <input type="hidden" name="fu_avatar" id="fu_avatar_r" value="{{$fu_avatar}}">
            </div>

      <div class="contact_inner new_select">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="delivery_information_from">
              <div class="form-group label-floating is-empty">
                  <i class="zmdi zmdi-account-o"></i>
                  <label for="fn" class="control-label">{{trans('frontlabels.firstname')}}</label>
                  <input type="text" name="fu_first_name"  class="form-control" id="fn" value="{{$userdetail->fu_first_name}}">
              </div>
            </div>
            <div class="delivery_information_from">
              <div class="form-group label-floating is-empty">
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                  <label for="i5i" class="control-label">{{trans('frontlabels.email')}}</label>
                  <input type="email" name="fu_email"  class="form-control" id="em" value="{{$userdetail->fu_email}}">
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">
            <div class="delivery_information_from">
                <div class="form-group label-floating is-empty">
                    <i class="zmdi zmdi-account-o"></i>
                    <label for="i5i" class="control-label">{{trans('frontlabels.lastname')}}</label>
                    <input type="text" name="fu_last_name" class="form-control" id="ln" value="{{$userdetail->fu_last_name}}">
                </div>
            </div>
            <div class="delivery_information_from">
              <div class="form-group label-floating is-empty">
                  <i class="zmdi zmdi-account-o"></i>
                  <label for="i5i" class="control-label">{{trans('frontlabels.username')}}</label>
                  <input type="text" name="fu_user_name" class="form-control" id="fn" value="{{$userdetail->fu_user_name}}">
              </div>
            </div>
          </div>
          <?php
          if (old('fu_avatar'))
              $fu_avatar = old('fu_avatar');
          elseif ($userdetail)
              $fu_avatar = $userdetail->fu_avatar;
          else
              $fu_avatar = '';
          ?>

          <div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-12">
            <div class="customer_profile cst_change_avtar_btn">
              <?php
              if (isset($userdetail->id) && $userdetail->id != '0') {
                  if (File::exists(public_path($uploadAvatarPath . $userdetail->fu_avatar)) && $userdetail->fu_avatar != '') {
                      ?>
                      <div id="display_image" class="avatar comp_pro_user_img">
                          <img id="blah" src="{{ url($uploadAvatarPath.$userdetail->fu_avatar) }}"  alt="{{$userdetail->fu_avatar}}" height="150">
                      </div>
                  <?php } else { ?>
                 <div id="display_image" class="avatar comp_pro_user_img">
                      <img id="blah" src="{{asset('/upload/avatar/ava1.jpg')}}" alt="Default Image" class="avatar" height="150" >
                      </div>
                      <?php
                  }
              }
              else
              { ?>
              <div id="display_image" class="avatar comp_pro_user_img"></div>
              <?php }
              ?>
            <h3>My Avatar</h3>
            <button type="button" class="comp_pro_user_btn" data-toggle="modal" data-target="#myModal">{{trans('frontlabels.changeavatar')}}</button>
              <input type="hidden" name="fu_avatar" id="fu_avatar" value="{{$fu_avatar}}">
            </div>
          </div>

        </div><!-- row End -->
      </div><!-- contact_inner End -->
      <div class="delivery_info">
        <div class="alien_ufo_header">
          <h2>{{trans('frontlabels.deliveryinformation')}}</h2>
        </div>
        <div class="contact_inner new_select">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="delivery_information_from">
                <div class="form-group label-floating is-empty">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <label for="i5i" class="control-label">{{trans('frontlabels.addressline1')}}</label>
                    <input type="text" name="fu_address1" class="form-control" id="i5i" value="{{$userdetail->fu_address1}}">
                </div>
              </div><!-- delivery_information_from End -->
              <div class="delivery_information_from date_time_cont drop_data_cont">
                <div class="form-group label-floating is-empty delivery_dropdown">
                    <i class="fa fa-flag-o" aria-hidden="true"></i>
                    <?php $countries = Helpers::getCountries(); ?>
                    <select class="select"  id="fu_country" name="fu_country" onchange="getDataOfState(this.value)">
                        <option value="">{{trans('adminlabels.formlblselectcountry')}}</option>
                        <?php foreach ($countries as $key => $value) { ?>
                            <option value="{{$value->id}}" <?php if ($userdetail->fu_country == $value->id) echo 'selected'; ?> >{{$value->c_name}}</option>
                        <?php } ?>
                    </select>
                </div>
              </div><!-- delivery_information_from End -->

              <div class="delivery_information_from drop_data_cont">
                <div class="form-group label-floating is-empty delivery_dropdown">
                    <i class="zmdi zmdi-city-alt"></i>
                    <?php $cities = Helpers::getCities($userdetail->fu_state); ?>
                    <select class="select" id="fu_city" name="fu_city">
                        <option value="">{{trans('adminlabels.formlblcity')}}</option>
                        <?php foreach ($cities as $key => $value) { ?>
                            <option value="{{$value->id}}" <?php if ($userdetail->fu_city == $value->id) echo 'selected'; ?> >{{$value->c_name}}</option>
                        <?php } ?>
                    </select>
                </div>
              </div><!-- delivery_information_from End -->
             
              <div class="delivery_information_from">
                <div class="form-group label-floating is-empty">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <label for="i5i" class="control-label">{{trans('frontlabels.telephonenumber')}}</label>
                    <input type="number" name="fu_phone"class="form-control" id="i5i" value="{{$userdetail->fu_phone}}">
                </div>
              </div><!-- delivery_information_from End -->
            </div>
            <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1  col-xs-12">
              <div class="delivery_information_from">
                <div class="form-group label-floating is-empty">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <label for="i5i" class="control-label">{{trans('frontlabels.addressline2')}}</label>
                    <input type="text" name="fu_address2" class="form-control" id="i5i" value="{{$userdetail->fu_address2}}">
                </div>
              </div><!-- delivery_information_from End -->

              <div class="delivery_information_from drop_data_cont">
                <div class="form-group label-floating is-empty delivery_dropdown">
                    <i class="zmdi zmdi-city-alt"></i>
                    <?php $states = Helpers::getStates($userdetail->fu_country); ?>
                    <select class="select" id="fu_state" name="fu_state" onchange="getDataOfCity(this.value)">
                        <option value="">{{trans('adminlabels.formlblstate')}}</option>
                        <?php foreach ($states as $key => $value)  { ?>
                         <option value="{{$value->id}}" <?php if ($userdetail->fu_state
                          == $value->id) echo 'selected'; ?> >{{$value->s_name}}</option>
                        <?php } ?>
                    </select>
                </div>
              </div><!-- delivery_information_from End -->
              <div class="delivery_information_from">
                <div class="form-group label-floating is-empty">
                  <i class="zmdi zmdi-city-alt"></i>
                    <label for="i5i" class="control-label">{{trans('frontlabels.zipcode')}}</label>
                    <input type="number" class="form-control" name="fu_zipcode" id="fu_zipcode" value="{{$userdetail->fu_zipcode}}">
                </div>
              </div><!-- delivery_information_from End -->
            </div>
          </div><!-- row End -->
        </div><!-- contact_inner End -->
      </div><!-- delivery_info End -->
      <div class="personal_info">
        <div class="alien_ufo_header">
          <h2>{{trans('frontlabels.personalinformation')}}
          </h2>
        </div>
        <div class="contact_inner new_select">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="date_time_con drop_data_cont">
              <?php if($userdetail->fu_birthdate=='0000-00-00') $birthDate =''; 
              else $birthDate = date('m/d/Y' ,strtotime($userdetail->fu_birthdate));?>
                <div class="form-group label-floating is-empty">
                   <i class="fa fa-calendar" aria-hidden="true"></i>
                   <label for="i5i" class="control-label">{{trans('frontlabels.formlblbdate')}}</label>   
                   <input type="text" class="form-control" id="datetimepicker4"  name="fu_birthdate" value="{{$birthDate}}"/>
                </div> 
              </div><!-- date_time_con End -->
            </div>
            <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">
              <div class="delivery_dropdown delivery_information_from">
                <div class="form-group label-floating is-empty is-focused">
                <i class="zmdi zmdi-male-female"></i>
                <?php $gender = Helpers::gender(); ?>
                <select class="select" id="fu_gender" name="fu_gender">
                  <?php foreach ($gender as $key => $value) { ?>
                    <option value="{{$key}}" <?php if ($userdetail->fu_gender == $key) echo 'selected'; ?> >{{$value}}</option>
                  <?php } ?>
                </select>
                </div>
              </div><!-- delivery_information_from End -->
          
            </div>
          </div><!-- row End -->
        </div><!-- contact_inner End -->
        <div class="update_btn">
          <button type="submit" class="btn btn-default" data-dismiss="modal">{{trans('frontlabels.update')}}<div class="ripple-container"></div></button>
        </div>
      </div><!-- delivery_info End -->
      </form>
      <div class="vw_advertisement_footer">
        <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}"  alt="vw_advertisement_footer">
      </div>
    </div><!-- container End -->
  </div><!-- contact_information End -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('frontlabels.selectyouravatar')}} </h4>
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
@stop
@section('script')

<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>

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
      
                $(document).ready(function() {
                var adminvalidationRules = {
                    
            fu_first_name: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            fu_last_name: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            fu_user_name: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            fu_address1: {
                required: true,
                minlength: 3,
                maxlength: 50
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
            fu_avatar: {
                required: true
            },
            fu_phone: {
                required: true,
                digits : true,
                minlength: 10,
                maxlength: 12
            },
            fu_birthdate: {
                required: true
            },
            fu_gender: {
                required: true
            }
                }
            

        $("#editprofile").validate({
            ignore : "",
            rules : adminvalidationRules,
            messages : {
            fu_first_name: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            fu_last_name: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            fu_user_name: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
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
            }
                }
        })
    });
        $('body').on('click','.avtar',function(){
        var image_name = $(this).data('image');
        $('#fu_avatar').val(image_name);
        $('#fu_avatar_r').val(image_name);
        var image_url = $(this).data('image_url');
        $('#display_image').html('<img src="'+image_url+'" />');
        $('#display_image_r').html('<img src="'+image_url+'" />');
        $('#myModal').modal('hide');
    });
</script>

@stop