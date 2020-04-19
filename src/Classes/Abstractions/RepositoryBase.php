<?php

namespace Aposoftworks\LaravelUtilities\Classes\Abstractions;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\RepositoryContract;

//Classes
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryBase implements RepositoryContract {

    //-------------------------------------------------
    // Properties
	//-------------------------------------------------

	protected static $singleton;

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	public function getModel () : string {
		return $this->model;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public static function index ($perPage = 25) {
		return self::$singleton->getModel()::paginate($perPage);
	}

	public static function show ($id) {
		return self::$singleton->getModel()::findOrFail($id);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public static function store (array $fields) {
		return self::$singleton->getModel()::create($fields);
	}

	public static function update ($model, array $fields) {
		if ($model instanceof Model)
			return $model->update($fields);
		else
			return self::$singleton->getModel()::find($model)->update($fields);
	}

	public static function destroy ($model) {
		if ($model instanceof Model)
			return $model->delete();
		else
			return self::$singleton->getModel()::find($model)->delete();
	}

    //-------------------------------------------------
    // Magic methods
	//-------------------------------------------------

	public function __construct () {
		self::$singleton = $this;
	}

	public static function __callStatic ($name, $arguments) {
		return self::$singleton->{$name}(...$arguments);
	}
}
