@extends('layouts.default')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            @if (session('success'))
                <div class="float-left">
                    <h5 class="alert alert-success mb-2">{{ session('success') }}</h5>
                </div>
            @endif
            <div class="card-header">
                <div class="float-left pt-1">
                    Add Member Life Insurance
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('mutual_fund.update_mutual_fund', $mutual_fund->id) }}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="mutual_fund_id" id="mutual_fund_id" value="{{$mutual_fund->id}}">
                    <div class="row mb-3">
                        <label for="sr_no" class="col-md-3 col-form-label text-md-end text-start">Sr No <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control @error('sr_no') is-invalid @enderror" id="sr_no" name="sr_no" value="{{ old('sr_no',$mutual_fund->sr_no) }}" placeholder="Sr No." autocomplete="off">
                            @if ($errors->has('sr_no'))
                                <span class="error invalid-feedback">{{ $errors->first('sr_no') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mutual_fund_holder_name" class="col-md-3 col-form-label text-md-end text-start">Mutual Fund Holder Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('mutual_fund_holder_name') is-invalid @enderror" id="mutual_fund_holder_name" name="mutual_fund_holder_name" value="{{ old('mutual_fund_holder_name',$mutual_fund->mutual_fund_holder_name) }}" placeholder="Mutual Fund Holder Name" autocomplete="off">
                            @if ($errors->has('mutual_fund_holder_name'))
                                <span class="error invalid-feedback">{{ $errors->first('mutual_fund_holder_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Mutual Fund<span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="mutual_fund_type" class="form-control @error('mutual_fund_type') is-invalid @enderror mutual_fund_type" name="mutual_fund_type" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Mutual Fund --</option>
                                @foreach ($mutual_fund_type as $data)
                                @if (old('mutual_fund_type',$mutual_fund->mutual_fund_type_id) == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('mutual_fund_type'))
                                    <span class="error invalid-feedback">{{ $errors->first('mutual_fund_type') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="folio_number" class="col-md-3 col-form-label text-md-end text-start">Folio Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control @error('folio_number') is-invalid @enderror" id="folio_number" name="folio_number" value="{{ old('folio_number',$mutual_fund->folio_number) }}" placeholder="Folio Number" autocomplete="off">
                            @if ($errors->has('folio_number'))
                                <span class="error invalid-feedback">{{ $errors->first('folio_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fund_name" class="col-md-3 col-form-label text-md-end text-start">Fund Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('fund_name') is-invalid @enderror" id="fund_name" name="fund_name" value="{{ old('fund_name',$mutual_fund->fund_name) }}" placeholder="Fund Name" autocomplete="off">
                            @if ($errors->has('fund_name'))
                                <span class="error invalid-feedback">{{ $errors->first('fund_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fund_type" class="col-md-3 col-form-label text-md-end text-start">Fund Type <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('fund_type') is-invalid @enderror" id="fund_type" name="fund_type" value="{{ old('fund_type',$mutual_fund->fund_type) }}" placeholder="Fund Type" autocomplete="off">
                            @if ($errors->has('fund_type'))
                                <span class="error invalid-feedback">{{ $errors->first('fund_type') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="purchase_date" class="col-md-3 col-form-label text-md-end text-start">Purchase Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group purchase_date" id="purchase_date" data-target-input="nearest">
                                <input type="text" name="purchase_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('purchase_date') is-invalid @enderror  datetimepicker-input" data-target="#purchase_date" placeholder="YYYY-MM-DD" value="{{ old('purchase_date') ? old('purchase_date') : $mutual_fund->purchase_date }}"/>
                                <div class="input-group-append" data-target="#purchase_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('purchase_date'))
                                    <span class="error invalid-feedback">{{ $errors->first('purchase_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="amount" class="col-md-3 col-form-label text-md-end text-start">Amount <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount',$mutual_fund->amount) }}" placeholder="Amount" autocomplete="off">
                            @if ($errors->has('amount'))
                                <span class="error invalid-feedback">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="yearly_amount" class="col-md-3 col-form-label text-md-end text-start">Yearly Amount <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="number" min="0" class="form-control @error('yearly_amount') is-invalid @enderror" id="yearly_amount" name="yearly_amount" value="{{ old('yearly_amount',$mutual_fund->yearly_amount) }}" placeholder="Yearly Amount" autocomplete="off" readonly>
                            @if ($errors->has('yearly_amount'))
                                <span class="error invalid-feedback">{{ $errors->first('yearly_amount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nominee_name" class="col-md-3 col-form-label text-md-end text-start">Nominee Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('nominee_name') is-invalid @enderror" id="nominee_name" name="nominee_name" value="{{ old('nominee_name',$mutual_fund->nominee_name) }}" placeholder="Nominee Name" autocomplete="off">
                            @if ($errors->has('nominee_name'))
                                <span class="error invalid-feedback">{{ $errors->first('nominee_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nominee_relation" class="col-md-3 col-form-label text-md-end text-start">Nominee Relation <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('nominee_relation') is-invalid @enderror" id="nominee_relation" name="nominee_relation" value="{{ old('nominee_relation',$mutual_fund->nominee_relation) }}" placeholder="Nominee Relation" autocomplete="off">
                            @if ($errors->has('nominee_relation'))
                                <span class="error invalid-feedback">{{ $errors->first('nominee_relation') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nominee_dob" class="col-md-3 col-form-label text-md-end text-start">Nominee DOB <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group nominee_dob" id="nominee_dob" data-target-input="nearest">
                                <input type="text" name="nominee_dob" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('nominee_dob') is-invalid @enderror  datetimepicker-input" data-target="#nominee_dob" placeholder="YYYY-MM-DD" value="{{ old('nominee_dob') ? old('nominee_dob') : $mutual_fund->nominee_dob }}"/>
                                <div class="input-group-append" data-target="#nominee_dob" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($errors->has('nominee_dob'))
                                    <span class="error invalid-feedback">{{ $errors->first('nominee_dob') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agent_name" class="col-md-3 col-form-label text-md-end text-start">Agent Name</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="agent_name" name="agent_name" value="{{ old('agent_name',$mutual_fund->agent_name) }}" placeholder="Agent Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="agent_mobile_number" class="col-md-3 col-form-label text-md-end text-start">Agent Mobile Number</label>
                        <div class="col-md-4">
                        <input type="number" min="0" class="form-control" id="agent_mobile_number" name="agent_mobile_number" value="{{ old('agent_mobile_number',$mutual_fund->agent_mobile_number) }}" placeholder="Agent Mobile Number" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="other_details" class="col-md-3 col-form-label text-md-end text-start">Other Details </label>
                        <div class="col-md-4">
                            <textarea class="form-control select2 select2-hidden-accessible state " name="other_details" placeholder="Other Details">{{ old('other_details') ? old('other_details') : $mutual_fund->other_details }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Update Mutual Fund">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    // $(document).ready(function(){
        $(document).on('change','#mutual_fund_type',function(){
        var mutual_fund_type = $(this).val();
        var amount =$("#amount").val();
        if(mutual_fund_type=="1"){
            $("#yearly_amount").val((parseInt(amount)*1));
        }else if(mutual_fund_type=="2"){
            $("#yearly_amount").val((parseInt(amount)*12));
        }
    });
        
    $(document).on('change','#amount',function(){
        var amountt = $(this).val();
        var mutual_fund_type =$("#mutual_fund_type").val();
        if(mutual_fund_type=="1"){
            $("#yearly_amount").val((parseInt(amountt)*1));
        }else if(mutual_fund_type=="2"){
            $("#yearly_amount").val((parseInt(amountt)*12));
        }

    });
// })
</script>
@endsection
