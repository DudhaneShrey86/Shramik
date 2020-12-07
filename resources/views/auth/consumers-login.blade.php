@extends('layouts.login-master-providers')
@section('title', "Consumer's Login")
@section('sidenavoptions')
<li class="active"><a class="waves-effect" href="{{ route('consumers.login') }}">Login</a></li>
<li class=""><a class="waves-effect" href="{{ route('consumers.register') }}">Register</a></li>
@endsection
@section('topnavoptions')
<li class="active"><a href="{{ route('consumers.login') }}">Login</a></li>
<li class=""><a href="{{ route('consumers.register') }}">Register</a></li>
@endsection
@section('content')

<div class="container">
  @if(session()->has('custommsg'))
  <p class="{{session()->get('classes')}} card col s12 m6 offset-m3 custommsgs">{{session()->get('custommsg')}}</p>
  @endif
  <div class="row" id="login-container">
    <br>
    <div class="card" id="login-form">
      <p class="flow-text">Welcome Back, User</p>
      <div class="divider">

      </div>
      <form class="row card-content" action="{{ route('consumers.login.submit') }}" method="post">
        @csrf
        <p>Logging in as User, <a href="{{ route('providers.login') }}" class="underlined">Change to Provider</a> </p>
        <br>
        <p class="red-text col s12">{{$errors->first() ?? ''}}</p>
        <div class="input-field col s12">
          <input id="email" name="email" type="email" required>
          <label for="email">Email</label>
          <span class="helper-text" data-error="The email must be a valid email address" data-success="">@error('email') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="password" name="password" type="password" required>
          <label for="password">Password</label>
          <span class="helper-text" data-error="The password field is required" data-success="">@error('password') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <p id="remember-container">
            <label for="remember">
              <input type="checkbox" class="filled-in" name="remember" id="remember" />
              <span>Remember Me</span>
            </label>
            <a href="#" class="underlined right">Forgot Password?</a>
          </p>
        </div>
        <div class="input-field col s12">
          <br>
          <button class="btn waves-effect waves-light blue btn-large col s12">Login</button>
        </div>
        <div class="col s12" id="other-action">
          <br>
          <div class="divider">

          </div>
          <br>
          <p>Don't have an account? <a href="{{ route('consumers.register') }}" class="underlined">Sign Up Instead</a></p>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('scripts')

@endsection
