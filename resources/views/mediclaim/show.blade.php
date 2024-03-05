@extends('layouts.default')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Mediclaim Information
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
                        {{ $mediclaim[0]->user->user_id }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>User Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->user->name }} {{ $mediclaim[0]->user->middle_name }} {{ $mediclaim[0]->user->surname }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Sr No.:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->sr_no}}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Holder Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->policy_holder_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-3 col-form-label text-md-end text-start"><strong>Birth Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                    {{ $mediclaim[0]->birth_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Start Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->policy_start_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Company name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->company_name->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->policy_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Type:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->policy_type->name }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Sum Assured:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->sum_assured }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->policy_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Mode:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->policy_mode->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Premium Amount:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->premium_amount }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Yearly Premim Amount:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->yearly_premium_amount }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->agent_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Mobile Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->agent_mobile_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Branch Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->branch_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Branch Address:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->branch_address }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Branch Contact Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mediclaim[0]->branch_contact_number }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection