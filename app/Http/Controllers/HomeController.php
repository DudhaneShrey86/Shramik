<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {

  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index()
  {
    $types = Type::all();
    return view('homepage', ['types' => $types]);
  }
}
