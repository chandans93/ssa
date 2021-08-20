@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.game')}}
        </div>
        <div class="col-md-2">
            <a href="{{ url('admin/addgame') }}" class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.add')}}</a>
        </div>       

    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header pull-right ">
                <i class="s_active fa fa-square"></i> {{trans('adminlabels.activelbl')}} <i class="s_inactive fa fa-square"></i>{{trans('adminlabels.inactivelbl')}}
            </div>
        </div>                
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <table id="gameTable" class="table table-striped">
                        <thead>
                            <tr class="filters">                                                                
                                <th>{{trans('adminlabels.formlblegame')}}</th>
                                <th>{{trans('adminlabels.formlblegamecategory')}}</th>
                                <th>{{trans('adminlabels.formlbleproductvoucher')}}</th>
                                
                                <th>{{trans('adminlabels.lblstatus')}}</th>                                                                
                                <th>{{trans('adminlabels.lblaction')}}</th>                                
                            </tr>
                        </thead>
                    </table>                   
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('script')

<script type="text/javascript">

    $(document).ready(function () {
        var table = $('#gameTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.getgame') !!}',
            columns: [
                {data: 'g_title', name: 'g_title'},
                {data: 'g_category_id', name: 'g_category_id'},
                {data: 'g_coin', name: 'g_coin'},                    
                {data: 'deleted', name: 'deleted', orderable: false, searchable: true},                                
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "language": {
                  "emptyTable": "<?php echo trans('adminlabels.norecordfound'); ?>"
            }
        });
    });

</script>

@stop