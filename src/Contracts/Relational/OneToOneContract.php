<?php

namespace Aposoftworks\LaravelUtilities\Contracts\Relational;

interface OneToOneContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function show ($model); 	//list

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store ($model, array $fields);
	public function update ($model, array $fields);
	public function destroy ($model);
}
