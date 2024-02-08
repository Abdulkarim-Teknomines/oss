@extends('auth.layouts')
@section('content')

<div class="login-box">
  <div class="login-logo">
    <p style="color:#007bff;"><b>One Stop Solution</b><p>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form  action="{{ route('authenticate') }}" method="post">
      @csrf
        <div class="input-group ">
            <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" autocomplete="off">
                
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        <div class="input-group mt-3">
          <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
        <div class="row">
          <div class="col-8 mt-3">
            <p class="mb-1">
              <a class="reset_pass" href="{{ route('forget.password.get') }}">Lost your password?</a>
            </p>
          </div>
          <!-- /.col -->
          <div class="col-4 mt-3">
            <input type="submit" class="btn btn-primary btn-block" value="Sign In">
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        
        <a class="reset_pass" href="{{ route('update_password') }}">Lost your password?</a>
      </p> -->
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

@endsection