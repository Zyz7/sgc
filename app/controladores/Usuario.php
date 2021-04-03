<?php

/*
 * \class Usuario
 * \brief
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Usuario extends Controlador
{
  private $modelo;
  private $validar;

  function __construct()
  {
    $this->modelo = $this->modelo("UsuarioModelo");
    $this->validar = new Validar();
  }

  /// \fn caratula
  function caratula($email)
  {
    session_start();
    $usuario = $this->modelo->usuario(base64_decode($email));

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Inicio', 'email' => $email,
      'usuario' => $usuario['usuario'], 'error' => ''];
      $this->vista('usuarioVista', $datos);
    } else {
      $datos['error'] = 'No se encontró la sesión';
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn imagen Muestra la imagen de perfil del usuario
  function imagen($email) {
    $email = base64_decode($email);
    $ruta = $this->modelo->imagen($email);
    $imagen = imagecreatefrompng($ruta['imagen']);

    header('Content-type: image/png');
    imagepng($imagen);
    imagedestroy($imagen);
  }

  /// \fn editar Interfaz para editar datos del usuario
  function editar($email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Editar usuario', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'nombre' => '', 'apellido' => '',
      'emailForm' => '', 'error' => '', 'acierto' => '',
      'errorNombre' => '', 'errorApellido' => '', 'errorUsuario' => '',
      'errorCorreo' => '', 'errorContraseña' => '', 'errorImagen' => '',
      'errorNuevaContraseña' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $imagen = $_POST['imagen'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $correo = $_POST['email'];
        $valores = ['nombre' => $nombre, 'apellido' => $apellido,
        'usuario' => $usuario, 'correo' => $correo, 'imagen' => $imagen,
        'email' => base64_decode($email)];

        if ($this->validar->texto($nombre) && $this->validar->texto($apellido) &&
        $this->validar->usuario($usuario) && $this->validar->email($correo) &&
        $this->validar->url($imagen)) {
          if ($this->modelo->validarEmail($correo)) {
            if ($this->modelo->actualizar($valores)) {
              $datos['acierto'] = 'Datos guardados';
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
          if (!$this->validar->url($imagen)) {
            $total++;
            $datos['errorImagen'] = 'Debe ser una url válida de una imagen .png';
          }
          if ($total == 1) {
  		      $datos['error'] = $total.' error en el formulario';
  		    } else {
            $datos['error'] = $total.' errores en el formulario';
  	      }
        }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['nombre'] = $valores[0]['nombre'];
      $datos['apellido'] = $valores[0]['apellido'];
      $datos['nombre'] = $valores[0]['nombre'];
      $datos['usuario'] = $valores[0]['usuario'];
      $datos['emailForm'] = $valores[0]['email'];
      $this->vista('usuarioEditarVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn clave Cambia la contraseña del usuario
  function clave($email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Editar usuario', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'nombre' => '', 'apellido' => '',
      'emailForm' => '', 'error' => '', 'acierto' => '',
      'errorNombre' => '', 'errorApellido' => '', 'errorUsuario' => '',
      'errorCorreo' => '', 'errorContraseña' => '', 'errorImagen' => '',
      'errorNuevaContraseña' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $contraseña = $_POST['contraseña'];
        $nuevaContraseña = $_POST['nuevaContraseña'];
        $valores = ['nuevaContraseña' => $nuevaContraseña,
        'email' => base64_decode($email), 'contraseña' => $contraseña];

        if ($this->modelo->validarContraseña($valores)) {
          if ($this->validar->contraseña($nuevaContraseña)) {
            if ($this->modelo->cambiarContraseña($valores)) {
              $datos['acierto'] = 'Se ha cambiado la contraseña';
            } else {
              $datos['error'] = 'Error al cambiar la contraseña';
            }
          } else {
            $datos['error'] = 'Nueva contraseña incorrecta';
            $datos['errorContraseña'] = 'Debe de tener mínimo 6 caracteres';
          }
        } else {
          $datos['error'] = 'Contraseña actual incorrecta';
        }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['nombre'] = $valores[0]['nombre'];
      $datos['apellido'] = $valores[0]['apellido'];
      $datos['nombre'] = $valores[0]['nombre'];
      $datos['usuario'] = $valores[0]['usuario'];
      $datos['emailForm'] = $valores[0]['email'];
      $this->vista('usuarioEditarVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

}
