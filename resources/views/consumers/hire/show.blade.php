@extends('layouts.consumers-master')
@section('title', 'Hire Provider')
@section('csslinks')
<link rel="stylesheet" href="/css/consumers-show.css">
@endsection
@section('content')
<br>
<div class="container" id="parentcontainer" data-id="dashboard">
  @if(session()->has('custommsg'))
  <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
  @endif
  <div>
    <div class="card">
      <div class="card-content">
        <h5>Provider Details</h5>
        <div class="divider">

        </div>
        <div class="row">
          <div class="col s12">
            <h6>{{ $provider->name }}</h6>
          </div>
          <div class="col s12">
            <p class="blue-grey-text"><i>{{ $provider->business_name }} | <b>{{ $provider->type()->first()->name }}</b></i></p>
          </div>
          <div class="col s12">
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
            <p>Rating:</p>
            <p class="vertical-align">
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
              </span><small>({{ $count }})</small>
            </p>
          </div>
          <div class="col s12 l6">
            <p>Jobs Done</p>
            <p class="blue-grey-text"><b>{{ $provider->tasks()->count() }}</b></p>
          </div>
          <div class="col s12 l6">
            <p>Locality</p>
            <p class="blue-grey-text"><b>{{ $provider->locality }}</b></p>
          </div>
          <div class="col s12">
            <p>Joined On</p>
            <?php
            $date = $provider->created_at;
            $date = date_create($date);
            $date = date_format($date, "jS F Y");
            ?>
            <p class="blue-grey-text"><b>{{ $date }}</b></p>
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
            <p>Address:</p>
            <p class="blue-grey-text small-text">
              {!! nl2br($provider->address) !!}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content">
        <h5>Hire the Provider</h5>
        <div class="divider">

        </div>
        <div class="row">
          <div class="col s12 blue-grey-text small-text">
            <p>How does it work:</p>
            <ol class="nomargin">
              <li>Contact the provider and get the task arranged</li>
              <li>Click on the start task button below to start the task for the provider</li>
              <li>You will be redirected to the "tasks" page. There you can see the current status of the task</li>
              <li>Click on the "Finish task" button to end the task</li>
              <li>Leave a review about the provider's performance</li>
              <li>You can cancel the task at any point of time</li>
            </ol>
          </div>
          <div class="col s12" id="start-task-form">
            <form action="{{ route('consumers.hire.start', $provider->id) }}" method="post">
              @csrf
              <br>
              <h6>Start the Task</h6>
              <div class="input-field">
                <input type="text" id="title" name="title" required value="">
                <label for="title">Enter a title for the task</label>
              </div>
              <div class="input-field">
                <textarea name="description" id="description" required class="materialize-textarea"></textarea>
                <label for="description">Enter a short description</label>
              </div>
              <div class="input-field">
                <button type="submit" class="btn waves-effect blue">Start Task</button>
              </div>
            </form>
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
