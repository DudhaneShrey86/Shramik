@extends('layouts.consumers-master')
@section('title', 'Consumer Dashboard')
@section('csslinks')
<link rel="stylesheet" href="/css/providers-dashboard.css">
@endsection
@section('content')
<br>
<div class="container" id="parentcontainer" data-id="dashboard">
  @if(session()->has('custommsg'))
  <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
  @endif
  <div id="flex-container">
    <div id="big-div">
      <div class="card">
        <div class="card-content flex-card">
          <div class="text-div">
            <p class="card-title marginbottom">Hire A Service</p>
            <p>Find the best providers in your neighbourhood</p>
          </div>
          <div class="button-div">
            <a href="{{ route('consumers.search') }}" class="btn blue fullbuttons">Search</a>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <p class="card-title marginbottom">Recent Updates</p>
          <div class="divider">

          </div>
          @forelse($notifications as $notification)
          @php
          $data = $notification->data;
          $type = $data['type'];
          $task = Auth::guard('consumer')->user()->tasks()->find($data['task_id']);
          $provider = $task->provider()->find($data['provider_id']);
          @endphp
          <?php
          switch($type){
            case 'Cancelled Provider':
            ?>
            <div class="customcard">
              <h6>Task Cancelled</h6>
              <div class="content">
                <p>You cancelled the task - "<a href="{{ route('consumers.task.show', $task->id) }}" class="underlined">{{ $task->title }}</a>" for <b>{{ $provider->name }}</b> </p>
                <p>No worries! You will find the best provider for your task.</p>
                <a href="#" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            case 'Hired Provider':
            ?>
            <div class="customcard">
              <h6>Hired a Provider</h6>
              <div class="content">
                <p>You hired <b>{{ $provider->name }}</b> for the task "<a href="{{ route('consumers.task.show', $task->id) }}" class="underlined">{{ $task->title }}</a>"</p>
                <a href="{{ route('consumers.task.show', $task->id) }}" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            case 'Reviewed Provider':
            ?>
            <div class="customcard">
              <h6>Review Given</h6>
              <div class="content">
                <p>You submitted a review for <b>{{ $provider->name }}</b> for their performance on the task "<a href="{{ route('consumers.task.show', $task->id) }}" class="underlined">{{ $task->title }}</a>"</p>
                <div class="rating-div">
                  <p><b>Rating Given: <span>4.5/5</span></b></p>
                  <span class="rating-span">
                    <?php
                    for($i = 0;$i<5;$i++){
                      $value = "star";
                      ?>
                      <i class="material-icons">{{ $value }}</i>
                      <?php
                    }
                    ?>
                  </span>
                </div>
                <a href="{{ route('consumers.task.show', $task->id) }}" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            case 'Task Completed Provider':
            ?>
            <div class="customcard">
              <h6>Task Completed</h6>
              <div class="content">
                <p>The task "<a href="{{ route('consumers.task.show', $task->id) }}" class="underlined">{{ $task->title }}</a>" by <b>{{ $provider->name }}</b> was completed succesfully! </p>
                <p>Thank You for using our platform!</p>
                <a href="{{ route('consumers.task.show', $task->id) }}" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            default:
            ?>

            <?php
              break;
          }
          ?>
          @empty
          <div class="customcard center">
            <div id="empty-notification-div">
              <img src="{{asset('/images/empty.png')}}" alt="">
            </div>
            <h5>No Updates for now</h5>
            <p><i>Start hiring services online!</i></p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
    <div id="small-div">
      <div class="card">
        <div class="card-content">
          @php
          $reviews = "-";
          if($user->reviews_given != 0){
            $reviews = $user->reviews_given;
          }
          $tasks = $user->tasks()->get();
          $count = count($tasks);
          $task_text = "-";
          if($count != 0){
            $task_text = $count;
          }
          @endphp
          <h5>Welcome {{ explode(" ", Auth::user()->name)[0] }}</h5>
          <div class="divider">

          </div>
          <div class="customrow">
            <p>Tasks on Shramik</p>
            <b>{{ $task_text }}</b>
          </div>
          <div class="customrow">
            <p>Reviews Given</p>
            <b>{{ $reviews }}</b>
          </div>
          <div class="customrow">
            <p>Update Your Profile</p>
            <a href="{{ route('consumers.profile', Auth::user()->id) }}" class="btn btn-small fullbuttons margintop">Go To Profile</a>
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
