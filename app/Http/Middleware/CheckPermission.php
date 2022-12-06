<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user= new User();
        $userType=Auth::user()->user_type;
        $pageName=$request->route()->getName();
        $str = strpos($request->route()->getName(), '.');
        if($str !== false)
        {
            // has Dot
            $path=explode(".",$request->route()->getName());

        } else {
            $path=explode("_",$request->route()->getName());
            // underscore
        }
        $endName=strtolower($path[count($path)-1]);
            if($endName == 'show' || $endName == 'edit')
            {
                $endName ='update'; 
            }
            elseif($endName == 'index')
            {
                $endName ='view'; 
            }
            if($endName == 'dashboard')
            {
                return $next($request);
            }
            if($userType != 1)
            {
                $permission=$user->GetPermissions($pageName, $endName,$userType);
                $permission=json_decode($permission);
                // dd($pageName);
                if($permission[0]->$endName == 0)
                {
                    return redirect()->route('permission_error');
                }
            }

        return $next($request);
    }
}
