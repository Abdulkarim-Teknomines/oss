@extends('layouts.default')

@section('content')
<hr>
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Add Company
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('list_life_insurance_company') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('store_life_insurance_company') }}" method="post">
                    @csrf
                    
                    <div class="row mb-3">
                        <label for="company_name" class="col-md-3 col-form-label text-md-end text-start">Company_name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" autocomplete="off">
                            @if ($errors->has('company_name'))
                                <span class="error invalid-feedback">{{ $errors->first('company_name') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Add Company">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    

@endsection
