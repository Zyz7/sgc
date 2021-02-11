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

    $consulta = "insert into usuarios values(0, ";
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
      $valoresConsulta = $this->db->consultas($consulta);
      if (password_verify($valores["contraseña"], $valoresConsulta["clave"])) {
        $this->$resultado = true;
      }
    }
    return $this->$resultado;
  }

  function enviarEmail($email) {
    $para = "'".$email."'";
    $titulo = 'Restablecer contraseña';
    $mensaje = '
    <html>
      <head>
        <title>Recordatorio de cumpleaños para Agosto</title>
      </head>
      <body>
        <h1>Restablecer contraseña</h1>
        <p>Da click en:</p>
        <a href="https://sgcphp.herokuapp.com/login/recuperar/'.$email.
        "'>restablecer</a>
      </body>
    </html>
    '";
    $cabeceras  = 'MIME-Version: 1.0' . "\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
    $cabeceras .= 'From: SGC <soporte@sgc.com>' . "\n";

    $consulta = "select * from usuarios where email='".$valores["email"]."'";

    //if ($this->db->consultaBooleano($consulta)) {
      if (mail($para, $titulo, $mensaje, $cabeceras)) {
        $this->$resultado = true;
      }
    //}
    return $this->$resultado;
  }

}

?>
