@extends('layouts.providers-master')
@section('title', 'Provider Dashboard')
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
      @if($user->is_approved == 1 || $user->is_approved == 0)
      <div class="card">
        <div class="card-content flex-card">
          <div class="text-div">
            <p class="card-title marginbottom">Update Business Proof Documents</p>
            <p>Upload a business proof and your aadhar card to get a verified account.<br> Only verified accounts are shown in our search lists</p>
          </div>
          <div class="button-div">
            @if($user->is_approved == 1)
            <button type="button" class="btn fullbuttons disabled">Waiting for approval</button>
            @else
            <a href="" class="btn fullbuttons">Go There</a>
            @endif
          </div>
        </div>
      </div>
      @endif
      @if($user->profile_pic == null)
      <div class="card">
        <div class="card-content flex-card">
          <div class="text-div">
            <p class="card-title marginbottom">Update Profile Picture</p>
            <p>Keeping a profile picture creates a sense of authenticity in the users</p>
          </div>
          <div class="button-div">
            <a href="{{ route('providers.profile', Auth::user()->id) }}" class="btn fullbuttons">Update Pic</a>
          </div>
        </div>
      </div>
      @endif
      <div class="card">
        <div class="card-content">
          <p class="card-title marginbottom">Recent Updates</p>
          <div class="divider">

          </div>
          @forelse($notifications as $notification)
          @php
          $data = $notification->data;
          $type = $data['type'];
          @endphp
          <?php
          switch($type){
            case 'Accepted Application':
            ?>
            <div class="customcard">
              <h6>Account Verified</h6>
              <div class="content">
                <p>Congratulations! Your account has been verified.</p>
                <p>Verified accounts often rank higher in search lists - <a href="#" class="underlined">know more here</a> </p>
              </div>
            </div>


            <?php
              break;
            case 'Rejected Application':
            ?>
            <div class="customcard">
              <h6>Account Rejected</h6>
              <div class="content">
                <p>Your account was rejected recently. This generally happens if the uploaded documents were invalid or improper</p>
                <p>You will not be shown in our search lists as long as your account remains rejected - <a href="#" class="underlined">know more here</a> </p>
                <p>Please re-submit valid documents</p>
                <a href="#" class="btn btn-small blue fullbuttons2 margintop">Go There</a>
              </div>
            </div>


            <?php
              break;
            case 'Cancelled Provider':
            ?>
            <div class="customcard">
              <h6>Task Cancelled</h6>
              <div class="content">
                <p>The task "<a href="#" class="underlined">Some Task</a>" by <a href="#" class="underlined">Some Person</a> was cancelled.</p>
                <p>Keep trying!</p>
                <a href="#" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            case 'Hired Provider':
            ?>
            <div class="customcard">
              <h6>Hired for a task</h6>
              <div class="content">
                <p>You were hired by <a href="#" class="underlined">Some Person</a> for the task "<a href="#" class="underlined">Some Task Name</a>"</p>
                <a href="#" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            case 'Reviewed Provider':
            ?>
            <div class="customcard">
              <h6>Review Gained</h6>
              <div class="content">
                <p><a href="#" class="underlined">Some Person</a> provided their review on your performance for the task "<a href="#" class="underlined">Some Task</a>"</p>
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
                <a href="#" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
              </div>
            </div>


            <?php
              break;
            case 'Task Completed Provider':
            ?>
            <div class="customcard">
              <h6>Task Completed</h6>
              <div class="content">
                <p>Congratulations! You succesfully completed the task "<a href="#" class="underlined">Some Task</a>" for <a href="#" class="underlined">Some Person</a></p>
                <p>Keep up the good work!</p>
                <a href="#" class="btn btn-small blue fullbuttons2 margintop">Go To Task</a>
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
            <p><i>Start doing stuff - complete your profile, read the guidelines or provide services!</i></p>
          </div>
          @endforelse

        </div>
      </div>
    </div>
    <div id="small-div">
      <div class="card">
        <div class="card-content">
          <h5>Welcome {{ explode(" ", Auth::user()->name)[0] }}</h5>
          <div class="divider">

          </div>
          <div class="customrow">
            <p>Your Provider Rating</p>
            <b>-</b>
          </div>
          <div class="customrow">
            <p>Tasks completed</p>
            <b>-</b>
          </div>
          <div class="customrow">
            <p>Update Your Profile</p>
            <a href="{{ route('providers.profile', Auth::user()->id) }}" class="btn btn-small fullbuttons margintop">Go To Profile</a>
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
