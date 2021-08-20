@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.formlbleearnvoucher')}}
        </div>		
	
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-header pull-right ">
                <i class="s_active fa fa-square"></i> {{trans('adminlabels.activelbl')}} <i class="s_inactive fa fa-square"></i>{{trans('adminlabels.inactivelbl')}}
				<form id="searchPurchaseVoucherHistory" action="{{ url('admin/earnedvoucher')}}" method="get">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
         
          </form>
            </div>
        </div>                
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
				<div class="date_time_con clearfix admin_date_ti">
						<div class="date_inner">
						  <input type="text" id="datetimepicker5" name="searchDate" class="cst_datepicker"/>
						  <i class="fa fa-calendar" aria-hidden="true"></i>
						</div>
					</div><!-- date_time_con End -->
                    <table id="NewscommentListingTable" class="table table-striped">
                        <thead>
                            <tr>
							 <th>{{trans('adminlabels.userlblheadname')}}</th>
							 <th>{{trans('adminlabels.formlbletotalvoucher')}}</th>
							<th>{{trans('adminlabels.formlbletotalearntvoucher')}}</th>
                             <th>{{trans('adminlabels.formlbleearntvoucherdate')}}</th>
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
<script src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>

<script type="text/javascript">
      $(document).ready(function(){
      var CSRF_TOKEN = "{{ csrf_token() }}";
        var table = $('#NewscommentListingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url('admin/getearnedvoucher') }}',
        columns: [
						{data: 'fu_user_name', name: 'user.fu_user_name'},
						{data: 'pv_total_voucher', name: 'purchasevoucher.pv_total_voucher'},
						{data: 'pv_used_voucher', name: 'purchasevoucher.pv_used_voucher'},
						{data: 'created_at', name: 'purchasevoucher.created_at'}            
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
        });

        $( "#datetimepicker5" ).datepicker({ dateFormat: "yy-mm-dd", weekStart: 1, todayHighlight: 1,
   
         });
            
            $("#datetimepicker5").on("change",function(){
                
                var selected = $(this).val();
               // alert(selected);
                var flag = document.getElementById("datetimepicker5").value;
                if(flag != "")
                {
                    var table = $('#NewscommentListingTable').DataTable({ //tale1 is a table name 
                    
                    bProcessing: true,
                    serverSide: true,
                    bServerSide: true,
                    ajax: {
                    url: 'earnedvoucher',
                            type: 'POST',
							headers: {
									    'X-CSRF-TOKEN': CSRF_TOKEN
								     },
                            data: {
                                    'created_at': flag
                            }
                    },
                    deferRender: true,
                    processing: true,
                    destroy : true,
                    columns: [
								{data: 'fu_user_name', name: 'user.fu_user_name'},
								{data: 'pv_total_voucher', name: 'purchasevoucher.pv_total_voucher'},
								{data: 'pv_used_voucher', name: 'purchasevoucher.pv_used_voucher'},
								{data: 'created_at', name: 'purchasevoucher.created_at'}             
                             ],
            "language": {
                  "emptyTable": "<?php echo trans('adminlabels.norecordfound'); ?>"
            }

                    });
                }
        });
    });
</script>

@stop