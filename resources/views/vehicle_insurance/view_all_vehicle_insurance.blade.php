@extends('layouts.default')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Vehicle Insurance Information
                </div>
                <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>User ID:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->user->user_id }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>User Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->user->name }} {{ $vehicle_insurance[0]->user->middle_name }} {{ $vehicle_insurance[0]->user->surname }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Sr No.:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->sr_no}}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-3 col-form-label text-md-end text-start"><strong>Vehicle Category:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->vehicle_category->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-3 col-form-label text-md-end text-start"><strong>Vehicle Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                    {{ $vehicle_insurance[0]->vehicle_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Chasis Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->chasis_number }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Insurance Company Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->company_name->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->policy_number }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Type:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{$vehicle_insurance[0]->insurance_policy_type->name }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Premium:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->policy_premium }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Vehicle Owner Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->vehicle_owner_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy Start Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->policy_start_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Policy End Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->policy_end_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->agent_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Mobile Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $vehicle_insurance[0]->agent_mobile_number }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection