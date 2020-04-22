<?php

namespace Aposoftworks\LaravelUtilities\Abstractions;

abstract class SmartControllerBase extends SmartControllerLogic {

    //-------------------------------------------------
    // View (render) types
	//-------------------------------------------------

	public function create () {
        return view($this->createView);
	}

	public function edit () {
        $id         = $this->getId();
        $model      = $this->repositoryInstance()->show($id);
        $resource   = $this->getResource();

        return view($this->updateView, new $resource($model));
	}
}
