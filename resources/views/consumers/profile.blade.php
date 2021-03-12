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
@extends('layouts.consumers-master')
@section('title', 'Consumer Profile')
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
      <img src="{{ asset($consumer->profile_pic) }}" alt="">
      @if($canedit)
      <form id="upload_pic_form" action="{{ route('consumers.profile.submit', $consumer->id) }}" enctype="multipart/form-data" method="post">
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
                  <p class="flow-text">{{ $consumer->name }}</p>
                </div>
                <div class="smallmarginbottom">
                  <p>Joined On</p>
                  <?php
                  $date = $consumer->created_at;
                  $date = date_create($date);
                  $date = date_format($date, "jS F Y");
                  ?>
                  <p class="blue-grey-text"><b>{{ $date }}</b></p>
                </div>
                <div class="col s12">
                  <p>Address:</p>
                  <p class="blue-grey-text small-text">
                    {!! nl2br($consumer->address) !!}
                  </p>
                </div>
                <div>
                  <div class="col s12 l6">
                    <p>Email ID</p>
                    <p class="blue-text"><b>{{ $consumer->email }}</b></p>
                  </div>
                  <div class="col s12 l6">
                    <p>Contact</p>
                    <p class="blue-text"><b>{{ $consumer->contact }}</b></p>
                  </div>
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
                  <p>Reviews Given</p>
                  @php
                  $count = $consumer->reviews_given;
                  if($count == 0){
                    $count = "-";
                  }
                  @endphp
                  <p class="blue-grey-text"><b>{{ $count }}</b></p>
                </div>
                <div class="col s12">
                  <p>Tasks on Shramik</p>
                  @php
                  $count = count($tasks);
                  if($count == 0){
                    $count = "-";
                  }
                  @endphp
                  <p class="blue-grey-text"><b>{{ $count }}</b></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if($canedit)
    <div class="card" id="location">
      <div class="card-content">
        <h5>Set Your Location</h5>
        <div class="divider">

        </div>
        <div>
          <p>Your location will be used while searching for providers</p>
          <p class="blue-grey-text text-darken-1"><small>This location is only visible to you</small></p>
          <div id="locationmap" class="lightborder">
            <p class="flow-text">Space for maps</p>
          </div>
          <div>
            <p>Use the button below to set your location</p>
            <p class="marginbottom"><small id="erroroutput">Make sure to allow location access</small></p>
            <form id="form" action="{{ route('consumers.setlocation', $consumer->id) }}" method="post">
              @csrf
              <input type="hidden" name="latitude" id="latitude" value="">
              <input type="hidden" name="longitude" id="longitude" value="">
              @php
              $str = '';
              if($consumer->latitude == null){
                $str = 'Set Location';
              }
              else{
                $str = 'Update Location';
              }
              @endphp
              <p><button type="button" onclick="setLocation()" id="setlocation" class="btn blue">{{ $str }}</button></p>
            </form>
          </div>
        </div>
      </div>
    </div>
    @else

    @endif
    <div class="card" id="reviews">
      <div class="card-content">
        <h5>Reviews Given <small class="right">{{ $consumer->reviews_given }} reviews</small></h5>
        <div class="divider">

        </div>
        <div>
          @forelse($tasks as $task)
          @php
          $review = $task->review()->first();
          $provider = $task->provider()->first();
          @endphp
          <div class="customcard">
            <div class="row marginbottom">
              <div class="col s12 l6">
                <p><a href="{{ route('consumers.task.show', $task->id) }}" target="_blank" class="underlined">{{ $task->title }}</a></p>
              </div>
              @if($review != null)
              <div class="col s12 l6 rightonlarge">
                <span>
                  <?php
                  $rating = $review->rating;
                  $str = "";
                  for($i = 1; $i <= 5; $i++){
                    if($i <= $rating){
                      ?>
                      <i class="material-icons amber-text">star</i>
                      <?php
                    }
                    else if(($i - $rating) <= 0.5){
                      ?>
                      <i class="material-icons amber-text">star_half</i>
                      <?php
                    }
                    else{
                      ?>
                      <i class="material-icons amber-text">star_border</i>
                      <?php
                    }
                  }
                  ?>
                </span>
              </div>
              <div class="col s12">
                <p class="small-text">
                  <i>"{{ $review->text }}"</i>
                </p>
              </div>
              @endif
              <div class="col s12">
                <p>- <a href="#" class="underlined">{{ $provider->name }}</a> </p>
              </div>
            </div>
            <p><small>{{ time_elapsed_string($task->created_at) }}</small></p>
          </div>
          @empty
          <div class="customcard">
            <p class="flow-text">No Reviews Found!</p>
            <p class="grey-text"><i>Start using the platform to get some work done!</i></p>
          </div>
          @endforelse
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
