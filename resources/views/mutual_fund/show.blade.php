@extends('layouts.default')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Mutual Fund Information
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
                        {{ $mutual_funds[0]->user->user_id }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>User Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->user->name }} {{ $mutual_funds[0]->user->middle_name }} {{ $mutual_funds[0]->user->surname }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="name" class="col-md-3 col-form-label text-md-end text-start"><strong>Sr No.:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->sr_no}}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-3 col-form-label text-md-end text-start"><strong>Mutual Fund Holder Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->mutual_fund_holder_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="added_by" class="col-md-3 col-form-label text-md-end text-start"><strong>Mutualfund Type:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                    {{ $mutual_funds[0]->mutual_fund_type->name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Folio Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->folio_number }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Fund name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->fund_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start"><strong>Fund Type:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->fund_type }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start"><strong>Purchase Date:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->purchase_date }}
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Amount:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->amount }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Yearly Amount:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->yearly_amount }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Nominee Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->nominee_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Nominee Relation:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->nominee_relation }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Nominee DOB:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->nominee_dob }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Name:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->agent_name }}
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="roles" class="col-md-3 col-form-label text-md-end text-start"><strong>Agent Mobile Number:</strong></label>
                    <div class="col-md-4" style="line-height: 35px;">
                        {{ $mutual_funds[0]->agent_mobile_number }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection