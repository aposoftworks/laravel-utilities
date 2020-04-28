<?php

namespace Aposoftworks\LaravelUtilities\Classes\Helpers;

//Classes
use Aposoftworks\StubHelper\Classes\StubHelper;

class CreateNewSmartController {

	//-------------------------------------------------
    // Main methods
	//-------------------------------------------------

	public static function create ($arguments, $options) {
		$class 		= class_basename($arguments["classname"]);
		$model 		= CreateNewSmartController::findModelName($class);
		$path 		= CreateNewSmartController::createPath($arguments["classname"]);
		$savepath	= app_path(preg_replace("/App\\\\/", "", $path))."\\".$class.".php";

		//Check if repository already exists
		if (file_exists($savepath)) return false;

		//Check if the directory exists
		if (!is_dir(app_path(preg_replace("/App\\\\/", "", $path))))
			mkdir(app_path(preg_replace("/App\\\\/", "", $path)));

		//Prepare stub
		$stub = new StubHelper;
		$stub->getFile(__DIR__."/../../Stubs/smartcontroller.stub");
		$stub->setVariables(["class" => $class, "model" => $model, "path" => $path]);

		//Save stub
		$stub->saveTo($savepath);
		return true;
	}

	//-------------------------------------------------
    // Helper methods
	//-------------------------------------------------

	private static function findModelName (string $class) {
		$clearRepositoryName 	= preg_replace("/(Controller|SmartController)/", "", $class);
		$uppercase 				= ucfirst($clearRepositoryName);

		return $uppercase;
	}

	private static function createPath (string $class) {
		$classname 	= class_basename($class);
		$path 		= preg_replace("/".$classname."/", "", $class);
		$clearpath 	= preg_replace("/(^\/|^\\\\)/", "", $path);
		$qualified 	= "App\Http\Controllers\\".$clearpath;

		return preg_replace("/\\\\$/m", "", $qualified);
	}
}
