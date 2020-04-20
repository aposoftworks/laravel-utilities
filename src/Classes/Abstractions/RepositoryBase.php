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

	private function getModel () : string {
		return $this->model;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public static function index ($perPage = 25) {
		//Start singleton
		self::initialize();

		return self::$singleton->getModel()::paginate($perPage);
	}

	public static function show ($model) {
		//Start singleton
		self::initialize();

		if ($model instanceof Model)
			return $model;
		else
			return self::$singleton->getModel()::findOrFail($model);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public static function store (array $fields) {
		//Start singleton
		self::initialize();

		return self::$singleton->getModel()::create($fields);
	}

	public static function update ($model, array $fields) {
		//Start singleton
		self::initialize();

		if ($model instanceof Model)
			return $model->update($fields);
		else
			return self::$singleton->getModel()::find($model)->update($fields);
	}

	public static function destroy ($model) {
		//Start singleton
		self::initialize();

		if ($model instanceof Model)
			return $model->delete();
		else
			return self::$singleton->getModel()::find($model)->delete();
	}

    //-------------------------------------------------
    // Main methods
	//-------------------------------------------------

	private static function initialize () {
		if (!isset(self::$singleton) || is_null(self::$singleton)) {
			$class = get_called_class();
			self::$singleton = new $class;
		}
	}

    //-------------------------------------------------
    // Magic methods
	//-------------------------------------------------

	public function __construct () {
		self::$singleton = $this;
	}

	public static function __callStatic ($name, $arguments) {
		//Start singleton
		self::initialize();

		return self::$singleton->{$name}(...$arguments);
	}
}
