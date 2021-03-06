<?php

/*
 * \class Validar
 * \brief Valida que los datos contengan carácteres permitidos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Validar
{
  private $resultado;

  function __construct()
  {
  }

  /// \fn email Valida la dirección del correo electrónico
  function email($valor)
  {
    $this->resultado = false;

    if (!empty($valor)) {
     if (filter_var($valor, FILTER_VALIDATE_EMAIL)) {
        $this->resultado = true;
      }
    }
    return $this->resultado;
  }

  /// \fn contraseña Valida la contraseña
  function contraseña($valor)
  {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match('/[!-~]{6,12}/', $valor)) {
        $this->resultado = true;
      }
    }
    return $this->resultado;
  }

  /// \fn email Valida los datos que sólo deben de contener letras
  function texto($valor)
  {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match('/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,25}/', $valor)) {
        if (!preg_match('/[0-9]/', $valor)) {
          $this->resultado = true;
        }
      }
    }
    return $this->resultado;
  }

  /// \fn email Valida los nombres de usuario
  function usuario($valor)
  {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match('/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s0-9]{2,15}/', $valor)) {
        if (!preg_match('/[!-\/:-@[-`{-~]/', $valor)) {
          $this->resultado = true;
        }
      }
    }
    return $this->resultado;
  }

  /// \fn url Valida la dirección url
  function url($valor)
  {
    $this->resultado = false;

    if (!empty($valor)) {
     if (filter_var($valor, FILTER_VALIDATE_URL)) {
        $this->resultado = true;
      }
    }
    return $this->resultado;
  }

  /// \fn contenido Valida el contenido de una entrada
  function contenido($valor)
  {
    $this->resultado = false;

    if (!empty($valor)) {
      if (preg_match('/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s0-9!-\/:-@[-`{-~]/', $valor)) {
        if (!preg_match('/[<>]/', $valor)) {
          $this->resultado = true;
        }
      }
    }
    return $this->resultado;
  }

}
