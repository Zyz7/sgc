<?php

class LoginModelo {
  private $db;
  private $resultado = false;

  //Instancia la clase MysqlConexion de la carpeta app/librerias
  function __construct() {
    $this->db = new MysqlConexion();
  }

  function registrate($valores) {
    $hash = password_hash($valores["contraseña"], PASSWORD_BCRYPT);

    $consulta = "insert into usuarios values(";
    $consulta.= "'".$valores["nombre"]."', ";
    $consulta.= "'".$valores["apellido"]."', ";
    $consulta.= "'".$valores["usuario"]."', ";
    $consulta.= "'".$valores["email"]."', ";
    $consulta.= "'".$hash."', ";
    $consulta.= "'', ";
    $consulta.= "'Activo')";

    if ($this->db->consultaBooleano($consulta)) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }
  
  function autenticar($valores) {
    $consulta = "select * from usuarios where email='".$valores["email"]."'";
    
    if ($this->db->consultaBooleano($consulta)) {
      $valoresConsulta = $this->db->consultas($consulta)
      if (password_verify($valores["contraseña"], $valoresConsulta["clave"])) {
        $this->$resultado = true;
      }
    } 
    return $this->$resultado;
  }

}

?>
