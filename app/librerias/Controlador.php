<?php

/*
 * \class Controlador
 * \brief Instancia el modelo e imprime la vista
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Controlador
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
    if (file_exists('../app/vistas/'.$vista.'.html')) {
	    $template = file_get_contents('../app/vistas/'.$vista.'.html');

	    /// Sustituye los parámetros por su variable de la forma {valor}
      foreach ($datos as $clave => $valor) {
        $template = str_replace('{'.$clave.'}', $valor, $template);
      }
      print $template;
	  } elseif (file_exists('../app/vistas/'.$vista.'.php')) {
      $template = file_get_contents('../app/vistas/'.$vista.'.php');

	    /// Sustituye los parámetros por su variable de la forma {valor}
      foreach ($datos as $clave => $valor) {
        $template = str_replace('{'.$clave.'}', $valor, $template);
      }
      print $template;
    } else {
	    die('La vista no existe');
	  }
  }

}
