<?php

/*
 * \class InicioModelo
 * \brief Se crean y ejecutan las consultas a la base de datos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class InicioModelo
{
  private $db;
  private $resultado;

  function __construct()
  {
    $this->db = new MysqlConexion();
  }

  /// \fn comprobarEntradas Comprueba que exista por lo menos una entrada
  function comprobarEntradas()
  {
    $this->resultado = false;

    $consulta = 'select * from entradas';
    $valores = $this->db->consultas($consulta);

    if (strlen($valores) > 0) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

}
