@extends('layouts.admins-master')
@section('title', 'Index Page')

@section('content')
<br>
<div class="container" id="parentcontainer" data-id="manage-users">
  <div class="row">
    <br>
    @if(session()->has('custommsg'))
    <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
    @endif
    <div class="card col s12">
      <div class="row">
        <div class="col s12">
          <p class="flow-text">Manage Users <a href="{{ route('admins.create') }}" class="btn blue right"><i class="material-icons left">add</i> Add User</a></p>
          <div class="divider">

          </div>
          <table class="striped responsive-table">
            <thead>
              <tr>
                <th>Sr.no</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Designation</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->contact }}</td>
                <td>
                  @if($user->designation == '0')
                  Super Admin
                  @else
                  Admin
                  @endif
                </td>
                <td>
                  @can('issuperadmin')
                  <a href="{{ route('admins.edit', $user->id) }}" class="btn" title="Edit User"><i class="material-icons">edit</i></a>
                  <button class="deletebutton btn red darken-1 modal-trigger" data-target="confirmationmodal" data-deleteid="{{$user->id}}" title="Delete User"><i class="material-icons">delete</i></button>
                  @endcan
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="center flow-text" id="emptymsg">No Users Found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="modal" id="confirmationmodal">
            <div class="modal-content center">
              <i class="large material-icons white red-text circle">error</i>
              <p class="flow-text">Are you sure you want to delete the user? This action cannot be undone</p>
            </div>
            <div class="modal-footer">
              <button class="btn modal-close waves-effect waves-light">Cancel</button>
              <form style="display: inline" action="{{ route('admins.destroy', 'ok')}}" method="post">
                @csrf
                {{ method_field('DELETE')}}
                <input type="hidden" id="deleteid" name="deleteid" value="">
                <button class="red btn waves-effect waves-light">Delete</button>
                &nbsp;
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
@endsection
