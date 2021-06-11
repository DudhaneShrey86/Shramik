
@extends('layouts.consumers-master')
@section('title', 'Tasks')
@section('csslinks')
<link rel="stylesheet" href="/css/consumers-show.css">
<link rel="stylesheet" href="/css/task-show.css">
@endsection
@section('content')
<br>
<div class="container" id="parentcontainer" data-id="task-show">
  @if(session()->has('custommsg'))
  <p class="{{session()->get('classes')}} card custommsgs"><span>{{ session()->get('custommsg') }}</span><i class="material-icons small">{{ session()->get('icon') }}</i></p>
  @endif
  <div class="row">
    <div class="col s12">
      <div class="card" style="min-height: 50vh;">
        <ul class="tabs">
          <li class="tab col s3"><a href="#active">Active Tasks</a> </li>
          <li class="tab col s3"><a href="#finished">Finished Tasks</a> </li>
          <li class="tab col s3"><a href="#cancelled">Cancelled Tasks</a> </li>
        </ul>
        <div class="divider nomargin">

        </div>
        <div class="card-content">
          @forelse($tasks as $task)
          @php
          $provider = $task->provider()->first();
          $consumer = $task->consumer()->first();
          $date = $task->created_at;
          $date = date_create($date);
          $date = date_format($date, "Y-m-d H:i:s A");
          @endphp
          <div class="customrow" data-status="{{ $task->status }}">
            <div class="customcard">
              <h6><a href="{{ route('consumers.task.show', $task->id) }}" class="underlined">{{ $task->title }}</a></h6>
              <p class="blue-grey-text"> <span>{{ $provider->name }}</span> </p>
              @if($task->status == 2)
              <div class="blue-grey-text margintop">
                <p>Review Given:</p>
                <p class="small-text">{{ $task->review()->first()->text ?? '' }}</p>
              </div>
              @else

              @endif
              <p class=""><small class="">Created On: {{$date}}</small> </p>
            </div>
          </div>
          @empty

          @endforelse
          <div class="" id="active">

          </div>
          <div class="" id="finished">

          </div>
          <div class="" id="cancelled">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
<script src="/js/showtasks.js" charset="utf-8"></script>
@endsection
