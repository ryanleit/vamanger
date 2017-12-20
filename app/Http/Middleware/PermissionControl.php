<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ACLHelper;

class PermissionControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if(!ACLHelper::hasPermission($permissions))
        {
            //\Illuminate\Support\Facades\Auth::logout();
            //return redirect("login");
            //$request->session()->flash("fail_message", "Access Denied!");
            abort(404, "Access denied!");
            //return redirect("/");
        }    
        return $next($request);
    }
}
