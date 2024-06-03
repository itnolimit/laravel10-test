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
                <h2 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h2>
                <p class="text-muted mb-4">Welcome! Please log in so we can get started. </p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if(!empty($invitation))
                    <p class="text-center">
                        {{ $invitation->company->name ?? '' }} has been invited to join them.
                        Sign up and start using DOTDriverFiels
                    </p>
                @endif
                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"  name="email" placeholder="Enter your email" value="{{ $invitation->email ?? old('email') }}" required autocomplete="email" autofocus >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted float-right"><small> {{ __('Forgot Your Password?') }}</small></a>
                    @endif

                    <label for="password">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember"> {{ __('Remember Me') }}</label>
                    </div>
                </div>
                <div class="form-group mb-0 text-center">
                    <button class="btn btn-dark btn-block py-2" type="submit">{{ __('Login') }} </button>
                </div>
            </form>
        </div> <!-- end card-body -->
    </div>
    <!-- end card -->

    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-muted">Don't have an account? <a href="{{ url('register') }}" class="text-muted ms-1"><b>Sign Up</b></a></p>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

@endsection
