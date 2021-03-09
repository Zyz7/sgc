<?php

/*
 * \class Usuario
 * \brief
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Inicio extends Controlador
{
  private $modelo;
  private $validar;

  function __construct()
  {
    //$this->modelo = $this->modelo("InicioModelo");
    //$this->validar = new Validar();
  }

  /// \fn caratula
  function caratula()
  {
    if ($this->modelo->comprobarEntradas()) {
      $datos = ["RUTA" => RUTA, "titulo" => "Inicio", "plantilla" => ""];
      $this->vista("entradaVista", $datos);
    } else {
      $datos = ["RUTA" => RUTA, "titulo" => "Inicio"];
      $this->vista("inicioVista", $datos);
    }
  }

}
