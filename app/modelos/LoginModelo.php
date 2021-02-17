<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class LoginModelo {
  private $db;
  private $phpmailer;
  private $resultado;

  //Instancia la clase MysqlConexion de la carpeta app/librerias
  function __construct() {
    $this->db = new MysqlConexion();
    $this->phpmailer = new PHPMailer();
  }

  function registrate($valores) {
    $this->resultado = false;
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
      $this->resultado = true;
    }
    return $this->resultado;
  }

  function validarEmail($email) {
    $this->resultado = false;
    $consulta = "select email from usuarios where email='".$email."'";
    $valores = $this->db->consulta($consulta);

    if ($valores["email"] == NULL) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  function autenticar($valores) {
    $this->resultado = false;
    $consulta = "select clave from usuarios where email='".$valores["email"]."'";
    $valoresConsulta = $this->db->consulta($consulta);

    //if ($valoresConsulta["email"] != NULL) {
      if (password_verify($valores["contraseña"], $valoresConsulta["clave"])) {
        $this->resultado = true;
      }
    //}
    return $this->resultado;
  }

  function enviarEmail($email) {
    $this->resultado = false;
    //datos de la cuenta de Gmail
    $this->phpmailer->Username = "zyzstfwr@gmail.com";
    $this->phpmailer->Password = "jrBSz$7W";

    // $phpmailer->SMTPDebug = 1;
    $this->phpmailer->SMTPSecure = 'tls';
    $this->phpmailer->Host = "smtp.gmail.com";
    //puerto 587 requiere tls
    $this->phpmailer->Port = 587;
    $this->phpmailer->IsSMTP();
    $this->phpmailer->SMTPAuth = true;

    $this->phpmailer->setFrom($this->phpmailer->Username,"SGC");
    $this->phpmailer->AddAddress($email);

    $this->phpmailer->Subject = "Restablecer contraseña";
    $this->phpmailer->Body .="<h1>Restablecer contraseña</h1>";
    $this->phpmailer->Body .= "<p>Da clic en el siguiente enlace:</p>";
    $this->phpmailer->Body .= "<p><a href='https://sgcphp.herokuapp.com/login/recuperar/".
      $email."'>Restablecer</a></p>";
    $this->phpmailer->IsHTML(true);

    if ($this->phpmailer->Send()) {
      $this->resultado = true;
    }
    return $this->resultado;
  }
  
  function recuperarContraseña($valores) {
    $this->resultado = false;
    $hash = password_hash($valores["contraseña"], PASSWORD_BCRYPT);
    
    $consulta = "update usuarios set clave='".$hash."' ";
    $consulta.= "where email='".$valores["email"]."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

}

?>
