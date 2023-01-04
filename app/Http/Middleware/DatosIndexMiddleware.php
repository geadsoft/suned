<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TmPersonas;

class DatosIndexMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     public $records;
     public $datos= [
        'total' => 0,
        'hombres' => 0,
        'mujeres' => 0,
        '01' => 0,
        '02' => 0,
        '03' => 0,
        '04' => 0,
        '05' => 0,
        '06' => 0,
        '07' => 0,
        '08' => 0,
        '09' => 0,
        '10' => 0,
        '11' => 0,
        '12' => 0,
     ];

    public function handle(Request $request, Closure $next)
    {
        $this->records=TmPersonas::where([
            ["genero","F"],
            ["tipopersona","E"],
        ])->get(); 
            
        return $next($request);
    }
}
