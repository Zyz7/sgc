<?php

/*
 * \class Login
 * \brief Gestiona el inicio de sesión
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Login extends Controlador
{
  private $modelo;
  private $validar;

  function __construct()
  {
    $this->modelo = $this->modelo('LoginModelo');
    $this->validar = new Validar();
  }

  /// \fn caratula Obtiene y verifica las credenciales
  function caratula()
  {
    session_start();
    $datos = ['RUTA' => RUTA, 'titulo' => 'Iniciar sesión', 'error' => ''];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      $captcha = $_POST['captcha'];
      $valores = ['email' => $email, 'contraseña' => $contraseña];

      if ($captcha == $_SESSION['captcha']) {
        if ($this->validar->email($email) &&
        $this->validar->contraseña($contraseña)) {
          if ($this->modelo->autenticar($valores)) {
            if ($this->modelo->estado($email)) {

              $id = $this->modelo->id($email);
              $_SESSION[$email] = $email;
              $this->modelo->actividad();
              header('Location:'.RUTA.'admin/'.base64_encode($email));
            } else {
              $datos['error'] = 'Usuario inactivo';
              $this->vista('loginVista', $datos);
            }
          } else {
            $datos['error'] = 'Correo o contraseña incorrectos';
            $this->vista('loginVista', $datos);
          }
        } else {
          $datos['error'] = 'Correo o contraseña inválidos';
          $this->vista('loginVista', $datos);
        }
      } else {
        $datos['error'] = 'Captcha incorrecto';
        $this->vista('loginVista', $datos);
      }
    } else {
      $this->vista('loginVista', $datos);
    }
  }

  /// \fn captcha Genera la imagen del captcha
  function captcha()
  {
    session_start();

    $entrada = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $largo = strlen($entrada);
    $captcha = '';

    for($i = 0; $i < 6; $i++) {
      // Genera un número aleatorio
      $caracter = $entrada[mt_rand(0, $largo - 1)];
      $captcha .= $caracter;
    }

    $_SESSION['captcha'] = $captcha;

    // Crea una nueva imagen en color negro
    $imagen = imagecreatetruecolor(200, 50);
    // Activa antialias para dibujo rápido
    imageantialias($imagen, true);
    $colores = [];
    $rojo = rand(125, 175);
    $verde = rand(125, 175);
    $azul = rand(125, 175);

    for($i = 0; $i < 5; $i++) {
      // Crea el color morado para la imagen
      $colores[] = imagecolorallocate($imagen, $rojo - 20*$i, $verde - 20*$i,
      $azul - 20*$i);
    }

    // Rellena de color morado la imagen
    imagefill($imagen, 0, 0, $colores[0]);

    for($i = 0; $i < 10; $i++) {
      // Establece el grosor de las líneas
      imagesetthickness($imagen, rand(2, 10));
      $linea_color = $colores[rand(1, 4)];
      // Dibuja los rectangulos
      imagerectangle($imagen, rand(-10, 190), rand(-10, 10), rand(-10, 190),
      rand(40, 60), $linea_color);
    }

    // Crea el color morado para la imagen
    $negro = imagecolorallocate($imagen, 0, 0, 0);
    $blanco = imagecolorallocate($imagen, 255, 255, 255);
    $texto_colores = [$negro, $blanco];

    for($i = 0; $i < 6; $i++) {
      $letra_espacio = 170/6;
      // 15 con imagettftext
      $inicial = 25;
	    // Establecer la variable de entorno para GD
      putenv('GDFONTPATH=' . realpath('.'));
	    /*$fuente = 'fonts/arial_narrow_7.ttf';
      // Escribe texto en la imagen usando fuentes
      imagettftext($imagen, 24, rand(-15, 15), $inicial + $i*$letra_espacio,
      rand(25, 45), $texto_colores[rand(0, 1)], $fuente, $captcha[$i]);*/
      imagestring($imagen, 5, $inicial + $i*$letra_espacio, rand(15, 25),
      $captcha[$i], $texto_colores[rand(0, 1)]);
    }

    header('Content-type: image/png');
    imagepng($imagen);
    imagedestroy($imagen);
  }

  /// \fn registrate Guarda un nuevo usuario en la base de datos
  function registrate()
  {
    $datos = ['RUTA' => RUTA, 'titulo' => 'Registrate', 'error' => '',
    'errorNombre' => '', 'errorApellido' => '', 'errorUsuario' => '',
    'errorCorreo' => '', 'errorContraseña' => '', 'acierto' => ''];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $usuario = $_POST['usuario'];
      $email = $_POST['email'];
      $contraseña = $_POST['contraseña'];
      $valores = ['nombre' => $nombre, 'apellido' => $apellido,
      'usuario' => $usuario, 'email' => $email, 'contraseña' => $contraseña];

      if ($this->validar->texto($nombre) && $this->validar->texto($apellido) &&
      $this->validar->usuario($usuario) && $this->validar->email($email) &&
      $this->validar->contraseña($contraseña)) {
        if ($this->modelo->validarEmail($email)) {
          if ($this->modelo->registrate($valores)) {
            $datos['acierto'] = 'Registro completado';
          } else {
            $datos['error'] = 'Error al guardar los datos';
          }
        } else {
          $datos['error'] = 'El correo ya se encuentra registrado';
        }
      } else {
        $total = 0;
        if (!$this->validar->texto($nombre)) {
          $total++;
          $datos['errorNombre'] = 'Ingrese sólo letras menores a 25 caracteres';
        }
        if (!$this->validar->texto($apellido)) {
          $total++;
          $datos['errorApellido'] = 'Ingrese sólo letras menores a 25 caracteres';
        }
        if (!$this->validar->usuario($usuario)) {
          $total++;
          $datos['errorUsuario'] = 'Sólo letras y números menores a 15 caracteres';
        }
        if (!$this->validar->email($email)) {
          $total++;
          $datos['errorCorreo'] = 'Debe de tener el formato nombre@dominio.extension';
        }
        if (!$this->validar->contraseña($contraseña)) {
          $total++;
          $datos['errorContraseña'] = 'Debe de tener mínimo 6 caracteres';
        }
        if ($total == 1) {
		      $datos['error'] = $total.' error en el formulario';
		    } else {
          $datos['error'] = $total.' errores en el formulario';
	      }
      }
    }
    $this->vista('registrateVista', $datos);
  }

  /// \fn restablecer Se envía un correo para restablecer la contraseña
  function restablecer()
  {
    $datos = ['RUTA' => RUTA, 'titulo' => 'Enviar correo', 'error' => '',
    'errorCorreo' => '', 'acierto' => ''];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = $_POST['email'];

      if ($this->validar->email($email)) {
        if (!$this->modelo->validarEmail($email)) {
          if ($this->modelo->enviarEmail($email)) {
            $datos['acierto'] = 'Correo enviado a '.$email;
          } else {
            $datos['error'] = 'No se pudo enviar el correo';
          }
        } else {
          $datos['error'] = 'Ingrese un correo que este registrado';
        }
      } else {
        $datos['errorCorreo'] = 'Debe de tener el formato nombre@dominio.extension';
      }
    }
    $this->vista('restablecerVista', $datos);
  }

  /// \fn recuperar Se actualiza la contraseña en la base de datos
  function recuperar($email)
  {
    $datos = ['RUTA' => RUTA, 'titulo' => 'Restablecer', 'error' => '',
    'acierto' => '', 'email' => $email];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = base64_decode($email);
      $contraseña = $_POST['contraseña'];
      $valores = ['email' => $email, 'contraseña' => $contraseña];

      if ($this->validar->contraseña($contraseña)) {
        if ($this->modelo->recuperarContraseña($valores)) {
          $datos['acierto'] = 'Se ha restablecido la contraseña';
        } else {
          $datos['error'] = 'No se pudo restablecer la contraseña';
        }
      } else {
        $datos['error'] = 'Debe de tener mínimo 6 caracteres';
      }
    }
    $this->vista('recuperarContraseñaVista', $datos);
  }

  /// \fn salir Termina la sesión y regresa a la página de inicio
  function salir($email)
  {
    session_start();
    $email = base64_decode($email);
    unset($_SESSION[$email]);
    session_destroy();
    header('Location:'.RUTA.'login');
  }

}
