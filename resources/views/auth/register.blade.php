@extends('layouts.app')

@section('content')

<div class="p-signup">

    <form method="POST" action="{{ route('register') }}" class="p-signup__form">
                        @csrf
    <h2 class="p-signup__form-heading">{{ __('messages.register.register') }}</h2>
    <div class="p-signup__form-content">
      <div class="row">
        <div class="form-group col-md-12">
          <label for="p-signup-first-name">{{ __('messages.register.full_name') }}</label>
          <!-- <input type="text" class="form-control" id="p-signup-first-name" placeholder="First Name"> -->
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="{{ __('messages.register.full_name') }}">

          @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>    
      <div class="row">
        <div class="form-group col-md-12">
          <label for="email">{{ __('messages.register.email_address') }}</label>
          
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@yourcompany.com">

          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
       <div class="row">
        <div class="form-group col-md-12">
          <label for="email">{{ __('messages.register.user_role') }}</label>
          
          <select name="user_role_id" class="form-control @error('user_role_id') is-invalid @enderror" id="user_role_id">
            <option value="">Please select</option>
            @if(!empty($roles))
            @foreach($roles as $k=> $v)
            <option value="{{isset($v->id)?$v->id:''}}">{{isset($v->title)?$v->title:''}}</option>
            @endforeach
            @endif
          </select>

          @error('user_role_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="password">{{ __('messages.register.password') }}</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password" value="{{ old('password') }}">

          @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <label for="password-confirm">{{ __('messages.register.confirm_password') }}</label>

          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password" value="{{ old('newpassword') }}">

          @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

      </div>
      <ul class="form-group p-signup__form-password-hints">
        <li>{{ __('messages.register.one_lowercase_character') }}</li>
        <li>{{ __('messages.register.one_number') }}</li>
        <li>{{ __('messages.register.one_uppercase_character') }}</li>
        <li>{{ __('messages.register.8_characters_minimum') }}</li>
      </ul>

      <div>
        <button type="submit" class="btn btn-info btn-block btn-lg p-signup__form-submit">{{ __('messages.register.register') }} </button>
      </div>

      <div class="p-signup__form-links">
       
        <div class="p-signup__form-link">
          {{__('messages.register.already_have_and_account')}} <a href="{{url('/')}}" class="link-info">{{ __('messages.register.signin') }}</a>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
