<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckRole
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


//        Session::put('users',$params);
        if($request->user()==null){
            return response('Insuficient permissions',403);
        }

//        dd($params);
//        dd($writer);
//        $roles['admin']=$role;
//        $roles['writer']=$writer;
//        $actions=$request->route()->getAction();
//        $roles=isset($actions['roles'])? $actions['roles']:null;
        $roles=array_slice(func_get_args(), 2);
//        dd($roles);
        if($request->user()->hasAnyRole($roles) || !$roles){

            return $next($request);
        }
//        return view('',401);
        return response('Insuficient Permissions',403);
    }

}
