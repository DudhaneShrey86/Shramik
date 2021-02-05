<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Auth;
use App\Models\Provider;
use App\Models\Task;

class ProviderController extends Controller
{
  public function __construct(){
    $this->middleware('auth:provider');
    date_default_timezone_set("Asia/Kolkata");
    $this->middleware('verified', ['except' => ['showVerifyEmail', 'verifyEmail', 'sendEmail']]);
  }

  public function index(){
    $user = Auth::guard('provider')->user();
    $notifications = $user->notifications;
    return view('providers.index', ['user' => $user, 'notifications' => $notifications]);
  }

  public function showVerifyEmail(){
    if(Auth::guard('provider')->user()->email_verified_at == null){
      return view('auth.verifyProvider');
    }
    else{
      return redirect()->route('providers.index');
    }
  }

  public function verifyEmail(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect()->route('providers.index');
  }

  public function sendEmail(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return redirect()->back()->with('status', 'verification-link-sent');
  }

  public function showProfile(Provider $provider){
    $tasks = $provider->tasks()->get();
    $canedit = false;
    if(Auth::guard('provider')->user()->id == $provider->id){
      $canedit = true;
    }
    return view('providers.profile', ['provider' => $provider, 'canedit' => $canedit, 'tasks' => $tasks]);
  }

  public function updateProfile(Provider $provider){
    if($provider->id != Auth::guard('provider')->user()->id){
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

      $path = public_path().'/Documents/ProviderProfilePic/';

      $file1->move($path,$filename1);
      $filepath1 = '/Documents/ProviderProfilePic/'.$filename1;
      $data['profile_pic'] = $filepath1;

    }
    if(request()->has('summary')){
      $data['summary'] = request()->summary;
    }
    $provider->update($data);
    $provider->save();
    return redirect()->back()->with('custommsg', 'Changes Saved!')->with('classes', 'green darken-1');
  }

  public function showTask(Task $task){
    return view('providers.task.show', ['task' => $task]);
  }
  public function updateTask(Task $task){
    $data = request()->validate([
      'status' => 'required',
    ]);
    $task->update($data);
    $task->save();
    if($data['status'] == 0){
      return redirect()->route('providers.index')->with('custommsg', 'Task Cancelled!')->with('classes', 'amber darken-1');
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
      return redirect()->route('providers.index')->with('custommsg', 'Task Completed!')->with('classes', 'green darken-1');
    }
  }
  public function showAllTasks(){
    $provider = Auth::guard('provider')->user();
    $tasks = $provider->tasks()->get();
    return view('providers.task.showall', ['tasks' => $tasks]);
  }
  public function setLocation(Provider $provider){
    $latitude = request()->latitude;
    $longitude = request()->longitude;
    $provider->latitude = $latitude;
    $provider->longitude = $longitude;
    $provider->save();
    return redirect()->back()->with('custommsg', 'Location set successfully!')->with('classes', 'green darken-1');
  }
}
