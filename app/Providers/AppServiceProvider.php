<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// Users Management
// use App\Repositories\ICRUD;
use App\Repositories\UsersManagement\IUserRepository;
use App\Repositories\UsersManagement\IEmpleadoRepository;
use App\Repositories\UsersManagement\ManageUser;

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
        // $this->app->singleton(ICRUD::class, ManageUsers::class);
        $this->app->singleton(IUserRepository::class, ManageUser::class);
        $this->app->singleton(IEmpleadoRepository::class, ManageUser::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
