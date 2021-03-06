<?php

namespace Aposoftworks\LaravelUtilities\Contracts;

interface RepositoryContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index ($perPage = 25); 	//list
	public function show ($id);				//single

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store (array $fields);
	public function update ($model, array $fields);
	public function destroy ($model);
}
