<?php

namespace Aposoftworks\LaravelUtilities\Providers;

//General
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

//Commands
use Aposoftworks\LaravelUtilities\Commands\NewRepositoryCommand;
use Aposoftworks\LaravelUtilities\Commands\NewSmartControllerCommand;
use Illuminate\Support\Facades\Route;
//use Illuminate\Routing\Route;

class UtilitiesServiceProvider extends ServiceProvider {
	public function register () {
		//Macros
		Route::macro("oneToOneResource", function ($path, $controller, $parent = "parent") {
			$related 	= Str::singular(class_basename($path));

			Route::get($path."/{".$parent."}", 					$controller."@index")->name($parent.".".$related.".index");
			Route::get($path."/{".$parent."}/{".$related."}", 	$controller."@show")->name($parent.".".$related.".show");
			Route::post($path."/{".$parent."}", 				$controller."@store")->name($parent.".".$related.".store");
			Route::patch($path."/{".$parent."}",				$controller."@update")->name($parent.".".$related.".update");
			Route::put($path."/{".$parent."}",					$controller."@update")->name($parent.".".$related.".update");
			Route::delete($path."/{".$parent."}",				$controller."@destroy")->name($parent.".".$related.".destroy");
		});

		Route::macro("oneToManyResource", function ($path, $controller, $parent = "parent") {
			$related 	= Str::singular(class_basename($path));

			Route::get($path."/{".$parent."}", 						$controller."@index")->name($parent.".".$related.".index");
			Route::get($path."/{".$parent."}/{".$related."}", 		$controller."@show")->name($parent.".".$related.".show");
			Route::post($path."/{".$parent."}", 					$controller."@add")->name($parent.".".$related.".add");
			Route::patch($path."/{".$parent."}",					$controller."@set")->name($parent.".".$related.".set");
			Route::delete($path."/{".$parent."}", 					$controller."@clear")->name($parent.".".$related.".clear");
			Route::patch($path."/{".$parent."}/{".$related."}",		$controller."@update")->name($parent.".".$related.".update");
			Route::delete($path."/{".$parent."}/{".$related."}",	$controller."@destroy")->name($parent.".".$related.".destroy");
		});
	}

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
