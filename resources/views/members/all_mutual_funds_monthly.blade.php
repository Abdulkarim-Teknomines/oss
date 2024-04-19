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
        @php $dates = Date('M');@endphp
        <!-- <h4 class="text-center" style="color:#007bff">Mutual Fund Yearly Premium Amount Sum : <span id="sum_yearly_amount">0</span></h4> -->
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-rupee-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:#007bff">Mutual Fund Yearly Premium Amount</span>
                        <span class="info-box-number"  style="color:#007bff" id="sum_yearly_amount"></span>
                    </div>

                </div>
            </div>
        </div>
        <div class="mb-3 row">
            
            <label class="col-md-1 offset-md-4 col-form-label text-md-end text-start">Month <span style="color:red">*</span></label>
            <div class="col-md-3">
                <select id="month" class="form-control" name="month" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value="jan" @if(Date('M')=='Jan') selected="true" @endif >January</option>
                    <option value="feb" @if(Date('M')=='Feb') selected="true" @endif>February</option>
                    <option value="mar" @if(Date('M')=='Mar') selected="true" @endif>March</option>
                    <option value="apr" @if(Date('M')=='Apr') selected="true" @endif>April</option>
                    <option value="may" @if(Date('M')=='May') selected="true" @endif>May</option>
                    <option value="jun" @if(Date('M')=='Jun') selected="true" @endif>June</option>
                    <option value="jul" @if(Date('M')=='Jul') selected="true" @endif>July</option>
                    <option value="aug" @if(Date('M')=='Aug') selected="true" @endif>August</option>
                    <option value="sep" @if(Date('M')=='Sep') selected="true" @endif>September</option>
                    <option value="oct" @if(Date('M')=='Oct') selected="true" @endif>October</option>
                    <option value="nov" @if(Date('M')=='Nov') selected="true" @endif>November</option>
                    <option value="dec" @if(Date('M')=='Dec') selected="true" @endif>December</option>
                </select>
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
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function(){
            var sum =0;
    var month = $('#month').find(":selected").val();
    var table = $('.dts').DataTable({
        
        processing: false,
        serverSide: false,
        paging: true,
        searching: true,
        "bDestroy": false,
        "info":true,
        type: 'GET',
        dom:'lBfrtip',
        ajax: {
            url: "{{ route('mutual_fund.all_mutual_fund_monthly')  }}",
            data: function (d) {
                d.date = month;
             }
        },
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
$(document).on('change','#month',function(){
    var sum =0;
    var months = $(this).val();
    $("#sum_yearly_amount").text(parseInt(sum));
    var table = $('.dts').DataTable({
        processing: false,
        paging: true,
        serverSide: false,
        searching: true,
        "bDestroy": true,
        "info":true,
        dom:'lBfrtip',
        type: 'GET',
        ajax: {
            url: "{{ route('mutual_fund.all_mutual_fund_monthly')  }}",
            data: function (d) {
                d.date = months;
             }
        },
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
function view_mutual_fund_monthly(id){
    window.location.href='/all_mutual_fund/'+id+'/view';
}

</script>
@endsection
