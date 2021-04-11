<?php

/*
 * \class ControladorDependiente
 * \brief Instancia el modelo e imprime la vista
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class ControladorDependiente
{
  function __construct()
  {
  }

  /// \fn modelo Instancia el modelo
  public function modelo($modelo)
  {
	  require_once('../app/modelos/'.$modelo.'.php');
	  return new $modelo();
  }

  /// \fn vista Imprime la vista con sus parámetros
  public function vista($vista, $datos=[])
  {
    if (file_exists("../app/vistas/".$vista.".php")) {
	    require_once("../app/vistas/".$vista.".php");
	  } else {
	    die("La vista no existe");
	  }
  }

}
