<?php

namespace Aposoftworks\LaravelUtilities\Contracts\Relational;

interface OneToOneContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function show ($parent); 	//list

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store ($parent, array $fields);
	public function update ($parent, array $fields);
	public function destroy ($parent);
}
