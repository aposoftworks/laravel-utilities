<?php

namespace Aposoftworks\LaravelUtilities\Abstractions;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\RepositoryContract;

//Classes
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryBasic implements RepositoryContract {

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
		return $this->getModel()::paginate($perPage);
	}

	public function show ($model) {
		if ($model instanceof Model)
			return $model;
		else
			return $this->getModel()::findOrFail($model);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store (array $fields) {
        //Create model
        $modelPath = $this->getModel();
        $model = new $modelPath();
        $model->fill($fields);
        $model->save();

        //Response
		return $model;
	}

	public function update ($model, array $fields) {
        //Get model
        $modelPath  = $this->getModel();
        $model      = ($model instanceof Model)? $model:$modelPath::find($model);

        //Update
        $model->fill($fields);
        $model->save();

        return $model;
	}

	public function destroy ($model) {
		if ($model instanceof Model)
			return $model->delete();
		else
			return $this->getModel()::find($model)->delete();
	}
}
