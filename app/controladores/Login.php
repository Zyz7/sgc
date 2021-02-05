<?php

class Login extends Controlador {
  private $modelo;

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
  }

  function caratula() {
    $datos = ["titulo" => "Login"];
	  $this->vista("loginVista", $datos);
  }
}

?>
