<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'task_id',
        'provider_id',
        'consumer_id',
        'text',
        'rating',
    ];


    public function task(){
      return $this->belongsTo('App\Models\Task');
    }
    public function provider(){
      return $this->belongsTo('App\Models\Provider');
    }
    public function consumer(){
      return $this->belongsTo('App\Models\Consumer');
    }
}
