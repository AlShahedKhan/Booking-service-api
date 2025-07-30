<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Repositories\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Repositories\ContactRepositoryInterface::class, \App\Repositories\ContactRepository::class);
        $this->app->bind(\App\Repositories\BlogRepositoryInterface::class, \App\Repositories\BlogRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\LoginInterface::class, \App\Repositories\LoginRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\RegisterInterface::class, \App\Repositories\RegisterRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\LogoutInterface::class, \App\Repositories\LogoutRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ForgotPasswordInterface::class, \App\Repositories\ForgotPasswordRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ResetPasswordInterface::class, \App\Repositories\ResetPasswordRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
