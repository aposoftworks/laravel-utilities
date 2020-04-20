<?php

namespace Aposoftworks\LaravelUtilities\Classes\Abstractions;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\SmartControllerContract;

//Traits
use Aposoftworks\LaravelUtilities\Traits\DinamicRequest;

//Laravel
use Illuminate\Support\Facades\Request;

abstract class SmartControllerBase implements SmartControllerContract {

    //-------------------------------------------------
    // Traits
	//-------------------------------------------------

	use DinamicRequest;

    //-------------------------------------------------
    // Properties
	//-------------------------------------------------

	protected static $singleton;
	protected $name = null;

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	private function getId () : string {
		//Get last defined id
		if (is_null($this->name)) {
			$parameters = Request::route()->parameters();
			return end($parameters);
		}
		//Custom defined id
		else {
			return Request::route($this->name);
		}
	}

	private function getName () : string {
		return $this->name;
	}

	private function getModel () : string {
		return $this->model;
	}

	private function getRepository (): string {
		return $this->repository;
	}

	private function getResource () : string {
		return $this->resource;
	}

	private function getCollection () : string {
		return $this->collection;
	}

	private function getRequestCreate (): string {
		return $this->requestCreate;
	}

	private function getRequestUpdate (): string {
		return $this->requestUpdate;
	}

    //-------------------------------------------------
    // View (render) types
	//-------------------------------------------------

	public static function create () {

	}

	public static function edit () {

	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public static function index () {
		$repository = self::$singleton->getRepository();
		$list 		= (new $repository)::index();
		$collection	= self::$singleton->getCollection();

		return new $collection($list);
	}

	public static function show () {
		$id 		= self::$singleton->getId();
		$resource 	= self::$singleton->getResource();
		$response	= self::$singleton->getRepository()::show($id);

		return new $resource($response);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public static function store () {
		$request 	= insertRequest(self::$singleton->getRequestCreate());
		$response	= self::$singleton->getRepository()::store($request->validated());
		$resource 	= self::$singleton->getResource();

		return new $resource($response);
	}

	public static function update () {
		$id 		= self::$singleton->getId();
		$request 	= insertRequest(self::$singleton->getRequestUpdate());
		$response 	= self::$singleton->getRepository()::update($id, $request->validated());
		$resource 	= self::$singleton->getResource();

		return new $resource($response);
	}

	public static function destroy () {
		$id 	= self::$singleton->getId();

		return self::$singleton->getRepository()::destroy($id);
	}

    //-------------------------------------------------
    // Magic methods
	//-------------------------------------------------

	public function __construct () {
		self::$singleton = $this;
	}

	public static function __callStatic ($name, $arguments) {
		return self::$singleton->{$name}(...$arguments);
	}
}
