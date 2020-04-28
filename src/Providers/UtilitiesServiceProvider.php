<?php

namespace Aposoftworks\LaravelUtilities\Providers;

//General
use Illuminate\Support\ServiceProvider;

//Commands
use Aposoftworks\LaravelUtilities\Commands\NewRepositoryCommand;
use Aposoftworks\LaravelUtilities\Commands\NewSmartControllerCommand;

class UtilitiesServiceProvider extends ServiceProvider {
    public function boot () {
        //Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                NewRepositoryCommand::class,
                NewSmartControllerCommand::class,
            ]);
        }
    }
}
