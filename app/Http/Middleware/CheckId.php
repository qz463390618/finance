<?php

namespace App\Http\Middleware;

use Closure;

class CheckId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(null == session()->get('admin')['user_id'])
        {
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
