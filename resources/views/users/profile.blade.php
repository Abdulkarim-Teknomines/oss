@extends('layouts.default')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left">
                    Update User Profile
                </div>
                <div class="float-right">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('update_profile') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-3 col-form-label text-md-end text-start">Name <span style="color:red">*</span> </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name') ? old('name') : $user->name}}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="middle_name" class="col-md-3 col-form-label text-md-end text-start">Middle Name <span style="color:red">*</span> </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{old('middle_name') ? old('middle_name') : $user->middle_name}}">
                            @if ($errors->has('middle_name'))
                                <span class="text-danger">{{ $errors->first('middle_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="surname" class="col-md-3 col-form-label text-md-end text-start">Surame <span style="color:red">*</span> </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{old('surname') ? old('surname') : $user->surname}}">
                            @if ($errors->has('surname'))
                                <span class="text-danger">{{ $errors->first('surname') }}</span>
                            @endif
                        </div>
                    </div>
                    @if(Auth::User()->hasRole('Member'))
                    <div class="mb-3 row">
                        <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start">Pancard Number </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('pancard_number') is-invalid @enderror" id="pancard_number" name="pancard_number" value="{{old('pancard_number') ? old('pancard_number') : $user->pancard_number}}">
                            @if ($errors->has('pancard_number'))
                                <span class="text-danger">{{ $errors->first('pancard_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="adharcard_number" class="col-md-3 col-form-label text-md-end text-start">Adharcard Number </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('adharcard_number') is-invalid @enderror" id="adharcard_number" name="adharcard_number" value="{{old('adharcard_number') ? old('adharcard_number') : $user->adharcard_number}}">
                            @if ($errors->has('adharcard_number'))
                                <span class="text-danger">{{ $errors->first('adharcard_number') }}</span>
                            @endif
                        </div>
                    </div>
                          <input type="hidden" id="mobile_number" name="mobile_number" value="{{$user->mobile_number}}">
                          <input type="hidden" id="emergency_contact_number" name="emergency_contact_number" value="{{$user->emergency_contact_number}}">
                    <div class="mb-3 row">
                        <label for="mother_name" class="col-md-3 col-form-label text-md-end text-start">Mother Name </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{old('mother_name') ? old('mother_name') : $user->member->mother_name}}">
                            @if ($errors->has('mother_name'))
                                <span class="text-danger">{{ $errors->first('mother_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="father_name" class="col-md-3 col-form-label text-md-end text-start">Father Name </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{old('father_name') ? old('father_name') : $user->member->father_name}}">
                            @if ($errors->has('father_name'))
                                <span class="text-danger">{{ $errors->first('father_name') }}</span>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="mb-3 row">
                        <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start">Pancard Number </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('pancard_number') is-invalid @enderror" id="pancard_number" name="pancard_number" value="{{old('pancard_number') ? old('pancard_number') : $user->pancard_number}}">
                            @if ($errors->has('pancard_number'))
                                <span class="text-danger">{{ $errors->first('pancard_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="adharcard_number" class="col-md-3 col-form-label text-md-end text-start">Adharcard Number </label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('adharcard_number') is-invalid @enderror" id="adharcard_number" name="adharcard_number" value="{{old('adharcard_number') ? old('adharcard_number') : $user->adharcard_number}}">
                          @if ($errors->has('adharcard_number'))
                                <span class="text-danger">{{ $errors->first('adharcard_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start">Mobile Number <span style="color:red">*</span></label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" value="{{old('mobile_number') ? old('mobile_number') : $user->mobile_number}}">
                          @if ($errors->has('mobile_number'))
                                <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start">Emergency Contact Number <span style="color:red">*</span></label>
                        <div class="col-md-5">
                          <input type="text" class="form-control @error('emergency_contact_number') is-invalid @enderror" id="emergency_contact_number" name="emergency_contact_number" value="{{old('emergency_contact_number') ? old('emergency_contact_number') : $user->emergency_contact_number}}">
                          @if ($errors->has('emergency_contact_number'))
                                <span class="text-danger">{{ $errors->first('emergency_contact_number') }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Update Profile">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>    
@endsection