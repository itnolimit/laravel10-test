@extends('layouts.auth')

@section('content')

    <!-- LOGO -->
    <div class="py-4 text-center">
        <a href="{{ route('login') }}">
            <img src="{{ url('images/dto-logo.svg') }}" alt="DOTDriverFiles" class="img-fluid" style="height: 60px;">
        </a>
    </div>


    <div class="card">

        <div class="card-body px-2 px-md-4">

            <div class="text-center w-75 m-auto">
                <h2 class="text-dark-50 text-center pb-0 fw-bold">Reset Password</h2>
                <p class="text-muted mb-4">Enter your email address and we'll send you an email with instructions to reset your password.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"  name="email" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email" autofocus >
            @error('email')
            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
            @enderror
        </div>
        <div class="form-group mb-0 text-center">
            <button class="btn btn-dark btn-block" type="submit"><i class="mdi mdi-login"></i>{{ __('Send Password Reset Link') }} </button>
        </div>
    </form>

        </div>
    </div>

@endsection
