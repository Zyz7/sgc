<?php

class LoginModelo {
  private $db;
  private $phpmailer;
  private $resultado = false;

  //Instancia la clase MysqlConexion de la carpeta app/librerias
  function __construct() {
    $this->db = new MysqlConexion();
    $this->phpmailer = new PHPMailer();
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
    //datos de la cuenta de Gmail
    $this->phpmailer->Username = "zyzstfwr@gmail.com";
    $this->phpmailer->Password = "jrBSz$7W";

    // $phpmailer->SMTPDebug = 1;
    $this->phpmailer->SMTPSecure = 'ssl';
    $this->phpmailer->Host = "smtp.gmail.com";
    $this->phpmailer->Port = 587;
    $this->phpmailer->IsSMTP();
    $this->phpmailer->SMTPAuth = true;

    $this->phpmailer->setFrom($phpmailer->Username,"SGC");
    $this->phpmailer->AddAddress($email);

    $this->phpmailer->Subject = "Restablecer contraseña";
    $this->phpmailer->Body .="<h1>Restablecer contraseña</h1>";
    $this->phpmailer->Body .= "<p>Da clic en el siguiente enlace:</p>";
    $this->phpmailer->Body .= "<p><a href='https://sgcphp.herokuapp.com/login/recuperar/".
      $email."'>Restablecer</a></p>";
    $this->phpmailer->IsHTML(true);

    if ($this->phpmailer->Send()) {
      $this->$resultado = true;
    }
    return $this->$resultado;
  }

}

?>
