@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.formlblauction')}}
        </div>
        <div class="col-md-2">
            <a href="{{ url('admin/addauction') }}" class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.add')}}</a>
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
                    <table id="auctionTable" class="table table-striped">
                        <thead>
                            <tr class="filters">                                                                
                                <th>{{trans('adminlabels.formlbleproduct')}}</th>
                                <th>{{trans('adminlabels.formlblstarttime')}}</th>
                                <th>{{trans('adminlabels.formlblendtime')}}</th>
                                <th>{{trans('adminlabels.lblstatus')}}</th>
                                <th>{{trans('adminlabels.formlblauctiontype')}}</th>
                                <th>{{trans('adminlabels.formlblbidvoucher')}}</th>
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
        var table = $('#auctionTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.getauction') !!}',
            columns: [
                {data: 'au_product_id', name: 'au_product_id'},
                {data: 'au_start_time', name: 'au_start_time'},
                {data: 'au_end_time', name: 'au_end_time'},
                {data: 'au_status', name: 'au_status'},
                {data: 'au_bid_type', name: 'au_bid_type'},
                {data: 'au_bid_voucher', name: 'au_bid_voucher'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "language": {
                  "emptyTable": "<?php echo trans('adminlabels.norecordfound'); ?>"
            }
        });
         
    });

</script>

@stop