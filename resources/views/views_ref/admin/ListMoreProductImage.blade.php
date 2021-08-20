@extends('admin.Master')

@section('content')
<!-- content   -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <div class="col-md-6">
            {{trans('adminlabels.productimage')}}
        </div>
        
         <div class="col-md-4">
            <a href="{{ url('admin/product') }}" class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.back')}}</a>
        </div>       

        
        <div class="col-md-2">
            <a href="{{ url('admin/addproductimage') }}/{{$id}}" class="btn btn-block btn-primary add-btn-primary pull-right">{{trans('adminlabels.add')}}</a>
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
                                <th>{{trans('adminlabels.productimage')}}</th> 
                                <th>{{trans('adminlabels.lblmainimage')}}</th> 
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
        var table = $('#productTable').DataTable({
            processing: true,
            serverSide: true,            
            ajax: '{{ url('/getproductimage') }}/{{ $id }}',
            columns: [
                {data: 'pi_image_name', name: 'pi_image_name'},               
                {data: 'pi_main_image', name: 'pi_main_image'},               
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