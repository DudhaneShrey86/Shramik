@extends('layouts.login-master-providers')
@section('title', "Consumers's Login")
@section('sidenavoptions')
<li class=""><a class="waves-effect" href="{{ route('consumers.login') }}">Login</a></li>
<li class="active"><a class="waves-effect" href="{{ route('consumers.register') }}">Register</a></li>
@endsection
@section('topnavoptions')
<li class=""><a href="{{ route('consumers.login') }}">Login</a></li>
<li class="active"><a href="{{ route('consumers.register') }}">Register</a></li>
@endsection
@section('content')

<div class="container">
  <input type="hidden" id="localities" value="{{ $localities }}">
  <div class="row">
    <br>
    <div class="card col s12 l6 center offset-l3">
      <h5 class="marginbottom marginbigtop">Welcome to Shramik</h5>
      <h6 class="blue-grey-text">A platform to bring neighbouring services online</h6>
      <br>
      <div class="divider">

      </div>
      <form class="row card-content" action="{{ route('consumers.register.submit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <p>Registering as a User, <a href="{{ route('providers.register') }}" class="underlined">Change to Provider</a></p>
        <br>
        <p class="red-text col s12">{{$errors->first() ?? ''}}</p>
        <div class="input-field col s12">
          <input id="name" name="name" type="text" class="validate">
          <label for="name">Enter Your Name</label>
          <span class="helper-text" data-error="Required*" data-success="">@error('name') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="contact" name="contact" type="number" class="validate" >
          <label for="contact">Enter Your Contact Number</label>
          <span class="helper-text" data-error="Required*" data-success="">@error('contact') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <textarea name="address" id="address" class="materialize-textarea validate" ></textarea>
          <label for="address">Enter your address</label>
          <span class="helper-text" data-error="Required*" data-success="">@error('address') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="locality" name="locality" type="text" class="validate">
          <label for="locality">Enter Your Locality</label>
          <small>This will be used to find nearby services. It can be changed later</small>
          <span class="helper-text" data-error="Required*" data-success="">@error('locality') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="email" name="email" type="email" class="validate" >
          <label for="email">Enter Your Email ID</label>
          <small>A mail will be sent to your id to confirm your registration</small>
          <span class="helper-text" data-error="Valid email address *" data-success="">@error('email') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="password" name="password" type="password" class="validate" >
          <label for="password">Enter A Password</label>
          <small>Minimum 8 characters</small>
          <span class="helper-text" data-error="Required*" data-success="">@error('password') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="password_confirmation" name="password_confirmation" type="password" class="validate" >
          <label for="password_confirmation">Retype your Password</label>
          <span class="helper-text" data-error="Required*" data-success="">@error('password_confirmation') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12" id="center-input-field">
          <button class="btn waves-effect waves-light blue btn-large">Register</button>
        </div>
        <div class="col s12" id="other-action">
          <br>
          <div class="divider">

          </div>
          <br>
          <p>Already have an account? <a href="{{ route('consumers.login') }}" class="underlined">Sign In</a></p>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script src="/js/providers-register.js" charset="utf-8"></script>
@endsection
