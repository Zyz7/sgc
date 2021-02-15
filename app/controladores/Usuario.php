<?php

class Usuario extends Controlador {
  private $modelo;
  private $validar;

  function __construct() {
    //$this->modelo = $this->modelo("LoginModelo");
    $this->validar = new Validar();
  }

  function caratula($usuario) {
    $datos = ["RUTA" => RUTA, "titulo" => "Usuario", "usuario" => $usuario];
    $this->vista("usuarioVista", $datos);
  }

}

?>
