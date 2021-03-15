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
    $this->validar = new Validar();
  }

  /// \fn caratula
  function caratula($usuario)
  {
    session_start();
    if (isset($_SESSION[$usuario])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Inicio', 'usuario' => $usuario];
      $this->vista('usuarioVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn editar
  function editar($usuario)
  {
    session_start();
    if (isset($_SESSION[$usuario])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Editar', 'usuario' => $usuario,
      'error' => '', 'acierto' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	      if (isset($_FILES['imagen']) &&
	      $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
		      $valores = ["tmp_name" => $_FILES['imagen']['tmp_name'],
			  "name" => $_FILES['imagen']['name'], "size" =>
			  $_FILES['imagen']['size'], "type" =>
			  $_FILES['imagen']['type']];
			  $name_campos = explode(".", $valores['name']);
			  $ext = strtolower(end($name_campos));

		      if ($this->validar->imagen($valores)) {
		        if (move_uploaded_file($valores['tmp_name'], './img/logo_'.
			        $usuario.'.'.$ext)) {
			        $datos['acierto'] = 'Imagen guardada';
			      } else {
			        $datos['error'] = 'No se pudo guardar la imagen';
			      }
		      } else {
				$datos['error'] = 'Imagen inválida';
			  }
		    }
	    }
      $this->vista('usuarioEditarVista', $datos);
    } else {
      header('Location:'.RUTA);
    }
  }

}
