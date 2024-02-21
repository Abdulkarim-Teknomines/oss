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
                <a href="{{ route('create_mediclaim_company') }}" class="btn btn-primary btn-sm my-2"><i class="fa fa-plus"></i> Add Company Name</a>
            </div>
        
    </div>
    <div class="card-body">
    <table class="table table-bordered dts">
        <thead>
            <tr>
                <th scope="col">Company Name</th>
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
      ajax: "{{ route('list_mediclaim_company') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

</script>
@endsection
