<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Auth;
use App\Models\Provider;

class ProviderController extends Controller
{
  public function __construct(){
    $this->middleware('auth:provider');
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
    return back()->with('status', 'verification-link-sent');
  }

  public function showProfile(Provider $provider){
    return view('providers.profile', ['provider' => $provider]);
  }
}
