@extends('layouts.default')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Add New Product
                </div>
                <div class="float-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="post">
                    @csrf

                    <div class="field item form-group row">
                        <label for="name" class="col-form-label col-md-3 col-sm-3  label-align">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="field item form-group row">
                        <label for="description" class="col-form-label col-md-3 col-sm-3  label-align">Description</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- <div class="field item form-group row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Product">
                    </div> -->
                    <div class="col-md-6 offset-md-3">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <!-- <button type="reset" class="btn btn-success">Reset</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection