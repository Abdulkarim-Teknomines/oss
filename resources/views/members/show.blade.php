@extends('layouts.default')

@section('content')
<hr>
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Member Information
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
                        {{ $user[0]->user_id }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->name }} {{ $user[0]->middle_name }} {{ $user[0]->surname }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Address:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->address }} {{ $user[0]->city->name }} {{ $user[0]->state->name }} {{ $user[0]->country->name }} 
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Mobile Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->mobile_number}}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-3 col-form-label text-md-end text-start"><strong>Pancard Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->pancard_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-3 col-form-label text-md-end text-start"><strong>Adharcard Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                    {{ $user[0]->adharcard_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Birth Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->birth_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Email ID:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->email }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Father Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->member->father_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Mother Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->member->mother_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Spouse Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->member->spouse_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Spouse DOB:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->member->spouse_dob }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Anniversary Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user[0]->member->anniversary_date }}
                    </div>
                </div>
                @if(!empty($user[0]->children))
                    <div class="mb-3 row">
                        <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Children:</strong></label>
                        <div class="col-md-4 "  style="line-height: 35px;">
                            {{ $user[0]->children->pluck('name')->implode(', ') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>    
@endsection