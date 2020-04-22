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

	public function create () {

	}

	public function edit () {

	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index () {
		$repository = $this->getRepository();
		$list 		= (new $repository)::index();
		$collection	= $this->getCollection();

		return new $collection($list);
	}

	public function show () {
		$id 		= $this->getId();
		$resource 	= $this->getResource();
		$response	= $this->getRepository()::show($id);

		return new $resource($response);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store () {
		$request 	= $this->insertRequest($this->getRequestCreate());
		$response	= $this->getRepository()::store($request->validated());
		$resource 	= $this->getResource();

		return new $resource($response);
	}

	public function update () {
		$id 		= $this->getId();
		$request 	= $this->insertRequest($this->getRequestUpdate());
		$response 	= $this->getRepository()::update($id, $request->validated());
		$resource 	= $this->getResource();

		return new $resource($response);
	}

	public function destroy () {
		$id 	= $this->getId();

		return $this->getRepository()::destroy($id);
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
