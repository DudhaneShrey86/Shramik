@extends('layouts.admins-master')
@section('title', 'Index Page')

@section('content')
<br>
<div class="container" id="parentcontainer" data-id="manage-service-types">
  <div class="row">
    <br>
    @if(session()->has('custommsg'))
    <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
    @endif
    <div class="card col s12">
      <div class="row">
        <div class="col s12">
          <p class="flow-text">Manage Service Types <button class="btn blue right modal-trigger" data-target="add-modal"><i class="material-icons left">add</i> Add</button></p>
          <div class="divider">

          </div>
          <table class="striped responsive-table">
            <thead>
              <tr>
                <th>Sr.no</th>
                <th>Name</th>
                <th>Total No of Providers</th>
              </tr>
            </thead>
            <tbody>
              @forelse($types as $type)
              @php
              $count = $type->providers()->count();
              @endphp
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $type->name }}</td>
                <td>{{ $count }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="center flow-text" id="emptymsg">No Service Types Found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="modal" id="add-modal">
            <div class="modal-content">
              <form action="{{ route('admins.store-service-type') }}" method="post">
                @csrf
                <div class="row">
                  <div class="col s12 l8 offset-l2">
                    <p class="flow-text">Add New Service Type</p>
                    <p>Service Type is the type where a provider belongs to</p>
                    <br>
                  </div>
                  <div class="col s12 l8 offset-l2">
                    <div class="input-field">
                      <input type="text" name="name" id="name" class="validate" required>
                      <label for="name">Enter A Type Name</label>
                      <span class="helper-text" data-error="Required*" data-success="">@error('name') {{$message}} @enderror</span>
                    </div>
                  </div>
                  <div class="col s12 l8 offset-l2">
                    <br>
                    <button class="btn waves-effect waves-light smallmarginright modal-close">Add</button>
                    <button type="button" class="btn white teal-text waves-effect modal-close">Cancel</button>
                  </div>
                </div>
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
