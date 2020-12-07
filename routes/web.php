<?php
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admins')->group(function(){

  Route::get('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admins.login');
  Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admins.login.submit');
  Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admins.index');
  Route::get('/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admins.logout');

  Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admins.index');

  Route::middleware('can:issuperadmin')->group(function(){
    Route::get('/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admins.create');
    Route::post('/create', [App\Http\Controllers\AdminController::class, 'store'])->name('admins.store');
    Route::get('/manage-users', [App\Http\Controllers\AdminController::class, 'manageUsers'])->name('admins.manage-users');
    Route::delete('/destroy/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admins.destroy');

    Route::get('/approve-accounts', [App\Http\Controllers\AdminController::class, 'showAccounts'])->name('admins.approve-accounts');
    Route::post('/approve-accounts', [App\Http\Controllers\AdminController::class, 'accountAction'])->name('admins.approve-an-account');
  });

  Route::middleware('can:isadmin')->group(function(){
    Route::get('/edit/{id}', [App\Http\Controllers\AdminController::class, 'edit'])->name('admins.edit');
    Route::post('/edit/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admins.update');

    Route::get('/manage-service-types', [App\Http\Controllers\AdminController::class, 'manageServiceTypes'])->name('admins.manage-service-types');
    Route::post('/manage-service-types', [App\Http\Controllers\AdminController::class, 'storeServiceType'])->name('admins.store-service-type');

  });

});


Route::prefix('/providers')->group(function(){
  Route::get('/login', [App\Http\Controllers\Auth\ProviderLoginController::class, 'showLoginForm'])->name('providers.login');
  Route::post('/login', [App\Http\Controllers\Auth\ProviderLoginController::class, 'login'])->name('providers.login.submit');
  Route::get('/', [App\Http\Controllers\ProviderController::class, 'index'])->name('providers.index');
  Route::get('/logout', [App\Http\Controllers\Auth\ProviderLoginController::class, 'logout'])->name('providers.logout');

  Route::get('/register', [App\Http\Controllers\Auth\ProviderLoginController::class, 'showRegistrationForm'])->name('providers.register');
  Route::post('/register', [App\Http\Controllers\Auth\ProviderLoginController::class, 'register'])->name('providers.register.submit');

  Route::get('/email/verify', [App\Http\Controllers\ProviderController::class, 'showVerifyEmail'])->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\ProviderController::class, 'verifyEmail'])->middleware(['auth:provider', 'signed'])->name('verification.verify');
  Route::post('/email/verification-notification', [App\Http\Controllers\ProviderController::class, 'sendEmail'])->name('verification.send');

  Route::get('/profile/{provider}', [App\Http\Controllers\ProviderController::class, 'showProfile'])->name('providers.profile');
});

Route::prefix('/consumers')->group(function(){
  Route::get('/login', [App\Http\Controllers\Auth\ConsumerLoginController::class, 'showLoginForm'])->name('consumers.login');
  Route::post('/login', [App\Http\Controllers\Auth\ConsumerLoginController::class, 'login'])->name('consumers.login.submit');
  Route::get('/', [App\Http\Controllers\ConsumerController::class, 'index'])->name('consumers.index');
  Route::get('/logout', [App\Http\Controllers\Auth\ConsumerLoginController::class, 'logout'])->name('consumers.logout');

  Route::get('/register', [App\Http\Controllers\Auth\ConsumerLoginController::class, 'showRegistrationForm'])->name('consumers.register');
  Route::post('/register', [App\Http\Controllers\Auth\ConsumerLoginController::class, 'register'])->name('consumers.register.submit');
});
