<?php

namespace App\Providers;

use App\Models\Categories\Repositories\CategoryRepository;
use App\Models\Categories\Repositories\CategoryRepositoryInterface;

use App\Models\Submissions\Repositories\SubmissionRepository;
use App\Models\Submissions\Repositories\SubmissionRepositoryInterface;

use App\Models\PromoCodes\Repositories\PromoCodeRepository;
use App\Models\PromoCodes\Repositories\PromoCodeRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            SubmissionRepositoryInterface::class,
            SubmissionRepository::class
        );

        $this->app->bind(
            PromoCodeRepositoryInterface::class,
            PromoCodeRepository::class
        );

    }
}
