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
	  session_start();

    $input = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $input_length = strlen($input);
    $captcha_string = '';

    for($i = 0; $i < 6; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $captcha_string .= $random_character;
    }

    $_SESSION['captcha'] = $captcha_string;
	  
    $datos = ["RUTA" => RUTA, "titulo" => "Iniciar sesión", "error" => ""];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      $captcha = $_POST['captcha'];
      $valores = ["email" => $email, "contraseña" => $contraseña];

      if ($this->validar->email($email) &&
      $this->validar->contraseña($contraseña) &&
      $this->validar->captcha($captcha)) {
        if ($this->modelo->autenticar($valores)) {
          $usuario = $this->modelo->usuario($email);
          session_start();
          $_SESSION[$email] = $email;
          header("Location:".RUTA."usuario/".$_SESSION[$email]);
        } else {
          $datos["error"] = "Correo o contraseña incorrectos";
          $this->vista("loginVista", $datos);
        }
      } else {
        if (!$this->validar->captcha($captcha)) {
          $datos["error"] = "Captcha incorrecto";
        } else {
          $datos["error"] = "Correo o contraseña inválidos";
        }
        $this->vista("loginVista", $datos);
      }
    } else {
      $this->vista("loginVista", $datos);
    }
  }

  /// \fn captcha Genera el captcha
  function captcha()
  {
    session_start();

    $captcha_string = $_SESSION['captcha'];

    // Crea una nueva imagen en color negro
    $image = imagecreatetruecolor(200, 50);
    // Activa antialias para dibujo rápido
    imageantialias($image, true);
    $colors = [];
    $red = rand(125, 175);
    $green = rand(125, 175);
    $blue = rand(125, 175);

    for($i = 0; $i < 5; $i++) {
      // Crea el color morado para la imagen
      $colors[] = imagecolorallocate($image, $red - 20*$i, $green - 20*$i,
      $blue - 20*$i);
    }

    // Rellena de color morado la imagen
    imagefill($image, 0, 0, $colors[0]);

    for($i = 0; $i < 10; $i++) {
      // Establece el grosor de las líneas
      imagesetthickness($image, rand(2, 10));
      $line_color = $colors[rand(1, 4)];
      // Dibuja los rectangulos
      imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190),
      rand(40, 60), $line_color);
    }

    // Crea el color morado para la imagen
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);
    $textcolors = [$black, $white];

    for($i = 0; $i < 6; $i++) {
      $letter_space = 170/6;
      $initial = 15;
      // Escribe texto en la imagen usando fuentes
      imagettftext($image, 24, rand(-15, 15), $initial + $i*$letter_space,
      rand(25, 45), $textcolors[rand(0, 1)], 'arial_narrow_7.ttf',
      $captcha_string[$i]);
    }

    header('Content-type: image/png');
    imagepng($image);
    imagedestroy($image);
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

  /// \fn salir Termina la sesión y regresa a la página de inicio
  function salir($usuario)
  {
    session_start();
    unset($_SESSION[$usuario]);
    session_destroy();
    header("Location:".RUTA);
  }

}
