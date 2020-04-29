<?php

namespace Aposoftworks\LaravelUtilities\Abstractions\Relational;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\RelationalRepositoryContract;

//Classes
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class OneToMany implements RelationalRepositoryContract {

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

	public function store ($parent, array $fields) {
		$relation = $this->getRelatedMethod($parent)();

		$relation->save($fields);
	}

	public function update ($parent, $related, array $fields) {
		$relation = $this->getRelatedMethod($parent);

		if ($related instanceof Model && $relation->contains($related))
			$related->update($fields);
		else
			$relation()->findOrFail($related)->update($fields);
	}

	public function destroy ($parent, $related) {
		$relation = $this->getRelatedMethod($parent);

		if ($related instanceof Model && $relation->contains($related))
			$related->delete();
		else
			$relation()->findOrFail($related)->delete();
	}

	public function clear ($parent) {
		$relation = $this->getRelatedMethod($parent);

		$relation()->delete();
	}

    //-------------------------------------------------
    // Helpers
	//-------------------------------------------------

	private function getRelatedMethod ($model) : Model {
		if ($model instanceof Model)
			return $model->{$this->getRelatedName()};
		else
			return $this->getParent()::findOrFail($model)->{$this->getRelatedName()};
	}
}
