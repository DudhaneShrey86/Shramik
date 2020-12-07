<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Consumer;
use App\Models\Provider;
use App\Models\Type;
use Auth;
use Gate;
use App\Notifications;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{

  public function __construct(){
    $this->middleware('auth:admin');
  }

  public function index(){
    if(Gate::allows('issuperadmin')){
      return redirect()->route('admins.manage-users');
    }
    else if(Gate::allows('isadmin')){
      return 'ok';
      // return redirect()->route('admins.products.manage');
    }
  }

  public function manageUsers(){
    if(Gate::allows('issuperadmin')){
      $users = Admin::where('id', '!=', Auth::user()->id)->get();
      return view('admins.manage-users', ['users' => $users]);
    }
    return redirect()->back()->with('custommsg', 'You are not authorized for this action!')->with('classes', 'red darken-1');
  }

  public function create(){
    return view('admins.create');
  }

  public function store(){
    $data = request()->validate([
      'name' => 'required',
      'email' => 'required|email|unique:admins,email',
      'password' => 'required',
      'contact' => 'digits:10|unique:admins,contact',
      'designation' => 'required'
    ]);
    $data['password'] = Hash::make($data['password']);
    Admin::create($data);
    return redirect()->route('admins.manage-users')->with('custommsg', 'User Created Succesfully!')->with('classes', 'green darken-1')->with('icon', 'done');
  }

  public function edit($id){
    $user = Admin::find($id);
    if(Auth::user()->designation != 0 && Auth::user()->id != $id){
      return redirect()->back()->with('custommsg', 'Some Error Occured!')->with('classes', 'red darken-1');
    }
    if($user != null){
      return view('admins.edit-user', ['user' => $user]);
    }
    else{
      return redirect()->back()->with('custommsg', 'Some Error Occured!')->with('classes', 'red darken-1');
    }
  }
  public function update($id){
    $data = request()->validate([
      'name' => 'required',
      'email' => 'required|email',
      'contact' => 'digits:10',
    ]);
    if(request()->password != ''){
      $data['password'] = Hash::make(request()->password);
    }
    try{
      Admin::where('id', $id)->update($data);
      return redirect()->route('admins.edit', $id)->with('custommsg', 'Details Updated!')->with('classes', 'green darken-1')->with('icon', 'done');
    }
    catch(QueryException $e){
      return redirect()->back()->with('custommsg', 'Either Email or Contact already taken!')->with('classes', 'red darken-1')->with('icon', 'clear');
    }
  }

  public function destroy($id){
    try{
      Admin::destroy(request()->deleteid);
      $message = "User Deleted Succesfully";
      $classes = "amber lighten-1";
      $icon = "done";
    }
    catch(QueryException $e){
      $message = "Some error occured";
      $classes = "red darken-1";
      $icon = "error";
    }
    return redirect()->route('admins.manage-users')->with('custommsg', $message)->with('classes', $classes)->with('icon', $icon);
  }

  public function manageServiceTypes(){
    $types = Type::all();
    return view('admins.manage-service-types', ['types' => $types]);
  }

  public function storeServiceType(){
    $data = request()->validate([
      "name" => "required|unique:types,name"
    ]);
    Type::create($data);
    return redirect()->route('admins.manage-service-types')->with('custommsg', 'Service Type Added!')->with('classes', 'green darken-1')->with('icon', 'done');
  }

  public function showAccounts(){
    $providers = Provider::where('is_approved', 1)->get();
    return view('admins.approve-accounts', ['providers' => $providers]);
  }

  //////////send notification//////////
  public function sendnotification($provider, $actiontype){
    if($actiontype == '0'){
      $provider->notify(new Notifications\RejectedApplication());
    }
    else if($actiontype == '2'){
      $provider->notify(new Notifications\AcceptedApplication());
    }
    return true;
  }

  public function accountAction(){
    $request_type = request()->actiontype;
    $provider = Provider::where('id', request()->id)->update([
      'is_approved' => $request_type,
    ]);
    $this->sendnotification(Provider::find(request()->id), $request_type);
    if($request_type == 2){
      return 'yes';
    }
    else{
      return 'no';
    }
  }

}
