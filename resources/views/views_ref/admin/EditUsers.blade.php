@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.user')}}
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo (isset($userDetail) && !empty($userDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.user')}}</h3>
                </div><!-- /.box-header -->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('adminvalidation.whoops')}}</strong>{{trans('adminvalidation.someproblems')}}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="addUser" class="form-horizontal" method="post" action="{{ url('/admin/saveuser') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($userDetail) && !empty($userDetail)) ? $userDetail->id : '0' ?>">
                    <input type="hidden" name="hidden_password" value="<?php echo (isset($userDetail) && !empty($userDetail)) ? $userDetail->password : '0' ?>">
                    <div class="box-body">
                        <?php
                        if (old('fu_first_name'))
                            $fu_first_name = old('fu_first_name');
                        elseif ($userDetail)
                            $fu_first_name = $userDetail->fu_first_name;
                        else
                            $fu_first_name = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_first_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblefirstname')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fu_first_name" name="fu_first_name" placeholder="{{trans('adminlabels.formlblefirstname')}}" value="{{ $fu_first_name}}" minlength="3" maxlength="30"/>
                            </div>
                        </div>
                        <?php
                        if (old('fu_last_name'))
                            $fu_last_name = old('fu_last_name');
                        elseif ($userDetail)
                            $fu_last_name = $userDetail->fu_last_name;
                        else
                            $fu_last_name = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_last_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblelastname')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fu_last_name" name="fu_last_name" placeholder="{{trans('adminlabels.formlblelastname')}}" value="{{ $fu_last_name}}" minlength="3" maxlength="30"/>
                            </div>
                        </div>
                        <?php
                        if (old('fu_user_name'))
                            $fu_user_name = old('fu_user_name');
                        elseif ($userDetail)
                            $fu_user_name = $userDetail->fu_user_name;
                        else
                            $fu_user_name = '';
                        ?>
                        <?php if($fu_user_name !=='') { ?>
                        <div class="form-group">
                            <label for="fu_user_name" class="col-sm-2 control-label">{{trans('adminlabels.formlbleusername')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="fu_user_name" name="fu_user_name" placeholder="{{trans('adminlabels.formlbleusername')}}" value="{{$fu_user_name }}" minlength="3" maxlength="30"/>
                            </div>
                        </div>
                        <?php } else { ?> <?php } ?>
                         <?php
                        if (old('fu_email'))
                            $fu_email = old('fu_email');
                        elseif ($userDetail)
                            $fu_email = $userDetail->fu_email;
                        else
                            $fu_email = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_email" class="col-sm-2 control-label">{{trans('adminlabels.formlblemail')}}</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control onlyemail" id="fu_email" name="fu_email" placeholder="{{trans('adminlabels.formlblemail')}}" value="{{ $fu_email}}" minlength="3"/>
                                <div id="email_validation" style="color: red;"></div>
                            </div>
                        </div>

                        <?php
                        if (old('password'))
                            $password = old('password');
                        elseif ($userDetail)
                            $password = $userDetail->password;
                        else
                            $password = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_password" class="col-sm-2 control-label">{{trans('adminlabels.formlblpassword')}}</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{trans('adminlabels.formlblpassword')}}" value="" minlength="6" maxlength="20"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="col-sm-2 control-label">{{trans('adminlabels.formlblconfirmpassword')}}</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="{{trans('adminlabels.formlblconfirmpassword')}}" value="" minlength="6" maxlength="20"/>
                            </div>
                        </div>
                        <?php
                        if (old('fu_address1'))
                            $fu_address1 = old('fu_address1');
                        elseif ($userDetail)
                            $fu_address1 = $userDetail->fu_address1;
                        else
                            $fu_address1 = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_address1" class="col-sm-2 control-label">{{trans('adminlabels.formlbladdress1')}}</label>
                            <div class="col-sm-6">
                                 <textarea rows="4" id="fu_address1" name="fu_address1" minlength="3" maxlength="50" style="width:100%; padding:5px;">{{ $fu_address1}}</textarea>                               
                            </div>
                        </div>

                        <?php
                        if (old('fu_address2'))
                            $fu_address2 = old('fu_address2');
                        elseif ($userDetail)
                            $fu_address2 = $userDetail->fu_address2;
                        else
                            $fu_address2 = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_address2" class="col-sm-2 control-label">{{trans('adminlabels.formlbladdress2')}}</label>
                            <div class="col-sm-6">
                               <textarea rows="4" id="fu_address2" name="fu_address2" minlength="3" maxlength="50" style="width:100%; padding:5px;">{{ $fu_address2}}</textarea>
                            </div>
                        </div>                      

                        <?php
                        if (old('fu_country'))
                            $fu_country = old('fu_country');
                        elseif ($userDetail)
                            $fu_country = $userDetail->fu_country;
                        else
                            $fu_country = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_country" class="col-sm-2 control-label">{{trans('adminlabels.formlblselectcountry')}}</label>
                            <div class="col-sm-6">
                                <?php $countries = Helpers::getCountries(); ?>
                                <select class="form-control" id="fu_country" name="fu_country" onchange="getDataOfState(this.value)">
                                    <option value="">{{trans('adminlabels.formlblselectcountry')}}</option>
                                    <?php foreach ($countries as $key => $value) { ?>
                                        <option value="{{$value->id}}" <?php if ($fu_country == $value->id) echo 'selected'; ?> >{{$value->c_name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('fu_state'))
                            $fu_state = old('fu_state');
                        elseif ($userDetail)
                            $fu_state = $userDetail->fu_state;
                        else
                            $fu_state = '';
                        ?>
                       
                        <div class="form-group">
                            <label for="fu_state" class="col-sm-2 control-label">{{trans('adminlabels.formlblstate')}}</label>
                            <div class="col-sm-6">
                                <?php $states = Helpers::getStates($fu_country); ?>
                                <select class="form-control" id="fu_state" name="fu_state" onchange="getDataOfCity(this.value)">
                                    <option value="">{{trans('adminlabels.formlblstate')}}</option>
                                    <?php foreach ($states as $key => $value)  {  ?>                                              
                                        <option value="{{$value->id}}" <?php if ($fu_state == $value->id) echo 'selected'; ?> >{{$value->s_name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('fu_city'))
                            $fu_city = old('fu_city');
                        elseif ($userDetail)
                            $fu_city = $userDetail->fu_city;
                        else
                            $fu_city = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_city" class="col-sm-2 control-label">{{trans('adminlabels.formlblcity')}}</label>
                            <div class="col-sm-6">
                                <?php $cities = Helpers::getCities($fu_state); ?>

                                <select class="form-control" id="fu_city" name="fu_city">
                                    <option value="">{{trans('adminlabels.formlblcity')}}</option>
                                    <?php foreach ($cities as $key => $value) { ?>
                                        <option value="{{$value->id}}" <?php if ($fu_city == $value->id) echo 'selected'; ?> >{{$value->c_name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <?php
                        if (old('fu_zipcode'))
                            $fu_zipcode = old('fu_zipcode');
                        elseif ($userDetail)
                            $fu_zipcode = $userDetail->fu_zipcode;
                        else
                            $fu_zipcode = '';
                        ?>
                        <div class="form-group">
                            <label for="pincode" class="col-sm-2 control-label">{{trans('adminlabels.formlblpincode')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="fu_zipcode" class="form-control onlyNumber" maxlength="12" minlength="6" placeholder="{{trans('adminlabels.formlblpincode')}}"  value="{{ $fu_zipcode  or ''}}">
                            </div>
                        </div>
                        <?php
                        if (old('fu_avatar'))
                            $fu_avatar = old('fu_avatar');
                        elseif ($userDetail)
                            $fu_avatar = $userDetail->fu_avatar;
                        else
                            $fu_avatar = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_avatar" class="col-sm-2 control-label">{{trans('adminlabels.formlblavatar')}}</label>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Select Avatar</button>

                                <input type="hidden" name="fu_avatar" id="fu_avatar" value="{{$fu_avatar}}">

                                <?php
                                if (isset($userDetail->id) && $userDetail->id != '0') {
                                    if (File::exists(public_path($uploadAvatarPath . $userDetail->fu_avatar)) && $userDetail->fu_avatar != '') {
                                        ?>
                                        <div id="display_image" class="avatar">
                                            <img src="{{ url($uploadAvatarPath.$userDetail->fu_avatar) }}"  alt="{{$userDetail->fu_avatar}}">
                                        </div>
                                    <?php } else { ?>
                                         <div id="display_image" class="avatar">
                                        <img src="{{ asset('/upload/avatar/ava1.jpg')}}" alt="Default Image" class="avatar" height="<?php echo Config::get('constant.USER_PHOTO_THUMB_IMAGE_WIDTH'); ?>" width="<?php echo Config::get('constant.USER_PHOTO_THUMB_IMAGE_HEIGHT'); ?>">
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                { ?>
                                <div id="display_image" class="avatar">
                                    
                                </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (old('fu_phone'))
                            $fu_phone = old('fu_phone');
                        elseif ($userDetail)
                            $fu_phone = $userDetail->fu_phone;
                        else
                            $fu_phone = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_phone" class="col-sm-2 control-label">{{trans('adminlabels.formlblphone')}}</label>
                            <div class="col-sm-6">
                                <input type="text" name="fu_phone" minlength="10" maxlength="12" class="form-control onlyNumber" placeholder="{{trans('adminlabels.formlblphone')}}"  value="{{ $fu_phone or ''}}">
                            </div>
                        </div>
                        <?php
                        if (old('fu_birthdate'))
                            $fu_birthdate = old('fu_birthdate');
                        elseif ($userDetail)
                            $fu_birthdate = date('m/d/Y' ,strtotime($userDetail->fu_birthdate));
                        else
                            $fu_birthdate = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_birthdate" class="col-sm-2 control-label">{{trans('adminlabels.formlblbdate')}}</label>
                            <div class="col-sm-6">
                                <input type="text"  class="form-control onlyNothing" id="fu_birthdate"   name="fu_birthdate" placeholder="{{trans('adminlabels.formlblbdate')}}" value="{{$fu_birthdate}}" />
                            </div>
                        </div>
                        <?php
                        if (old('fu_gender'))
                            $fu_gender = old('fu_gender');
                        elseif ($userDetail)
                            $fu_gender = $userDetail->fu_gender;
                        else
                            $fu_gender = '';
                        ?>
                        <div class="form-group">
                            <label for="fu_gender" class="col-sm-2 control-label">{{trans('adminlabels.formlblgender')}}</label>
                            <div class="col-sm-6">
                                <?php $gender = Helpers::gender(); ?>
                                <select class="form-control" id="fu_gender" name="fu_gender">
                                    <option value="">{{trans('adminlabels.formlblselectgender')}}</option>
                                    <?php foreach ($gender as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if ($fu_gender == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($userDetail)
                            $deleted = $userDetail->deleted;
                        else
                            $deleted = '';
                        ?>
                        <div class="form-group">
                            <label for="deleted" class="col-sm-2 control-label">{{trans('adminlabels.formlblstatus')}}</label>
                            <div class="col-sm-6">
                                <?php $staus = Helpers::status(); ?>
                                <select class="form-control" id="deleted" name="deleted">
                                    <?php foreach ($staus as $key => $value) { ?>
                                        <option value="{{$key}}" <?php if ($deleted == $key) echo 'selected'; ?> >{{$value}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" id="submit" class="btn btn-primary btn-flat" >{{trans('adminlabels.savebtn')}}</button>
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/user') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

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

@stop

@section('script')
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>


<script type="text/javascript">

jQuery(document).ready(function () {
    $('.onlyNumber').on('keyup', function () {
        this.value = this.value.replace(/[^0-9]/gi, '');
    });
    $('.onlyNothing').on('keyup', function () {
        this.value = this.value.replace(/[^a-z]/gi, '');
    });
    $('.onlyemail').on('keyup', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9._@]/gi,'');
    });
    jQuery.noConflict();
    jQuery("#fu_birthdate").datepicker({
        yearRange: "-130:-13",
        maxDate: -4749,
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        defaultDate: null
    }).on('change', function () {
        $(this).valid();
    });

  
<?php if (isset($userDetail->id) && $userDetail->id != '0') { ?>
        var adminvalidationRules = {
            fu_email: {
                required: true,
                email: true,
                minlength: 6,
                
            },
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
            fu_address2: {                
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
                minlength: 6,
                maxlength: 12
            },
            fu_avatar: {
                required: true
            },
            fu_phone: {
                required: true,
                minlength: 10,
                maxlength: 12
            },
            fu_birthdate: {
                required: true
            },
            fu_gender: {
                required: true
            },
            deleted: {
                required: true
            }
        }
<?php } else { ?>
        var adminvalidationRules = {
            fu_email: {
                required: true,
                
                minlength: 6,                
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            confirm_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo: '#password'
            },
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
                maxlength: 30
            },
            fu_address2: {                
                minlength: 3,
                maxlength: 30
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
                minlength: 6,
                maxlength: 12
            },
            fu_avatar: {
                required: true
            },
            fu_phone: {
                required: true,
                minlength: 10,
                maxlength: 12
            },
            fu_birthdate: {
                required: true
            },
            fu_gender: {
                required: true
            },
            deleted: {
                required: true
            }
        }
<?php } ?>

    $("#addUser").validate({
        rules: adminvalidationRules,
        messages: {
            fu_email: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>",
                
            },
            password: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            confirm_password: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>",
                equalTo: "<?php echo trans('adminvalidation.passwordnotmatch'); ?>"
            },
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
            fu_address2: {
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
            deleted: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            }
        }
    });

    $('body').on('click','.avtar',function(){
        var image_name = $(this).data('image');
        $('#fu_avatar').val(image_name);
        var image_url = $(this).data('image_url');
        $('#display_image').html('<img src="'+image_url+'" />');
        $('#myModal').modal('hide');

    });
});
function Emailvalidation(email)
{
     var reEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

   if(!email.match(reEmail)) {
    $("#email_validation").text("Please Enter valid Email Address.");
    return false;
  }
  else
  {
      $("#email_validation").hide();
  }     

  return true;
}
function getDataOfState(countryId)
{
    $("#fu_state").empty();
    $("#fu_city").empty();
    $.ajax({
        type: 'GET',
        url: '/getState/' + countryId,
        dataType: "JSON",
        success: function (JSON) {
            $("#fu_state").empty()            
            $("#fu_state").append($("<option>Select State</option>").val("0"))
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
            $("#fu_city").append($("<option>Select City</option>").val("0"))
            for (var i = 0; i < JSON.length; i++) {
                $("#fu_city").append($("<option></option>").val(JSON[i].id).html(JSON[i].c_name));
            }
        }
    });

}


</script>

@stop

