@extends('layouts.admins-master')
@section('title', 'Index Page')

@section('content')
<br>
<div class="container" id="parentcontainer" data-id="create-users">
  <div class="row">
    <form class="col s12 l6 offset-l3" action="{{route('admins.store')}}" method="post">
      @csrf
      <div class="row">
        <p class="flow-text">Creating A New User</p>
        <p>{{$custommsg ?? ''}}</p>
        <div class="input-field col s12">
          <input type="text" name="name" id="name" value="{{old('name')}}" class="validate" required>
          <label for="name">Name</label>
          <span class="helper-text red-text text-darken-1" data-error="Required*">@error('name') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input type="email" name="email" id="email" value="{{old('email')}}" class="validate" required>
          <label for="email">Email</label>
          <span class="helper-text red-text text-darken-1" data-error="Email address Required*">@error('email') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input type="password" name="password" id="password" value="{{old('password')}}" class="validate" required>
          <label for="password">Password</label>
          <span class="helper-text red-text text-darken-1" data-error="Required*">@error('password') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <input type="number" name="contact" min="0" id="contact" value="{{old('contact')}}" class="validate" required>
          <label for="contact">Contact Number</label>
          <span class="helper-text red-text text-darken-1" data-error="Valid contact number required*">@error('contact') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <select name="designation">
            <option value="" disabled selected>Select A Designation</option>
            <option value="0">Super Admin</option>
            <option value="1">Admin</option>
          </select>
          <span class="helper-text red-text text-darken-1" data-error="Required*">@error('designation') {{$message}} @enderror</span>
        </div>
        <div class="input-field col s12">
          <button class="btn waves-effect waves-light margin-right-button smallmarginright">Create User</button>
          <a href="{{ route('admins.manage-users') }}" class="btn-flat waves-effect white teal-text">Back</a>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
@endsection
