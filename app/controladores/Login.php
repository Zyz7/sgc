<?php

class Login extends Controlador {
  private $modelo;
  private $validar;

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
    $this->validar = $this->validar();
  }

  function caratula() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST('email');
      $contraseña = $_POST('contraseña');
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->email($valores) &&
        $this->validar->contraseña($valores)) {
        if ($this->modelo->autenticar($valores)) {
          //inicia sesión con éxito
        } else {
          $datos = ["titulo" => "Iniciar sesión", "error" =>
          "Correo eletrónico o contraseña incorrectos"];
      	  $this->vista("loginVista", $datos);
        }
      } else {
        $datos = ["titulo" => "Iniciar sesión", "error" =>
        "Correo eletrónico o contraseña inválidos"];
        $this->vista("loginVista", $datos);
      }
    } else {
      $datos = ["titulo" => "Iniciar sesión", "error" => ""];
  	  $this->vista("loginVista", $datos);
    }
  }
  
  function registrate() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nombre = $_POST('nombre');
      $apellido = $_POST('apellido');
      $usuario = $_POST('usuario');
      $email = $_POST('email');
      $contraseña = $_POST('contraseña');
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->email($valores) &&
        $this->validar->contraseña($valores)) {
        
      } else {
        $datos = ["titulo" => "Iniciar sesión", "error" =>
        "Correo eletrónico o contraseña inválidos"];
        $this->vista("loginVista", $datos);
      }
    } else {
      $datos = ["titulo" => "Registrate", "error" => ""];
  	  $this->vista("registrateVista", $datos);
    }
  }
  
  function restablecer {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST('email');
      $valores = ["email" => $email];

      if ($this->validar->email($valores)) {
        
      } else {
        $datos = ["titulo" => "Iniciar sesión", "error" =>
        "Correo eletrónico o contraseña inválidos"];
        $this->vista("loginVista", $datos);
      }
    } else {
      $datos = ["titulo" => "Restablecer", "error" => ""];
  	  $this->vista("restablecerVista", $datos);
    }
  }

}

?>
