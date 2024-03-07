@extends('layouts.default')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Add Member Mediclaim
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('mediclaim.store_mediclaim') }}" method="post">
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
                        <label for="policy_holder_name" class="col-md-3 col-form-label text-md-end text-start">Policy Holder Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('policy_holder_name') is-invalid @enderror" id="policy_holder_name" name="policy_holder_name" value="{{ old('policy_holder_name') }}" placeholder="Policy Holder Name" autocomplete="off">
                            @if ($errors->has('policy_holder_name'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_holder_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start">Birth Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group birth_date" id="birth_date" data-target-input="nearest">
                                <input type="text" name="birth_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('birth_date') is-invalid @enderror  datetimepicker-input" data-target="#birth_date" placeholder="YYYY-MM-DD" readonly="true" value="{{ old('birth_date') ? old('birth_date') : '' }}" readonly/>
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
                                <input type="text" name="policy_start_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('policy_start_date') is-invalid @enderror  datetimepicker-input" data-target="#policy_start_date" placeholder="YYYY-MM-DD" value="{{ old('policy_start_date') ? old('policy_start_date') : '' }}" readonly/>
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
                                <input type="text" name="policy_end_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('policy_end_date') is-invalid @enderror  datetimepicker-input" data-target="#policy_end_date" placeholder="YYYY-MM-DD" value="{{ old('policy_end_date') ? old('policy_end_date') : '' }}" readonly/>
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
                        <label class="col-md-3 col-form-label text-md-end text-start">Company Name<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="company_name" class="form-control @error('company_name') is-invalid @enderror company_name" name="company_name" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Company Name --</option>
                                @foreach ($company_name as $data)
                                @if (old('company_name') == $data->id)
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
                        <input type="text" class="form-control @error('policy_number') is-invalid @enderror" id="policy_number" name="policy_number" value="{{ old('policy_number') }}" placeholder="Policy Number" autocomplete="off">
                            @if ($errors->has('policy_number'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_number') }}</span>
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
                        <label for="sum_assured" class="col-md-3 col-form-label text-md-end text-start">Sum Assured <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control @error('sum_assured') is-invalid @enderror" id="sum_assured" name="sum_assured" value="{{ old('sum_assured') }}" placeholder="Sum Assured" autocomplete="off">
                            @if ($errors->has('sum_assured'))
                                <span class="error invalid-feedback">{{ $errors->first('sum_assured') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="policy_name" class="col-md-3 col-form-label text-md-end text-start">Policy Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('policy_name') is-invalid @enderror" id="policy_name" name="policy_name" value="{{ old('policy_name') }}" placeholder="Policy Name" autocomplete="off">
                            @if ($errors->has('policy_name'))
                                <span class="error invalid-feedback">{{ $errors->first('policy_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Policy Mode<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="policy_mode" class="form-control @error('policy_mode') is-invalid @enderror policy_mode" name="policy_mode" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Policy Mode --</option>
                                @foreach ($policy_mode as $data)
                                @if (old('policy_mode') == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('policy_mode'))
                                    <span class="error invalid-feedback">{{ $errors->first('policy_mode') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="premium_amount" class="col-md-3 col-form-label text-md-end text-start">Premium Amount <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('premium_amount') is-invalid @enderror" id="premium_amount" name="premium_amount" value="{{ old('premium_amount') }}" placeholder="Premium Amount" autocomplete="off">
                            @if ($errors->has('premium_amount'))
                                <span class="error invalid-feedback">{{ $errors->first('premium_amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="yearly_premium_amount" class="col-md-3 col-form-label text-md-end text-start">Yearly Premium Amount <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('yearly_premium_amount') is-invalid @enderror" id="yearly_premium_amount" name="yearly_premium_amount" value="{{ old('yearly_premium_amount') }}" placeholder="Yearly Premium Amount" autocomplete="off" readonly>
                            @if ($errors->has('yearly_premium_amount'))
                                <span class="error invalid-feedback">{{ $errors->first('yearly_premium_amount') }}</span>
                            @endif
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
                        <label for="branch_name" class="col-md-3 col-form-label text-md-end text-start">Branch Name</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ old('branch_name') }}" placeholder="Branch Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="branch_address" class="col-md-3 col-form-label text-md-end text-start">Branch Address </label>
                        <div class="col-md-4">
                            <textarea class="form-control select2 select2-hidden-accessible state " name="branch_address" placeholder="Branch Address">{{ old('branch_address') ? old('branch_address') : '' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="branch_contact_number" class="col-md-3 col-form-label text-md-end text-start">Branch Contact Number</label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control" id="branch_contact_number" name="branch_contact_number" value="{{ old('branch_contact_number') }}" placeholder="Branch Contact Number" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="other_details" class="col-md-3 col-form-label text-md-end text-start">Other Details </label>
                        <div class="col-md-4">
                            <textarea class="form-control select2 select2-hidden-accessible state " name="other_details" placeholder="Other Details">{{ old('other_details') ? old('other_details') : '' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Add Mediclaim">
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
    // $(document).ready(function(){
$('#policy_number').change( function() {
    var policy_num = $(this).val();
    $.ajax({
        url: "{{route('fetchPolicyUser')}}",
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
                    $(".policy_holder_names").text(value.policy_holder_name);
                });
            }else{
            $(".error_class").remove();
            }
        }
    });
}); 
        
        
        $(document).on('change','#policy_mode',function(){
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
        var policy_mode =$("#policy_mode").val();
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
// })
</script>
@endsection
