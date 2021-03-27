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

  /// \fn usuario Obtiene el pseudónimo del usuario
  function usuario($email)
  {
    $consulta = "select usuario from usuarios where email='".$email."'";
    $valor = $this->db->consulta($consulta);
    return $valor;
  }

  /// \fn imagen Obtiene la dirección de la imagen de perfil del usuario
  function imagen($email)
  {
    $consulta = "select imagen from usuarios where email='".$email."'";
    $valor = $this->db->consulta($consulta);
    return $valor;
  }

}
