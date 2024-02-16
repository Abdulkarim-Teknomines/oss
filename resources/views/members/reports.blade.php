@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header-primary">
    <div class="card-body">
        
    <table class="table table-bordered dts1" id="dts1">
        <thead>
            <tr  style="color:#007bff">
                
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
                <th scope="col" style="color:#007bff">Total</th>
            </tr>
        </thead>
        <tbody>
            
        
        </tr>
        </tbody>
        <tfoot>
            <tr style="color:#007bff">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
        </tfoot>
    </table>
    <div class="float-right">
        <a class="btn btn-primary float-end" href="{{ route('members.member_export',[Request::segment(2)] )}}">Export Member Report</a>
        <!-- <a class="btn btn-warning float-end" href="{{ route('members.generate_pdf',[Request::segment(2)] )}}">Export User Data</a> -->
    </div>
</div>
    </div>
</div>
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function(){
    $('#dts1').DataTable({
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var janTotal = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
	        var febTotal = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
            var marTotal = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
	        var aprTotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
	        var mayTotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var junTotal = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var julTotal = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var augTotal = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var sepTotal = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var octTotal = api
                .column( 10 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var novTotal = api
                .column( 11 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var decTotal = api
                .column( 12 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var singleTotal = api
                .column( 13 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
               var subTotal = api
                .column( 14 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
               }, 0 );
            // Update footer by showing the total with the reference of the column index 
	        $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 1 ).footer() ).html(janTotal);
            $( api.column( 2 ).footer() ).html(febTotal);
            $( api.column( 3 ).footer() ).html(marTotal);
            $( api.column( 4 ).footer() ).html(aprTotal);
            $( api.column( 5 ).footer() ).html(mayTotal);
            $( api.column( 6 ).footer() ).html(junTotal);
            $( api.column( 7 ).footer() ).html(julTotal);
            $( api.column( 8 ).footer() ).html(augTotal);
            $( api.column( 9 ).footer() ).html(sepTotal);
            $( api.column( 10 ).footer() ).html(octTotal);
            $( api.column( 11 ).footer() ).html(novTotal);
            $( api.column( 12 ).footer() ).html(decTotal);
            $( api.column( 13 ).footer() ).html(singleTotal);
            $( api.column( 14 ).footer() ).html(subTotal);
            
        },
      processing: true,
      serverSide: true,
      paginate:false,
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
          {data: 'total', name: 'total'},
      
      ],
      
  });
});
</script>
@endsection