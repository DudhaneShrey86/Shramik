<?php

$cdate = $task->created_at;
$cdate = date_create($cdate);
$cdate = date_format($cdate, "jS F Y - H:i:s a");

$date = $task->updated_at;
$date = date_create($date);
$date = date_format($date, "jS F Y - H:i:s a");

?>

@extends('layouts.providers-master')
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
            <div class="col s12">
              <br>
              <?php
              if($task->status == 0){
                ?>
                <p class="grey-text text-lighten-1">Task cancelled</p>
                <?php
              }
              else if($task->status == 1){
                ?>
                <p class="green-text text-darken-1">Working on the task...</p>
                <?php
              }
              else{
                ?>
                <p class="grey-text text-lighten-1">Task finished</p>
                <?php
              }
              ?>
            </div>
          </div>
          <div class="">
            <a href="{{ route('providers.index') }}" class="btn-flat blue-text waves-effect"><i class="material-icons left">chevron_left</i> Back</a>
          </div>
          <div class="modal" id="cancelmodal">
            <div class="modal-content center">
              <i class="large material-icons white red-text text-lighten-1 circle">info</i>
              <p class="flow-text">Are you sure you want to cancel the task?</p>
              <p>This action cannot be undone</p>
            </div>
            <div class="modal-footer">
              <button class="btn modal-close waves-effect waves-light white teal-text">Close</button>
              <form style="display: inline" action="{{ route('providers.task.update', $task->id) }}" method="post">
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
            <p><b>{{ $task->consumer()->first()->name }}</b></p>
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
@endsection
