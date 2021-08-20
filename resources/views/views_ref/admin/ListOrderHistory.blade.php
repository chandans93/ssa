@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.orderhistory')}}
        </div>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header pull-right ">
                
            </div>
        </div>                
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <table id="OrderHistoryListingTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{trans('adminlabels.lblusername')}}</th>
                                <th>{{trans('adminlabels.lblonumber')}}</th>
                                <th>{{trans('adminlabels.lblorderdate')}}</th>
                                <th>{{trans('adminlabels.lbldeliverydate')}}</th>
                                <th>{{trans('adminlabels.lblamount')}}</th>                                
                                <th>{{trans('adminlabels.lblbillingaddress')}}</th>
                                <th>{{trans('adminlabels.lblstatus')}}</th>
                                
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
<script type="text/javascript" src="{{ asset('backend/js/dataTables.select.min.js') }}"></script> 
        <script type="text/javascript" src="{{ asset('backend/js/dataTables.editor.min.js') }}"></script> 
        <script type="text/javascript" src="{{ asset('backend/js/dataTables.editor.js') }}"></script>  

<script type="text/javascript">
    
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     
    $(document).ready($.fn.myFunction = function  () {
        
        var editor; // use a global for the submit and return data rendering in the examples  
        editor = new $.fn.dataTable.Editor( {
                processing: true,
                serverSide: true,
                ajax: '{!! route('.savedata') !!}',                
                table: "#OrderHistoryListingTable",                
                idSrc:  'row',                
                
                
                fields: [ 
                        {
                            label: "",
                            name: "id"
                        },
                        {
                            label: "",
                            name: "o_delivery_date",
                            type:  "date",
                            def:        function () { return new Date(); },
                            dateFormat: $.datepicker.ISO_8601
                        }
                        
                ]
        } );      
  
        editor.on( 'preSubmit', function ( e, o, action ) 
        {
            if ( action !== 'remove' ) 
            {
                 var firstName = editor.field( 'o_delivery_date' );
                   var re =  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
               
 
            }
            
        } );
        
        
        $('#OrderHistoryListingTable').on('click', 'tbody td:not(:first-child)',  function (e) 
        {            
           editor.inline( this, {               
                       submitOnBlur: true
                } );            
        });
       });            

    $(document).ready(function () {
        var table = $('#OrderHistoryListingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.gethistory') !!}',
            columns: [
                {data: 'fu_user_name', name: 'fu_user_name'},
                {data: 'o_order_number', name: 'o_order_number'},
                {data: 'o_order_date', name: 'o_order_date'},                
                {data: 'o_delivery_date', name: 'o_delivery_date'},
                {data: 'o_total_payble_amount', name: 'o_total_payble_amount'},
                {data: 'address', name: 'address', orderable: false, searchable: true},
                {data: 'o_order_status', name: 'o_order_status', orderable: false, searchable: true},
                
                
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