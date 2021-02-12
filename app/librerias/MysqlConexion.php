<?php

class MysqlConexion {

  private $host = "eu-cdbr-west-03.cleardb.net";
  private $usuario = "b1c91617573beb";
  private $clave = "7553b48e";
  private $db = "heroku_beecda265392686";
  private $puerto = ""; //Windows necesita el puerto
  private $conexion;

  function __construct() {
    $this->conexion = mysqli_connect($this->host, $this->usuario, $this->clave,
      $this->db);

    //si falla la prueba de conexión se desconecta
    if (mysqli_connect_errno()) {
      exit();
    }

    //si no se establen los caracteres utf8 se desconecta
    if (!mysqli_set_charset($this->conexion, "utf8")) {
      exit();
    }
  }

  //regresa un valor
  function consulta($consulta) {
    $valor = array();
    $resultado = mysqli_query($this->conexion, $consulta);

	  if($resultado) {
      $valor = mysqli_fetch_assoc($consulta_mysql);
	  }

    return $valor;
  }

  //Regresa varios valores
  function consultas($consulta) {
    $valores = array();
    $resultado = mysqli_query($this->conexion, $consulta);

	  if ($resultado) {
		  while ($row = mysqli_fetch_assoc($consulta_mysql)) {
        array_push($valores, $row);
      }
	  }

    return $valores;
  }

  //Regresa un valor booleano
  function consultaBooleano($consulta) {
    $resultado = mysqli_query($this->conexion, $consulta);

    return $resultado;
  }

}

?>
