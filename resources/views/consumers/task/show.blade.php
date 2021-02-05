<?php

$cdate = $task->created_at;
$cdate = date_create($cdate);
$cdate = date_format($cdate, "jS F Y - H:i:s a");

$date = $task->updated_at;
$date = date_create($date);
$date = date_format($date, "jS F Y - H:i:s a");

?>

@extends('layouts.consumers-master')
@section('title', 'Task Details')
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
  <div id="flex-container">
    <div id="big-div">
      <div class="card">
        <div class="card-content">
          <p class="flow-text">{{ $task->title }}</p>
          <div class="divider">

          </div>
          <div class="row">
            <div class="col s12">
              <p class="blue-grey-text"><b>Task ID: #{{ $task->id }}</b> </p>
            </div>
            <div class="col s12">
              <p>Description</p>
              <p class="small-text">
                {!! nl2br($task->description) !!}
              </p>
            </div>
            <div class="col s12">
              <p class="blue-grey-text">Locality: <b>{{ $task->provider()->first()->locality }}</b></p>
            </div>
          </div>
          <div class="">
            <?php
            if($task->status == 0){
              ?>
              <p class="grey-text text-lighten-1">Task cancelled</p>
              <?php
            }
            else if($task->status == 1){
              ?>
              <button type="button" class="btn waves-effect green darken-1 smallmarginright" id="finishbutton">Finish Task</button>
              <button type="button" data-target="cancelmodal" class="btn waves-effect red darken-1 modal-trigger">Cancel Task</button>
              <?php
            }
            else{
              ?>
              <p class="grey-text text-lighten-1">Task finished</p>
              <?php
            }
            ?>
          </div>
          <div id="finishtaskdiv">
            <div class="divider">

            </div>
            <h6>Submit a review</h6>
            <br>
            <div class="row">
              <form action="{{ route('consumers.task.update', $task->id) }}" method="post">
                @csrf
                <input type="hidden" name="status" value="2">
                <div class="col s12">
                  <div class="input-field">
                    <textarea name="text" id="text" class="materialize-textarea"></textarea>
                    <label for="text">Leave a review about the provider</label>
                  </div>
                </div>
                <div class="col s12">
                  <small>Rate the provider's overall performance</small>
                  <input type="hidden" name="rating" id="rating" value="1">
                  <div class="">
                    <p id="ratingp" class="left">
                      <i class="material-icons ratingicons" id="5">star</i><i class="material-icons ratingicons" id="4">star</i><i class="material-icons ratingicons" id="3">star</i><i class="material-icons ratingicons" id="2">star</i><i class="material-icons ratingicons active" id="1">star</i>
                    </p>
                  </div>
                </div>
                <div class="col s12">
                  <div class="input-field">
                    <button type="submit" class="btn waves-effect blue smallmarginright">Submit Review</button>
                    <button type="reset" class="btn-flat waves-effect teal-text" id="cancelreviewbutton">Cancel</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal" id="cancelmodal">
            <div class="modal-content center">
              <i class="large material-icons white red-text text-lighten-1 circle">info</i>
              <p class="flow-text">Are you sure you want to cancel the task?</p>
              <p>This action cannot be undone</p>
            </div>
            <div class="modal-footer">
              <button class="btn modal-close waves-effect waves-light white teal-text">Close</button>
              <form style="display: inline" action="{{ route('consumers.task.update', $task->id) }}" method="post">
                @csrf
                <input type="hidden" name="status" value="0">
                <button type="submit" class="btn modal-close waves-effect waves-light red darken-1">Cancel the task</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="small-div">
      <div class="card">
        <div class="card-content">
          <p class="flow-text">Task Details</p>
          <div class="divider">

          </div>
          <div class="customrow">
            <p>Task By: </p>
            <p><b><a href="{{ route('consumers.profile', $task->consumer()->first()->id) }}" class="underlined">{{ $task->consumer()->first()->name }}</a> </b></p>
          </div>
          <div class="customrow">
            <p>Task Status: </p>
            @php
            $classes = "";
            $icon = "";
            $text = "";
            if($task->status == 2){
              $classes = "green-text";
              $icon = "done_all";
              $text = "Finished";
            }
            else if($task->status == 1){
              $classes = "amber-text";
              $icon = "update";
              $text = "In Progress";
            }
            else{
              $classes = "red-text";
              $icon = "close";
              $text = "Cancelled";
            }
            @endphp
            <p class="{{ $classes }} text-darken-1 vertical-align"><i class="material-icons">{{ $icon }}</i> <span>{{ $text }}</span></p>
          </div>
          <div class="customrow">
            <p>Started On: </p>
            <p class="blue-grey-text"><i>{{ $cdate }}</i></p>
          </div>
          <?php
          if($task->status == 0){
            ?>
            <div class="customrow">
              <p>Cancelled On: </p>
              <p class="blue-grey-text"><i>{{ $date }}</i></p>
            </div>
            <?php
          }
          else if($task->status == 2){
            ?>
            <div class="customrow">
              <p>Finished On: </p>
              <p class="blue-grey-text"><i>{{ $date }}</i></p>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="/js/confirmmodals.js" charset="utf-8"></script>
<script src="/js/task-show.js" charset="utf-8"></script>
@endsection
