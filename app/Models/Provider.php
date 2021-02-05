<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Str;

class Provider extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'business_name',
        'type_id',
        'email',
        'email_verified_at',
        'password',
        'contact',
        'address',
        'locality',
        'last_seen',
        'summary',
        'business_document',
        'profile_pic',
        'aadhar_card',
        'is_approved',
        'reviews_gained',
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

     protected $guard = 'provider';

     public function type(){
       return $this->belongsTo('App\Models\Type');
     }
     public function tasks(){
       return $this->hasMany('App\Models\Task');
     }
     public function reviews(){
       return $this->hasMany('App\Models\Review');
     }

     public function run_factory(){
       $providers = Provider::factory()->count(30)->state(new Sequence(
         ['locality' => 'Amrai'],
         ['locality' => 'Vijaynagar'],
         ['locality' => 'Chinchpada'],
         ['locality' => 'Tisgaon'],
         ))->create();
     }
}
