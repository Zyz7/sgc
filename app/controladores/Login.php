<?php

class Login extends Controlador {
  private $modelo;
  private $validar;

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
    $this->validar = $this->validar();
  }

  function caratula() {
    $datos = ["titulo" => "Iniciar sesión"];
	  $this->vista("loginVista", $datos);
  }

  function verificar() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $usuario = $_POST('usuario');
      $contraseña = $_POST('contraseña');
      $valores = ["usuario" => $usuario, "contraseña" => $contraseña];

      if ($this->validar->usuario($valores) &&
        $this->validar->contraseña($valores)) {
        if ($this->modelo->verificarLogin($valores)) {

        } else {

        }
      } else {

      }
    }
  }
}

?>
