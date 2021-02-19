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
      $datos = ["RUTA" => RUTA, "titulo" => "Usuario", "usuario" => $usuario];
      $this->vista("usuarioVista", $datos);
    } else {
      header("Location:".RUTA);
    }
  }

}
