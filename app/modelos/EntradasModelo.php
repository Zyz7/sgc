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

  /// \fn entrada Agrega una nueva entrada
  function entrada($valores)
  {
    $this->resultado = false;

    $consulta = "insert into entradas values(0, ";
    $consulta.= "'".$valores["titulo"]."', ";
    $consulta.= "'".$valores["subtitulo"]."', ";
    $consulta.= "'".$valores["contenido"]."', ";
    $consulta.= "current_date(), ";
    $consulta.= "current_date(), ";
    $consulta.= "'".$valores["usuario"]."', ";
    $consulta.= "'".$valores["categoria"]."', ";
    $consulta.= "1)";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn validarCategoria Valida que no exista la categoria que se desea guardar
  function validarCategoria($categoria)
  {
    $this->resultado = false;
    $consulta = "select nombre from categorias where nombre='".$categoria."'";
    $valores = $this->db->consulta($consulta);

    if (empty($valores)) {
      $this->resultado = true;
    }

    return $this->resultado;
  }

  /// \fn categoria Agrega una nueva categoria
  function categoria($valores)
  {
    $this->resultado = false;

    $consulta = "insert into categorias values(0, ";
    $consulta.= "'".$valores["categoria"]."', ";
    $consulta.= "1)";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn listaUsuarios Obtiene la lista de las categorias
  function listaCategorias()
  {
    $consulta = "select * from categorias where estado=1";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

}
