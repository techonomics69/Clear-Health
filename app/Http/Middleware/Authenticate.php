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
        dd($url);
        if (!empty(trim($request->header('Authorization')))) {
            $is_exists = User::where('id', Auth::guard('api')->id())->exists();
            if ($is_exists) {
                $this->authenticate($request, $guards);
                return $next($request);
            }
        }

        return abort(401, 'You are not authenticated to this service');
    }


    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
