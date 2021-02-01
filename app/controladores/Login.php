<?php

class Login extends Controlador {
	private $modelo;
	
	function __construct() {
		$this->modelo = $this->modelo('LoginModelo');
	}
	
	function vista() {
		$this->vista('loginVista');
	}
}
?>
