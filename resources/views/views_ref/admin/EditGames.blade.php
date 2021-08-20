@extends('admin.Master')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('adminlabels.game')}}
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
                    <h3 class="box-title"><?php echo (isset($gameDetail) && !empty($gameDetail)) ? trans('adminlabels.edit') : trans('adminlabels.add') ?> {{trans('adminlabels.game')}}</h3>
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

                <form id="addGame" class="form-horizontal" method="post" action="{{ url('/admin/savegame') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="<?php echo (isset($gameDetail) && !empty($gameDetail)) ? $gameDetail->id : '0' ?>">                    
                    <input type="hidden" name="hidden_profile" value="<?php echo (isset($gameDetail) && !empty($gameDetail)) ? $gameDetail['0']['pi_image_name'] : '' ?>">

                    <div class="box-body">
                       
                        <?php
                        if (old('g_title'))
                            $g_title = old('g_title');
                        elseif ($gameDetail)
                            $g_title = $gameDetail->g_title;
                        else
                            $g_title = '';
                        ?>
                        <div class="form-group">
                            <label for="g_title" class="col-sm-2 control-label">{{trans('adminlabels.formlblegametitle')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="g_title" name="g_title" placeholder="{{trans('adminlabels.formlblegametitle')}}" value="{{ $g_title}}" minlength="3" maxlength="100"/>
                            </div>
                        </div>
                        <!----- this is for Game category -->
                        <?php
                        if (old('g_category_id'))
                            $g_category_id = old('g_category_id');
                        elseif ($gameDetail)
                            $g_category_id = $gameDetail->g_category_id;
                        else
                            $g_category_id = '';
                        ?>
                        <div class="form-group">
                            <label for="g_category_id" class="col-sm-2 control-label">{{trans('adminlabels.formlblegamecategory')}}</label>
                            <div class="col-sm-6">
                                <?php $game = Helpers::getGameid(); ?>
                                <select class="form-control" id="g_category_id" name="g_category_id" onchange="getDataOfSubCategory(this.value)">
                                    <option value="">{{trans('adminlabels.formlblegamecategory')}}</option>
                                    <?php foreach ($game as $value) { ?>
                                        <option value="{{$value->id}}" <?php if ($g_category_id == $value->id) echo 'selected'; ?> >{{$value->gc_title}}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!----- end Game category -->

                        <!----- this is for Game Subcategory -->

                        <?php
                        if (old('g_subcategory_id'))
                            $g_subcategory_id = old('g_subcategory_id');
                        elseif ($gameDetail)
                            $g_subcategory_id = $gameDetail->g_subcategory_id;
                        else
                            $g_subcategory_id = '';
                        ?>                        

                        <div class="form-group" id="hide_show">
                            <label for="g_subcategory_id" class="col-sm-2 control-label">{{trans('adminlabels.formlblegamesubcategory')}}</label>
                            <div class="col-sm-6">
                                <?php $gameSubCategory = Helpers::getGameSubCategory($g_category_id); 
                                
                                ?>
                                <select class="form-control" id="g_subcategory_id" name="g_subcategory_id">
                                    <option value="">{{trans('adminlabels.formlblegamesubcategory')}}</option>
                                    <?php
                                    if (isset($gameSubCategory) && !empty($gameSubCategory)) {
                                        foreach ($gameSubCategory as $value) {
                                            ?>
                                            <option value="{{$value->id}}" <?php if ($g_subcategory_id == $value->id) echo 'selected'; ?> >{{$value->gc_title}}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!----- end product Subcategory -->
                        <?php
                        if (old('g_coin'))
                            $g_coin = old('g_coin');
                        elseif ($gameDetail)
                            $g_coin = $gameDetail->g_coin;
                        else
                            $g_coin = '';
                        ?>
                        <div class="form-group">
                            <label for="g_coin" class="col-sm-2 control-label">{{trans('adminlabels.formlblgamevoucher')}}</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control onlyNumber" id="g_coin" name="g_coin" placeholder="{{trans('adminlabels.formlblgamevoucher')}}" value="{{ $g_coin}}" minlength="1" maxlength="100"/>
                            </div>
                        </div>

                        
                        <?php
                        if (old('g_description'))
                            $g_description = old('g_description');
                        elseif ($gameDetail)
                            $g_description = $gameDetail->g_description;
                        else
                            $g_description = '';
                        ?>
                        <div class="form-group">
                            <label for="g_description" class="col-sm-2 control-label">{{trans('adminlabels.formlblgamedescription')}}</label>
                            <div class="col-sm-6">

                                <textarea name="g_description" id="p_description">{{$g_description}}</textarea>                               
                            </div>
                        </div>

                        <?php
                        if (old('g_photo'))
                            $g_photo = old('g_photo');
                        elseif ($gameDetail)
                            $g_photo = $gameDetail->g_photo;
                        else
                            $g_photo = '';
                        ?>
                        <div class="form-group">
                            <label for="g_photo" class="col-sm-2 control-label">{{trans('adminlabels.gamelblimage')}}</label>
                            <div class="col-sm-6">
                                <input type="file" class="productPhoto" id="g_photo" name="g_photo"/>
                                <div id="image_validation" style="color: red;"></div>
                               <?php
                                    if(isset($gameDetail->id) && $gameDetail->id != '0'){
                                        if(File::exists(public_path($uploadGameImagePath.$gameDetail->g_photo)) && $gameDetail->g_photo != '') { ?><br>
                                            <img src="{{ url($uploadGameImagePath.$gameDetail->g_photo) }}" alt="{{$gameDetail->g_photo}}" >
                                        <?php }else{ ?>
                                        <img src="{{ asset('/backend/images/avatar5.png')}}" class="user-image" alt="Default Image">
                                <?php   }
                                    }
                                ?>
                            </div>
                        </div>
                       
                        <?php
                        if (old('g_embedded_script'))
                            $g_embedded_script = old('g_embedded_script');
                        elseif ($gameDetail)
                            $g_embedded_script = $gameDetail->g_embedded_script;
                        else
                            $g_embedded_script = '';
                        ?>
                        <div class="form-group">
                            <label for="g_embedded_script" class="col-sm-2 control-label">{{trans('adminlabels.formlblembeddedscript')}}</label>
                            <div class="col-sm-6">
                                <textarea rows="4" id="g_embedded_script" name="g_embedded_script"  style="width:100%; padding:5px;">{{ $g_embedded_script}}</textarea>                               
                            </div>
                        </div>

                        <?php
                        if (old('deleted'))
                            $deleted = old('deleted');
                        elseif ($gameDetail)
                            $deleted = $gameDetail->deleted;
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
                        <a class="btn btn-danger btn-flat pull-right" href="{{ url('admin/game') }}">{{trans('adminlabels.cancelbtn')}}</a>
                    </div><!-- /.box-footer -->
                </form>
            </div>   <!-- /.row -->
        </div>
    </div>
</section><!-- /.content -->

@stop

@section('script')
<script type="text/javascript" src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>


<script type="text/javascript">
                                    CKEDITOR.replace('g_description');
                                    jQuery(document).ready(function () {
                                        jQuery.validator.addMethod("emptyetbody", function (value, element) {

                                            var p_description_data = CKEDITOR.instances['g_description'].getData();
                                            return p_description_data != '';
                                        }),
                                                $('.onlyNumber').on('keyup', function () {
                                            this.value = this.value.replace(/[^0-9]/gi, '');
                                        });
                                        $('.onlyNothing').on('keyup', function () {
                                            this.value = this.value.replace(/[^a-z]/gi, '');
                                        });
                                        

<?php if (isset($gameDetail->id) && $gameDetail->id != '0') { ?>
                                            var adminvalidationRules = {
                                                
                                                g_title: {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 60
                                                },
                                                
                                                g_voucher: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                
                                                g_description: {
                                                    required: true,
                                                },
                                                g_category_id: {
                                                    required: true,
                                                },
                                                g_embedded_script: {
                                                    required: true,
                                                },
                                                deleted: {
                                                    required: true
                                                }
                                            }
<?php } else { ?>
                                            var adminvalidationRules = {
                                                
                                                g_title: {
                                                    required: true,
                                                    minlength: 3,
                                                    maxlength: 60
                                                },
                                                
                                                g_voucher: {
                                                    required: true,
                                                    minlength: 1,
                                                    maxlength: 10000
                                                },
                                                
                                                g_description: {
                                                    required: true,
                                                },
                                                g_category_id: {
                                                    required: true,
                                                },
                                                g_photo: {
                                                    required: true,
                                                },
                                                g_embedded_script: {
                                                    required: true,
                                                },
                                                deleted: {
                                                    required: true
                                                }
                                            }
<?php } ?>

                                        $("#addGame").validate({
                                            rules: adminvalidationRules,
                                            messages: {                                               
                                                g_title: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                
                                                g_voucher: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                
                                                g_description: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                g_category_id: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                g_embedded_script: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                g_photo: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                },
                                                deleted: {
                                                    required: "<?php echo trans('adminvalidation.requiredfield'); ?>"
                                                }
                                            }
                                        });
                                    });
                                    function getDataOfSubCategory(CategoryId)
                                    {
                                        $("#g_subcategory_id").empty();
                                        $.ajax({
                                            type: 'GET',
                                            url: '/getGameSubCategory/' + CategoryId,
                                            dataType: "JSON",
                                            success: function (JSON) {
                                                
                                                $("#g_subcategory_id").empty()
                                                $("#g_subcategory_id").append($("<option>Game SubCategory</option>").val("0"))
                                                for (var i = 0; i < JSON.length; i++) {
                                                    $("#g_subcategory_id").append($("<option></option>").val(JSON[i].id).html(JSON[i].gc_title))
                                                }
                                            }
                                        });
                                    }
                                    $(".productPhoto").change(function (e) {
                                        var ext = this.value.match(/\.(.+)$/)[1];
                                        switch (ext)
                                        {
                                            case 'jpg':
                                            case 'bmp':
                                            case 'png':
                                            case 'jpeg':
                                            case 'JPG':
                                            case 'JPEG':    
                                                break;
                                            default:
                                                $("#image_validation").text("This Image Type Not Allow.");
                                                this.value = '';
                                        }
                                    });


</script>

@stop

