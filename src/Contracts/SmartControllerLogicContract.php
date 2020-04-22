<?php

namespace Aposoftworks\LaravelUtilities\Contracts;

interface SmartControllerLogicContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index (); 		//list
	public function show ();		//single

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store ();
	public function update ();
	public function destroy ();
}
