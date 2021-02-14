<?php

class Validar {
  private $resultado;

  function __construct() {
  }

  function email($valor) {
    $this->resultado = false;

    if (!empty($valor)) {
     if (filter_var($valor, FILTER_VALIDATE_EMAIL)) {
        $this->resultado = true;
      }
    }
    return $this->resultado;
  }

  function contraseña($valor) {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match("/[!-~]{6,12}/", $valor)) {
        $this->resultado = true;
      }
    }
    return $this->resultado;
  }

  function texto($valor) {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match("/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,25}/", $valor)) {
        if (!preg_match("/[0-9]/", $valor)) {
          $this->resultado = true;
        }
      }
    }
    return $this->resultado;
  }

  function usuario($valor) {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match("/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s0-9]{2,15}/", $valor)) {
        if (!preg_match("/[!-\/:-@[-`{-~]/", $valor)) {
          $this->resultado = true;
        }
      }
    }
    return $this->resultado;
  }
}

?>
