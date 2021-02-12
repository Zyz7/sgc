<?php
include "PHPMailer.php";
include "SMTP.php";

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
    $phpmailer = new PHPMailer();

    //datos de la cuenta de Gmail
    $phpmailer->Username = "zyzstfwr@gmail.com";
    $phpmailer->Password = "jrBSz$7W"; 

    // $phpmailer->SMTPDebug = 1;
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->Host = "smtp.gmail.com"; 
    $phpmailer->Port = 587;
    $phpmailer->IsSMTP(); 
    $phpmailer->SMTPAuth = true;

    $phpmailer->setFrom($phpmailer->Username,"SGC");
    $phpmailer->AddAddress($email);

    $phpmailer->Subject = "Restablecer contraseña";	
    $phpmailer->Body .="<h1>Restablecer contraseña</h1>";
    $phpmailer->Body .= "<p>Da clic en el siguiente enlace:</p>";
    $phpmailer->Body .= "<p><a href='https://sgcphp.herokuapp.com/login/recuperar/".
      $email."'>Restablecer</a></p>";
    $phpmailer->IsHTML(true);

    if ($phpmailer->Send()) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }

}

?>
