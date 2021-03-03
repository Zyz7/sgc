<?php

/*
 * \class Login
 * \brief Realiza la gestión de iniciar sesión
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Login extends Controlador
{
  private $modelo;
  private $validar;

  function __construct()
  {
    $this->modelo = $this->modelo("LoginModelo");
    $this->validar = new Validar();
  }

  /// \fn caratula Obtiene y verifica las credenciales
  function caratula()
  {
    $datos = ["RUTA" => RUTA, "titulo" => "Iniciar sesión", "error" => ""];

    if ($this->modelo->validarAdmin()) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $valores = ["email" => $email, "contraseña" => $contraseña];

        if ($this->validar->email($email) && $this->validar->contraseña($contraseña)) {
          if ($this->modelo->autenticar($valores)) {
  	        $usuario = $this->modelo->usuario($email);
            session_start();
            //session_regenerate_id();
            $_SESSION[$email] = $email;
            header("Location:".RUTA."usuario/".$_SESSION[$email]);
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
    } else {
      header("Location:".RUTA."login/registrate");
    }
  }

  /// \fn registrate Guarda un nuevo usuario en la base de datos
  function registrate()
  {
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
          $datos["error"] = "El correo ya se encuentra registrado";
        }
      } else {
        $total = 0;
        if (!$this->validar->texto($nombre)) {
          $total++;
          $datos["errorNombre"] = "Ingrese sólo letras menores a 25 carácteres";
        }
        if (!$this->validar->texto($apellido)) {
          $total++;
          $datos["errorApellido"] = "Ingrese sólo letras menores a 25 carácteres";
        }
        if (!$this->validar->usuario($usuario)) {
          $total++;
          $datos["errorUsuario"] = "Sólo letras y números menores a 15 carácteres";
        }
        if (!$this->validar->email($email)) {
          $total++;
          $datos["errorCorreo"] = "Debe de tener el formato nombre@dominio.extension";
        }
        if (!$this->validar->contraseña($contraseña)) {
          $total++;
          $datos["errorContraseña"] = "Debe de tener mínimo 6 carácteres";
        }
        if ($total == 1) {
		      $datos["error"] = $total." error en el formulario";
		    } else {
          $datos["error"] = $total." errores en el formulario";
	      }
      }
    }
    $this->vista("registrateVista", $datos);
  }

  /// \fn restablecer Se envía un correo para restablecer la contraseña
  function restablecer()
  {
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
          $datos["error"] = "Ingrese un correo que este registrado";
        }
      } else {
        $datos["errorCorreo"] = "Debe de tener el formato nombre@dominio.extension";
      }
    }
    $this->vista("restablecerVista", $datos);
  }

  /// \fn recuperar Se actualiza la contraseña en la base de datos
  function recuperar($email)
  {
    $datos = ["RUTA" => RUTA, "titulo" => "Restablecer", "error" => "",
    "acierto" => "", "email" => $email];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $contraseña = $_POST['contraseña'];
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->contraseña($contraseña)) {
        if ($this->modelo->recuperarContraseña($valores)) {
          $datos["acierto"] = "Se ha restablecido la contraseña";
        } else {
          $datos["error"] = "No se pudo restablecer la contraseña";
        }
      } else {
        $datos["error"] = "Debe de tener mínimo 6 carácteres";
      }
    }
    $this->vista("recuperarContraseñaVista", $datos);
  }

  /// \fn salir Termina la sesión y regresa a la página del login
  function salir($usuario)
  {
    session_start();
    unset($_SESSION[$usuario]);
    session_destroy();
    header("Location:".RUTA);
  }

}

?>
