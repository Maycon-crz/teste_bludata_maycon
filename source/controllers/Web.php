<?php

namespace Source\controllers;

use League\Plates\Engine;
class Web{
	/*@var Engine*/
	private $view;

	public function __construct($router){
		$this->view = Engine::create(
			dirname(__DIR__, 2) . "/theme",
			"php"
		);
		$this->view->addData(["router" => $router]);
	}
	public function home(): void{
		echo $this->view->render("home");
	}
	public function painel(): void{
		echo $this->view->render("painel");
	}
}
