<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Consumer;
use App\Models\Provider;
use App\Models\Type;
use App\Models\Task;
use App\Models\Review;
use Illuminate\Support\Facades\DB;


class ConsumerController extends Controller
{
  public function __construct(){
    $this->middleware('auth:consumer');
    date_default_timezone_set("Asia/Kolkata");
  }

  public function index(){
    $user = Auth::guard('consumer')->user();
    $notifications = $user->notifications;
    return view('consumers.index', ['user' => $user, 'notifications' => $notifications]);
  }

  public function showProfile(Consumer $consumer){
    $tasks = $consumer->tasks()->get();
    $canedit = false;
    if(Auth::guard('consumer')->user()->id == $consumer->id){
      $canedit = true;
    }
    return view('consumers.profile', ['consumer' => $consumer, 'canedit' => $canedit, 'tasks' => $tasks]);
  }

  public function updateProfile(Consumer $consumer){
    if($consumer->id != Auth::guard('consumer')->user()->id){
      return redirect()->back()->with('custommsg', 'Some error occured!')->with('classes', 'red darken-1');
    }
    if(request()->has('profile_pic')){
      $data = request()->validate([
        'profile_pic' => 'required|mimes:jpeg,png'
      ]);
      $data['profile_pic'] = request()->profile_pic;
      $file1 = request()->file('profile_pic');
      $filename1 = $file1->getClientOriginalName();
      $ext1 = pathinfo($filename1, PATHINFO_EXTENSION);

      $filename1 = str_replace(basename($filename1, ".".$ext1), "profile_pic", $filename1);

      $filename1 = $provider->id."_".$filename1;

      $path = public_path().'/Documents/ConsumerProfilePic/';

      $file1->move($path,$filename1);
      $filepath1 = '/Documents/ConsumerProfilePic/'.$filename1;
      $data['profile_pic'] = $filepath1;

    }
    $consumer->update($data);
    $consumer->save();
    return redirect()->back()->with('custommsg', 'Changes Saved!')->with('classes', 'green darken-1');
  }

  public function searchServices(){
    $types = Type::all();
    $localities = Provider::distinct('locality')->pluck('locality');
    return view('consumers.search', ['types' => $types, 'localities' => $localities]);
  }
  public function showProviders(){
    $types = Type::all();
    $localities = Provider::distinct('locality')->pluck('locality');
    if(!request()->has('type_id') || !request()->has('locality')){
      return redirect()->back()->with('custommsg', 'Some error occured...')->with('classes', 'amber darken-1');
    }
    $latitude = floatval(request()->latitude);
    $longitude = floatval(request()->longitude);
    $type_id = request()->type_id;
    $locality = request()->locality;

    if($latitude != '' && $longitude != ''){
      $providers = Provider::where([
        ['type_id', '=', $type_id],
        ['is_approved', '<>', 0],
      ])
      ->orderBy('is_approved', 'DESC')
      ->orderBy(DB::raw('ABS(latitude - '.$latitude.') + ABS(longitude - '.$longitude.')'), 'ASC')
      ->orderBy('reviews_gained', 'DESC')
      ->orderBy('last_seen', 'DESC')
      ->orderBy('created_at', 'ASC')
      ->get();
    }
    else{
      $providers = Provider::where([
        ['type_id', '=', $type_id],
        ['locality', '=', $locality],
        ['is_approved', '<>', 0],
      ])
      ->orderBy('is_approved', 'DESC')
      ->orderBy('reviews_gained', 'DESC')
      ->orderBy('last_seen', 'DESC')
      ->orderBy('created_at', 'ASC')
      ->get();
    }
    return view('consumers.search', ['types' => $types, 'localities' => $localities, 'providers' => $providers, 'latitude' => $latitude, 'longitude' => $longitude]);
  }

  public function showHirePage(Provider $provider){
    return view('consumers.hire.show', ['provider' => $provider]);
  }
  public function startTask(Provider $provider){
    $data = request()->validate([
      'title' => 'required',
      'description' => 'required',
    ]);
    $data['consumer_id'] = Auth::guard('consumer')->user()->id;
    $task = $provider->tasks()->create($data);
    return redirect()->route('consumers.task.show', $task->id)->with('custommsg', 'Task Created!')->with('classes', 'green darken-1');
  }

  public function showTask(Task $task){
    return view('consumers.task.show', ['task' => $task]);
  }
  public function updateTask(Task $task){
    $data = request()->validate([
      'status' => 'required',
    ]);
    $task->update($data);
    $task->save();
    if($data['status'] == 0){
      return redirect()->route('consumers.index')->with('custommsg', 'Task Cancelled!')->with('classes', 'amber darken-1');
    }
    else if($data['status'] == 2){
      $data = request()->validate([
        "text" => "required",
        "rating" => "required",
      ]);
      $data['provider_id'] = $task->provider_id;
      $data['consumer_id'] = $task->consumer_id;
      $review = $task->review()->create($data);
      $provider = Provider::find($task->provider_id);
      $consumer = Consumer::find($task->consumer_id);
      $provider->reviews_gained += 1;
      $provider->save();
      $consumer->reviews_given += 1;
      $consumer->save();
      return redirect()->route('consumers.index')->with('custommsg', 'Task Completed!')->with('classes', 'green darken-1');
    }
  }
  public function showAllTasks(){
    $consumer = Auth::guard('consumer')->user();
    $tasks = $consumer->tasks()->get();
    return view('consumers.task.showall', ['tasks' => $tasks]);
  }
  public function setLocation(Consumer $consumer){
    $latitude = request()->latitude;
    $longitude = request()->longitude;
    $consumer->latitude = $latitude;
    $consumer->longitude = $longitude;
    $consumer->save();
    return redirect()->back()->with('custommsg', 'Location set successfully!')->with('classes', 'green darken-1');
  }
}
