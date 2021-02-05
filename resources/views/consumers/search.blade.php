<?php

function getDistance($lat, $lon, $latitude, $longitude){
  $radius = 6371;
  $lon = deg2rad($lon);
  $longitude = deg2rad($longitude);
  $lat = deg2rad($lat);
  $latitude = deg2rad($latitude);
  //Haversine Formula
  $latDelta = $lat - $latitude;
  $lonDelta = $lon - $longitude;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latitude) * cos($lat) * pow(sin($lonDelta / 2), 2)));
  return number_format($angle * $radius, 2);
}
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
@section('title', 'Search Services')
@section('csslinks')
<link rel="stylesheet" href="/css/consumers-search.css">
@endsection
@section('content')
<br>
<div class="container" id="parentcontainer" data-id="search-services">
  @if(session()->has('custommsg'))
  <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
  @endif
  @php
  $consumer = Auth::guard('consumer')->user();
  @endphp
  <input type="hidden" id="localities" value="{{ $localities }}">
  <div id="flex-container">
    <div id="small-div">
      <div class="card">
        <div class="card-content" id="filterdiv">
          <p class="flow-text">Filters</p>
          <div class="divider">

          </div>
          <div class="customrow">
            <p>
              <label>
                <input type="checkbox" name="recent" id="recent" value="">
                <span>Show recently active providers only</span>
              </label>
            </p>
          </div>
          <br>
          <div class="customrow">
            <div class="input-field">
              <input type="text" name="locality_filter" id="locality_filter" value="{{ $locality ?? Auth::guard('consumer')->user()->locality }}">
              <label for="locality_filter" class="active">Locality</label>
            </div>
          </div>
          <div class="customrow">
            <p class="blue-grey-text small-text">Show results within distance (in Kms)</p>
            <p class="range-field">
              <input type="range" name="distance_range" id="distance_range" min="0" value="10" max="50">
            </p>
          </div>
          <div class="customrow">
            <p class="blue-grey-text small-text">No. of reviews gained</p>
            <p>
              <label>
                <input type="checkbox" name="no_of_reviews" value="0 to 10">
                <span>0 to 10</span>
              </label>
            </p>
            <p>
              <label>
                <input type="checkbox" name="no_of_reviews" value="10 to 100">
                <span>10 to 100</span>
              </label>
            </p>
            <p>
              <label>
                <input type="checkbox" name="no_of_reviews" value="100+">
                <span>100+</span>
              </label>
            </p>
          </div>
          <div class="center" id="buttondiv">
            <button type="button" class="btn amber darken-1">Apply</button>
          </div>
        </div>
      </div>
    </div>
    <div id="big-div">
      @if(isset($providers))
      <div id="search-provider-div">
        <div class="card" id="searchdiv">
          <div class="input-field col s12">
            <input type="text" name="search" id="search" value="" autocomplete="off" placeholder="Search A Provider">
          </div>
        </div>
        <div>
          <p class="flow-text" id="noresult">No Providers found!</p>
          <div class="card" id="results">
            @forelse($providers as $provider)
            @php
            $avg_rating = 0;
            $reviews = $provider->reviews()->get();
            $count = count($reviews);
            if($count != 0){
              $v = 0;
              foreach($reviews as $review){
                $v += $review->rating;
              }
              $avg_rating = $v / $count;
            }
            @endphp

            <a href="{{ route('consumers.hire.show', $provider->id) }}" class="itema">
              <div class="customitem">
                <div class="row">
                  <div class="col s9">
                    <h6 id="name">{{ $provider->name }}</h6>
                  </div>
                  <div class="col s3 right-align">
                    <p id="distance" class="margintop small-text grey-text"><i>{{ getDistance($provider->latitude, $provider->longitude, $latitude, $longitude) }} km</i></p>
                  </div>
                  <div class="col s12 l6">
                    <p class="blue-grey-text"><b>{{ $provider->business_name }}</b></p>
                  </div>
                  @if($provider->is_approved == 2)
                  <div class="col s12 l6 rightonlarge">
                    <p class="vertical-align"><span>Verified Account</span> <i class="material-icons green-text text-darken-1">check_circle</i></p>
                  </div>
                  @endif
                  <div class="col s12 smallmarginbottom">
                    <p class="vertical-align">
                      @if($count == 0)
                      <span>-</span>
                      <small>(No reviews yet)</small>
                      @else
                      <span>
                        <?php
                        for($i = 1; $i <= 5; $i++){
                          if($i <= $avg_rating){
                            ?>
                            <i class="material-icons amber-text">star</i>
                            <?php
                          }
                          else if(($i - $avg_rating) <= 0.5){
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
                      <small>({{ $count }})</small>
                      @endif
                    </p>
                  </div>
                  <div class="col s6">
                    <p class="small-text">Locality: {{ $provider->locality }}</p>
                  </div>
                  <div class="col s6">
                    @php
                    $t = time_elapsed_string($provider->last_seen);
                    @endphp
                    @if($t == "just now")
                    <p class="small-text green-text right vertical-align"><i class="material-icons tiny">fiber_manual_record</i> <span>Online</span></p>
                    @else
                    <p class="small-text grey-text right">Last Seen: {{ $t }}</p>
                    @endif
                  </div>
                </div>
              </div>
            </a>
            @empty
            <div class="card-content">
              <p class="flow-text">No Providers Found!</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>
      @else
      <div id="search-service-div">
        <div class="card">
          <div class="card-content center">
            <p class="flow-text">Search Providers for a Service</p>
            <div class="divider">

            </div>
            <div id="search-service-form">
              <form action="{{ route('consumers.show') }}" method="get">
                @csrf
                <select class="" name="type_id" id="type_id" required>
                  <option value="" disabled selected>Select A Service Type</option>
                  @forelse($types as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                  @empty
                  <option value="" disabled>No Services Found!</option>
                  @endforelse
                </select>
                <br>
                <div class="left-align">
                  @php
                  $location_found = 0;
                  $str = 'Use my current location';
                  $latitude = '';
                  $longitude = '';
                  if($consumer->latitude == null){
                    $location_found = 0;
                  }
                  else{
                    $latitude = $consumer->latitude;
                    $longitude = $consumer->longitude;
                    $str = 'Use my current location instead';
                    $location_found = 1;
                  }
                  @endphp
                  @if($location_found == 1)
                  <p class="blue-grey-text small-text smallmarginbottom">Using Saved Location</p>
                  @else
                  <p class="amber-text text-darken-1 small-text smallmarginbottom">No Saved Location found!</p>
                  <p class="marginbottom"><small>You can either use current location for now, set your location in your profile or search by locality</small></p>
                  @endif
                  <div class="">
                    <input type="hidden" name="latitude" id="latitude" value="{{ $latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $longitude }}">
                  </div>
                  <p class="">
                    <label>
                      <input type="checkbox" name="current_location" class="filled-in" id="current_location" value="">
                      <span>{{ $str }}</span>
                    </label>
                  </p>
                </div>
                <div class="">
                  <h5>OR</h5>
                </div>
                <div class="bigmargintop">
                  <div class="input-field">
                    <input type="text" name="locality" id="locality" required value="{{ $locality ?? Auth::guard('consumer')->user()->locality }}">
                    <label for="locality">Search by locality</label>
                  </div>
                  <div class="input-field">
                    <button type="submit" id="submitbutton" class="btn waves-effect blue">Search Providers</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
  <div id="see_filters_div" class="blue-grey lighten-5">
      <a href="#filter_modal" id="see_filters" class="modal-trigger">See Filters <i class="material-icons right">arrow_drop_up</i></a>
    </div>
    <div id="filter_modal" class="modal modal-fixed-footer bottom-sheet">
      <div class="modal-content">
        <p class="flow-text">Filters</p>
        <div class="divider">

        </div>
        <div class="customrow">
          <p>
            <label>
              <input type="checkbox" name="recent" id="recent" value="">
              <span>Show recently active providers only</span>
            </label>
          </p>
        </div>
        <br>
        <div class="customrow">
          <div class="input-field">
            <input type="text" name="locality_filter_mobile" id="locality_filter_mobile" value="{{ $locality ?? Auth::guard('consumer')->user()->locality }}">
            <label for="locality_filter_mobile" class="active">Locality</label>
          </div>
        </div>
        <div class="customrow">
          <p class="blue-grey-text small-text">Show results within distance (in Kms)</p>
          <p class="range-field">
            <input type="range" name="distance_range_mobile" id="distance_range_mobile" min="0" value="10" max="50">
          </p>
        </div>
        <div class="customrow">
          <p class="blue-grey-text small-text">No. of reviews gained</p>
          <p>
            <label>
              <input type="checkbox" name="no_of_reviews" value="0 to 10">
              <span>0 to 10</span>
            </label>
          </p>
          <p>
            <label>
              <input type="checkbox" name="no_of_reviews" value="10 to 100">
              <span>10 to 100</span>
            </label>
          </p>
          <p>
            <label>
              <input type="checkbox" name="no_of_reviews" value="100+">
              <span>100+</span>
            </label>
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="apply2" class="btn-small amber darken-1 waves-effect">Apply</button>
      </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
<script src="/js/consumers-search.js" charset="utf-8"></script>
@endsection
