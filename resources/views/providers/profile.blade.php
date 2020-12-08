<?php
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }
?>
@extends('layouts.providers-master')
@section('title', 'Provider Profile')
@section('csslinks')
<link rel="stylesheet" href="/css/providers-profile.css">
@endsection
@section('content')
<br>
<div class="container" id="parentcontainer" data-id="dashboard">
  @if(session()->has('custommsg'))
  <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
  @endif
  <div id="parentdiv">
    <div id="imagediv">
      <img src="{{ asset($provider->profile_pic) }}" alt="">
      @if($canedit)
      <form id="upload_pic_form" action="{{ route('providers.profile.submit', $provider->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        <label for="profile_pic" class="btn waves-effect blue"><i class="material-icons left">edit</i><span>Change Pic</span></label>
        <input type="file" name="profile_pic" id="profile_pic" value=""><br>
        <span class="helper-text" data-error="Required*" data-success="">@error('profile_pic') {{$message}} @enderror</span>
      </form>
      @endif
    </div>
    <div id="contentdiv" class="card">
      <div class="card-content">
        <div id="flex-container">
          <div id="big-div">
            <h6>Details</h6>
            <div class="divider">

            </div>
            <div class="">
              <div class="row">
                <div class="smallmarginbottom">
                  <p class="flow-text">{{ $provider->name }}
                    @if($canedit)
                    <button type="button" class="btn right btn-small active" id="editbutton"><i class="material-icons">edit</i></button>
                    @endif
                  </p>
                </div>
                <div class="smallmarginbottom">
                  <p class="blue-grey-text"><i>{{ $provider->business_name }}</i></p>
                </div>
                <div class="smallmarginbottom">
                  <p class="blue-grey-text"><b>{{ $provider->type()->first()->name }}</b></p>
                </div>
                <div>
                  <div class="col s12 l6">
                    <p>Rating:</p>
                    <p>
                      <i class="material-icons amber-text">star</i>
                      <i class="material-icons amber-text">star</i>
                      <i class="material-icons amber-text">star</i>
                      <i class="material-icons amber-text">star</i>
                      <i class="material-icons amber-text">star</i>
                    </p>
                  </div>
                  <div class="col s12 l6">
                    <p>Joined On</p>
                    <?php
                    $date = $provider->created_at;
                    $date = date_create($date);
                    $date = date_format($date, "jS F Y");
                    ?>
                    <p class="blue-grey-text"><b>{{ $date }}</b></p>
                  </div>
                </div>
                <div class="col s12">
                  <p>Address:</p>
                  <p class="blue-grey-text small-text">
                    {!! nl2br($provider->address) !!}
                  </p>
                </div>
                <div>
                  <div class="col s12 l6">
                    <p>Email ID</p>
                    <p class="blue-text"><b>{{ $provider->email }}</b></p>
                  </div>
                  <div class="col s12 l6">
                    <p>Contact</p>
                    <p class="blue-text"><b>{{ $provider->contact }}</b></p>
                  </div>
                </div>
                <div class="col s12">
                  <p>Summary</p>
                  <form action="{{ route('providers.profile.submit', $provider->id) }}" method="post">
                    @csrf
                    <textarea class="custominputs small-text" readonly id="summary" name="summary" placeholder="Enter a short summary about your business">{!! nl2br($provider->summary) !!}</textarea>
                    <div id="savediv">
                      <button type="submit" class="smallmarginright btn" id="savebutton">Save Changes</button>
                      <button type="reset" class="btn white teal-text" id="cancelbutton">Cancel</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div id="blank-div">

          </div>
          <div id="small-div">
            <h6>Stats</h6>
            <div class="divider">

            </div>
            <div>
              <div class="row">
                <div class="col s12">
                  <p class="vertical-align">
                    <span>Email Verified</span>
                    @if($provider->email_verified_at != null)
                    <i class="material-icons green-text right" title="verified">check_circle</i>
                    @else
                    <i class="material-icons red-text right" title="not verified">cancel</i>
                    @endif
                  </p>
                </div>
                <div class="col s12">
                  <p class="vertical-align">
                    <span>Account Verified</span>
                    <?php
                    $title = "";
                    $text = "";
                    $class = "";
                    if($provider->is_approved == 2){
                      $title = "verified";
                      $text = "check_circle";
                      $class = "green-text";
                    }
                    else if($provider->is_approved == 1){
                      $title = "pending approval";
                      $text = "update";
                      $class = "amber-text";
                    }
                    else{
                      $title = "rejected";
                      $text = "cancel";
                      $class = "red-text";
                    }
                    ?>
                    <i class="material-icons right {{ $class }}" title="{{ $title }}">{{ $text }}</i>
                  </p>
                </div>
                <div class="col s12">
                  <p>Reviews Gained</p>
                  @if($provider->reviews_gained == 0)
                  <p class="blue-grey-text"><b>-</b></p>
                  @else
                  <p class="blue-grey-text"><b>{{ $provider->reviews_gained }}</b></p>
                  @endif
                </div>
                <div class="col s12">
                  <p>Jobs Done</p>
                  <p class="blue-grey-text"><b>-</b></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card" id="reviews">
      <div class="card-content">
        <h5>Reviews <small class="right">0 reviews</small></h5>
        <div class="divider">

        </div>
        <div>
          <div class="customcard">
            <div class="row marginbottom">
              <div class="col s12 l6">
                <p><a href="#" class="underlined">Some Task</a></p>
              </div>
              <div class="col s12 l6 rightonlarge">
                <span>
                  <i class="material-icons amber-text">star</i>
                  <i class="material-icons amber-text">star</i>
                  <i class="material-icons amber-text">star</i>
                  <i class="material-icons amber-text">star</i>
                  <i class="material-icons amber-text">star</i>
                </span>
              </div>
              <div class="col s12">
                <p class="small-text">
                  <i>"Test was the best in the business!"</i>
                </p>
              </div>
              <div class="col s12">
                <p>- <a href="#" class="underlined">Some Person</a> </p>
              </div>
            </div>
            <p><small>{{ time_elapsed_string('2020-12-08 02:04:38') }}</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
<script src="/js/profile.js" charset="utf-8"></script>
@endsection
