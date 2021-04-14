<?php

/*
 * \class Entradas
 * \brief Gestiona las entradas
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Entradas extends Controlador
{
  private $modelo;
  private $validar;

  function __construct()
  {
    $this->modelo = $this->modelo("EntradasModelo");
    $this->validar = new Validar();
  }

  /// \fn caratula
  function caratula($email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Entradas', 'email' => $email,
      'usuario' => '', 'imagen' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['usuario'] = $valores[0]['usuario'];

      $entradas = $this->modelo->listaEntradas();
      $datos['entradas'] = $entradas;

      $this->vista('entradasVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn agregar Crea una nueva entrada para ser publicada
  function agregar($email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Agregar entrada', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'error' => '', 'acierto' => '',
      'errorTitulo' => '', 'errorSubtitulo' => '', 'errorContenido' => '',
      'errorCategoria' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $titulo = $_POST['titulo'];
		    $subtitulo = $_POST['subtitulo'];
        $contenido = $_POST['contenido'];
        $categoria = $_POST['categoria'];
        $usuario = $this->modelo->datosUsuario(base64_decode($email));
        $valores = ['titulo' => $titulo, 'subtitulo' => $subtitulo,
        'contenido' => $contenido, 'categoria' => $categoria,
        'email' => base64_decode($email), 'usuario' => $usuario['usuario']];

        if ($this->validar->texto($titulo) && $this->validar->texto($subtitulo) &&
        $this->validar->contenido($contenido)) {
			    if ($this->modelo->entrada($valores)) {
            $datos['acierto'] = 'Datos guardados';
          } else {
            $datos['error'] = 'Error al guardar los datos';
          }
		    } else {
			    $total = 0;
          if (!$this->validar->texto($titulo)) {
            $total++;
            $datos['errorTitulo'] = 'Ingrese sólo letras y números';
          }
          if (!$this->validar->texto($subtitulo)) {
            $total++;
            $datos['errorSubtitulo'] = 'Ingrese sólo letras y números';
          }
          if (!$this->validar->contenido($contenido)) {
            $total++;
            $datos['errorContenido'] = 'Sólo caracteres válidos';
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
      $datos['usuario'] = $valores[0]['usuario'];

      $this->vista('agregarEntradaVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn categoria Crea una nueva categoria
  function categoria($email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Agregar entrada', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'error' => '', 'acierto' => '',
      'errorTitulo' => '', 'errorSubtitulo' => '', 'errorContenido' => '',
      'errorCategoria' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $categoria = $_POST['nuevaCategoria'];

        $valores = ['categoria' => $nuevaCategoria, 'email' => base64_decode($email)];

        if ($this->validar->texto($categoria)) {
			    if ($this->modelo->categoria($valores)) {
            $datos['acierto'] = 'Categoría guardada';
          } else {
            $datos['error'] = 'Error al guardar los datos';
          }
		    } else {
			    $total = 0;
          if (!$this->validar->texto($titulo)) {
            $total++;
            $datos['errorTitulo'] = 'Ingrese sólo letras y números';
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
      $datos['usuario'] = $valores[0]['usuario'];

      $this->vista('agregarEntradaVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

}
