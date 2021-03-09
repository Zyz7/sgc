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
      if (preg_match("/[!-~]{6,12}/", $valor)) {
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
      if (preg_match("/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,25}/", $valor)) {
        if (!preg_match("/[0-9]/", $valor)) {
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
      if (preg_match("/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s0-9]{2,15}/", $valor)) {
        if (!preg_match("/[!-\/:-@[-`{-~]/", $valor)) {
          $this->resultado = true;
        }
      }
    }
    return $this->resultado;
  }

  /// \fn imagen Valida las imagenes
  function imagen($valores)
  {
    $this->resultado = false;
    $extensiones = array('jpg', 'jpeg', 'png');
    $name_campos = explode(".", $valores['name']);
    $ext = strtolower(end($name_campos));

    if (in_array($ext, $extensiones)) {
      if ($valores['size'] < 1000000) {
        $this->resultado = true;
      }
    }
    return $this->resultado;
  }

  /// \fn captcha Valida el texto ingresado para el captcha
  function captcha($valor)
  {
    $this->resultado = false;

    if ($valor == $_SESSION["captcha"]) {
      $this->resultado = true;
    }
    return $this->resultado;
  }
}
