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
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:#007bff">Mutual Fund Yearly Premium Amount</span>
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
                <th scope="col">Mutual Fund Holder Name</th>
                <th scope="col">Mutual Fund Type</th>
                <th scope="col">Folio Number</th>
                <th scope="col">Fund Name</th>
                <th scope="col">Fund Type</th>
                <th scope="col">Purchase Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Yearly Amount</th>
                <th scope="col">Nominee Name</th>
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
        ajax: "{{ route('mutual_fund.all_mutual_fund_yearly') }}",
            columns: [
                {data: 'sr_no', name: 'sr_no'},
                {data: 'mutual_fund_holder_name', name: 'mutual_fund_holder_name'},
                {data: 'mutual_fund_type_id', name: 'mutual_fund_type_id'},
                {data: 'folio_number', name: 'folio_number'},
                {data: 'fund_name', name: 'fund_name'},
                {data: 'fund_type', name: 'fund_type'},
                {data: 'purchase_date', name: 'purchase_date'},
                {data: 'amount', name: 'amount'},
                {data: 'yearly_amount', name: 'yearly_amount'},
                {data: 'nominee_name', name: 'nominee_name'},
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
                        sum=sum+parseInt(val.yearly_amount);
                    });
                    $("#sum_yearly_amount").text(parseInt(sum));
                }
        });
        table.buttons().container().appendTo($('#buttons'))
    });
    function view_mutual_fund_yearly(id){
        window.location.href='/all_mutual_fund/'+id+'/view';
    }

</script> 

@endsection
