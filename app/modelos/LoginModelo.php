<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/*
 * \class LoginModelo
 * \brief Se crean y ejecutan las consultas a la base de datos
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class LoginModelo 
{
  private $db;
  private $phpmailer;
  private $resultado;

  function __construct() {
    $this->db = new MysqlConexion();
    $this->phpmailer = new PHPMailer();
  }

  /// \fn registrate Crea un nuevo usuario
  function registrate($valores) 
  {
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

  /// \fn validarEmail Valida que no exista el email que se desea registrar
  function validarEmail($email) 
  {
    $this->resultado = false;
    $consulta = "select email from usuarios where email='".$email."'";
    $valores = $this->db->consulta($consulta);

    if ($valores["email"] == NULL) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

  /// \fn autenticar Verifica las credenciales contra la base de datos
  function autenticar($valores) 
  {
    $this->resultado = false;
    $consulta = "select clave from usuarios where email='".$valores["email"]."'";
    $valoresConsulta = $this->db->consulta($consulta);

    if (password_verify($valores["contraseña"], $valoresConsulta["clave"])) {
      $this->resultado = true;
    }
 
    return $this->resultado;
  }

  /// \fn enviarEmail Envía un correo electrónico mediante gmail con phpmailer
  function enviarEmail($email) 
  {
    $this->resultado = false;
    //datos de la cuenta de Gmail
    $this->phpmailer->Username = "zyzstfwr@gmail.com";
    $this->phpmailer->Password = "jrBSz$7W";

    // $phpmailer->SMTPDebug = 1;
    $this->phpmailer->SMTPSecure = 'tls';
    $this->phpmailer->Host = "smtp.gmail.com";
    //puerto 587 requiere tls
    $this->phpmailer->Port = 587;
    $this->phpmailer->isSMTP();
    $this->phpmailer->SMTPAuth = true;

    $this->phpmailer->setFrom($this->phpmailer->Username,"SGC");
    $this->phpmailer->addAddress($email);

    $this->phpmailer->CharSet = "utf-8";
    $this->phpmailer->Subject = "Restablecer contraseña";
    $this->phpmailer->Body .="<h1>Restablecer contraseña</h1>";
    $this->phpmailer->Body .= "<p>Da clic en el siguiente enlace:</p>";
    $this->phpmailer->Body .= "<p><a href='https://sgcphp.herokuapp.com/login/recuperar/".
      $email."'>Restablecer</a></p>";
    $this->phpmailer->isHTML(true);

    if ($this->phpmailer->send()) {
      $this->resultado = true;
    }
    return $this->resultado;
  }
  
  ///  \fn recuperarContraseña Actualiza la contraseña
  function recuperarContraseña($valores) 
  {
    $this->resultado = false;
    $hash = password_hash($valores["contraseña"], PASSWORD_BCRYPT);
    
    $consultaId = "select id from usuarios where email='".$valores["email"]."'";
    $id = $this->db->consulta($consultaId);
    $consulta = "update usuarios set clave='".$hash."' ";
    $consulta.= "where id='".$id."'";

    if ($this->db->consultaBooleano($consulta)) {
      $this->resultado = true;
    }
    return $this->resultado;
  }

}
