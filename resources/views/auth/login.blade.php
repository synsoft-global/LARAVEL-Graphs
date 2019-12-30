@extends('layouts.app')

@section('content')
<div class="page-loading" id="page_loading" style="display: none;">
  <div class="p-signin">
    <form method="POST" action="{{ route('login') }}" class="p-signin__form" id="login_form">
      {{ csrf_field() }}
      <h2 class="p-signin__form-heading">{{ __('messages.login.login') }} </h2>
      <div class="p-signin__form-content">
        <div class="row">
          <div class="form-group col-md-12">
            <label for="p-signin-work-email">{{ __('messages.login.email_address') }}</label>
            
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="{{ __('messages.login.email_address') }}">

            @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>


        <div class="row">
          <div class="form-group col-md-12">
            <label for="p-signin-set-password">{{ __('messages.login.password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('messages.login.password') }}" autocomplete="current-password">
            @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
       <!--  <div class="row">
          <div class="form-group col-md-12">
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                  <label class="form-check-label" for="remember">
                      {{ __('Remember Me') }}
                  </label>
              </div>
          </div>
        </div> -->
        <div>      
          <button type="submit" class="btn btn-info btn-block  p-signin__form-submit">
              {{ __('messages.login.login') }}
          </button>

        </div>
        <div class="p-signin__form-links">
          <div class="p-signin__form-link">
              @if (Route::has('password.request'))
              <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('messages.login.forgot_your_password') }}
              </a>
              @endif
          </div>
          <!-- <div class="p-signin__form-link">
            Don't have an account? <a href="{{url('register')}}" class="link-info">{{ __('Register') }}</a>
          </div> -->
        </div>
      </div>
    </form>
  </div>
</div>
@endsection


