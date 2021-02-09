<?php

class Validar {
  private $resultado = false;

  function __construct() {
  }

  function email($valor) {
    if (!empty($valor) && strlen($valor) < 100 &&
    filter_var($valor, FILTER_VALIDATE_EMAIL)) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }

  function contraseña($valor) {
    if (!empty($valor) && strlen($valor) > 5 && strlen($valor) < 13) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }

  function texto($valor) {
    $regexp = array("options"=>array("regexp"=>"/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]/"));

    if (!empty($valor) && filter_var($valor, FILTER_VALIDATE_REGEXP, $regexp)) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }

  function usuario($valor) {
    $regexp = array("options"=>array("regexp"=>"/[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s-]/"));

    if (!empty($valor) && filter_var($valor, FILTER_VALIDATE_REGEXP, $regexp)) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }
}

?>
