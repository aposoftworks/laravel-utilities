<?php

namespace Aposoftworks\LaravelUtilities\Contracts;

interface RelationalRepositoryContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index ($model, $perPage = 25); 	//list

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function add ($model, $fields);
	public function set ($model, $fields);
	public function remove ($model, $fields);
	public function clear ($model);
}
