<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            $user =  User::find(Auth::user()->id);
            if ($user->role_as == 1)
            {
                return $next($request);
            }else{
                return redirect()->back()->with('error', 'Access Denied. As you are not an Admin.');
            }
        }else {
            return redirect()->back()->with('error', 'Login First');
        }
    }
}
