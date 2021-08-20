@extends('front.Master')

@section('content')
<?php if (isset($cmsDetail) && !empty($cmsDetail)) { ?>
<div class="cst_welcome">
    <div class="container">
      <div class="alien_ufo_header">
        <h2>{{$cmsDetail->cms_subject}}</h2>
      </div>
      <div class="cst_welcome_inner">
        <div class="row">
          <div class="col-xs-12">
            <div class="cst_welcome_content">
              {!! $cmsDetail->cms_body !!}
            </div>
          </div>
        </div><!-- row End -->
      </div><!-- cst_welcome_inner End -->
    </div><!-- container End -->
  </div><!-- cst_welcome End --> <!-- /.content -->
<?php }else{ ?>
<div class="cst_welcome">
    <div class="container">
      <div class="cst_welcome_inner">
        <div class="row">
          <div class="col-md-7 col-sm-7 col-xs-12">
            <div class="cst_welcome_content">
              {{trans('frontlabels.contentnotavailable')}}
            </div>
          </div>
        </div><!-- row End -->
      </div><!-- cst_welcome_inner End -->
    </div><!-- container End -->
  </div>
<?php } ?>
@stop
