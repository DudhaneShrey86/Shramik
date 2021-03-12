<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Consumer;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Str;

class Consumer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'address',
        'locality',
        'profile_pic',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
     protected $casts = [
         'email_verified_at' => 'datetime',
     ];

     protected $guard = 'consumer';

     public function tasks(){
       return $this->hasMany('App\Models\Task');
     }
     public function reviews(){
       return $this->hasMany('App\Models\Review');
     }

     public function run_factory(){
       $providers = Consumer::factory()->count(60)->state(new Sequence(
         ['locality' => 'Amrai'],
         ['locality' => 'Vijaynagar'],
         ['locality' => 'Chinchpada'],
         ['locality' => 'Tisgaon'],
         ['locality' => 'Manpada'],
         ['locality' => 'Khadakpada'],
         ['locality' => 'Godrej Hill'],
         ['locality' => 'Ambivili'],
         ['locality' => 'Kongaon'],
         ['locality' => 'Manere Gaon'],
         ['locality' => 'Nevali'],
         ['locality' => 'Shilphata'],
         ['locality' => 'Nevali'],
         ))->create();
     }
}
