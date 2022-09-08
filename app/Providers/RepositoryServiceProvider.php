<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserContract;
use App\Contracts\PartnerContract;
use App\Contracts\CustomerContract;
use App\Contracts\ProjectContract;
use App\Contracts\ScopeContract;
use App\Contracts\ScopeStageContract;
use App\Contracts\CountryContract;
use App\Contracts\QuestionContract;
use App\Contracts\QuestionCategoryContract;

use App\Repositories\UserRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ScopeRepository;
use App\Repositories\ScopeStageRepository;
use App\Repositories\CountryRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionCategoryRepository;

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
        $this->app->bind(CountryContract::class, CountryRepository::class);
        $this->app->bind(QuestionContract::class, QuestionRepository::class);
        $this->app->bind(QuestionCategoryContract::class, QuestionCategoryRepository::class);
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
