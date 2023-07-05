<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Adm\LoginController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        Route::group(
            [
                'namespace' => 'Laravel\Fortify\Http\Controllers',
                'domain' => config('fortify.domain', null),
                'prefix' => config('fortify.prefix'),
            ],
            function () {
                $this->loadRoutesFrom(base_path('routes/fortify.php'));
            }
        );

        RateLimiter::for(
            'login',
            function (Request $request) {
                $email = (string) $request->email;

                return Limit::perMinute(5)->by($email.$request->ip());
            }
        );

        RateLimiter::for(
            'two-factor',
            function (Request $request) {
                return Limit::perMinute(5)->by($request->session()->get('login.id'));
            }
        );

        Fortify::loginView(
            function (Request $request) {
                $loginController = new LoginController();
                return $loginController->index($request);
            }
        );

        Fortify::requestPasswordResetLinkView(
            function () {
                return view('auth.forgot-password');
            }
        );

        Fortify::resetPasswordView(
            function (Request $request) {
                return view('auth.reset-password', ['request' => $request]);
            }
        );

        Fortify::authenticateUsing(
            function (Request $request) {
                $loginController = new LoginController();
                $user = $loginController->loginUser($request);

                if ($user) {
                    return $user;
                }

                return;
            }
        );
    }
}
