<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Route;

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
        //
        Blade::directive('actionSearch', function () {
            
            $action = route('frontsite.project.index');
            if (Route::currentRouteName() == 'frontsite.user.index')
                $action = route('frontsite.user.index', request()->email);
            
            return $action;

        });

        Blade::directive('trans', function ($key) {
            return "<?php echo ___($key); ?>";
        });
    }
}
