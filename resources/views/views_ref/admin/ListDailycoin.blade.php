@extends('admin.Master')

@section('content')
<!-- content   -->

<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.dailycoin')}}
        </div>		
		@if($dailyCoin < 16 )
        <div class="col-md-2">
            <a href="{{ url('admin/adddailycoin') }}"  class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.add')}}</a>
        </div>  
		 @else
		 @endif
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
                    <table id="DailycoinListingTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{trans('adminlabels.dailyrewardcoin')}}</th>
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
        var table = $('#DailycoinListingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.getdailycoin') !!}',
            columns: [
                
                {data: 'sw_reward_coins', name: 'sw_reward_coins'},
                {data: 'deleted', name: 'deleted', orderable: false, searchable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
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