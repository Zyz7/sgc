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

  /// \fn imagen Muestra la imagen de perfil del usuario
  function imagen($email) {
    $email = base64_decode($email);
    $ruta = $this->modelo->imagen($email);
    $imagen = imagecreatefrompng($ruta['imagen']);

    header('Content-type: image/png');
    imagepng($imagen);
    imagedestroy($imagen);
  }

  /// \fn editar Interfaz para editar datos del usuario
  function editar($email)
  {
    session_start();
    $usuario = $this->modelo->usuario(base64_decode($email));
    $valores = $this->modelo->datosUsuario(base64_decode($email));

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Editar usuario', 'email' => $email,
      'usuario' => $usuario['usuario'], 'imagen' => $valores[0]['imagen'],
      'nombre' => $valores[0]['nombre'], 'apellido' => $valores[0]['apellido'],
      'emailForm' => $valores[0]['email'], 'error' => '', 'acierto' => '',
      'errorNombre' => '', 'errorApellido' => '', 'errorUsuario' => '',
      'errorCorreo' => '', 'errorContraseña' => '', 'errorImagen' => '',
      'errorNuevaContraseña' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      }
      $this->vista('usuarioEditarVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

}
