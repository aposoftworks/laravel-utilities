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

	public function index ($perPage = 25) {
		//Start singleton
		$this->initialize();

		return $this->getModel()::paginate($perPage);
	}

	public function show ($model) {
		//Start singleton
		$this->initialize();

		if ($model instanceof Model)
			return $model;
		else
			return $this->getModel()::findOrFail($model);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store (array $fields) {
		//Start singleton
        $this->initialize();

        //Create model
        $modelPath = $this->getModel();
        $model = new $modelPath();
        $model->fill($fields);
        $model->save();

        //Response
		return $model;
	}

	public function update ($model, array $fields) {
		//Start singleton
		$this->initialize();

        //Get model
        $modelPath  = $this->getModel();
        $model      = ($model instanceof Model)? $model:$modelPath::find($model);

        //Update
        $model->fill($fields);
        $model->save();

        return $model;
	}

	public function destroy ($model) {
		//Start singleton
		$this->initialize();

		if ($model instanceof Model)
			return $model->delete();
		else
			return $this->getModel()::find($model)->delete();
	}

    //-------------------------------------------------
    // Main methods
	//-------------------------------------------------

	private function initialize () {
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
