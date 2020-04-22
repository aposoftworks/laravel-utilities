# Laravel Utilities

[![Latest Stable Version](https://poser.pugx.org/aposoftworks/laravel-utilities/version)](https://packagist.org/packages/aposoftworks/laravel-utilities) [![Total Downloads](https://poser.pugx.org/aposoftworks/laravel-utilities/downloads)](https://packagist.org/packages/aposoftworks/laravel-utilities) [![License](https://poser.pugx.org/aposoftworks/laravel-utilities/license)](https://packagist.org/packages/aposoftworks/laravel-utilities) [![Support](https://img.shields.io/badge/Patreon-Support-orange.svg?logo=Patreon)](https://www.patreon.com/rafaelcorrea)

This package composes of a collection of tools that can be used to enhance your workflow when using the laravel framework. This package is continuously evolving to add more tools or update the current ones available.

## Installation

This is a typical Laravel package installation, you can run as follows:

``` bash
composer require aposoftworks/laravel-utilities
```

## Tools

All of those tools can have their methods overwritten for custom implementation (just like any other good OO class).

### Repositories
A simple implementation of the repository pattern that uses Laravel's standard model. You can use it by extending our repository base and setting a public model variable inside of it. It uses the default naming from Laravel: index, show, store, update, destroy.

``` php
<?php

namespace App\Http\Repositories;

use Aposoftworks\LaravelUtilities\Classes\Abstractions\RepositoryBase;
use Path\To\Your\Model;

class YourRepository extends RepositoryBase {
	public $model = Model::class;
}

```

To use it, you must have an instance of it.

``` php
<?php

namespace App\Http\Controllers;

use App\Http\Repositories\YourRepository;

class TestController extends Controller {
	public function index (YourRepository $repository) {
	    $repository->index();
	}
}

```

### Smart Controllers
This is a case dependant, since it just implements basic functionality. But it should suffice 80% of times. It uses Laravel's requests, resources/collections and our repository to work. You can use it by extending our smart controller base and setting the following variables inside of it. It uses the default naming from Laravel: create, edit, index, show, store, update, destroy.

PS: We have a smart api controller (SmartApiController) that can be used to only use methods that don't return a view.

``` php
<?php

namespace App\Http\Controllers;

use Aposoftworks\LaravelUtilities\Classes\Abstractions\SmartControllerBase;
use Path\To\Your\Model;
use Path\To\Your\Repository;
use Path\To\Your\Collection;
use Path\To\Your\Resource;
use Path\To\Your\RequestCreate;
use Path\To\Your\RequestUpdate;

class CustomSmartController extends RepositoryBase {
	public $model 		    = Model::class;
	public $resource 	    = Resource::class;
	public $collection 	    = Collection::class;
	public $repository 	    = UserRepository::class;
	public $requestCreate	= RequestCreate::class;
	public $requestUpdate 	= RequestUpdate::class;
}
```

To call this controller, you may use it this in the route:
``` php
<?php

Route::resource("controller", "CustomSmartController");
//or
Route::apiResource("controller", "CustomSmartController");
```
