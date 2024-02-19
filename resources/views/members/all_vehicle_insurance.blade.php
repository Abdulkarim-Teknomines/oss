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
        <thead>
            <tr>
                <th scope="col">Sr No</th>
                <th scope="col">Vehicle Category</th>
                <th scope="col">Vehicle Number</th>
                <th scope="col">Vehicle Name</th>
                <th scope="col">Chasis Number</th>
                <th scope="col">Insurance Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Insurance Policy Type</th>
                <th scope="col">Policy Premium</th>
                <th scope="col">Vehicle Owner Name</th>
                <th scope="col">Policy Start Date</th>
                <th scope="col">Policy End Date</th>
                <th scope="col">Agent Name</th>
                <th scope="col">Agent Mobile Number</th>
                <th scope="col">Other Details</th>
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
      ajax: "{{ route('vehicle_insurance.all_vehicle_insurance') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'vehicle_category_id', name: 'vehicle_category_id'},
            {data: 'vehicle_number', name: 'vehicle_number'},
            {data: 'vehicle_name', name: 'vehicle_name'},
            {data: 'chasis_number', name: 'chasis_number'},
            {data: 'insurance_company_name', name: 'insurance_company_name'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'insurance_policy_type_id', name: 'insurance_policy_type_id'},
            {data: 'policy_premium', name: 'policy_premium'},
            {data: 'vehicle_owner_name', name: 'vehicle_owner_name'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'policy_end_date', name: 'policy_end_date'},
            {data: 'agent_name', name: 'agent_name'},
            {data: 'agent_mobile_number', name: 'agent_mobile_number'},
            {data: 'other_details', name: 'other_details'},
        ]
    });

</script>
@endsection