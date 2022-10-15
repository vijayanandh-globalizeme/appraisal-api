<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Session\Store;
use Auth;
use Session;
use Carbon\Carbon;
 
class SessionExpired 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $user = Auth::user();
        if(isset($user->last_active_at)){
            $lastActivityTime = Carbon::createFromFormat('Y-m-d H:i:s', $user->last_active_at);
                
            if($lastActivityTime->diffInMinutes(Carbon::now()) > config('session.lifetime')){
                $user->token()->revoke();
                return response()->json([
                    'message' => '401 Unauthorized HTTP'
                ], 401);
            }
        }
        $user->last_active_at = Carbon::now();
        $user->save();
        return $next($request);
    }
}