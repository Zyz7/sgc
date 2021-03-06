<?php

/*
 * \class AdminModelo
 * \brief Se crean y ejecutan las consultas a la base de datos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class AdminModelo
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

  /// \fn datosUsuario Obtiene todos los datos del usuario
  function datosUsuario($email)
  {
    $consulta = "select * from usuarios where email='".$email."'";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

  /// \fn validarEmail Valida que no exista el email que se desea guardar
  function validarEmail($email)
  {
    $this->resultado = false;
    $consulta = "select email from usuarios where email='".$email."'";
    $valores = $this->db->consulta($consulta);

    if ($email == $valores['email']) {
      $this->resultado = true;
    } elseif (empty($valores)) {
      $this->resultado = true;
    }

    return $this->resultado;
  }

  /// \fn actualizar Actualiza los datos del usuario
  function actualizar($valores)
  {
    $this->resultado = false;

    $consultaId = "select id from usuarios where email='".$valores["email"]."'";
    $id = $this->db->consulta($consultaId);
    $consulta = "update usuarios set ";
    $consulta.= "nombre='".$valores["nombre"]."', ";
    $consulta.= "apellido='".$valores["apellido"]."', ";
    $consulta.= "usuario='".$valores["usuario"]."', ";
    $consulta.= "email='".$valores["correo"]."', ";
    $consulta.= "imagen='".$valores["imagen"]."' ";
    $consulta.= "where id='".$id['id']."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn validarContraseña Valida la contraseña del administrador
  function validarContraseña($valores)
  {
    $this->resultado = false;
    $consulta = "select clave from usuarios where email='".$valores["email"]."'";
    $valor = $this->db->consulta($consulta);

    if (password_verify($valores['contraseña'], $valor['clave'])) {
      $this->resultado = true;
    }

    return $this->resultado;
  }

  /// \fn cambiarContraseña Actualiza la contraseña del usuario
  function cambiarContraseña($valores)
  {
    $this->resultado = false;
    $hash = password_hash($valores['nuevaContraseña'], PASSWORD_BCRYPT);

    $consultaId = "select id from usuarios where email='".$valores["email"]."'";
    $id = $this->db->consulta($consultaId);
    $consulta = "update usuarios set ";
    $consulta.= "clave='".$hash."' ";
    $consulta.= "where id='".$id['id']."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn eliminar Cambia el estado del usuario a 0
  function eliminar($valores)
  {
    $this->resultado = false;

    $consultaId = "select id from usuarios where email='".$valores["email"]."'";
    $id = $this->db->consulta($consultaId);
    $consulta = "update usuarios set ";
    $consulta.= "estado='0' ";
    $consulta.= "where id='".$id['id']."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn listaOperadores Obtiene la lista de los operadores
  function listaOperadores()
  {
    $consulta = "select * from operadores where estado=1";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

  /// \fn crearOperador Crea un nuevo usuario operador
  function crearOperador($valores)
  {
    $this->resultado = false;
    $hash = password_hash($valores['contraseña'], PASSWORD_BCRYPT);

    $consulta = "insert into operadores values(0, ";
    $consulta.= "'".$valores["nombre"]."', ";
    $consulta.= "'".$valores["apellido"]."', ";
    $consulta.= "'".$valores["usuario"]."', ";
    $consulta.= "'".$valores["email"]."', ";
    $consulta.= "'".$hash."', ";
    $consulta.= "'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png', ";
    $consulta.= "'', ";
    $consulta.= "1)";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn datosOperador Obtiene todos los datos del usuario operador
  function datosOperador($id)
  {
    $consulta = "select * from operadores where id='".$id."'";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

  /// \fn actualizarOperador Actualiza los datos del usuario operador
  function actualizarOperador($valores)
  {
    $this->resultado = false;

    $consulta = "update operadores set ";
    $consulta.= "nombre='".$valores["nombre"]."', ";
    $consulta.= "apellido='".$valores["apellido"]."', ";
    $consulta.= "usuario='".$valores["usuario"]."', ";
    $consulta.= "email='".$valores["correo"]."', ";
    $consulta.= "imagen='".$valores["imagen"]."' ";
    $consulta.= "where id='".$valores["id"]."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn eliminar Cambia el estado del usuario operador a 0
  function eliminarOperador($id)
  {
    $this->resultado = false;

    $consulta = "update operadores set ";
    $consulta.= "estado='0' ";
    $consulta.= "where id='".$id."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn listaAdministradores Obtiene la lista de los administradores
  function listaAdministradores()
  {
    $consulta = "select * from usuarios where estado=1";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

  /// \fn datosAdministrador Obtiene todos los datos del administrador
  function datosAdministrador($id)
  {
    $consulta = "select * from usuarios where id='".$id."'";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

  /// \fn listaActividad Obtiene registro de los dispositivos
  function listaActividad()
  {
    $consulta = "select * from actividad order by id desc";
    $valores = $this->db->consultas($consulta);
    return $valores;
  }

}
