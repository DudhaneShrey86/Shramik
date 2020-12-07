@extends('layouts.login-master-admins')
@section('title', "Admin's Login")
@section('sidenavoptions')
<li class="active"><a class="waves-effect" href="#">Login</a></li>
@endsection
@section('topnavoptions')
<li class="active"><a href="#">Login</a></li>
@endsection
@section('content')

<div class="container">
  <div class="row">
    <br>
    <div class="card col s12 m6 offset-m3">
      <form class="row card-content" action="{{ route('admins.login.submit') }}" method="post">
        @csrf
        <p class="flow-text">Admin's Login</p>
        <br>
        <p class="red-text col s12">{{$errors->first() ?? ''}}</p>
        <div class="input-field col s12">
          <input id="email" name="email" type="email" class="validate" required>
          <label for="email">Email</label>
          <span class="helper-text" data-error="The email must be a valid email address" data-success="">@error('email') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input id="password" name="password" type="password" class="validate" required>
          <label for="password">Password</label>
          <span class="helper-text" data-error="The password field is required" data-success="">@error('password') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12 l6">
          <p>
            <label for="remember">
              <input type="checkbox" class="filled-in" name="remember" id="remember" />
              <span>Remember Me</span>
            </label>
          </p>
        </div>
        <div class="input-field col s12">
          <button class="btn waves-effect waves-light">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('scripts')

@endsection
