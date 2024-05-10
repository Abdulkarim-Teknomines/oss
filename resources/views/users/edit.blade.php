@extends('layouts.default')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card card-primary">
            <div class="card-header">
                <div class="float-left pt-1">
                    Edit User
                </div>
                <!-- <div class="float-right">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">&larr; Back</a>
                </div> -->
                <div class="float-right">
                    <a href="javascript:history.back()" class="btn btn-primary">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="mb-3 row">
                        <label for="name" class="col-md-3 col-form-label text-md-end text-start">Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}" placeholder="Name" autocomplete="off">
                            @if ($errors->has('name'))
                                <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="middle_name" class="col-md-3 col-form-label text-md-end text-start">Middle Name <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{old('middle_name', $user->middle_name)}}" placeholder="Middle Name" autocomplete="off">
                            @if ($errors->has('middle_name'))
                                <span class="error invalid-feedback">{{ $errors->first('middle_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="surname" class="col-md-3 col-form-label text-md-end text-start">Surname <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{old('surname', $user->surname)}}" placeholder="Surname" autocomplete="off">
                            @if ($errors->has('surname'))
                                <span class="error invalid-feedback">{{ $errors->first('surname') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    
                    <div class="mb-3 row">
                        <label for="mobile_number" class="col-md-3 col-form-label text-md-end text-start">Mobile Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number" name="mobile_number" value="{{old('mobile_number', $user->mobile_number)}}" placeholder="Mobile Number" autocomplete="off">
                            @if ($errors->has('mobile_number'))
                                <span class="error invalid-feedback">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="emergency_contact_number" class="col-md-3 col-form-label text-md-end text-start">Emergency Contact Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                        <input type="text" class="form-control @error('emergency_contact_number') is-invalid @enderror" id="emergency_contact_number" name="emergency_contact_number" value="{{old('emergency_contact_number', $user->emergency_contact_number)}}" placeholder="Emergency Contact Number" autocomplete="off">
                            @if ($errors->has('emergency_contact_number'))
                                <span class="error invalid-feedback">{{ $errors->first('emergency_contact_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pancard_number" class="col-md-3 col-form-label text-md-end text-start">Pan Card Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control @error('pancard_number') is-invalid @enderror" id="pancard_number" name="pancard_number" value="{{old('pancard_number', $user->pancard_number)}}" placeholder="Pancard Number" autocomplete="off">
                            @if ($errors->has('pancard_number'))
                                <span class="error invalid-feedback">{{ $errors->first('pancard_number') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="adharcard_number" class="col-md-3 col-form-label text-md-end text-start">Adhar Card Number <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control @error('adharcard_number') is-invalid @enderror" id="adharcard_number" name="adharcard_number" value="{{old('adharcard_number', $user->adharcard_number)}}" placeholder="Adharcard Number" autocomplete="off">
                                @if ($errors->has('adharcard_number'))
                                    <span class="error invalid-feedback">{{ $errors->first('adharcard_number') }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-3 col-form-label text-md-end text-start">Country <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="country" class="form-control @error('country_id') is-invalid @enderror country_id" name="country_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Country --</option>
                                @foreach ($countries as $data)
                                @if (old('country_id') == $data->id)
                                    <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                @elseif ($user->country_id == $data->id)
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
                            <select id="state" name="state_id" class="form-control select2 select2-hidden-accessible state_id @error('state_id') is-invalid @enderror state_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
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
                            <select id="city" name="city_id" class="form-control select2 select2-hidden-accessible city_id @error('city_id') is-invalid @enderror city_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
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
                        <textarea class="form-control select2 select2-hidden-accessible state @error('address') is-invalid @enderror " name="address" placeholder="Address">{{ old('address') ? old('address') : $user->address }}</textarea>
                        @if ($errors->has('address'))
                            <span class="error invalid-feedback">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    </div>
                    <!-- <div class="mb-3 row">
                        <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start">Birth Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group birth_date" id="reservationdates" data-target-input="nearest">
                                <input type="text" name="birth_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('birth_date') is-invalid @enderror  datetimepicker-input" data-target="#reservationdates" placeholder="YYYY-MM-DD" readonly="true" value="{{ old('birth_date') ? old('birth_date') : $user->birth_date }}"/>
                                <div class="input-group-append" data-target="#reservationdates" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('birth_date'))
                                <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                            @endif
                        </div>
                    </div> -->
                    <div class="mb-3 row">
                        <label for="birth_date" class="col-md-3 col-form-label text-md-end text-start">Birth Date <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group birth_date" id="birth_date" data-target-input="nearest">
                                <input type="text" name="birth_date" data-toggle="datetimepicker" class="form-control select2 select2-hidden-accessible state @error('birth_date') is-invalid @enderror  datetimepicker-input" data-target="#birth_date" placeholder="YYYY-MM-DD" readonly="true" value="{{ old('birth_date') ? old('birth_date') : $user->birth_date }}"/>
                                <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @if ($errors->has('birth_date'))
                                <span class="error invalid-feedback">{{ $errors->first('birth_date') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label text-md-end text-start">Blood Group <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <select id="blood_group" name="blood_group_id" class="form-control select2 select2-hidden-accessible state @error('blood_group_id') is-invalid @enderror blood_group_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Blood Group --</option>
                                @foreach ($blood_group as $data)
                                    @if (old('blood_group_id') == $data->id)
                                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                    @elseif ($user->blood_group_id == $data->id)
                                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                    @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                <!-- <option value="{{$data->id}}" {{ old('blood_group_id') ?? $data->id ? 'selected' : '' }}>
                                    {{$data->name}}
                                </option> -->
                                @endforeach
                            </select>
                            @if ($errors->has('blood_group_id'))
                                <span class="error invalid-feedback">{{ $errors->first('blood_group_id') }}</span>
                            @endif
                        </div>
                    </div>
                    @if(Auth::User()->hasRole('Super Admin'))
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label text-md-end text-start">Department </label>
                        <div class="col-md-4">
                            <select id="department" name="department_id" class="form-control select2 select2-hidden-accessible state @error('department_id') is-invalid @enderror department_id" style="width: 100%;" data-select2-id="1" aria-hidden="true">
                                <option value="">-- Select Department --</option>
                                @foreach ($departments as $data)
                                    @if (old('department_id') == $data->id)
                                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                    @elseif ($user->department_id == $data->id)
                                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                    @else
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            <!-- @if ($errors->has('department_id'))
                                <span class="error invalid-feedback">{{ $errors->first('department_id') }}</span>
                            @endif -->
                        </div>
                    </div>
                    @endif
                    <div class="mb-3 row">
                        <label for="email" class="col-md-3 col-form-label text-md-end text-start">Email Address <span style="color:red">*</span></label>
                        <div class="col-md-4">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $user->email)}}" placeholder="Email Address" autocomplete="off">
                            @if ($errors->has('email'))
                                <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                        <div class="col-md-6">
                          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                        <div class="col-md-6">
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div> -->
                    <div class="mb-3 row">
                        <label for="email" class="col-md-3 col-form-label text-md-end text-start">Active / Inactive <span style="color:red">*</span></label>
                        <div class="col-md-4">
                            <input type="checkbox" name="isActive" id="enable_disable" value="{{ $user->isActive=='0' ? '0' : '1' }}" {{$user->isActive == 0 ? 'checked':''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </div>
                        </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-2 offset-md-10 btn btn-primary" value="Update User">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>   
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script type="text/javascript">
    
    $(document).ready(function(){
        var country_id = "{{old('country_id')?old('country_id'):$user->country_id}}";
        var state_id = "{{old('state_id')?old('state_id'):$user->state_id}}";
        var city_id = "{{old('city_id')?old('city_id'):$user->city_id}}";
        $.ajax({
            url: "{{route('fetchState')}}",
            type: "POST",
            data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    // console.log(result.states);
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
<!-- <script>
    $('#reservationdates').datetimepicker({
        format: 'yyyy-MM-DD',
    });
    </script> -->