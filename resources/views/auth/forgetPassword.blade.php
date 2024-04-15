@extends('auth.layouts')
@section('content')
  <!-- /.login-logo -->
  <div class="login-box">
  <div class="login-logo">
    <p style="color:#007bff;"><b>One Stop Solution Data Management</b><p>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="{{ route('forget.password.post') }}" method="post">
      @csrf
        <div class="input-group mb-3">
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="off">
          
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @if ($errors->has('email'))
              <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
          @endif
        </div>
        <div class="row">
          <div class="col-12">
            </div>
          </div>
          <div class="float-left pt-1">
            <a href="{{route('login')}}" class="btn btn-primary btn-block">Login</a>
          </div>
           <div class="float-right">
                  <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                </div>
      </form>

      
    </div>
  </div>
</div>
  @endsection
