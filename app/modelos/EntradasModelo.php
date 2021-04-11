<?php

/*
 * \class EntradasModelo
 * \brief Se crean y ejecutan las consultas a la base de datos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class EntradasModelo
{
  private $db;
  private $resultado;

  function __construct()
  {
    $this->db = new MysqlConexion();
  }

  /// \fn datosUsuario Obtiene todos los datos del usuario
  function datosUsuario($email)
  {
    $consulta = "select * from usuarios where email='".$email."'";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

  /// \fn listaUsuarios Obtiene la lista de los usuarios
  function listaEntradas()
  {
    $consulta = "select * from entradas";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

}
