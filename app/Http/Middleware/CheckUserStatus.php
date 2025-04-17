<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('web')->check() && auth('web')->user()->status == 0){
            return redirect()->route('frontend.wait');
        }
        if(auth('sanctum')->check() && auth('sanctum')->user()->status == 0){
           auth('sanctum')->user()->currentAccessToken()->delete();
              return apiResponse(401, 'Your account is not active, please contact support');
        }
        return $next($request);
    }
}
