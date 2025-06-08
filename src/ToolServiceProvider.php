<?php

namespace Pekhota\NovaScrollButton;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Pekhota\NovaScrollButton\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::script('nova-scroll-buttons', __DIR__.'/../dist/js/tool.js');
    }
}
