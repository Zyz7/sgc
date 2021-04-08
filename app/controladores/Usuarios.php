<?php

/*
 * \class Usuarios
 * \brief Muestra la información de los usuarios
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Usuarios extends Controlador
{
  private $modelo;
  private $validar;

  function __construct()
  {
    $this->modelo = $this->modelo("UsuariosModelo");
    $this->validar = new Validar();
  }

  /// \fn caratula
  function caratula($email)
  {
    session_start();
    $usuario = $this->modelo->usuario(base64_decode($email));
    $usuarios = $this->modelo->listaUsuarios();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Usuarios', 'email' => $email,
      'usuario' => $usuario['usuario'], 'error' => ''];

      $datos['usuario0'] = $usuarios[0]['usuario'];
      $datos['nombre0'] = $usuarios[0]['nombre'];
      $datos['apellido0'] = $usuarios[0]['apellido'];
      $datos['email0'] = $usuarios[0]['email'];

      $this->vista('usuariosVista', $datos);
    } else {
      $datos['error'] = 'No se encontró la sesión';
      header('Location:'.RUTA.'login');
    }
  }

}
