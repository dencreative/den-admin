@extends('layouts.auth')

@section('content')
    <div class="login__block active" id="l-login">
        <div class="login__block__header">
            <i class="zmdi zmdi-account-circle"></i>
            Hi there! Please Sign in

            <div class="actions actions--inverse login__block__actions">
                <div class="dropdown">
                    <i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('register') }}">Create an account</a>
                        <a class="dropdown-item" href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="login__block__body">
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
                <div class="form-group form-group--float form-group--centered">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <i class="form-group__bar"></i>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('login-email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group form-group--float form-group--centered">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    <label for="password">{{ __('Password') }}</label>
                    <i class="form-group__bar"></i>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-long-arrow-right"></i></button>
            </form>
        </div>
    </div>
    {{--

        <!-- Forgot Password -->
        <div class="login__block" id="l-forget-password">
            <div class="login__block__header palette-Purple bg">
                <i class="zmdi zmdi-account-circle"></i>
                Forgot Password?

                <div class="actions actions--inverse login__block__actions">
                    <div class="dropdown">
                        <i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-login" href="">Already have an account?</a>
                            <a class="dropdown-item" data-ma-action="login-switch" data-ma-target="#l-register" href="">Create an account</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login__block__body">
                <p class="mt-4">Lorem ipsum dolor fringilla enim feugiat commodo sed ac lacus.</p>

                <div class="form-group form-group--float form-group--centered">
                    <input type="text" class="form-control">
                    <label>Email Address</label>
                    <i class="form-group__bar"></i>
                </div>

                <button href="index.html" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-check"></i></button>
            </div>
        </div>
        --}}
@endsection