<?php

namespace Aposoftworks\LaravelUtilities\Traits;

trait DinamicRequest {
	public function insertRequest (string $requestclasspath) {
        $request = new $requestclasspath();
        $request->setContainer(app());
        $request->setRedirector(app('Illuminate\Routing\Redirector'));
        $current = app('request');
        $request->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $current->files->all(), $current->server->all(), $current->getContent()
        );

		$request->validateResolved();

		return $request;
	}
}
