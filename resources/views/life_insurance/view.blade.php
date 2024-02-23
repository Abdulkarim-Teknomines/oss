@extends('layouts.default')
@section('content')
<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
    </div>
    
        
    <div class="card-body ">
        <table class="table table-bordered dts1 table-responsive " id="dts1">
            <thead class="bg-primary">
                <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Policy Holder Name</th>
                    <th scope="col">Birth Date</th>
                    <th scope="col">Policy Start Date</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Policy Number</th>
                    <th scope="col">Plan Name</th>
                    <th scope="col">PPT</th>
                    <th scope="col">Premim Mode</th>
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
    var table = $('.dts1').DataTable({
      processing: true,
      serverSide: true,
      
      ajax: "{{ route('life_insurance.view',[Request::segment(2)]) }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'ppt_id', name: 'ppt_id'},
            {data: 'premium_mode_id', name: 'premium_mode_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    function view_life_insurance(id){
        window.location.href='/life_insurances/'+id;
    }
    function edit_life_insurance(id){
        window.location.href='/life_insurances/'+id+'/edit_life_insurance';
    }
</script>
@endsection
