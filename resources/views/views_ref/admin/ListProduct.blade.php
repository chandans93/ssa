@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-10">
            {{trans('adminlabels.product')}}
        </div>
        <div class="col-md-2">
            <a href="{{ url('admin/addproduct') }}" class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.add')}}</a>
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
                    <table id="productTable" class="table table-striped">
                        <thead>
                            <tr class="filters">                                                                
                                <th>{{trans('adminlabels.formlbleproduct')}}</th>
                                <th>{{trans('adminlabels.formlblecategory')}}</th>
                                <th>{{trans('adminlabels.formlbleproductprice')}}</th>
                                <th>{{trans('adminlabels.lblstatus')}}</th>                                
                                <th>{{trans('adminlabels.lblmoreimages')}}</th>
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
<?php $contact_us = Helpers::getProductid();?>
@section('script')

<script type="text/javascript">

    $(document).ready(function () {
        var table = $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('.getproduct') !!}',
            columns: [
                {data: 'p_title', name: 'p_title'},
                {data: 'p_category_id', name: 'p_category_id'},
                {data: 'p_voucher', name: 'p_voucher'},                
                {data: 'deleted', name: 'deleted', orderable: false, searchable: true},
                
                {data: 'images', name: 'images', orderable: false, searchable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            "language": {
                  "emptyTable": "<?php echo trans('adminlabels.norecordfound'); ?>"
            }
        });
    });

</script>

@stop