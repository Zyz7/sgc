<?php

class Controlador {
  protected $controlador = "Login";
  protected $metodo = "caratula";
  protected $parametros = [];

  function __construct() {

  }

  public function modelo($modelo) {
	  require_once("../modelos/".$modelo.".php");
	  return new $modelo();
  }

  public function vista($vista, $datos=[]) {

    if (file_exists("../vistas/".$vista.".php")) {
	    require_once("../vistas/".$vista.".php");
	  } else {
	    die("La vista no existe");
	  }
  }
}

?>
