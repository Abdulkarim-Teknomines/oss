@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        @can('create-member')
            <div class="float-right">
                <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm my-2"><i class="fa fa-plus"></i> Add New Member</a>
            </div>
        @endcan</div>
    <div class="card-body">
        
    <table class="table table-bordered dts1" id="dts1">
        <thead class="bg-primary">
            <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col">Mediclaim</th>
                <th scope="col">Mutual Fund</th>
                <th scope="col">Vehicle Insurance</th>
                <th scope="col">Life Insurance</th>
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
    $(document).ready(function(){

    
    $('#dts1').DataTable({
      processing: true,
      serverSide: false,
      ajax: "{{ route('members.index') }}",
      columns: [
          {data: 'id', name: 'id'},
          {data: 'name', name: 'name'},
          {data: 'mediclaim', name: 'mediclaim'},
          {data: 'mutual_fund', name: 'mutual_fund'},
          {data: 'vehicle_insurance', name: 'vehicle_insurance'},
          {data: 'life_insurance', name: 'life_insurance'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });
})
function add_mediclaim(id){
    window.location.href='mediclaim/'+id+'/add';
}
function view_mediclaim(id){
    window.location.href='mediclaim/'+id+'/view';
}
function add_life_insurance(id){
    window.location.href='life_insurance/'+id+'/add';
}
function view_life_insurance(id){
    window.location.href='life_insurance/'+id+'/view';
}
function add_mutual_fund(id){
    window.location.href='mutual_fund/'+id+'/add';
}
function view_mutual_fund(id){
    window.location.href='mutual_fund/'+id+'/view';
}
function add_vehicle_insurance(id){
    window.location.href='vehicle_insurance/'+id+'/add';
}
function view_vehicle_insurance(id){
    window.location.href='vehicle_insurance/'+id+'/view';
}
    </script>
@endsection
