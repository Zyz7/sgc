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
    $this->modelo = $this->modelo("UsuarioModelo");
    $this->validar = new Validar();
  }

  /// \fn caratula
  function caratula($email)
  {
    session_start();
    $usuario = $this->modelo->usuario(base64_decode($email));

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Inicio', 'email' => $email,
      'usuario' => $usuario['usuario'], 'error' => ''];
      $this->vista('usuarioVista', $datos);
    } else {
      $datos['error'] = 'No se encontró la sesión';
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn imagen
  function imagen($email) {
    $email = base64_decode($email);
    $ruta = $this->modelo->imagen($email);
    $imagen = imagecreatefrompng($ruta['imagen']);

    header('Content-type: image/png');
    imagepng($imagen);
    imagedestroy($imagen);
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
