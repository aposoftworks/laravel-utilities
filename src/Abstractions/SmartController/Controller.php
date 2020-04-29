<?php

namespace Aposoftworks\LaravelUtilities\Abstractions\SmartController;

use Aposoftworks\LaravelUtilities\Abstractions\SmartController\ControllerLogic;

abstract class Controller extends ControllerLogic {

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
