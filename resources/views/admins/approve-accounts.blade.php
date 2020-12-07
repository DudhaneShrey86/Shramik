@extends('layouts.admins-master')
@section('title', 'Index Page')
@section('csslinks')
<link rel="stylesheet" href="/css/approve-accounts.css">
@endsection
@section('content')
<br>
<div class="container" id="parentcontainer" data-id="approve-accounts">
  <div class="row">
    <br>
    @if(session()->has('custommsg'))
    <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
    @endif
    <div>
      <div class="col s12">
        <p class="flow-text">Approve Provider Accounts</p>
        <div class="divider">

        </div>
        <br>
      </div>
      <ul class="col s12 collapsible z-depth-0 zeroborder">
      @forelse($providers as $provider)
      <li class="card col s12" data-id="{{ $provider->id }}">
        <div class="card-content row smallpadding">
          <div class="col s12 marginallbottom">
            <p class="flow-text">{{ $provider->business_name }} <span class="right">#{{ $provider->id }}</span></p>
            <b class="blue-grey-text">{{ $provider->name }}</b>
          </div>
          <div class="col s12 l6">
            <p class="paras">Applied On: <span>{{ $provider->created_at }}</span></p>
          </div>
          <div class="col s12 l6 rightonlarge">
            <p>
              <a href="#business_document_{{ $provider->id }}" class="links modal-trigger">Business Document Proof</a>
              <a href="#aadhar_card_{{ $provider->id }}" class="links modal-trigger">Aadhar Card</a>
            </p>
          </div>
          <div class="modal modal-fixed-footer" id="business_document_{{ $provider->id }}">
            <div class="modal-content">
              <embed src="{{ asset($provider->business_document) }}" type="application/pdf" width="100%" height="600px" />
            </div>
            <div class="modal-footer">
              <a class="modal-close btn">Close</a>
            </div>
          </div>
          <div class="modal modal-fixed-footer" id="aadhar_card_{{ $provider->id }}">
            <div class="modal-content">
              <embed src="{{ asset($provider->aadhar_card) }}" type="application/pdf" width="100%" height="600px" />
            </div>
            <div class="modal-footer">
              <a class="modal-close btn">Close</a>
            </div>
          </div>
        </div>
        <div class="card-action zeropadding relativediv">
          <p class="rightonlarge absolutebuttons">
            <button type="button" data-actiontype="2" class="actionbuttons btn waves-effect waves-light">Approve</button>
            <button type="button" data-actiontype="0" class="actionbuttons btn waves-effect waves-light red darken-1">Reject</button>
          </p>
          <div class="collapsible-header">
            <button type="button" class="btn blue">Details</button>
          </div>
        </div>
        <div class="collapsible-body">
          <div class="row">
            <div class="col s12">
              <div>
                <p class="flow-text">Provider Details</p>
                <div class="divider">

                </div>
                <br>
              </div>
              <div>
                <div class="col s12 marginallbottom">
                  <h6 class="blue-grey-text">{{ $provider->name }}</h6>
                </div>
                <div class="col s12 l8 marginallbottom">
                  <p class="blue-grey-text">Business Name: <span>{{ $provider->business_name }}</span></p>
                </div>
                @if($provider->email_verified_at != null)
                <div class="col s12 l4 marginallbottom">
                  <p class="rightonlarge"><i class="material-icons green-text">check_circle</i><span>Email Self Verified</span></p>
                </div>
                @endif
              </div>
              <div class="col s12">
                <br>
              </div>
              <div class="col s12 l6">
                <p><b class="blue-grey-text">Email:</b></p>
                <p class="blue-text">{{ $provider->email }}</p>
              </div>
              <div class="col s12 l6">
                <p><b class="blue-grey-text">Contact:</b></p>
                <p class="blue-text">{{ $provider->contact }}</p>
              </div>
              <div class="col s12">
                <p><b class="blue-grey-text">Address:</b></p>
                <p class="blue-text">
                  {!! nl2br($provider->address) !!}
                </p>
              </div>
              <div class="col s12">
                <br>
                <small class="grey-text text-darken-2">Applied on: {{ $provider->created_at }}</small>
              </div>
            </div>
          </div>
        </div>
      </li>
      @empty
      <p class="flow-text">No Providers Accounts to be approved at this moment</p>
      @endforelse
    </ul>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
<script src="/js/approve-accounts.js" charset="utf-8"></script>
@endsection
