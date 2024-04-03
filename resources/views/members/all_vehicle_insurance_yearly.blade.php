@extends('layouts.default')

@section('content')
<style>
    .dataTables_length, .dataTables_length select{ float:left}
    #DataTables_Table_0_filter{margin-top:10px;}
    </style>
<div class="card pt-3" style="width:100% !important">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:#007bff">Vehicle Insurance Premium Amount</span>
                        <span class="info-box-number"  style="color:#007bff" id="sum_yearly_amount"></span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
    <div id="buttons" class="text-right" ></div>
    <table class="table table-bordered dts">
        <thead class="bg-primary">
            <tr>
                <th scope="col">Sr No</th>
                <th scope="col">Vehicle Category</th>
                <th scope="col">Vehicle Number</th>
                <th scope="col">Vehicle Name</th>
                <th scope="col">Chassis Number</th>
                <th scope="col">Insurance Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Insurance Policy Type</th>
                <th scope="col">Policy Premium</th>
                <th scope="col">Vehicle Owner Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
    </div>
</div>
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function(){
        var sum =0;
    var table = $('.dts').DataTable({
      processing: true,
      serverSide: true,
      dom:'lBfrtip',
      ajax: "{{ route('vehicle_insurance.all_vehicle_insurance_yearly') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'vehicle_category_id', name: 'vehicle_category_id'},
            {data: 'vehicle_number', name: 'vehicle_number'},
            {data: 'vehicle_name', name: 'vehicle_name'},
            {data: 'chasis_number', name: 'chasis_number'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'insurance_policy_type_id', name: 'insurance_policy_type_id'},
            {data: 'policy_premium', name: 'policy_premium'},
            {data: 'vehicle_owner_name', name: 'vehicle_owner_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        buttons: [
            {
               "extend": 'excel',
               "titleAttr": 'Excel',                               
               "className": 'text-right',
               "footer": true,
               "exportOptions": {
                    columns: 'th:not(:last-child)'
                } 
            },
            {
               "extend": 'csv',
               "titleAttr": 'CSV',   
               "footer": true,
               "exportOptions": {
                    columns: 'th:not(:last-child)'
                }                             
            },
            {
               "extend": 'pdf',
               "titleAttr": 'PDF',
               "pageSize": 'B4',
               "footer": true,
               "exportOptions": {
                    columns: 'th:not(:last-child)'
                }
            },
            {
               "extend": 'print',
               "titleAttr": 'Print', 
               "footer": true,
               "exportOptions": {
                    columns: 'th:not(:last-child)'
                }                                
            }],
            createdRow: function ( row, data, index ) {
                $(data).each(function(key,val){
                    sum=sum+parseInt(val.policy_premium);
                });
                $("#sum_yearly_amount").text(parseInt(sum));
            }
    });
    table.buttons().container().appendTo($('#buttons'))
});
    function view_vehicle_insurance_yearly(id){
        window.location.href='/all_vehicle_insurance/'+id+'/view';
    
    }
    
</script>
@endsection
