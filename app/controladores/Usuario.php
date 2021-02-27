<?php

/*
 * \class Usuario
 * \brief 
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Usuario extends Controlador 
{
  private $modelo;
  private $validar;

  function __construct() 
  {
    //$this->modelo = $this->modelo("LoginModelo");
    //$this->validar = new Validar();
  }

  /// \fn caratula
  function caratula($usuario) 
  {
    session_start();
    if (isset($_SESSION[$usuario])) {
      $datos = ["RUTA" => RUTA, "titulo" => "Inicio", "usuario" => $usuario];
      $this->vista("usuarioVista", $datos);
    } else {
      header("Location:".RUTA);
    }
  }
  
  /// \fn editar
  function editar($usuario) 
  {
    session_start();
    if (isset($_SESSION[$usuario])) {
      $datos = ["RUTA" => RUTA, "titulo" => "Editar", "usuario" => $usuario, 
      "error" => "", "acierto" => ""];
      
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	      if (isset($_FILES['imagen']) && 
	      $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
		      if ($this->validar->imagen($_FILES['imagen'])) {
		        if(move_uploaded_file($_FILES['imagen']['tmp_name'], 
		        RUTA.'img/logo_'.$usuario.'.'.$_FILES['imagen']['type']) {
			        $datos["acierto"] = "Imagen guardada";
			      } else {
			        $datos["error"] = "No se pudo guardar la imagen";
			      }
		      }
		    }
	    }
      $this->vista("usuarioEditarVista", $datos);
    } else {
      header("Location:".RUTA);
    }
  }

}
