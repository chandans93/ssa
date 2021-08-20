@extends('front.Master')
@section('css')
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/owl.transitions.css')}}">

@stop
@section('content')


<div class="contact_us">
    <div class="container">
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
        <div class="alien_ufo_header">
            <h2>Billing Information</h2>
        </div>
        <div class="tab_content">
            <div class="tab_content_inner">          
                <div class="select_address">
                    <div class="form-group">
                        <span class="billingaddress">SELECT A BILLING ADDRESS FROM YOUR ADDRESS BOOK OR ENTER NEW ADDRESS</span>
                        <div class="caretz">



                            <select class="selectpicker" id="address_list_cst">  
                                <option value="1">
                                    {{$orderAddress->fu_address1}},
                                    {{$orderAddress->fu_address2}},
                                    <?php $cities = Helpers::getCities($orderAddress->fu_state); ?>
                                    <?php foreach ($cities as $key => $value) { ?>
                                    <?php if ($orderAddress->fu_city == $value->id) echo $value->c_name; ?>
                                    <?php } ?>,                                    
                                    
                                     <?php $states = Helpers::getStates($orderAddress->fu_country); ?>
                                    <?php foreach ($states as $key => $value) { ?>
                                    <?php if ($orderAddress->fu_state == $value->id) echo $value->s_name; ?>
                                    <?php } ?>,
                                    
                                    <?php $countries = Helpers::getCountries(); ?>
                                    <?php foreach ($countries as $key => $value) { ?>
                                    <?php if ($orderAddress->fu_country == $value->id) echo $value->c_name; ?>
                                    <?php } ?>,
                                {{$orderAddress->fu_zipcode}}


                                </option>
                                <option value="2">new address</option>                    
                            </select>
                        </div>  
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
                    </div><!-- form-group End -->  
                </div><!-- select_address End -->  
                <div class="newaddress_form" style="display: none;">
                    <div class="row"> 
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           
                             <form id="CheckOut" class="form-horizontal" method="post" action="{{ url('/checkout')}}/{{$id}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="o_total_payble_amount" value="<?php echo $orderDetails['o_total_payble_amount'] ;?>">
                    <input type="hidden" name="o_order_number" value="<?php  echo  $orderDetails['o_order_number'];?>">
                    
                    
                            <div class="form-group">
                                <span >Address Line 1</span>
                                <input type="text" id="di_address1" name="di_address1" class="form-control" placeholder="Address Line 1" value="{{$orderAddress->fu_address1}}">
                            </div>
                            <div class="form-group">                    
                               <?php $countries = Helpers::getCountries(); ?>
                                <select class="selectpicker" id="di_country" name="di_country" onchange="getDataOfState(this.value)">
                                    <option value="{{$orderAddress->fu_country}}">{{trans('adminlabels.formlblselectcountry')}}</option>
                                    <?php foreach ($countries as $key => $value) { ?>
                                        <option value="{{$value->id}}"  <?php if ($orderAddress->fu_country == $value->id) echo 'selected'; ?>>{{$value->c_name}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <span >&nbsp;</span>                 
                                <?php $states = Helpers::getStates($orderAddress->fu_country); ?>
                                <select class="selectpicker" id="di_state" name="di_state" onchange="getDataOfCity(this.value)">
                                    <option value="">{{trans('adminlabels.formlblstate')}}</option>
                                    <?php foreach ($states as $key => $value)  {  ?>                                              
                                        <option value="{{$value->id}}" <?php if ($orderAddress->fu_state == $value->id) echo 'selected'; ?>>{{$value->s_name}}</option>
                                    <?php } ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <span >TELEPHONE NUMBER</span>
                                <input type="text" id="di_phone" name="di_phone" class="form-control onlyNumber" placeholder="Mobile Number" value="{{$orderAddress->fu_phone}}">
                            </div>              
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <span >Address Line 2</span>
                                <input type="text" id="di_address2" name="di_address2" class="form-control" placeholder="Address Line 2" value="{{$orderAddress->fu_address2}}">
                            </div>
                            <div class="form-group">                   
                                <?php $cities = Helpers::getCities($orderAddress->fu_state); ?>

                                <select class="selectpicker" id="di_city" name="di_city">
                                    <option value="{{$orderAddress->fu_city}}">{{trans('adminlabels.formlblcity')}}</option>
                                    <?php foreach ($cities as $key => $value) { ?>
                                        <option value="{{$value->id}}"   <?php if ($orderAddress->fu_city == $value->id) echo 'selected'; ?>>{{$value->c_name}}</option>
                                    <?php } ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <span >Zip Code</span>
                                <input type="text" id="di_zipcode" name="di_zipcode" class="form-control onlyNumber" placeholder="Zip Code" value="{{$orderAddress->fu_zipcode}}">
                            </div>
                        </div>              
                    </div>           
                </div><!-- newaddress_form End --> 
                <div class="address_radio">
                    <div class="form-group">
                        <div class="radio">
                            <label class="radiolabel">
                                <input type="radio" name="address" id="radio1" value="option1" checked>
                                Ship to this address
                            </label>
                        </div><!-- radio End -->
                        <div class="radio">
                            <label class="radiolabel">
                                <input type="radio" name="address" id="radio2" value="option2">
                                Ship to different address
                            </label>
                        </div><!--radio End -->  
                        <div>
                            <button type="submit" class="btn-default">CONTINUE</button>
                        </div>
                        </form>
                    </div>
                </div><!-- address_radio End --> 
            </div><!-- tab_content_inner End -->        
        </div><!-- tab_content End -->
        <div class="vw_advertisement_footer">
            <img src="{{ asset('/frontend/images/vw_advertisement_footer.jpg') }}" alt="vw_advertisement_footer">
        </div>
    </div><!-- container End -->
</div><!-- contact_us End -->

@stop
@section('script')



        <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
        
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript">
$('#address_list_cst').change(function () {
    if ($(this).val() === '2') {
        $('.newaddress_form').slideDown();
    } else {
        $('.newaddress_form').slideUp();
    }
});

jQuery(document).ready(function () {
    $('.onlyNumber').on('keyup', function () {
        this.value = this.value.replace(/[^0-9]/gi, '');
    });

        var adminvalidationRules = {
           
            di_address1: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            di_address2: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            di_city: {
                required: true
            },
            di_state: {
                required: true
            },
            di_country: {
                required: true
            },
            di_zipcode: {
                required: true,
                minlength: 6,
                maxlength: 12
            },
            
            di_phone: {
                required: true,
                minlength: 10,
                maxlength: 12
            },
            
            deleted: {
                required: true
            }
        }


    $("#CheckOut").validate({
        rules: adminvalidationRules,
        messages: {
            
            di_address1: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            di_address2: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            di_city: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            di_state: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            di_country: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            di_phone: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            },
            
            deleted: {
                required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
            }
        }
    });

 });


function getDataOfState(countryId)
{
    $("#di_state").empty();
    $("#di_city").empty();
    $.ajax({
        type: 'GET',
        url: '/getState/' + countryId,
        dataType: "JSON",
        success: function (JSON) {
            $("#di_state").empty()
            for (var i = 0; i < JSON.length; i++) {
                $("#di_state").append($("<option></option>").val(JSON[i].id).html(JSON[i].s_name))
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
            $("#di_city").empty();
            for (var i = 0; i < JSON.length; i++) {
                $("#di_city").append($("<option></option>").val(JSON[i].id).html(JSON[i].c_name));
            }
        }
    });

}

</script>
@stop

