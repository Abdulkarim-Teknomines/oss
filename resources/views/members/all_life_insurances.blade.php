@extends('layouts.default')

@section('content')

<div class="card pt-3" style="width:100% !important">
    <div class="card-header">
        @if (session('success'))
            <div class="float-left">
                <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
            </div>
        @endif
    <!-- @php $dates = Date('M');@endphp -->
        <!-- <div class="mb-3 row">
            <label class="col-md-1 offset-md-4 col-form-label text-md-end text-start">Month <span style="color:red">*</span></label>
            <div class="col-md-3">
                <select id="month" class="form-control" name="month" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value="">-- Select Month --</option>
                    <option value="jan" @if(Date('M')=='Jan') selected="true" @endif >January</option>
                    <option value="feb" @if(Date('M')=='Feb') selected="true" @endif>February</option>
                    <option value="mar" @if(Date('M')=='Mar') selected="true" @endif>March</option>
                    <option value="apr">April</option>
                    <option value="may">May</option>
                    <option value="jun">June</option>
                    <option value="jul">July</option>
                    <option value="aug">August</option>
                    <option value="sep">September</option>
                    <option value="oct">October</option>
                    <option value="nov">November</option>
                    <option value="dec">December</option>
                </select>
            </div>
        </div> -->
        <div class="float-left">

            

        </div>
</div>
    <div class="card-body">
    <table class="table table-bordered dts">
        <thead class="bg-primary">
            <tr>
                <th scope="col">Sr No</th>
                <th scope="col">Policy Holder Name</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Policy Start Date</th>
                <th scope="col">Company Name</th>
                <th scope="col">Policy Number</th>
                <th scope="col">Sum Assured</th>
                <th scope="col">Plan Name</th>
                <th scope="col">PPT</th>
                <th scope="col">Policy Term</th>
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
      ajax: "{{ route('life_insurance.all_life_insurance') }}",
        columns: [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'policy_holder_name', name: 'policy_holder_name'},
            {data: 'birth_date', name: 'birth_date'},
            {data: 'policy_start_date', name: 'policy_start_date'},
            {data: 'company_name_id', name: 'company_name_id'},
            {data: 'policy_number', name: 'policy_number'},
            {data: 'sum_assured', name: 'sum_assured'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'ppt_id', name: 'ppt_id'},
            {data: 'policy_term', name: 'policy_term'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

$(document).on('change','#month',function(){
    var val = $(this).val();
    $.ajax({
        url: "{{ route('life_insurance.all_life_insurance') }}",
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
</script>
@endsection
