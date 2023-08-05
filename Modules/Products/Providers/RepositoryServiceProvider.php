<?php

namespace Modules\Products\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\Modules\Products\Repositories\ProductRepository::class, \Modules\Products\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\Modules\Products\Repositories\ProductCategoryRepository::class, \Modules\Products\Repositories\ProductCategoryRepositoryEloquent::class);
    }
}
