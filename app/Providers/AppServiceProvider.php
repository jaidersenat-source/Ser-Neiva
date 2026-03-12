<?php

namespace App\Providers;

use App\Models\Iglesia;
use App\Policies\IglesiaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Iglesia::class, IglesiaPolicy::class);
    }
}
