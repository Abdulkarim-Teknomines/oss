@extends('layouts.default')

@section('content')

<div class="card pt-3" style="width:100% !important">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
    @php $dates = Date('M');
        $date = strtotime('Jan'); 
        $date = date('M', strtotime('Jan')); 
    @endphp
        <div class="mb-3 row">
            <label class="col-md-1 offset-md-4 col-form-label text-md-end text-start">Month <span style="color:red">*</span></label>
            <div class="col-md-3">
                <select id="month" class="form-control" name="month" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value="jan" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Jan')))) selected="true" @endif >January</option>
                    <option value="feb" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>February</option>
                    <option value="mar" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>March</option>
                    <option value="apr" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>April</option>
                    <option value="may" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>May</option>
                    <option value="jun" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>June</option>
                    <option value="jul" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>July</option>
                    <option value="aug" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>August</option>
                    <option value="sep" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>September</option>
                    <option value="oct" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>October</option>
                    <option value="nov" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>November</option>
                    <option value="dec" @if(strtotime(Date('M'))==strtotime(Date('M',strtotime('Feb')))) selected="true" @endif>December</option>
                </select>
            </div>
        </div>
        <div class="float-left">
        </div>
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
                <th scope="col">Sum Assured</th>
                <th scope="col">Plan Name</th>
                <th scope="col">Premium Amount</th>
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
    var month = $('#month').find(":selected").val();
    
    var table = $('.dts').DataTable({
        processing: false,
        serverSide: false,
        paging: true,
        searching: true,
        "bDestroy": false,
        "info":true,
        ajax: "{{ route('life_insurance.all_life_insurance_monthly',['date' => "+month+"]) }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'sum_assured', name: 'sum_assured'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'premium_amount', name: 'premium_amount'},
            {data: 'premium_mode', name: 'premium_mode'},
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
      ajax: "{{ route('life_insurance.all_life_insurance_monthly',['date' => "+months+"]) }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'sum_assured', name: 'sum_assured'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'premium_amount', name: 'premium_amount'},
            {data: 'premium_mode', name: 'premium_mode'},
            {data: 'yearly_premium_amount', name: 'yearly_premium_amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});
    function view_life_insurance_monthly(id){
        window.location.href='/all_life_insurance/'+id+'/view';
    }
$('.dts tr').each(function() { 
    $(this).closest('td').find('span.yearly_premium_amount').text();
    // alert($(this).closest("td").find('.yearly_premium_amount').text() );
    // console.log(($this).closest('tr').text());
    // var val = $(this).closest('td').find('.yearly_premium_amount').text();
    // var val=$(this).closest('td').text();
    // alert(val);
      // do something with each input element 
    //   console.log(val); 
    
}); 
</script>
@endsection
