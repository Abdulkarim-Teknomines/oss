@extends('layouts.default')

@section('content')

<div class="card pt-3" style="width:100% !important">
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
                <th scope="col">Vehicle Category</th>
                <th scope="col">Vehicle Number</th>
                <th scope="col">Vehicle Name</th>
                <th scope="col">Chassis Number</th>
                <th scope="col">Insurance Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Added By</th>
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
    var table = $('.dts').DataTable({
      processing: true,
      serverSide: false,
      ajax: "{{ route('member_vehicle_insurance') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'vehicle_category_id', name: 'vehicle_category_id'},
            {data: 'vehicle_number', name: 'vehicle_number'},
            {data: 'vehicle_name', name: 'vehicle_name'},
            {data: 'chasis_number', name: 'chasis_number'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'added_by', name: 'added_by'},
            {data: 'policy_premium', name: 'policy_premium'},
            {data: 'vehicle_owner_name', name: 'vehicle_owner_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    function view_vehicle_insurance_yearly(id){
    
    window.location.href='/all_vehicle_insurance/'+id+'/view';
    
}
</script>
@endsection
