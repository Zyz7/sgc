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
    if (file_exists("../app/vistas/".$vista.".html")) {
	    $template = file_get_contents("../app/vistas/".$vista.".html");

      foreach ($datos as $clave => $valor) {
        $template = str_replace('{'.$clave.'}', $valor, $template);
      }
      print $template;
	  } else {
	    die("La vista no existe");
	  }
  }
}

 ?>
