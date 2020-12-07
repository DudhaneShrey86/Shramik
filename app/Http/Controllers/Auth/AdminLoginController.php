<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
  public function __construct(){
    $this->middleware('guest:admin', ['except' => ['logout']]);
  }
  public function showLoginForm(){
    return view('auth.admins-login');
  }
  public function login(){
    $data = request()->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);
    if(Auth::guard('admin')->attempt(['email' => request()->email, 'password' => request()->password], request()->remember)){
      ///////changes here////////////
      return redirect()->intended(route('admins.index'));
    }
    else{
      return redirect()->back()->withErrors(['Incorrect Email Or Password']);
    }
  }
  public function logout(){
    Auth::logout();
    request()->session()->flush();
    request()->session()->regenerate();
    return redirect()->route('admins.index');
  }

}
