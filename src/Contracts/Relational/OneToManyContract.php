<?php

namespace Aposoftworks\LaravelUtilities\Contracts\Relational;

interface OneToManyContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index ($parent); 			//list
	public function show ($parent, $related); 	//single

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function add ($parent, $insert);
	public function set ($parent, $insert);
	public function update ($parent, $related, array $fields);
	public function destroy ($parent, $related);
	public function clear ($parent);
}
