@extends('layouts.default')

@section('content')
<hr>
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Life Insurance Information
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>User ID:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->user->user_id }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>User Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->user->name }} {{ $life_insurance[0]->user->middle_name }} {{ $life_insurance[0]->user->surname }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Sr No.:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->sr_no}}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Holder Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->policy_holder_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-3 col-form-label text-md-end text-start"><strong>Birth Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                    {{ $life_insurance[0]->birth_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Start Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->policy_start_date }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Company Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->company_name->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->policy_number }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Sum Assured:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{$life_insurance[0]->sum_assured }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Plan Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->plan_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>PPT:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->ppt }} Year
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>PPT End Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->ppt_end_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Premium Mode:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->policy_mode->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Premium Amount:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->premium_amount }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Yearly Premium Amount:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->yearly_premium_amount }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Nominee Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->nominee_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Nominee Relation:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->nominee_relation }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Nominee DOB:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->nominee_dob }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->agent_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Mobile Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->agent_mobile_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Branch Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->branch_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Branch Address:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->branch_address }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Branch Contact Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $life_insurance[0]->branch_contact_no }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection