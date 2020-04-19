<?php

namespace Aposoftworks\LaravelUtilities\Contracts;

interface SmartControllerContract {

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	public function getModel () : string;

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public static function index ($perPage = 25); 	//list
	public static function show ($id);				//single

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public static function store (array $fields);
	public static function update ($model, array $fields);
	public static function destroy ($model);
}
