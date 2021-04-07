<?php

/*
 * \class UsuarioModelo
 * \brief Se crean y ejecutan las consultas a la base de datos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class UsuariosModelo
{
  private $db;
  private $resultado;

  function __construct()
  {
    $this->db = new MysqlConexion();
  }

  /// \fn usuario Obtiene el pseudónimo del usuario
  function usuario($email)
  {
    $consulta = "select usuario from usuarios where email='".$email."'";
    $valor = $this->db->consulta($consulta);
    return $valor;
  }

  /// \fn listaUsuarios Obtiene la lista de los usuarios
  function listaUsuarios()
  {
    $consulta = "select * from usuarios";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

}
