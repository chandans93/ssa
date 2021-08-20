@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.user')}}
        </div>
        <div class="col-md-2">
            <a href="{{ url('admin/adduser') }}" class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.add')}}</a>
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
                    <table id="UserListingTable" class="table table-striped">
                        <thead>
                            <tr class="filters">                                     
                                <th>{{trans('adminlabels.userlblheadname')}}</th>
                                <th>{{trans('adminlabels.userlblheademail')}}</th>
                                <th>{{trans('adminlabels.userlblheadphone')}}</th>
                                <th>{{trans('adminlabels.blheadstatus')}}</th>
                                <th>{{trans('adminlabels.blheadaction')}}</th>                                
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
        var table = $('#UserListingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.getuser') !!}',
            columns: [
                {data: 'fu_user_name', name: 'fu_user_name'},
                {data: 'fu_email', name: 'fu_email'},
                {data: 'fu_phone', name: 'fu_phone'},                
                {data: 'deleted', name: 'deleted', orderable: false, searchable: true},
                {data: 'actions', name: 'actions', orderable: false, searchable: true}
            ],
             "language": {
                  "emptyTable": "<?php echo trans('adminlabels.norecordfound'); ?>"
            }
        });
        table.on( 'draw', function () {
            $(table.table().container())
          .find('div.dataTables_paginate')
          .css( 'display', table.page.info().pages <= 1 ?
               'none' :
               'block'
          )
      } );
    });

</script>

@stop