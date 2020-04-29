<?php

namespace Aposoftworks\LaravelUtilities\Abstractions\SmartController;

//Interfaces
use Aposoftworks\LaravelUtilities\Contracts\SmartControllerLogicContract;

//Traits
use Aposoftworks\LaravelUtilities\Traits\DinamicRequest;

//Laravel
use Illuminate\Support\Facades\Request;

abstract class ControllerLogic implements SmartControllerLogicContract {

    //-------------------------------------------------
    // Traits
	//-------------------------------------------------

	use DinamicRequest;

    //-------------------------------------------------
    // Properties
    //-------------------------------------------------

	protected $name = null;

    //-------------------------------------------------
    // Reference types
	//-------------------------------------------------

	protected function getId () : string {
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

	protected function getName () : string {
		return $this->name;
	}

	protected function getModel () : string {
		return $this->model;
	}

	protected function getRepository (): string {
		return $this->repository;
	}

	protected function getResource () : string {
		return $this->resource;
	}

	protected function getCollection () : string {
		return $this->collection;
	}

	protected function getRequestCreate (): string {
		return $this->requestCreate;
	}

	protected function getRequestUpdate (): string {
		return $this->requestUpdate;
	}

    //-------------------------------------------------
    // Display types
	//-------------------------------------------------

	public function index () {
		$list 		= $this->repositoryInstance()->index();
		$collection	= $this->getCollection();

		return new $collection($list);
	}

	public function show () {
		$id 		= $this->getId();
		$resource 	= $this->getResource();
		$response	= $this->repositoryInstance()->show($id);

		return new $resource($response);
	}

    //-------------------------------------------------
    // Effect types
	//-------------------------------------------------

	public function store () {
		$request 	= $this->insertRequest($this->getRequestCreate());
		$response	= $this->repositoryInstance()->store($request->validated());
		$resource 	= $this->getResource();

		return new $resource($response);
	}

	public function update () {
		$id 		= $this->getId();
		$request 	= $this->insertRequest($this->getRequestUpdate());
		$response 	= $this->repositoryInstance()->update($id, $request->validated());
		$resource 	= $this->getResource();

		return new $resource($response);
	}

	public function destroy () {
		$id 	= $this->getId();

		return $this->repositoryInstance()->destroy($id);
	}

    //-------------------------------------------------
    // Helper
    //-------------------------------------------------

    protected function repositoryInstance () {
        $repository = $this->getRepository();
        return new $repository;
    }
}
