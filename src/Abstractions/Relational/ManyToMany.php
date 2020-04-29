<?php

namespace Aposoftworks\LaravelUtilities\Abstractions\Relational;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\RelationalRepositoryContract;

//Classes
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class ManyToMany implements RelationalRepositoryContract {

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	private function getModel () : string {
		return $this->parent;
	}

	private function getRelatedModel () : string {
		return $this->related;
	}

	private function getRelatedName () : string {
		if (isset($this->relationName))
			return $this->relationName;

		$basename 	= class_basename($this->getRelatedModel());
		$lowercase	= strtolower($basename);
		$plural 	= $this->hasMany ? Str::plural($lowercase) : $lowercase;
		return $plural;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index ($parent, $perPage = 25) {
		return $this->getRelated($parent)->paginate($perPage);
	}

	public function show ($parent, $related) {
		return $this->getRelated($parent)->findOrFail($related);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function add ($model, $fields) {
		$relation = $this->getRelated($parent);

		if ($this->hasMany)
			$relation->add($fields);
		else
			$relation->create($fields);
	}
	public function set ($model, $fields) {

	}

	public function remove ($model, $fields) {

	}

	public function clear ($model) {

	}

    //-------------------------------------------------
    // Helpers
	//-------------------------------------------------

	private function getRelated ($model) {
		if ($model instanceof Model)
			return $model->{$this->getRelatedName()}();
		else
			return $this->getModel()::findOrFail($model)->{$this->getRelatedName()}();
	}
}
