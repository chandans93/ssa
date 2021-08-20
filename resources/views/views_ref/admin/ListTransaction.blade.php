@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.transactios')}}
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
                    <table id="TransactionListingTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{trans('adminlabels.txn_id')}}</th>
                                <th>{{trans('adminlabels.coinprice')}}</th>
                                <th>{{trans('adminlabels.username')}}</th>
                                <th>{{trans('adminlabels.purchaseditem')}}</th>
                                <th>{{trans('adminlabels.date')}}</th>
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
        var table = $('#TransactionListingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.gettransaction') !!}',
            columns: [
                {data: 't_txn_id', name: 't_txn_id'},
                {data: 't_currency', name: 't_currency', orderable: false, searchable: true},
                {data: 't_user_id', name: 't_user_id', orderable: false, searchable: true},
                {data: 't_purchased_item', name: 't_purchased_item', orderable: false, searchable: true},
                {data: 't_payment_date', name: 't_payment_date'}
            ],
            "language": {
                "emptyTable": "<?php echo trans('adminlabels.norecordfound'); ?>"
            }
        });
        table.on('draw', function () {
            $(table.table().container())
                    .find('div.dataTables_paginate')
                    .css('display', table.page.info().pages <= 1 ?
                            'none' :
                            'block'
                            )
        });
    });

</script>

@stop