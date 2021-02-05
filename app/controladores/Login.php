<?php

class Login extends Controlador {
  private $modelo;
  private $datos = [];

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
  }

  function caratula() {
    $this->datos = ["titulo" => "Login"];
	  $this->vista("loginVista", $datos);
  }
}

?>
