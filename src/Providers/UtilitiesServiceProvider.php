<?php

namespace Aposoftworks\LaravelUtilities\Providers;

//General
use Illuminate\Support\ServiceProvider;

//Commands
use Aposoftworks\LaravelUtilities\Commands\NewRepositoryCommand;

class UtilitiesServiceProvider extends ServiceProvider {
    public function boot () {
        //Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                NewRepositoryCommand::class,
            ]);
        }
    }
}
