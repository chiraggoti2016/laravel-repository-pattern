<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserContract;
use App\Contracts\PartnerContract;
use App\Contracts\CustomerContract;

use App\Repositories\UserRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\CustomerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(PartnerContract::class, PartnerRepository::class);
        $this->app->bind(CustomerContract::class, CustomerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
