<?php

namespace App\Providers;
use App\Models\TmPeriodosLectivos;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('America/Guayaquil');

        $periodoActivo = TmPeriodosLectivos::where('aperturado', 1)->first();

        View::share('periodoActivo', $periodoActivo);
    }

    
}
