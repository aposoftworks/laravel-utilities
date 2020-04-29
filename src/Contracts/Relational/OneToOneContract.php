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

	public function store ($parent, $insert);
	public function update ($parent, array $fields);
	public function destroy ($parent);
}
