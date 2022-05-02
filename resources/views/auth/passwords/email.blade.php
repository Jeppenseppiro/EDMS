@extends('layouts.login')

@section('title', 'Reset Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="card-header info-color white-text text-center py-4">
                    <strong>Electronic Document Management System</strong>
                </h3>
                {{-- <div class="card-body"> --}}
                    
                <form class="text-center border border-light p-5" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 class="h3 mb-4">Reset Password</h1>

                    <input type="email" id="email" placeholder="E-mail" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback mb-4">{{ $errors->first('email') }}</div>
                    @endif

                    <br>

                    <button type="submit" class="btn btn-warning btn-block my-4"> {{ __('Send Password Reset Link') }} </button>
                </form>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
