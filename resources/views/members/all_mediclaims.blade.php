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
        <thead>
            <tr>
                
                <th scope="col">Sr No</th>
                <th scope="col">Policy Holder Name</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Policy Start Date</th>
                <th scope="col">Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Policy Type</th>
                <th scope="col">Sum Assured</th>
                <th scope="col">Policy Name</th>
                <th scope="col">Policy Mode</th>
                <th scope="col">Premium Amount</th>
                <th scope="col">Yearly Premium Amount</th>
                <th scope="col">Agent Name</th>
                <th scope="col">Agent Mobile Number</th>
                <th scope="col">Branch_Name</th>
                <th scope="col">Branch Address</th>
                <th scope="col">Branch Contact No</th>
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
      ajax: "{{ route('mediclaim.all_mediclaim') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name', name: 'company_name'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'policy_type', name: 'policy_type'},
            {data: 'sum_assured', name: 'sum_assured'},
            {data: 'policy_name', name: 'policy_name'},
            {data: 'policy_mode', name: 'policy_mode'},
            {data: 'premium_amount', name: 'premium_amount'},
            {data: 'yearly_premium_amount', name: 'yearly_premium_amount'},
            {data: 'agent_name', name: 'agent_name'},
            {data: 'agent_mobile_number', name: 'agent_mobile_number'},
            {data: 'branch_name', name: 'branch_name'},
            {data: 'branch_address', name: 'branch_address'},
            {data: 'branch_contact_no', name: 'branch_contact_no'},
            {data: 'other_details', name: 'other_details'},
        ]
    });

</script>
@endsection
