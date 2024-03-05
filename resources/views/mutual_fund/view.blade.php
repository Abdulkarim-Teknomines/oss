@extends('layouts.default')
@section('content')
<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        <div class="float-right">
                <a href="javascript:history.back()" class="btn btn-primary btn-sm my-2">← Back</a>
        </div>
    </div>
    <div class="card-body ">
        <table class="table table-bordered dts2 " id="dts2">
            <thead class="bg-primary">
                <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Mutual Fund Holder Name</th>
                    <th scope="col">Mutual Fund</th>
                    <th scope="col">Folio Number</th>
                    <th scope="col">Fund Name</th>
                    <th scope="col">Fund Type</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script>
    var table = $('#dts2').DataTable({
      processing: true,
      serverSide: false,
      
      ajax: "{{ route('mutual_fund.view',[Request::segment(2)]) }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'mutual_fund_holder_name', name: 'mutual_fund_holder_name'},
            {data: 'mutual_fund_type_id', name: 'mutual_fund_type_id'},
            {data: 'folio_number', name: 'folio_number'},
            {data: 'fund_name', name: 'fund_name'},
            {data: 'fund_type', name: 'fund_type'},
            {data: 'purchase_date', name: 'purchase_date'},
            {data: 'amount', name: 'amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    function view_mutual_fund(id){
        window.location.href='/mutual_funds/'+id;
    }
    function edit_mutual_fund(id){
        window.location.href='/mutual_funds/'+id+'/edit_mutual_fund';
    }
</script>
@endsection
