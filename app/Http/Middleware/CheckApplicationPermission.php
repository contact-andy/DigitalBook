<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CheckApplicationPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Get the currently authenticated user
        $user = Auth::user();

        if(!$user){
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }
        // // Get the current route name
        $routeNameWithView = $request->route()->getName();
        $routeName = explode('.',$routeNameWithView)[0];
        // // Check if the user has permission to access the route
        $hasPermission = DB::table('dcb_application_permissions')
        ->join('dcb_application_lists', 'dcb_application_lists.id', '=', 'dcb_application_permissions.appId')
        ->where('userId', $user->id)
        ->where('dcb_application_lists.url', $routeName)
        ->exists();

        if (!$hasPermission) {
            // If the user doesn't have permission, redirect or return an error
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }
        // echo "routeName:$routeName";

        // return $next($request);
        return $next($request);
    }
}
