@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        @can('create-user')
            <div class="float-right">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm my-2"><i class="fa fa-plus"></i> Add New User</a>
            </div>
        @endcan</div>
    <div class="card-body">
    <table class="table table-bordered dts">
        <thead class="bg-primary">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
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
    var table = $('.dts').DataTable({
      processing: true,
      serverSide: false,
      ajax: "{{ route('user_password') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'password', name: 'password'},
        ]
    });
</script>
@endsection
