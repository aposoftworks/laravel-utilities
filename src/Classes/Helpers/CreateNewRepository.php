<?php

namespace Aposoftworks\LaravelUtilities\Classes\Helpers;

//Classes
use Aposoftworks\StubHelper\Classes\StubHelper;

class CreateNewRepository {

	//-------------------------------------------------
    // Main methods
	//-------------------------------------------------

	public static function create ($arguments, $options) {
		$class 		= class_basename($arguments["classname"]);
		$model 		= $options["model"] 	? $options["model"]:(CreateNewRepository::findModelName($class));
		$path 		= $options["path"] 		? $options["path"]:(CreateNewRepository::createPath($arguments["classname"]));
		$stubtype 	= $options["relation"] 	? ".relation":(preg_match("/relation/mi", $class) ? ".relation":"");
		$savepath	= app_path(preg_replace("/App\\\\/", "", $path))."\\".$class.".php";

		//Check if repository already exists
		if (file_exists($savepath)) return false;

		//Prepare stub
		$stub = new StubHelper;
		$stub->getFile(__DIR__."/../../Stubs/repository".$stubtype.".stub");
		$stub->setVariables(["class" => $class, "model" => $model, "path" => $path]);

		//Save stub
		$stub->saveTo($savepath);
		return true;
	}

	//-------------------------------------------------
    // Helper methods
	//-------------------------------------------------

	private static function findModelName (string $class) {
		$clearRepositoryName 	= preg_replace("/Repository/", "", $class);
		$uppercase 				= ucfirst($clearRepositoryName);

		return $uppercase;
	}

	private static function createPath (string $class) {
		$classname 	= class_basename($class);
		$path 		= preg_replace("/".$classname."/", "", $class);
		$clearpath 	= preg_replace("/(^\/|^\\\\)/", "", $path);
		$qualified 	= "App\Http\Repositories\\".$clearpath;

		return preg_replace("/\\\\$/m", "", $qualified);
	}
}
