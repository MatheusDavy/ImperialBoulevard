<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/adm/dash';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        $this->removeIndexPhpFromUrl();
        $this->removeServerPhpFromUrl();

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    protected function removeIndexPhpFromUrl()
    {
        if (Str::contains(request()->getRequestUri(), '/index.php')) {
            $url = str_replace('/index.php', '', request()->getRequestUri());

            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }
            
            header("Location: " . '/', true, 301);
            exit;
        }
    }

    protected function removeServerPhpFromUrl()
    {
        if (Str::contains(request()->getRequestUri(), '/server.php')) {
            $url = str_replace('/server.php', '', request()->getRequestUri());

            if (strlen($url) > 0) {
                header("Location: $url", true, 301);
                exit;
            }

            header("Location: " . '/', true, 301);
            exit;
        }
    }

}
