@extends('layouts.admins-master')
@section('title', 'Index Page')

@section('content')
<br>
<div class="container" id="parentcontainer" data-id="edit-user-{{ $user->id }}">
  <div class="row">
    <br>
    @if(session()->has('custommsg'))
    <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
    @endif
    <div class="col s12 card">
      <div class="row">
        <div class="col s12">
          <p class="flow-text">User Profile - {{ $user->name }} <button type="button" class="btn right" id="editbutton" data-status="start">Edit</button></p>
          <div class="divider">

          </div>
          <br>
        </div>
        <form class="col s12" id="editform" action="{{ route('admins.edit', $user->id) }}" method="post">
          @csrf
          <div class="col s12 l6 input-field">
            <input type="text" name="name" value="{{ $user->name }}" disabled class="validate inputs">
            <label for="name" class="active">Name</label>
            <span class="helper-text red-text text-darken-1">@error('name') {{$message}} @enderror</span>
          </div>
          <div class="col s12 l6 input-field">
            <input type="email" name="email" value="{{ $user->email }}" disabled class="validate inputs">
            <label for="email" class="active">Email ID</label>
            <span class="helper-text red-text text-darken-1">@error('email') {{$message}} @enderror</span>
          </div>
          <div class="col s12 l6 input-field">
            <input type="number" name="contact" value="{{ $user->contact }}" disabled class="validate inputs">
            <label for="contact" class="active">Contact Number</label>
            <span class="helper-text red-text text-darken-1">@error('contact') {{$message}} @enderror</span>
          </div>
          <div class="col s12 l6 input-field">
            <input type="text" value="@if($user->designation == '0') Super Admin @else Admin @endif" disabled>
            <label class="active">Designation</label>
            <span class="helper-text red-text text-darken-1"></span>
          </div>
          <div class="col s12 l6 input-field">
            <input type="password" name="password" placeholder="New Password" disabled class="validate inputs">
            <label for="password" class="active">Change Password</label>
            <small>Leave blank if no change</small>
            <span class="helper-text red-text text-darken-1">@error('password') {{$message}} @enderror</span>
          </div>
          <div class="col s12 input-field center">
            <button class="btn waves-effect waves-light inputs marginright" disabled>Update</button>
            <a href="{{ route('admins.manage-users') }}" class="btn-flat waves-effect inputs teal-text">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script src="/js/edit-profile.js" charset="utf-8"></script>
@endsection
