<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Type;
use App\Models\Provider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class ProviderLoginController extends Controller
{
  public function __construct(){
    $this->middleware('guest:provider', ['except' => ['logout']]);
    date_default_timezone_set("Asia/Kolkata");
  }
  public function showLoginForm(){
    return view('auth.providers-login');
  }
  public function login(){
    $data = request()->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);
    if(Auth::guard('provider')->attempt(['email' => request()->email, 'password' => request()->password], request()->remember)){
      ///////changes here////////////
      return redirect()->intended(route('providers.index'));
    }
    else{
      return redirect()->back()->withErrors(['Incorrect Email Or Password']);
    }
  }
  public function logout(){
    Auth::logout();
    request()->session()->flush();
    request()->session()->regenerate();
    return redirect()->route('providers.index');
  }

  public function showRegistrationForm(){
    // $provider = new Provider();
    // $provider->test_models_can_be_persisted();
    $types = Type::all();
    $localities = Provider::distinct('locality')->pluck('locality');
    return view('auth.providers-register', ['types' => $types, 'localities' => $localities]);
  }

  public function register(){
    $data = request()->validate([
      'name' => 'required',
      'business_name' => 'required',
      'type_id' => 'required',
      'email' => 'required|regex:/(.*)@(.*)\.(.{2,})/i',
      'password' => 'required|confirmed|min:8',
      'contact' => 'digits:10',
      'address' => 'required',
      'locality' => 'required',
      'business_document' => 'required',
      'aadhar_card' => 'required',
    ]);
    $data['password'] = Hash::make($data['password']);
    $provider = Provider::create($data);
    event(new Registered($provider));
    // $member->generateToken();
    $pid = $provider->id;

    $file1 = request()->file('business_document');
    $file2 = request()->file('aadhar_card');

    $filename1 = $file1->getClientOriginalName();
    $filename2 = $file2->getClientOriginalName();

    $ext1 = pathinfo($filename1, PATHINFO_EXTENSION);
    $ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

    $filename1 = str_replace(basename($filename1, ".".$ext1), "business_document", $filename1);
    $filename2 = str_replace(basename($filename2, ".".$ext2), "aadhar_card", $filename2);

    $filename1 = $pid."_".$filename1;
    $filename2 = $pid."_".$filename2;

    $path = public_path().'/Documents/ProviderDocuments/';

    $file1->move($path,$filename1);
    $file2->move($path,$filename2);
    $filepath1 = '/Documents/ProviderDocuments/'.$filename1;
    $filepath2 = '/Documents/ProviderDocuments/'.$filename2;

    $data1['business_document'] = $filepath1;
    $data1['aadhar_card'] = $filepath2;
    Provider::where('id', $pid)->update($data1);

    return redirect()->route('providers.login')->with('custommsg', 'Registration Successful')->with('classes', 'green darken-1');
  }

}
