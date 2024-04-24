@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        <!-- @can('create-user')
            <div class="float-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm my-2"><i class="fa fa-plus"></i> Add New User</a>
            </div>
        @endcan</div> -->
    <div class="card-body">
    <table class="table table-bordered dts">
        <thead class="bg-primary">
            <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Added By</th>
                <th scope="col">Status</th>
                <th scope="col">Pancard Number</th>
                <th scope="col">Mobile Number</th>
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
       var table = $('.dts').DataTable({
      processing: false,
        serverSide: false,
        paging: true,
        searching: true,
        "bDestroy": false,
        "info":true,
        type: 'GET',
        ajax: {
            url: "{{ route('member.active_member') }}",
            data: function (d) {
                 d.status = 0;
             }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'added_by', name: 'added_by'},
            {data: 'status', name: 'status', orderable: false},
            {data: 'pancard_number', name: 'pancard_number'},
            {data: 'mobile_number', name: 'mobile_number'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}); 

function view(id){
    window.location.href='/users/'+id+'/view';
}

</script>
@endsection
