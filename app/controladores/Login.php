<?php

class Login extends Controlador {
  private $modelo;
  private $validar;

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
    $this->validar = $this->validar();
  }

  function caratula() {
    $datos = ["RUTA" => RUTA, "titulo" => "Iniciar sesión", "error" => ""];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->email($email) && $this->validar->contraseña($contraseña)) {
        if ($this->modelo->autenticar($valores)) {
          //inicia sesión con éxito
        } else {
          $datos["error"] = "Correo eletrónico o contraseña incorrectos";
      	  $this->vista("loginVista", $datos);
        }
      } else {
        $datos["error"] = "Correo eletrónico o contraseña inválidos";
        $this->vista("loginVista", $datos);
      }
    } else {
  	  $this->vista("loginVista", $datos);
    }
  }

  function registrate() {
    $datos = ["RUTA" => RUTA, "titulo" => "Registrate", "error" => "",
    "errorNombre" => "", "errorApellido" => "", "errorUsuario" => "",
    "errorCorreo" => "", "errorContraseña" => "", "acierto" => ""];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $usuario = $_POST['usuario'];
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      $valores = ["nombre" => $nombre, "apellido" => $apellidos,
      "usuario" => $usuario, "email" => $email, "contraseña" => $contraseña];

      if ($this->validar->texto($nombre) && $this->validar->texto($apellido) &&
      $this->validar->usuario($usuario) && $this->validar->email($email) &&
      $this->validar->contraseña($contraseña)) {
        if ($this->modelo->registrate($valores)) {
          $datos["acierto"] = "Registro completado";
        } else {
          $datos["error"] = "Error al intentar guardar los datos";
        }
      } else {
        $datos["error"] = "errores en el formulario";
      }
    }
    $this->vista("registrateVista", $datos);
  }

  function restablecer() {
    $datos = ["RUTA" => RUTA, "titulo" => "Restablecer", "error" => "",
    "errorCorreo" => "", "acierto" => ""];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];

      if ($this->validar->email($email)) {
        if ($this->modelo->enviarEmail($email)) {
          $datos["acierto"] = "El correo eletrónico ha sido enviado a ".$email;
        } else {
          $datos["error"] = "El correo eletrónico no esta registrado";
        }
      } else {
        $datos["errorCorreo"] = "Correo eletrónico inválido";
      }
    }
    $this->vista("restablecerVista", $datos);
  }

  function recuperar($email) {
    $datos = ["RUTA" => RUTA, "titulo" => "Recuperar", "error" => "",
    "errorContraseña" => "", "acierto" => ""];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $contraseña = $_POST['contraseña'];
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->contraseña($contraseña)) {
        if ($this->modelo->restablecerContraseña($valores)) {
          $datos["acierto"] = "Se ha restablecido la contraseña puede iniciar sesión";
        }
      } else {
        $datos["errorContraseña"] = "Contraseña inválida";
      }
    }
    $this->vista("recuperarContraseñaVista", $datos);
  }

}

?>
