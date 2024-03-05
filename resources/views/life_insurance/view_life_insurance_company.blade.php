@extends('layouts.default')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Company Name
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('list_life_insurance_company') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
            <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Company Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                    
                        {{ $company[0]->name }}
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>    
@endsection