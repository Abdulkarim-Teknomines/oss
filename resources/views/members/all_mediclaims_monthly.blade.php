@extends('layouts.default')

@section('content')

<div class="card pt-3">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
        @php $dates = Date('M');@endphp
        <div class="mb-3 row">
            
            <label class="col-md-1 offset-md-4 col-form-label text-md-end text-start">Month <span style="color:red">*</span></label>
            <div class="col-md-3">
                <select id="month" class="form-control" name="month" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value="jan" @if(Date('M')=='Jan') selected="true" @endif >January</option>
                    <option value="feb" @if(Date('M')=='Feb') selected="true" @endif>February</option>
                    <option value="mar" @if(Date('M')=='Mar') selected="true" @endif>March</option>
                    <option value="apr" @if(Date('M')=='Apr') selected="true" @endif>April</option>
                    <option value="may" @if(Date('M')=='May') selected="true" @endif>May</option>
                    <option value="jun" @if(Date('M')=='Jun') selected="true" @endif>June</option>
                    <option value="jul" @if(Date('M')=='Jul') selected="true" @endif>July</option>
                    <option value="aug" @if(Date('M')=='Aug') selected="true" @endif>August</option>
                    <option value="sep" @if(Date('M')=='Sep') selected="true" @endif>September</option>
                    <option value="oct" @if(Date('M')=='Oct') selected="true" @endif>October</option>
                    <option value="nov" @if(Date('M')=='Nov') selected="true" @endif>November</option>
                    <option value="dec" @if(Date('M')=='Dec') selected="true" @endif>December</option>
                </select>
            </div>
        </div>
        <div class="float-left">

            

        </div>
    <div class="card-body">
    <table class="table table-bordered dts">
        <thead class="bg-primary">
            <tr>
                
                <th scope="col">Sr No</th>
                <th scope="col">Policy Holder Name</th>
                <th scope="col">Policy Start Date</th>
                <th scope="col">Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Policy Type</th>
                <th scope="col">Policy Name</th>
                <th scope="col">Premium Amount</th>
                <th scope="col">Policy Mode</th>
                <th scope="col">Yearly Premium Amount</th>
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
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    var month = $('#month').find(":selected").val();
    var table = $('.dts').DataTable({
        processing: false,
        serverSide: false,
        paging: true,
        searching: true,
        "bDestroy": false,
        "info":true,
    'info':false,
      ajax: "{{ route('mediclaim.all_mediclaim_monthly',['date' => "+month+"])  }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name', name: 'company_name'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'policy_type', name: 'policy_type'},
            {data: 'policy_name', name: 'policy_name'},
            {data: 'premium_amount', name: 'premium_amount'},
            {data: 'policy_mode', name: 'policy_mode'},
            {data: 'yearly_premium_amount', name: 'yearly_premium_amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    

$(document).on('change','#month',function(){
    var months = $(this).val();
    
    var table = $('.dts').DataTable({
      processing: false,
      paging: false,
      serverSide: false,
      searching: false,
      "bDestroy": true,
      "info":false,
      ajax: "{{ route('mediclaim.all_mediclaim_monthly',['date' => "+months+"])  }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name', name: 'company_name'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'policy_type', name: 'policy_type'},
            {data: 'policy_name', name: 'policy_name'},
            {data: 'premium_amount', name: 'premium_amount'},
            {data: 'policy_mode', name: 'policy_mode'},
            {data: 'yearly_premium_amount', name: 'yearly_premium_amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});
function view_mediclaim_monthly(id){
    
    window.location.href='/all_mediclaim/'+id+'/view';
}
</script>
@endsection
