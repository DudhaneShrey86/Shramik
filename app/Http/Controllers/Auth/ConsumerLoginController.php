<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Consumer;
use Illuminate\Support\Facades\Hash;

class ConsumerLoginController extends Controller
{
  public function __construct(){
    $this->middleware('guest:consumer', ['except' => ['logout']]);
  }
  public function showLoginForm(){
    return view('auth.consumers-login');
  }
  public function login(){
    $data = request()->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);
    if(Auth::guard('consumer')->attempt(['email' => request()->email, 'password' => request()->password], request()->remember)){
      ///////changes here////////////
      return redirect()->intended(route('consumers.index'));
    }
    else{
      return redirect()->back()->withErrors(['Incorrect Email Or Password']);
    }
  }
  public function logout(){
    Auth::logout();
    request()->session()->flush();
    request()->session()->regenerate();
    return redirect()->route('consumers.index');
  }

  public function showRegistrationForm(){
    return view('auth.consumers-register');
  }

  public function register(){
    $data = request()->validate([
      'name' => 'required',
      'email' => 'required|regex:/(.*)@(.*)\.(.{2,})/i',
      'password' => 'required|confirmed|min:8',
      'contact' => 'digits:10',
      'address' => 'required',
    ]);
    $data['password'] = Hash::make($data['password']);
    $consumer = Consumer::create($data);
    // $member->generateToken();
    // $pid = $provider->id;

    return redirect()->route('consumers.login')->with('custommsg', 'Registration Successful')->with('classes', 'green darken-1');
  }

}
