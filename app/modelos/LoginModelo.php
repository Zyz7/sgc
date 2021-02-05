<?php

class LoginModelo {
  private $db;

  //Instancia la clase MysqlConexion de la carpeta app/librerias
  function __construct() {
    $this->db = new MysqlConexion();
  }

}

?>
