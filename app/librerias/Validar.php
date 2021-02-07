<?php

class Validar {
  private $resultado = false;

  function __construct() {
  }

  function email($valores) {
    if (!empty($valores["email"]) && strlen($valores["email"]) < 100 &&
    filter_var($valores["email"], FILTER_VALIDATE_EMAIL)) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }

  function contraseña($valores) {
    if (!empty($valores["contraseña"]) && strlen($valores["contraseña"]) > 5 &&
    strlen($valores["contraseña"]) < 13) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }
}

?>
