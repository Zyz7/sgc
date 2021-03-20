<?php

/*
 * \class UsuarioModelo
 * \brief Se crean y ejecutan las consultas a la base de datos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class UsuarioModelo
{
  private $db;
  private $resultado;

  function __construct()
  {
    $this->db = new MysqlConexion();
  }

  /// \fn email Obtiene el email del usuario
  function email($id)
  {
    $consulta = "select email from usuarios where id='".$id."'";
    $valor = $this->db->consulta($consulta);
    return $valor;
  }

  /// \fn imagen Obtiene la dirección de la imagen
  function imagen($usuario)
  {
    $consulta = "select imagen from usuarios where email='".$usuario."'";
    $valor = $this->db->consulta($consulta);
    return $valor;
  }

}
