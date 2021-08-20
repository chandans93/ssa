@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        {{trans('adminlabels.setting')}}
        
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
                    <h3 class="box-title">{{trans('adminlabels.setting')}}</h3>
                </div><!-- /.box-header -->
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{trans('adminlabels.whoops')}}</strong> {{trans('adminlabels.someproblems')}}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="setting" class="form-horizontal" method="post" action="{{ url('/admin/savesetting') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="box-body">
                        
                        <?php
                        if (old('record_per_page'))
                            $record_per_page = old('record_per_page');
                        elseif (isset ($configuration['record_per_page']))
                            $record_per_page = $configuration['record_per_page'];
                        else
                            $record_per_page = '';
                        ?>
                        
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblrecordperpage')}}</label>
                            <div class="col-sm-6">
                                <input type="name" class="form-control" id="record_per_page" maxlength="10" name="record_per_page" value="{{$record_per_page}}" placeholder="{{trans('adminlabels.placeholderrecordperpage')}}"   />
                            </div>
                        </div>
                        
                        <?php
                        if (old('contact_us_email'))
                            $contact_us_email = old('contact_us_email');
                        elseif (isset ($configuration['contact_us_email']))
                            $contact_us_email = $configuration['contact_us_email'];
                        else
                            $contact_us_email = '';
                        ?>
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblcontactus')}}</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" maxlength="100" id="contact_us_email" name="contact_us_email" value="{{$contact_us_email}}" placeholder="{{trans('adminlabels.placeholdercontactus')}}"   />
                            </div>
                        </div>
                        <?php
                        if (old('facebook_link'))
                            $facebook_link = old('facebook_link');
                        elseif (isset ($configuration['facebook_link']))
                            $facebook_link = $configuration['facebook_link'];
                        else
                            $facebook_link = '';
                        ?>
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblfacebook')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" maxlength="100" id="facebook_link" name="facebook_link" value="{{$facebook_link}}" placeholder="{{trans('adminlabels.placeholderfacebook')}}"   />
                            </div>
                        </div>
                        <?php
                        if (old('twitter_link'))
                            $twitter_link = old('twitter_link');
                        elseif (isset ($configuration['twitter_link']))
                            $twitter_link = $configuration['twitter_link'];
                        else
                            $twitter_link = '';
                        ?>
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlbltwitter')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" maxlength="100" id="twitter_link" name="twitter_link" value="{{$twitter_link}}" placeholder="{{trans('adminlabels.placeholdertwitter')}}"   />
                            </div>
                        </div>
                        <?php
                        if (old('google_plus_link'))
                            $facebook_link = old('google_plus_link');
                        elseif (isset ($configuration['google_plus_link']))
                            $google_plus_link = $configuration['google_plus_link'];
                        else
                            $google_plus_link = '';
                        ?>
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblgoogleplus')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" maxlength="100" id="google_plus_link" name="google_plus_link" value="{{$google_plus_link}}" placeholder="{{trans('adminlabels.placeholdergoogleplus')}}"   />
                            </div>
                        </div>
                        <?php
                        if (old('youtube_link'))
                            $youtube_link = old('youtube_link');
                        elseif (isset ($configuration['youtube_link']))
                            $youtube_link = $configuration['youtube_link'];
                        else
                            $youtube_link = '';
                        ?>
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblyoutube')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" maxlength="100" id="youtube_link" name="youtube_link" value="{{$youtube_link}}" placeholder="{{trans('adminlabels.placeholderyoutube')}}"   />
                            </div>
                        </div>
                        <?php
                        if (old('support_link'))
                            $support_link = old('support_link');
                        elseif (isset ($configuration['support_link']))
                            $support_link = $configuration['support_link'];
                        else
                            $support_link = '';
                        ?>
                        <div class="form-group">
                            <label for="cat_name" class="col-sm-2 control-label">{{trans('adminlabels.formlblsupport')}}</label>
                            <div class="col-sm-6">
                                <input type="url" class="form-control" maxlength="100" id="support_link" name="support_link" value="{{$support_link}}" placeholder="{{trans('adminlabels.placeholdersupport')}}"   />
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-flat">{{trans('adminlabels.savebtn')}}</button>
                            <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/setting') }}">{{trans('adminlabels.cancelbtn')}}</a>
                        </div><!-- /.box-footer -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section><!-- /.content -->
@stop
@section('script')
<script type="text/javascript">
    jQuery(document).ready(function() {

        var signupRules = {
            record_per_page: {
                required: true,
                digits : true,
            },
            contact_us_email: {
                required: true,
                email : true,
            },
            facebook_link: {
                required: true,
                
            },
            twitter_link: {
                required: true,
                
            },
            google_plus_link : {
                required: true,
                
            },
            youtube_link: {
                required: true,
                
            },
            support_link: {
                required: true,
                
            },
                        
        };

        $("#setting").validate({
            rules: signupRules,
            messages: {
                record_per_page: {
                required: '<?php echo trans('adminvalidation.recordrequired')?>',
                digits : '<?php echo trans('adminvalidation.validnumber')?>',
                },
                contact_us_email: {
                    required: '<?php echo trans('adminvalidation.contactusemail')?>',
                    email : '<?php echo trans('adminvalidation.validemail')?>',
                },
                facebook_link: {
                    required: '<?php echo trans('adminvalidation.facebooklink')?>',
                
                },
                twitter_link: {
                    required: '<?php echo trans('adminvalidation.twitterlink')?>',
                
                },
                google_plus_link : {
                     required: '<?php echo trans('adminvalidation.googlepluslink')?>',
                
                },
                youtube_link: {
                     required: '<?php echo trans('adminvalidation.youtubelink')?>',
                
                },
                support_link: {
                     required: '<?php echo trans('adminvalidation.supportlink')?>',
                
                },
                
            }
        });
    });
</script>
@stop