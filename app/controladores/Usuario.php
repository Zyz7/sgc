<?php

class Usuario extends Controlador {
  private $modelo;
  private $validar;

  function __construct() {
    //$this->modelo = $this->modelo("LoginModelo");
    $this->validar = new Validar();
  }

  function caratula() {
    $datos = ["RUTA" => RUTA, "titulo" => "Usuario", "error" => ""];
    $this->vista("usuarioVista", $datos);
  }

}

?>
