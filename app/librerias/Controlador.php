<?php

class Controlador {
  protected $controlador = "Login";
  protected $metodo = "caratula";
  protected $parametros = [];

  function __construct() {

  }

  //Carga el modelo
  public function modelo($modelo) {
	  require_once("../app/modelos/".$modelo.".php");
	  return new $modelo();
  }

  //Carga la vista
  public function vista($vista, $datos=[]) {
    if (file_exists("../app/vistas/".$vista.".php")) {
	    require_once("../app/vistas/".$vista.".php");
	  } else {
	    die("La vista no existe");
	  }
  }
}

 ?>
