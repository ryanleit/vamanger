<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ACLHelper;
use Illuminate\Support\Facades\Auth;
class RoleControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $role_arr = explode('|',$role);
        
        if (!ACLHelper::hasRole($role_arr)) {
            abort(404, "Access denied!");
            //Auth::logout();            
            //return redirect('login');
        }

        return $next($request);
    }
}
