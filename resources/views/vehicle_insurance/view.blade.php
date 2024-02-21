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
            <thead>
                <tr>
                    <th scope="col">Sr No.</th>
                    <th scope="col">Vehicle Category</th>
                    <th scope="col">Vehicle Number</th>
                    <th scope="col">Vehicle Name</th>
                    <th scope="col">Insurance Company Name</th>
                    <th scope="col">Policy Number</th>
                    <th scope="col">Insurance Policy Type</th>
                    
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
      ajax: "{{ route('vehicle_insurance.view',[Request::segment(2)]) }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'vehicle_category_id', name: 'vehicle_category_id'},
            {data: 'vehicle_number', name: 'vehicle_number'},
            {data: 'vehicle_name', name: 'vehicle_name'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'insurance_policy_type_id', name: 'insurance_policy_type_id'},
            
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    function view_vehicle_insurance(id){
        window.location.href='/vehicle_insurances/'+id;
    }
    
    function edit_vehicle_insurance(id){
        window.location.href='/vehicle_insurances/'+id+'/edit_vehicle_insurance';
    }
</script>
@endsection
