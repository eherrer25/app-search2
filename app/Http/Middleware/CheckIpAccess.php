<?php

namespace App\Http\Middleware;

use App\Models\AccessIp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIpAccess
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
        $ip = request()->ip(); 
        $acceso = AccessIp::where('public_ip',$ip)->first();
        if(is_null($acceso)){ // si es null, es porque no existe y retornamos la ruta
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('main.index');
        }
        //caso contrario seguimos con petición
        return $next($request);
    }
}
