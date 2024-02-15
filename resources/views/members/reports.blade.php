@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header-primary">
    <div class="card-body">
        
    <table class="table table-bordered dts1" id="dts1">
        <thead>
            <tr>
                
                <th scope="col">Name</th>
                <th scope="col">Jan</th>
                <th scope="col">Feb</th>
                <th scope="col">Mar</th>
                <th scope="col">Apr</th>
                <th scope="col">May</th>
                <th scope="col">Jun</th>
                <th scope="col">Jul</th>
                <th scope="col">Aug</th>
                <th scope="col">Sep</th>
                <th scope="col">Oct</th>
                <th scope="col">Nov</th>
                <th scope="col">Dec</th>
                <th scope="col">Single</th>
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
    $('#dts1').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('members.reports',[Request::segment(2)]) }}",
      columns: [
        
          {data: 'name', name: 'name'},
          {data: 'jan', name: 'jan'},
          {data: 'feb', name: 'feb'},
          {data: 'mar', name: 'mar'},
          {data: 'apr', name: 'apr'},
          {data: 'may', name: 'may'},
          {data: 'jun', name: 'jun'},
          {data: 'jul', name: 'jul'},
          {data: 'aug', name: 'aug'},
          {data: 'sep', name: 'sep'},
          {data: 'oct', name: 'oct'},
          {data: 'nov', name: 'nov'},
          {data: 'dec', name: 'dec'},
          {data: 'single', name: 'single'},
      ]
  });
});
</script>
@endsection
