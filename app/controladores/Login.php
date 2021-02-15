<?php

class Login extends Controlador {
  private $modelo;
  private $validar;

  function __construct() {
    $this->modelo = $this->modelo("LoginModelo");
    $this->validar = new Validar();
  }

  function caratula() {
    $datos = ["RUTA" => RUTA, "titulo" => "Iniciar sesión", "error" => ""];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->email($email) && $this->validar->contraseña($contraseña)) {
        if ($this->modelo->autenticar($valores)) {
          session_start();
          //session_regenerate_id();
          $_SESSION[$email] = $email;
          header("Location:".RUTA."usuario/".$email);
        } else {
          $datos["error"] = "Correo o contraseña incorrectos";
      	  $this->vista("loginVista", $datos);
        }
      } else {
        $datos["error"] = "Correo o contraseña inválidos";
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
      $valores = ["nombre" => $nombre, "apellido" => $apellido,
      "usuario" => $usuario, "email" => $email, "contraseña" => $contraseña];

      if ($this->validar->texto($nombre) && $this->validar->texto($apellido) &&
      $this->validar->usuario($usuario) && $this->validar->email($email) &&
      $this->validar->contraseña($contraseña)) {
        if ($this->modelo->validarEmail($email)) {
          if ($this->modelo->registrate($valores)) {
            $datos["acierto"] = "Registro completado";
          } else {
            $datos["error"] = "Error al guardar los datos";
          }
        } else {
          $datos["error"] = "Error el correo ya esta registrado";
        }
      } else {
        $datos["error"] = "errores en el formulario";
        if (!$this->validar->texto($nombre)) {
          $datos["errorNombre"] = "Sólo ingrese letras menores a 25 carácteres";
        }
        if (!$this->validar->texto($apellido)) {
          $datos["errorApellido"] = "Sólo ingrese letras menores a 25 carácteres";
        }
        if (!$this->validar->usuario($usuario)) {
          $datos["errorUsuario"] = "Sólo letras y números menores a 15 carácteres";
        }
        if (!$this->validar->email($email)) {
          $datos["errorCorreo"] = "Debe de tener el formato nombre@dominio.extension";
        }
        if (!$this->validar->contraseña($contraseña)) {
          $datos["errorContraseña"] = "Debe de tener mínimo 6 carácteres";
        }
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
        if (!$this->modelo->validarEmail($email)) {
          if ($this->modelo->enviarEmail($email)) {
            $datos["acierto"] = "Correo enviado a ".$email;
          } else {
            $datos["error"] = "No se pudo enviar el correo";
          }
        } else {
          $datos["error"] = "El correo no se encuentra registrado";
        }
      } else {
        $datos["errorCorreo"] = "Debe de tener el formato nombre@dominio.extension";
      }
    }
    $this->vista("restablecerVista", $datos);
  }

  function recuperar($email) {
    $datos = ["RUTA" => RUTA, "titulo" => "Restablecer", "error" => "",
    "acierto" => "", "email" => $email];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $contraseña = $_POST['contraseña'];
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->contraseña($contraseña)) {
        if ($this->modelo->recuperarContraseña($valores)) {
          $datos["acierto"] = "Se ha restablecido la contraseña";
        }
      } else {
        $datos["error"] = "Debe de tener mínimo 6 carácteres";
      }
    }
    $this->vista("recuperarContraseñaVista", $datos);
  }
  
  function salir($usuario) {
    session_start();
    unset($_SESSION[$usuario]);
    session_destroy();
    header("Location:".RUTA);
  }

}

?>
