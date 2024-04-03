@extends('layouts.default')

@section('content')
<hr>
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Add Vehicle Insurance
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('vehicle_insurance.store_vehicle_insurance') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
                    <div class="row mb-3">
                        <label for="sr_no" class="col-md-3 col-form-label text-md-end text-start">Sr No <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control @error('sr_no') is-invalid @enderror" id="sr_no" name="sr_no" value="{{ old('sr_no') }}" placeholder="Sr No." autocomplete="off">
                            @if ($errors->has('sr_no'))
                                <span class="error invalid-feedback">{{ $errors->first('sr_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Vehicle Category<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="vehicle_category" class="form-control @error('vehicle_category') is-invalid @enderror vehicle_category" name="vehicle_category" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Vehicle Category --</option>
                                @foreach ($vehicle_category as $data)
                                @if (old('vehicle_category') == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('vehicle_category'))
                                    <span class="error invalid-feedback">{{ $errors->first('vehicle_category') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="vehicle_number" class="col-md-3 col-form-label text-md-end text-start">Vehicle Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}" placeholder="Vehicle Number" autocomplete="off">
                            @if ($errors->has('vehicle_number'))
                                <span class="error invalid-feedback">{{ $errors->first('vehicle_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="vehicle_name" class="col-md-3 col-form-label text-md-end text-start">Vehicle Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('vehicle_name') is-invalid @enderror" id="vehicle_name" name="vehicle_name" value="{{ old('vehicle_name') }}" placeholder="Vehicle Name" autocomplete="off">
                            @if ($errors->has('vehicle_name'))
                                <span class="error invalid-feedback">{{ $errors->first('vehicle_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="mb-3 row">
                        <label for="company_name_id" class="col-md-3 col-form-label text-md-end text-start">Insurance Company Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('company_name_id') is-invalid @enderror" id="company_name_id" name="company_name_id" value="{{ old('company_name_id') }}" placeholder="Insurance Company Name" autocomplete="off">
                            @if ($errors->has('company_name_id'))
                                <span class="error invalid-feedback">{{ $errors->first('company_name_id') }}</span>
                            @endif
                        </div>
                    </div> -->
                    <div class="mb-3 row">
                    <label for="company_name_id" class="col-md-3 col-form-label text-md-end text-start">Insurance Company Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="company_name_id" class="form-control @error('company_name_id') is-invalid @enderror company_name_id" name="company_name_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Company --</option>
                                @foreach ($company as $data)
                                @if (old('company_name_id') == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('company_name_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('company_name_id') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="policy_number" class="col-md-3 col-form-label text-md-end text-start">Policy Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('policy_number') is-invalid @enderror" id="policy_number" name="policy_number" value="{{ old('policy_number') }}" placeholder="Policy Number" autocomplete="off">
                            @if ($errors->has('policy_number'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="chasis_number" class="col-md-3 col-form-label text-md-end text-start">Chassis Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('chasis_number') is-invalid @enderror" id="chasis_number" name="chasis_number" value="{{ old('chasis_number') }}" placeholder="Chassis Number" autocomplete="off">
                            @if ($errors->has('chasis_number'))
                                <span class="error invalid-feedback">{{ $errors->first('chasis_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Policy Type<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="policy_type" class="form-control @error('policy_type') is-invalid @enderror policy_type" name="policy_type" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Policy Type --</option>
                                @foreach ($policy_type as $data)
                                @if (old('policy_type') == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('policy_type'))
                                    <span class="error invalid-feedback">{{ $errors->first('policy_type') }}</span>
                                @endif
                        </div>
                    </div>
                    


                    <div class="mb-3 row">
                        <label for="policy_premium" class="col-md-3 col-form-label text-md-end text-start">Policy Premium <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('policy_premium') is-invalid @enderror" id="policy_premium" name="policy_premium" value="{{ old('policy_premium') }}" placeholder="Policy Premium" autocomplete="off">
                            @if ($errors->has('policy_premium'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_premium') }}</span>
                            @endif
                        </div>
                    </div>
                   
                    
                    <div class="mb-3 row">
                        <label for="vehicle_owner_name" class="col-md-3 col-form-label text-md-end text-start">Vehicle Owner Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('vehicle_owner_name') is-invalid @enderror" id="vehicle_owner_name" name="vehicle_owner_name" value="{{ old('vehicle_owner_name') }}" placeholder="Vehicle Owner Name" autocomplete="off">
                            @if ($errors->has('vehicle_owner_name'))
                                <span class="error invalid-feedback">{{ $errors->first('vehicle_owner_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="policy_start_date" class="col-md-3 col-form-label text-md-end text-start">Policy Start Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group policy_start_date" id="policy_start_date" data-target-input="nearest">
                                <input type="text" name="policy_start_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('policy_start_date') is-invalid @enderror  datetimepicker-input" data-target="#policy_start_date" placeholder="YYYY-MM-DD" value="{{ old('policy_start_date') ? old('policy_start_date') : '' }}"/>
                                <div class="input-group-append" data-target="#policy_start_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('policy_start_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('policy_start_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="policy_end_date" class="col-md-3 col-form-label text-md-end text-start">Policy End Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group policy_end_date" id="policy_end_date" data-target-input="nearest">
                                <input type="text" name="policy_end_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('policy_end_date') is-invalid @enderror  datetimepicker-input" data-target="#policy_end_date" placeholder="YYYY-MM-DD" value="{{ old('policy_end_date') ? old('policy_end_date') : '' }}"/>
                                <div class="input-group-append" data-target="#policy_end_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('policy_end_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('policy_end_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="agent_name" class="col-md-3 col-form-label text-md-end text-start">Agent Name</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="agent_name" name="agent_name" value="{{ old('agent_name') }}" placeholder="Agent Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agent_mobile_number" class="col-md-3 col-form-label text-md-end text-start">Agent Mobile Number</label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control" id="agent_mobile_number" name="agent_mobile_number" value="{{ old('agent_mobile_number') }}" placeholder="Agent Mobile Number" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="other_details" class="col-md-3 col-form-label text-md-end text-start">Other Details </label>
                        <div class="col-md-4">
                            <textarea class="form-control select2 select2-hidden-accessible state " name="other_details" placeholder="Other Details">{{ old('other_details') ? old('other_details') : '' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Add Vehicle Insurance">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="float-left">
                    <h4 class="modal-title" id="myModal">Policy Number Exists </h4>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="User_ids" class="col-md-4 col-form-label text-md-end text-start">User ID</label>
                    <span class="col-md-6 form-control user_ids"></span>
                </div>
                <div class="mb-3 row">
                    <label for="user_names" class="col-md-4 col-form-label text-md-end text-start">User Name</label>
                    <span class="col-md-6 form-control user_names"></span>
                </div>
                <div class="mb-3 row">
                    <label for="sr_nos" class="col-md-4 col-form-label text-md-end text-start">Sr No</label>
                    <span class="col-md-6 form-control sr_nos"></span>
                </div>
                <div class="mb-3 row">
                    <label for="vehicle_owner_name" class="col-md-4 col-form-label text-md-end text-start">Policy Holder Name</label>
                    <span class="col-md-6 form-control vehicle_owner_names"></span>
                </div>
            </div>
        </div>
    </div>
</div>  

<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    // $(document).ready(function(){
$('#policy_number').change( function() {
    var policy_num = $(this).val();
    $.ajax({
        url: "{{route('fetchVehicleInsurancePolicy')}}",
        type: "POST",
        data: {
            policy_number: policy_num,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function (result) 
        {
            $(".error_class").remove(); 
            if(result.policy_users.length!=0){
                $("#policy_number").after('<span class="error error_class" style="color:red">Please Enter Unique Number</span>');
                $.each(result.policy_users, function (key, value) {
                    $("#login").modal('show');
                    $("#policy_number").val('');
                    $(".user_names").text(value.user.name+' '+value.user.middle_name+' '+value.user.surname);
                    $(".user_ids").text(value.user.user_id);
                    $(".sr_nos").text(value.sr_no);
                    $(".vehicle_owner_names").text(value.vehicle_owner_name);
                });
            }else{
            $(".error_class").remove();
            }
        }
    });
}); 
</script>
@endsection
