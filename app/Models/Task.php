<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'provider_id',
        'consumer_id',
        'title',
        'description',
        'status',
    ];


    public function consumer(){
      return $this->belongsTo('App\Models\Consumer');
    }
    public function provider(){
      return $this->belongsTo('App\Models\Provider');
    }
    public function review(){
      return $this->hasOne('App\Models\Review');
    }
}
