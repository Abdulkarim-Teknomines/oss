@extends('layouts.default')
@section('content')
<hr>
<div class="py-5">
    <!-- <div class="container"> -->
        <div class="row justify-content-center">
            <div class="col-md-11">

                @if (session('success'))
                    <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
                @endif
                @if(session('error'))
                <h5 class="alert alert-danger mb-2">{{ session('error') }}</h5>
                @endif
                <!-- @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul> -->
                <!-- @endif -->

                <div class="card shadow">
                    <div class="card-header bg-primary">
                    <div class="float-left">
                    Change Password
                </div>
                <div class="float-right">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('update_password') }}" method="POST">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-md-2 col-form-label text-md-end text-start">Current Password <span style="color:red">*</span> </label>
                                <div class="col-md-6">
                                <input type="password" class="form-control @error('name') is-invalid @enderror" id="current_password" name="current_password" value="{{old('current_password') ? old('current_password') : ''}}">
                                    @if ($errors->has('current_password'))
                                        <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                
                                <label for="name" class="col-md-2 col-form-label text-md-end text-start">New Password <span style="color:red">*</span> </label>
                                
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('name') is-invalid @enderror" id="password" name="password" value="{{old('password') ? old('password') : ''}}">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-md-2 col-form-label text-md-end text-start">Confirm Password <span style="color:red">*</span> </label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation') ? old('password_confirmation') : ''}}">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 text-right">
                                <hr>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>

@endsection