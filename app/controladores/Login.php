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
      $usuario = $_POST('usuario');
      $contraseña = $_POST('contraseña');
      $valores = ["usuario" => $usuario, "contraseña" => $contraseña];

      if ($this->validar->usuario($valores) &&
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
      $datos = ["titulo" => "Iniciar sesión"];
  	  $this->vista("loginVista", $datos);
    }
  }

}

?>
