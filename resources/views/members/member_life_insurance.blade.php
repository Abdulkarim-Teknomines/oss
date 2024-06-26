@extends('layouts.default')

@section('content')

<div class="card pt-3" style="width:100% !important">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
    @php $dates = Date('M');@endphp
        
</div>
    <div class="card-body">
    <table class="table table-bordered dts">
        <thead class="bg-primary">
            <tr>
                <th scope="col">Sr No</th>
                <th scope="col">Policy Holder Name</th>
                <th scope="col">Added By</th>
                <th scope="col">Policy Start Date</th>
                <th scope="col">Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Sum Assured</th>
                <th scope="col">Plan Name</th>
                <th scope="col">Premium Mode</th>
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
    var date = $("#month").val();

    var table = $('.dts').DataTable({
      processing: true,
      serverSide: false,
      ajax: "{{ route('member_life_insurance') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'added_by', name: 'added_by'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'sum_assured', name: 'sum_assured'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'premium_mode', name: 'premium_mode'},
            {data: 'yearly_premium_amount', name: 'yearly_premium_amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

$(document).on('change','#month',function(){
    var val = $(this).val();
    $.ajax({
        url: "{{ route('life_insurance.all_life_insurance_yearly') }}",
        type: 'GET',
        dataType: "json",
        data: {
            date: val,
        },
        success: function(data) {
            // log response into console
            
            dataTable.ajax.reload(null, false);
        }
    });
});
function view_life_insurance_yearly(id){
    
    window.location.href='/all_life_insurance/'+id+'/view';
}
</script>
@endsection
