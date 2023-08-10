<?php

namespace App\Providers;

use App\Repositories\Contracts\IRepoOrder;
use App\Repositories\RepoOrder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public array $bindings = [
//        ProductRepositoryContract::class => ProductRepository::class,
//        ImageRepositoryContract::class => ImageRepository::class,
//        IRepoOrder::class => RepoOrder::class,
//        PaypalServiceContract::class => PaypalService::class,
    ];
}
