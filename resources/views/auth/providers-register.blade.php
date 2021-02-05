@extends('layouts.login-master-providers')
@section('title', "Provider's Login")
@section('sidenavoptions')
<li class=""><a class="waves-effect" href="{{ route('providers.login') }}">Login</a></li>
<li class="active"><a class="waves-effect" href="{{ route('providers.register') }}">Register</a></li>
@endsection
@section('topnavoptions')
<li class=""><a href="{{ route('providers.login') }}">Login</a></li>
<li class="active"><a href="{{ route('providers.register') }}">Register</a></li>
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
      <form class="row card-content" action="{{ route('providers.register.submit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <p>Registering as a provider, <a href="{{ route('consumers.register') }}" class="underlined">Change to User</a></p>
        <br>
        <p class="red-text col s12">{{$errors->first() ?? ''}}</p>
        <h6>Setup personal info</h6>
        <div class="input-field col s12">
          <input id="name" name="name" type="text" class="validate" >
          <label for="name">Enter Your Name</label>
          <span class="helper-text" data-error="Required*" data-success="">@error('name') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="business_name" name="business_name" type="text" class="validate" >
          <label for="business_name">Enter Business Name</label>
          <small>Enter the name of your business, shop, etc</small>
          <span class="helper-text" data-error="Required*" data-success="">@error('business_name') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <small>What type of service do you provide?</small>
          <select class="" name="type_id">
            <option value="" selected disabled>Select a service type</option>
            @forelse($types as $type)
            <option value="{{ $type->id }}">{{ ucwords($type->name) }}</option>
            @empty
            <option value="" selected disabled>No service types found!</option>
            @endforelse
          </select>
          <span class="helper-text" data-error="Required*" data-success="">@error('name') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="contact" name="contact" type="number" class="validate" >
          <label for="contact">Enter Your Contact Number</label>
          <small>This number will be used by users to contact you</small>
          <span class="helper-text" data-error="Required*" data-success="">@error('contact') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <textarea name="address" id="address" class="materialize-textarea validate" ></textarea>
          <label for="address">Enter your Business Address</label>
          <span class="helper-text" data-error="Required*" data-success="">@error('address') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="locality" name="locality" type="text" class="validate">
          <label for="locality">Enter Your Locality</label>
          <small>The locality of your business/shop. It can be changed later</small>
          <span class="helper-text" data-error="Required*" data-success="">@error('locality') {{$message}} @enderror</span>
        </div>
        <div class="fileinputs col s12">
          <input type="file" name="aadhar_card" id="aadhar_card" value="{{old('aadhar_card')}}" class="validate" >
          <label for="aadhar_card"><p>Aadhar Card</p></label>
          <small>Please upload pdf or image files only</small><br>
          <span class="helper-text red-text" data-error="Required field*">@error('aadhar_card'){{$message}}@enderror</span>
        </div>
        <div class="fileinputs col s12">
          <input type="file" name="business_document" id="business_document" value="{{old('business_document')}}" class="validate" >
          <label for="business_document"><p>Business Document Proof</p></label>
          <small>Please upload pdf or image files only</small><br>
          <span class="helper-text red-text" data-error="Required field*">@error('business_document'){{$message}}@enderror</span>
        </div>
        <div class="col s12">
          <br><br>
        </div>
        <h6>Setup login info</h6>
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
          <p>Already have an account? <a href="{{ route('providers.login') }}" class="underlined">Sign In</a></p>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script src="/js/providers-register.js" charset="utf-8"></script>
@endsection
