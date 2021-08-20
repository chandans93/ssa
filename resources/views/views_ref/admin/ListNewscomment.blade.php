@extends('admin.Master')

@section('content')
<!-- content   -->

<?php
if (isset($data)){

foreach ($data as $key => $val) {
          $Parentid='0';
            if (isset($val['pc_parent_id']) && $val['pc_parent_id']>'0') {
                   $Parentid=$val['pc_parent_id'];
                      $val['Parentname']=$Parentname =$this->ProductCategoryRepository->getparentname($Parentid);
                     }
                      
                }                    

}?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.newscomment')}}
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
                    <table id="NewscommentListingTable" class="table table-striped">
                        <thead>
                            <tr>
							    <th>{{trans('adminlabels.userlblheadname')}}</th>
								<th>{{trans('adminlabels.newscommentcomment')}}</th>
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
        var table = $('#NewscommentListingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url('admin/getnewscomment') }}/{{ $topicid }}',
            columns: [
                
                {data: 'username', name: 'username'},
				{data: 'nc_comment', name: 'nc_comment'},
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