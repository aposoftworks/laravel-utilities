<?php

namespace Aposoftworks\LaravelUtilities\Abstractions\Relational;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\Relational\OneToManyContract;

//Classes
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class OneToMany implements OneToManyContract {

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	private function getParent () : string {
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
		$plural 	= Str::plural($lowercase);
		return $plural;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index ($parent, $perPage = 25) {
		return $this->getRelatedMethod($parent)->paginate($perPage);
	}

	public function show ($parent, $related) {
		return $this->getRelatedMethod($parent)()->findOrFail($related);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function add ($parent, array $fields) {
		$relation = $this->getRelatedMethod($parent);

		return $relation->create($fields);
	}

	public function set ($parent, array $fields) {
		//Clear all relations
		$this->clear($parent);

		//Add new relations
		$relation = $this->getRelatedMethod($parent);

		return $relation->create($fields);
	}

	public function update ($parent, $related, array $fields) {
		$relation = $this->getRelatedMethod($parent);

		//Find model if id given
		if (!($related instanceof Model && $relation->contains($related)))
			$related = $relation->findOrFail($related);

		//Actually update
		$related->update($fields);

		//Return info
		return $related;
	}

	public function destroy ($parent, $related) {
		$relation = $this->getRelatedMethod($parent);

		//Find model if id given
		if (!($related instanceof Model && $relation->contains($related)))
			$related = $relation->findOrFail($related);

		//Actually delete
		return $related->delete();
	}

	public function clear ($parent) {
		$relation = $this->getRelatedMethod($parent);

		return $relation->delete();
	}

    //-------------------------------------------------
    // Helpers
	//-------------------------------------------------

	private function getRelatedMethod ($model) {
		if ($model instanceof Model)
			return $model->{$this->getRelatedName()}();
		else
			return $this->getParent()::findOrFail($model)->{$this->getRelatedName()}();
	}
}
