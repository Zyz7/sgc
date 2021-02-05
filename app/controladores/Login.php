<?php

class Login extends Controlador {
  private $modelo;

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
  }

  function caratula() {
	  $this->vista("loginVista");
  }
}

?>
