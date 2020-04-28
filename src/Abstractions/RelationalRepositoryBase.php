<?php

namespace Aposoftworks\LaravelUtilities\Classes\Abstractions;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\RelationalRepositoryContract;

//Classes
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class RelationalRepositoryBase implements RelationalRepositoryContract {

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	private function getModel () : string {
		return $this->model;
	}

	private function getRelationModel () : string {
		return $this->relationModel;
	}

	private function getRelationName () : string {
		if (isset($this->relationName))
			return $this->relationName;

		$basename 	= class_basename($this->getModel());
		$lowercase	= strtolower($basename);
		$plural 	= Str::plural($lowercase);
		return $plural;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index ($model, $perPage = 25) {
		$this->getRelated($model)->paginate($perPage);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function add ($model, $fields) {

	}

    //-------------------------------------------------
    // Helpers
	//-------------------------------------------------

	private function getRelated ($model) {
		if ($model instanceof Model)
			return $model->{$this->getRelationName()};
		else
			return $this->getRelationModel()::find($model);
	}
}
