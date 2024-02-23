@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        
    <div class="card-body">
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
    var table = $('.dts').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('mutual_fund.all_mutual_fund') }}",
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
        ]
    });

</script>
@endsection
