<?php

namespace Aposoftworks\LaravelUtilities\Abstractions\Relational;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\Relational\OneToOneContract;

//Classes
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class OneToOne implements OneToOneContract {

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
		return $lowercase;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function show ($parent) {
		return $this->getRelatedMethod($parent);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store ($parent, array $fields) {
		$relation = $this->getRelatedMethod($parent);

		return $relation->create($fields);
	}
	public function update ($parent, array $fields) {
		$relation = $this->getRelatedMethod($parent);
		$relation->update($fields);

		return $relation->first();
	}

	public function destroy ($parent) {
		$relation = $this->getRelatedMethod($parent);

		return $relation->delete();
	}

    //-------------------------------------------------
    // Helpers
	//-------------------------------------------------

	private function getRelatedMethod ($parent) {
		if ($parent instanceof Model)
			return $parent->{$this->getRelatedName()}();
		else
			return $this->getParent()::findOrFail($parent)->{$this->getRelatedName()}();
	}
}
