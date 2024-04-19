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
                    <span class="info-box-icon bg-info"><i class="fa fa-rupee-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:#007bff">Life Insurance Yearly Premium Amount</span>
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
                        <th scope="col">Sum Assured</th>
                        <th scope="col">Plan Name</th>
                        <th scope="col">Premium Mode</th>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var date = $("#month").val();
    $(document).ready(function(){
        var sum =0;
        var table = $('.dts').DataTable({
        processing: false,
        serverSide: false,
        dom:'lBfrtip',
        ajax: "{{ route('life_insurance.all_life_insurance_yearly') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'sum_assured', name: 'sum_assured'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'premium_mode', name: 'premium_mode'},
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
                sum = sum+parseInt(val.yearly_premium_amount);
            });
            $("#sum_yearly_amount").text(parseInt(sum));
        },
    });
    table.buttons().container().appendTo($('#buttons'))
});   

function view_life_insurance_yearly(id){
    window.location.href='/all_life_insurance/'+id+'/view';
}

</script>
@endsection
