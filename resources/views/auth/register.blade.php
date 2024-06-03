@extends('layouts.auth')

@section('content')

    <!-- LOGO -->
    <div class="py-4 text-center">
        <a href="{{ route('register') }}">
            <img src="{{ url('images/dto-logo.svg') }}" alt="DOTDriverFiles" class="img-fluid" style="height: 60px;">
        </a>
    </div>

    <div class="card">

        <div class="card-body px-2 px-md-4">

            <div class="text-center w-75 m-auto">
                <h2 class="text-dark-50 text-center pb-0 fw-bold">Create Account</h2>
                <p class="text-muted mb-4">No Contracts, No Setup Fees, No Credit Card Required </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                @if(!empty($invitation))
                    <p class="text-center">
                        <strong>{{ $invitation->company->name ?? '' }}</strong> has been invited to join them. Sign up and start using DOTDriverFiles
                    </p>
                @else
                    <div class="form-group">
                        <label for="email">{{ __('Company Name') }} </label>
                        <input class="form-control @error('company') is-invalid @enderror" type="text" id="company"  name="company" placeholder="Please provide your company name." value="{{ old('company') ?? request()->get('company') }}">
                        @error('company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                @endif

                <div class="form-group">
                    <label for="email">{{ __('Your Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"  name="name" placeholder="Please provide your full name." value="{{ old('name') }}" required autofocus >
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"  name="email" placeholder="Your email address will be used as your log in name." value="{{ $invitation->email ?? old('email') }}" required autocomplete="email" autofocus >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" class="form-control" type="password"  name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn btn-dark btn-block py-2" type="submit">{{ __('Launch DOTDriverFiles') }} </button>
                </div>
            </form>
        </div> <!-- end card-body -->
    </div>
    <!-- end card -->

    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-muted">Log in with an existing account <a href="{{ url('login') }}" class="text-muted ms-1"><b>Login In</b></a></p>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

@endsection
