@extends('layouts.default')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Add New User
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('members.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('members.store') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-3 col-form-label text-md-end text-start">Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Name" autocomplete="off">
                            @if ($errors->has('name'))
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="middle_name" class="col-md-3 col-form-label text-md-end text-start">Middle Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle Name" autocomplete="off">
                            @if ($errors->has('middle_name'))
                                <span class="error invalid-feedback">{{ $errors->first('middle_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="surname" class="col-md-3 col-form-label text-md-end text-start">Surname <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}" placeholder="Surname" autocomplete="off">
                            @if ($errors->has('surname'))
                                <span class="error invalid-feedback">{{ $errors->first('surname') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    
                    <div class="mb-3 row">
                        <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start">Mobile Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" autocomplete="off">
                            @if ($errors->has('mobile_number'))
                                <span class="error invalid-feedback">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start">Birth Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group birth_date" id="birth_date" data-target-input="nearest">
                                <input type="text" name="birth_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('birth_date') is-invalid @enderror  datetimepicker-input" data-target="#birth_date" placeholder="YYYY-MM-DD" readonly="true" value="{{ old('birth_date') ? old('birth_date') : '' }}" />
                                <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('birth_date'))
                                <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-md-3 col-form-label text-md-end text-start">Email Address <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="off">
                            @if ($errors->has('email'))
                                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label for="mother_name" class="col-md-3 col-form-label text-md-end text-start">Father Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('father_name') is-invalid @enderror" id="father_name" name="father_name" value="{{ old('father_name') }}" placeholder="Father Name" autocomplete="off">
                            @if ($errors->has('father_name'))
                                <span class="error invalid-feedback">{{ $errors->first('father_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mother_name" class="col-md-3 col-form-label text-md-end text-start">Mother Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="text" class="form-control @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" value="{{ old('mother_name') }}" placeholder="Mother Name" autocomplete="off">
                            @if ($errors->has('mother_name'))
                                <span class="error invalid-feedback">{{ $errors->first('mother_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="spouse_name" class="col-md-3 col-form-label text-md-end text-start">Spouse Name</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="spouse_name" name="spouse_name" value="{{ old('spouse_name') }}" placeholder="Spouse Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="spouse_dob" class="col-md-3 col-form-label text-md-end text-start">Spouse DOB </label>
                        <div class="col-md-4">
                            <div class="input-group spouse_dob" id="spouse_dob" data-target-input="nearest">
                                <input type="text" name="spouse_dob" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state datetimepicker-input" data-target="#spouse_dob" placeholder="YYYY-MM-DD" readonly="true" value="{{ old('spouse_dob') ? old('spouse_dob') : '' }}"/>
                                <div class="input-group-append" data-target="#spouse_dob" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="anniversary_date" class="col-md-3 col-form-label text-md-end text-start">Anniversary Date</label>
                        <div class="col-md-4">
                            <div class="input-group anniversary_date" id="anniversary_date" data-target-input="nearest">
                                <input type="text" name="anniversary_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state datetimepicker-input" data-target="#anniversary_date" placeholder="YYYY-MM-DD" readonly="true" value="{{ old('anniversary_date') ? old('anniversary_date') : '' }}"/>
                                <div class="input-group-append" data-target="#anniversary_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Country <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="country" class="form-control @error('country_id') is-invalid @enderror country_id" name="country_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="">-- Select Country --</option>
                                @foreach ($countries as $data)
                                @if (old('country_id') == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('country_id') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label text-md-end text-start">State <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="state" name="state_id" class="form-control select2 select2-hidden-accessible state_id @error('state_id') is-invalid @enderror state_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="">-- Select State --</option>
                            </select>
                            @if ($errors->has('state_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('state_id') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label text-md-end text-start">City <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="city" name="city_id" class="form-control select2 select2-hidden-accessible city_id @error('city_id') is-invalid @enderror city_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="">-- Select City --</option>
                            </select>
                            @if ($errors->has('city_id'))
                                    <span class="error invalid-feedback">{{ $errors->first('city_id') }}</span>
                                @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                    <label for="address" class="col-md-3 col-form-label text-md-end text-start">Address <span style="color:red">*</span></label>
                    <div class="col-md-4">
                        <textarea class="form-control select2 select2-hidden-accessible state @error('address') is-invalid @enderror " name="address" placeholder="Address">{{ old('address') ? old('address') : '' }}</textarea>
                        @if ($errors->has('address'))
                            <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start">Pan Card Number</label>
                        <div class="col-md-4">
                        <input type="text" class="form-control" id="pancard_number" name="pancard_number" value="{{ old('pancard_number') }}" placeholder="Pancard Number" autocomplete="off">
                            
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="adharcard_number" class="col-md-3 col-form-label text-md-end text-start">Adhar Card Number</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="adharcard_number" name="adharcard_number" value="{{ old('adharcard_number') }}" placeholder="Adharcard Number" autocomplete="off">
                                
                        </div>
                    </div>
                    <div class="row mb-3"><label for="child" class="col-md-3 col-form-label text-md-end text-start">Children</label><div class="col-md-3">
                        <button id="rowAdder" type="button" class="btn btn-dark">
                        <span class="bi bi-plus-square-dotted"></span> ADD</button>
                    </div>
                </div>
                    <div id="newinput"></div>
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Add Member">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#rowAdder").click(function () {
            newRowAdd ='<div id="row" class="row mb-3"> <label for="child_name" class="col-md-2 col-form-label text-md-end text-start">Child Name</label><div class="col-md-3"><input type="text" class="form-control m-input child_name" name="child_name[]"> </div><label for="child_dob" class="col-md-2 col-form-label text-md-end text-start">Child DOB</label><div class="col-md-3"><div class="input-group child_dob" id="child_dob" data-target-input="nearest"><input type="text" class="form-control select2 select2-hidden-accessible state datetimepicker-input" placeholder="YYYY-MM-DD" readonly="true" name="child_dob[]"/><div class="input-group-append" data-target="#child_dob" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div></div><div class="col-md-2"> <button class="btn btn-danger" id="DeleteRow" type="button"><i class="bi bi-trash"></i> Delete</button></div>';
            $('#newinput').append(newRowAdd);
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
    
        var country_id = "{{old('country_id')}}";
        var state_id = "{{old('state_id')}}";
        var city_id = "{{old('city_id')}}";
        $.ajax({
            url: "{{route('fetchState')}}",
            type: "POST",
            data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state').html('<option value="">-- Select State --</option>');
                    $.each(result.states, function (key, value) {
                        $("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#city').html('<option value="">-- Select City --</option>');
                    $("#state option[value='"+state_id+"']").prop('selected', true);
                }
            });
            $.ajax({
                url: "{{route('fetchCity')}}",
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city').html('<option value="">-- Select City --</option>');
                    $.each(res.cities, function (key, value) {
                        $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $("#city option[value='"+city_id+"']").prop('selected', true);
                }
            });
    });
</script> 
@endsection
