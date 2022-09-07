<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserContract;
use App\Contracts\PartnerContract;
use App\Contracts\CustomerContract;
use App\Contracts\ProjectContract;
use App\Contracts\ScopeContract;
use App\Contracts\ScopeStageContract;

use App\Repositories\UserRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ScopeRepository;
use App\Repositories\ScopeStageRepository;

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
        $this->app->bind(ProjectContract::class, ProjectRepository::class);
        $this->app->bind(ScopeContract::class, ScopeRepository::class);
        $this->app->bind(ScopeStageContract::class, ScopeStageRepository::class);
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
