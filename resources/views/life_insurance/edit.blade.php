@extends('layouts.default')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Edit Member Life Insurance
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('life_insurance.update_life_insurance', $life_insurance->id) }}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="life_insurance_id" id="life_insurance_id" value="{{$life_insurance_id}}">
                    <div class="row mb-3">
                        <label for="sr_no" class="col-md-3 col-form-label text-md-end text-start">Sr No <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control @error('sr_no') is-invalid @enderror" id="sr_no" name="sr_no" value="{{ old('sr_no',$life_insurance->sr_no) }}" placeholder="Sr No." autocomplete="off">
                            @if ($errors->has('sr_no'))
                                <span class="error invalid-feedback">{{ $errors->first('sr_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="policy_holder_name" class="col-md-3 col-form-label text-md-end text-start">Policy Holder Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('policy_holder_name') is-invalid @enderror" id="policy_holder_name" name="policy_holder_name" value="{{ old('policy_holder_name',$life_insurance->policy_holder_name) }}" placeholder="Policy Holder Name" autocomplete="off">
                            @if ($errors->has('policy_holder_name'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_holder_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start">Birth Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group birth_date" id="birth_date" data-target-input="nearest">
                                <input type="text" name="birth_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('birth_date') is-invalid @enderror  datetimepicker-input" data-target="#birth_date" placeholder="YYYY-MM-DD" value="{{ old('birth_date') ? old('birth_date') : $life_insurance->birth_date }}" readonly/>
                                <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('birth_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="policy_start_date" class="col-md-3 col-form-label text-md-end text-start">Policy Start Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group policy_start_date" id="policy_start_date" data-target-input="nearest">
                                <input type="text" name="policy_start_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('policy_start_date') is-invalid @enderror  datetimepicker-input" data-target="#policy_start_date" placeholder="YYYY-MM-DD" value="{{ old('policy_start_date') ? old('policy_start_date') : $life_insurance->policy_start_date }}" readonly/>
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
                        <label class="col-md-3 col-form-label text-md-end text-start">Company Name<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="company_name" class="form-control @error('company_name') is-invalid @enderror company_name" name="company_name" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Company Name --</option>
                                @foreach ($company_name as $data)
                                @if (old('company_name',$life_insurance->company_name_id) == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('company_name'))
                                    <span class="error invalid-feedback">{{ $errors->first('company_name') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="policy_number" class="col-md-3 col-form-label text-md-end text-start">Policy Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('policy_number') is-invalid @enderror" id="policy_number" name="policy_number" value="{{ old('policy_number',$life_insurance->policy_number) }}" placeholder="Policy Number" autocomplete="off">
                            @if ($errors->has('policy_number'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="sum_assured" class="col-md-3 col-form-label text-md-end text-start">Sum Assured <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control @error('sum_assured') is-invalid @enderror" id="sum_assured" name="sum_assured" value="{{ old('sum_assured',$life_insurance->sum_assured) }}" placeholder="Sum Assured" autocomplete="off">
                            @if ($errors->has('sum_assured'))
                                <span class="error invalid-feedback">{{ $errors->first('sum_assured') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="plan_name" class="col-md-3 col-form-label text-md-end text-start">Plan Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('plan_name') is-invalid @enderror" id="plan_name" name="plan_name" value="{{ old('plan_name',$life_insurance->plan_name) }}" placeholder="Plan Name" autocomplete="off">
                            @if ($errors->has('plan_name'))
                                <span class="error invalid-feedback">{{ $errors->first('plan_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Plan Type<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="plan_type_id" class="form-control @error('plan_type_id') is-invalid @enderror plan_type_id" name="plan_type_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Plan Type --</option>
                                @foreach ($ppt as $data)
                                @if (old('plan_type_id',$life_insurance->plan_type_id) == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('plan_type_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('plan_type_id') }}</span>
                                @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">PPT<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="ppt" class="form-control @error('ppt') is-invalid @enderror ppt" name="ppt" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select PPT --</option>
                                @for($i=1;$i<=100;$i++)
                                    @if (old('ppt',$life_insurance->ppt) == $i)
                                        <option value="{{ $i }}" selected>{{ $i.' Year'}} </option>
                                @else
                                    <option value="{{ $i }}">{{ $i.' Year' }}</option>
                                @endif
                                @endfor
                            </select>
                            @if ($errors->has('ppt'))
                                    <span class="error invalid-feedback">{{ $errors->first('ppt') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ppt_end_date" class="col-md-3 col-form-label text-md-end text-start">PPT End Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group ppt_end_date" id="ppt_end_date" data-target-input="nearest">
                                <input type="text" name="ppt_end_date" class="form-control select2 select2-hidden-accessible state @error('ppt_end_date') is-invalid @enderror  datetimepicker-input" data-target="#ppt_end_date" placeholder="YYYY-MM-DD" value="{{ old('ppt_end_date') ? old('ppt_end_date') : $life_insurance->ppt_end_date }}" readonly/>
                                <div class="input-group-append" data-target="#ppt_end_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('ppt_end_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('ppt_end_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Premium Mode<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="premium_mode" class="form-control @error('premium_mode') is-invalid @enderror premium_mode" name="premium_mode" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Premium Mode --</option>
                                @foreach ($policy_mode as $data)
                                @if (old('premium_mode',$life_insurance->policy_mode_id) == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('premium_mode'))
                                    <span class="error invalid-feedback">{{ $errors->first('premium_mode') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="premium_amount" class="col-md-3 col-form-label text-md-end text-start">Premium Amount <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('premium_amount') is-invalid @enderror" id="premium_amount" name="premium_amount" value="{{ old('premium_amount',$life_insurance->premium_amount) }}" placeholder="Premium Amount" autocomplete="off">
                            @if ($errors->has('premium_amount'))
                                <span class="error invalid-feedback">{{ $errors->first('premium_amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="yearly_premium_amount" class="col-md-3 col-form-label text-md-end text-start">Yearly Premium Amount <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('yearly_premium_amount') is-invalid @enderror" id="yearly_premium_amount" name="yearly_premium_amount" value="{{ old('yearly_premium_amount',$life_insurance->yearly_premium_amount) }}" placeholder="Yearly Premium Amount" autocomplete="off" readonly>
                            @if ($errors->has('yearly_premium_amount'))
                                <span class="error invalid-feedback">{{ $errors->first('yearly_premium_amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nominee_name" class="col-md-3 col-form-label text-md-end text-start">Nominee Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('nominee_name') is-invalid @enderror" id="nominee_name" name="nominee_name" value="{{ old('nominee_name',$life_insurance->nominee_name) }}" placeholder="Nominee Name" autocomplete="off">
                            @if ($errors->has('nominee_name'))
                                <span class="error invalid-feedback">{{ $errors->first('nominee_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nominee_relation" class="col-md-3 col-form-label text-md-end text-start">Nominee Relation <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('nominee_relation') is-invalid @enderror" id="nominee_relation" name="nominee_relation" value="{{ old('nominee_relation',$life_insurance->nominee_relation) }}" placeholder="Nominee Relation" autocomplete="off">
                            @if ($errors->has('nominee_relation'))
                                <span class="error invalid-feedback">{{ $errors->first('nominee_relation') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nominee_dob" class="col-md-3 col-form-label text-md-end text-start">Nominee DOB <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group nominee_dob" id="nominee_dob" data-target-input="nearest">
                                <input type="text" name="nominee_dob" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('nominee_dob') is-invalid @enderror  datetimepicker-input" data-target="#nominee_dob" placeholder="YYYY-MM-DD" value="{{ old('nominee_dob') ? old('nominee_dob') : $life_insurance->nominee_dob }}" readonly/>
                                <div class="input-group-append" data-target="#nominee_dob" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('nominee_dob'))
                                    <span class="error invalid-feedback">{{ $errors->first('nominee_dob') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agent_name" class="col-md-3 col-form-label text-md-end text-start">Agent Name</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="agent_name" name="agent_name" value="{{ old('agent_name',$life_insurance->agent_name) }}" placeholder="Agent Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agent_mobile_number" class="col-md-3 col-form-label text-md-end text-start">Agent Mobile Number</label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control" id="agent_mobile_number" name="agent_mobile_number" value="{{ old('agent_mobile_number',$life_insurance->agent_mobile_number) }}" placeholder="Agent Mobile Number" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="branch_name" class="col-md-3 col-form-label text-md-end text-start">Branch Name</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ old('branch_name',$life_insurance->branch_name) }}" placeholder="Branch Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="branch_address" class="col-md-3 col-form-label text-md-end text-start">Branch Address </label>
                        <div class="col-md-4">
                            <textarea class="form-control select2 select2-hidden-accessible state" name="branch_address" placeholder="Branch Address">{{ old('branch_address') ? old('branch_address') : $life_insurance->branch_address }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="branch_contact_number" class="col-md-3 col-form-label text-md-end text-start">Branch Contact Number</label>
                        <div class="col-md-4">
                            <input type="number" min="0" class="form-control" id="branch_contact_number" name="branch_contact_number" value="{{ old('branch_contact_number',$life_insurance->branch_contact_no) }}" placeholder="Agent Mobile Number" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="other_details" class="col-md-3 col-form-label text-md-end text-start">Other Details </label>
                        <div class="col-md-4">
                            <textarea class="form-control select2 select2-hidden-accessible state " name="other_details" placeholder="Branch Address">{{ old('other_details') ? old('other_details') : $life_insurance->other_details }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Update Life Insurance">
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
                    <label for="policy_holder_name" class="col-md-4 col-form-label text-md-end text-start">Policy Holder Name</label>
                    <span class="col-md-6 form-control policy_holder_names"></span>
                </div>
            </div>
        </div>
    </div>
</div>  

<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $(document).ready(function(){
$('#policy_number').change( function() {
    var policy_num = $(this).val();
    var life_insurance_id = "{{$life_insurance->id}}";
    $.ajax({
        url: "{{route('fetchLifeInsurancePolicys')}}",
        type: "POST",
        data: {
            policy_number: policy_num,life_insurance_id:life_insurance_id,
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
                    $(".policy_holder_names").text(value.policy_holder_name);
                });
            }else{
                $(".error_class").remove();
            }
        }
    });
}); 
    // $(document).ready(function(){
    $(document).on('change','#premium_mode',function(){
        var prem_amt = $(this).val();
        var premium_amount =$("#premium_amount").val();
        if(prem_amt=="1"){
            $("#yearly_premium_amount").val((parseInt(premium_amount)*12));
        }else if(prem_amt=="2"){
            $("#yearly_premium_amount").val((parseInt(premium_amount)*4));
        }else if(prem_amt=="3"){
            $("#yearly_premium_amount").val((parseInt(premium_amount)*2));
        }else if(prem_amt=="4"){
            $("#yearly_premium_amount").val((parseInt(premium_amount)*1));
        }else{
            $("#yearly_premium_amount").val((parseInt(premium_amount)*1));
        }
    });
        
    $(document).on('change','#premium_amount',function(){
        var prem_amt = $(this).val();
        var policy_mode =$("#premium_mode").val();
        if(policy_mode=="1"){
            $("#yearly_premium_amount").val((parseInt(prem_amt)*12));
        }else if(policy_mode=="2"){
            $("#yearly_premium_amount").val((parseInt(prem_amt)*4));
        }else if(policy_mode=="3"){
            $("#yearly_premium_amount").val((parseInt(prem_amt)*2));
        }else if(policy_mode=="4"){
            $("#yearly_premium_amount").val((parseInt(prem_amt)*1));
        }else{
            $("#yearly_premium_amount").val((parseInt(prem_amt)*1));
        }
    });
    </script>
@endsection
