<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Models\Provider;
use DateTime;

class LastSeen
{

    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }


        $user = Auth::guard('provider')->user();
        if($user != null){
          $user->update([
              'last_seen' => new DateTime()
          ]);
          $user->save();
        }

        return $next($request);
    }
}
