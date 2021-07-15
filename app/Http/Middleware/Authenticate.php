<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\abort;
use Illuminate\Http\Request;
use App\Models\API\User;
use Closure;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected $invalidToken     =   404;
    public function handle($request, Closure $next, ...$guards)
    {
        $url = explode("/", $request->url());
        // dd($request->url());
        if(strpos($request->url(), 'api')!==false){
            // dd($request->header());
            if (!empty(trim($request->header('Authorization')))) {
                $is_exists = User::where('id', Auth::guard('api')->id())->exists();
                if ($is_exists) {
                    $this->authenticate($request, $guards);
                    return $next($request);
                }
            }
            $response = [
                'success' => false,
                'message' => 'You are not authenticated to this service',
            ];
            return response()->json($response, 401);
        }else{
            if(!Auth::check()){
                return redirect('/');
            }else{
                return $next($request);
            }
        }
        
    }


    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
