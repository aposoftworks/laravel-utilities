<?php

namespace Aposoftworks\LaravelUtilities\Contracts;

interface SmartControllerContract {

    //-------------------------------------------------
    // View (render) types
	//-------------------------------------------------

	public static function create ();
	public static function edit ();

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
