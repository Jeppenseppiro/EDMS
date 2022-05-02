@extends('layouts.login')

@section('title', 'Login')

@section('content')
<div class="container">
  <div class="row justify-content-center align-middle">
    <div class="col-md-8">
      <div class="card">

        <h3 class="card-header info-color white-text text-center py-4">
          <strong>Electronic Document Management System</strong>
        </h3>
        <form class="text-center border border-light p-5" method="POST" action="{{ route('login') }}">
          @csrf
          
          <h1 class="h3 mb-4">Sign in</h1>

          <input type="email" id="email" placeholder="E-mail" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
          @if ($errors->has('email'))
            <div class="invalid-feedback mb-4">{{ $errors->first('email') }}</div>
          @endif

          <br>

          <input type="password" id="password" placeholder="Password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
          @if ($errors->has('password'))
            <div class="invalid-feedback mb-4">{{ $errors->first('password') }}</div>
          @endif
          
          <br>

          <div class="d-flex justify-content-around">
            {{-- <div>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                <label class="custom-control-label" for="defaultLoginFormRemember">Remember me</label>
              </div>
            </div> --}}
            <div>
              <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>
          </div>

          <button class="btn btn-success btn-block my-4" type="submit">{{ __('Login') }}</button>
          {{-- <p>Not a member?
            <a href="">Register</a>
          </p>

          <p>or sign in with:</p>
          <a href="#" class="mx-2" role="button"><i class="fab fa-facebook-f light-blue-text"></i></a>
          <a href="#" class="mx-2" role="button"><i class="fab fa-twitter light-blue-text"></i></a>
          <a href="#" class="mx-2" role="button"><i class="fab fa-linkedin-in light-blue-text"></i></a>
          <a href="#" class="mx-2" role="button"><i class="fab fa-github light-blue-text"></i></a> --}}
        </form>



        {{-- <h5 class="card-header info-color white-text text-center py-4">
          <strong>Sign in</strong>
        </h5>

        <div class="card-body px-lg-5 pt-0">
          <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="md-form">
              <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

              @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
              <label for="materialLoginFormEmail">E-mail</label>
            </div>

            <div class="md-form">
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

              @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
              <label for="materialLoginFormPassword">Password</label>
            </div>

            <div class="d-flex justify-content-around">
              <div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="materialLoginFormRemember">
                  <label class="form-check-label" for="materialLoginFormRemember">Remember me</label>
                </div>
              </div>
              <div>
                <a href="{{ route('password.request') }}">Forgot password?</a>
              </div>
            </div>

            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">{{ __('Login') }}</button>

            <p>Not a member?
              <a href="{{ route('register') }}">Register</a>
            </p>

          </form>
        </div> --}}

      </div>
    </div>
  </div>
</div>



{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
