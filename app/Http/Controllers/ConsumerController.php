<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Consumer;
use App\Models\Provider;
use App\Models\Type;
use App\Models\Task;
use App\Models\Review;
use App\Notifications;
use Illuminate\Database\QueryException;
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

      $filename1 = $consumer->id."_".$filename1;

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
    $avg_distance = request()->avg_distance;
    $deviation_distance = request()->deviation_distance;
    $avg_rating = request()->avg_rating;
    $deviation_rating = request()->deviation_rating;
    $recommended_provider = null;
    $peoples_choice_provider = null;
    $upcoming_provider = null;

    $localities = Provider::distinct('locality')->pluck('locality');
    if(!request()->has('type_id') || !request()->has('locality')){
      return redirect()->back()->with('custommsg', 'Some error occured...')->with('classes', 'amber darken-1');
    }
    $latitude = floatval(request()->latitude);
    $longitude = floatval(request()->longitude);
    $type_id = request()->type_id;
    $locality = request()->locality;
    if($latitude != '' && $longitude != ''){
      // $providers = Provider::where([
      //   ['type_id', '=', $type_id],
      //   ['is_approved', '<>', 0],
      // ])->whereNotNull('latitude')
      // ->orderBy('is_approved', 'DESC')
      // ->orderBy(DB::raw('ABS(latitude - '.$latitude.') + ABS(longitude - '.$longitude.')'), 'ASC')
      // ->orderBy('reviews_gained', 'DESC')
      // ->orderBy('last_seen', 'DESC')
      // ->orderBy('created_at', 'ASC')
      // ->get();
      $providers = Provider::where([
        ['type_id', '=', $type_id],
        ['is_approved', '<>', 0],
      ])->whereNotNull('latitude')
      ->orderBy(DB::raw('ABS(latitude - '.$latitude.') + ABS(longitude - '.$longitude.')'), 'ASC')
      ->orderBy('reviews_gained', 'DESC')
      ->get();

      // $recommended_provider = Provider::where(function($query) use ($avg_rating, $deviation_rating){
      //
      // })->get();
      if($avg_distance != 0){
        $recommended_provider = Provider::where('type_id', '=', $type_id)->where(DB::raw('ASIN(SQRT(POW(SIN(ABS(RADIANS(latitude) - RADIANS('.$latitude.')) / 2), 2) + (COS('.$latitude.') * COS(latitude) * POW(SIN(ABS(RADIANS(longitude) - RADIANS('.$longitude.'))/2), 2)))) * 6371 * 2'), '<', $avg_distance + $deviation_distance);
        if($avg_rating != 0){
          $recommended_rating = Review::select(DB::raw('AVG(rating) as avg_rating, provider_id'))->orderBy('avg_rating', 'desc')->groupBy('provider_id')->having('avg_rating', '>=', $avg_rating - $deviation_rating)->take(30)->get();
          $provider_ids = [];
          foreach ($recommended_rating as $r) {
            array_push($provider_ids, $r->provider_id);
          }
          $recommended_provider = $recommended_provider->whereIn('id', $provider_ids);
        }

        $recommended_provider = $recommended_provider->orderBy((DB::raw('ASIN(SQRT(POW(SIN(ABS(RADIANS(latitude) - RADIANS('.$latitude.')) / 2), 2) + (COS('.$latitude.') * COS(latitude) * POW(SIN(ABS(RADIANS(longitude) - RADIANS('.$longitude.'))/2), 2)))) * 6371 * 2')), 'asc')->take(1)->get();
      }

      // upcoming
      $today = date_create();
      $days_before = date_create();
      date_sub($days_before, date_interval_create_from_date_string("7 days"));
      $recommended_upcoming_task = Task::select(DB::raw('COUNT(*) as count_tasks, provider_id'))->orderBy('count_tasks', 'desc')->groupBy('provider_id')->whereBetween('created_at', [$days_before, $today]);
      $providers_type = Type::find($type_id)->providers;
      $providers_id_arr = [];
      foreach ($providers_type as $value) {
        array_push($providers_id_arr, $value->id);
      }
      $recommended_upcoming_task = $recommended_upcoming_task->whereIn('provider_id', $providers_id_arr)->take(1)->get();
      if(count($recommended_upcoming_task) > 0){
        $upcoming_provider = Provider::where('id', $recommended_upcoming_task[0]->provider_id)->first();
      }
    }
    else{
      // $providers = Provider::where([
      //   ['type_id', '=', $type_id],
      //   ['locality', '=', $locality],
      //   ['is_approved', '<>', 0],
      // ])
      // ->orderBy('is_approved', 'DESC')
      // ->orderBy('reviews_gained', 'DESC')
      // ->orderBy('last_seen', 'DESC')
      // ->orderBy('created_at', 'ASC')
      // ->get();
      $providers = Provider::where([
        ['type_id', '=', $type_id],
        ['locality', '=', $locality],
        ['is_approved', '<>', 0],
      ])
      ->orderBy('reviews_gained', 'DESC')
      ->get();
    }

    // dd(count($recommended_provider));
    return view('consumers.search', ['types' => $types, 'localities' => $localities, 'recommended_provider' => $recommended_provider, 'upcoming_provider' => $upcoming_provider, 'providers' => $providers, 'latitude' => $latitude, 'longitude' => $longitude]);
  }

  public function showHirePage(Provider $provider){
    return view('consumers.hire.show', ['provider' => $provider]);
  }

  //////////send notification//////////
  public function sendnotification($provider, $consumer, $task, $actiontype){
    if($actiontype == '1'){
      $consumer->notify(new Notifications\HiredProvider($provider, $consumer, $task));
      $provider->notify(new Notifications\HiredProvider($provider, $consumer, $task));
    }
    else if($actiontype == '0'){
      $consumer->notify(new Notifications\CancelledProvider($provider, $consumer, $task));
      $provider->notify(new Notifications\CancelledProvider($provider, $consumer, $task));
    }
    else if($actiontype == '2'){
      $consumer->notify(new Notifications\TaskCompletedProvider($provider, $consumer, $task));
      $provider->notify(new Notifications\TaskCompletedProvider($provider, $consumer, $task));
    }
    return true;
  }

  public function startTask(Provider $provider){
    $data = request()->validate([
      'title' => 'required',
      'description' => 'required',
    ]);
    $data['consumer_id'] = Auth::guard('consumer')->user()->id;
    $task = $provider->tasks()->create($data);
    $this->sendnotification($provider, Auth::guard('consumer')->user(), $task, '1');
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
    $provider = $task->provider;
    $this->sendnotification($provider, Auth::guard('consumer')->user(), $task, $data['status']);
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
