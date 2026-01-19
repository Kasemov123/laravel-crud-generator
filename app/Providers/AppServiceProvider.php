<?php

namespace App\Providers;

use App\Models\Component;
use App\Observers\ComponentObserver;
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
        Component::observe(ComponentObserver::class);
        
        // مسح الـ cache عند تغيير الـ categories أو components
        Component::saved(fn() => \Cache::forget('active_categories_with_components'));
        Component::deleted(fn() => \Cache::forget('active_categories_with_components'));
        
        \App\Models\Category::saved(fn() => \Cache::forget('active_categories_with_components'));
        \App\Models\Category::deleted(fn() => \Cache::forget('active_categories_with_components'));
    }
}
