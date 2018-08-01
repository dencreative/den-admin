@extends('layouts.auth')

@section('content')
    <div class="login__block active" id="l-register">
        <div class="login__block__header palette-Blue bg">
            <i class="zmdi zmdi-account-circle"></i>
            Create an account

            <div class="actions actions--inverse login__block__actions">
                <div class="dropdown">
                    <i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('login') }}">Already have an account?</a>
                        <a class="dropdown-item" href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="login__block__body">
            <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                @csrf

                <div class="form-group form-group--float form-group--centered">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                    <label for="name">{{ __('Name') }}</label>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    <i class="form-group__bar"></i>
                </div>

                <div class="form-group form-group--float form-group--centered">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <i class="form-group__bar"></i>
                </div>

                <div class="form-group form-group--float form-group--centered">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    <label for="password">{{ __('Password') }}</label>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <i class="form-group__bar"></i>
                </div>

                <div class="form-group form-group--float form-group--centered">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <i class="form-group__bar"></i>
                </div>

                <button type="submit" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-check"></i></button>
            </form>
        </div>
    </div>
@endsection