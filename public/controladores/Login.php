<?php

class Login extends Controlador {
  private $modelo;

  function __construct() {

  }

  function caratula() {

	  $this->vista("loginVista");
  }
}

?>
