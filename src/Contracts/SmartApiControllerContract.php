<?php

namespace Aposoftworks\LaravelUtilities\Contracts;

interface SmartApiControllerContract {

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public static function index (); 		//list
	public static function show ();			//single

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public static function store ();
	public static function update ();
	public static function destroy ();
}
