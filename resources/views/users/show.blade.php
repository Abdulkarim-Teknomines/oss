@extends('layouts.default')

@section('content')
<hr>
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    User Information
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
            <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>User ID:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->user_id }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->name }} {{ $user->middle_name }} {{ $user->surname }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-3 col-form-label text-md-end text-start"><strong>Email Address:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->email }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-3 col-form-label text-md-end text-start"><strong>Added By:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{$user::getUserNameByID($user->parent_id) }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Pancard Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->pancard_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Mobile Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->mobile_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Emergency Contact Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->emergency_contact_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Birth Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $user->birth_date }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Roles:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        @forelse ($user->getRoleNames() as $role)
                            <span class="badge bg-primary">{{ $role }}</span>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection