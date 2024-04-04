@extends('layouts.default')

@section('content')
<style>
    .dataTables_length, .dataTables_length select{ float:left}
    #DataTables_Table_0_filter{margin-top:10px;}
    </style>
<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        <!-- <h4 class="text-center" style="color:#007bff">Mediclaim Yearly Premium Amount Sum : <span id="sum_yearly_amount"></span></h4> -->
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:#007bff">Mediclaim Yearly Premium Amount</span>
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
                <th scope="col">Policy Holder Name</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Policy Start Date</th>
                <th scope="col">Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Policy Type</th>
                <th scope="col">Policy Name</th>
                <th scope="col">Policy Mode</th>
                <th scope="col">Yearly Premium Amount</th>
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
        processing: false,
        serverSide: false,
        dom:'lBfrtip',
        ajax: "{{ route('mediclaim.all_mediclaim_yearly',Auth::User()->id) }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name', name: 'company_name'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'policy_type', name: 'policy_type'},
            {data: 'policy_name', name: 'policy_name'},
            {data: 'policy_mode', name: 'policy_mode'},
            {data: 'yearly_premium_amount', name: 'yearly_premium_amount'},
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
            }
        ],
        createdRow: function ( row, data, index ) {
            $(data).each(function(key,val){
                sum=sum+parseInt(val.yearly_premium_amount);
            });
            $("#sum_yearly_amount").text(parseInt(sum));
        }
    });
    table.buttons().container().appendTo($('#buttons'))
});
    function view_mediclaim_yearly(id){
        
    window.location.href='/all_mediclaim/'+id+'/view';
}

</script>
@endsection
