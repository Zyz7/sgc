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
        'email' => base64_decode($email), 'usuario' => $usuario[0]['usuario']];

        if ($this->validar->texto($titulo) && $this->validar->texto($subtitulo) &&
        $this->validar->contenido($contenido)) {
			    if ($this->modelo->entrada($valores)) {
            $datos['acierto'] = 'Entrada guardada';
          } else {
            $datos['error'] = 'Error al guardar los datos de entrada';
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
  		      $datos['error'] = $total.' error en el formulario de entrada';
  		    } else {
            $datos['error'] = $total.' errores en el formulario de entrada';
  	      }
		    }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $categorias = $this->modelo->listaCategorias();
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['usuario'] = $valores[0]['usuario'];
      $datos['categorias'] = $categorias;

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

        $valores = ['categoria' => $categoria, 'email' => base64_decode($email)];

        if ($this->validar->texto($categoria)) {
          if ($this->modelo->validarCategoria($categoria)) {
            if ($this->modelo->categoria($valores)) {
              $datos['acierto'] = 'Categoría guardada';
            } else {
              $datos['error'] = 'Error al guardar los datos de la categoría';
            }
          } else {
            $datos['error'] = 'Ya existe la categoría';
          }
		    } else {
			    $total = 0;
          if (!$this->validar->texto($titulo)) {
            $total++;
            $datos['errorTitulo'] = 'Ingrese sólo letras y números';
          }
          if ($total == 1) {
  		      $datos['error'] = $total.' error en el formulario de la categoría';
  		    } else {
            $datos['error'] = $total.' errores en el formulario de la categoría';
  	      }
		    }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $categorias = $this->modelo->listaCategorias();
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['usuario'] = $valores[0]['usuario'];
      $datos['categorias'] = $categorias;

      $this->vista('agregarEntradaVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

	/// \fn editar Edita una entrada
  function editar($id, $email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Editar entrada', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'error' => '', 'acierto' => '',
      'errorContraseñaEliminar' => '', 'id' => $id, 'errorTitulo' => '',
      'errorSubtitulo' => '', 'errorContenido' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'];
		    $subtitulo = $_POST['subtitulo'];
        $contenido = $_POST['contenido'];
        $categoria = $_POST['categoria'];
        $usuario = $this->modelo->datosUsuario(base64_decode($email));
        $valores = ['titulo' => $titulo, 'subtitulo' => $subtitulo,
        'contenido' => $contenido, 'categoria' => $categoria, 'id' => $id,
        'email' => base64_decode($email), 'usuario' => $usuario[0]['usuario']];

        if ($this->validar->texto($titulo) && $this->validar->texto($subtitulo) &&
        $this->validar->contenido($contenido)) {
			    if ($this->modelo->editarEntrada($valores)) {
            $datos['acierto'] = 'Datos guardados';
          } else {
            $datos['error'] = 'Error al guardar los datos de entrada';
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
  		      $datos['error'] = $total.' error en el formulario de entrada';
  		    } else {
            $datos['error'] = $total.' errores en el formulario de entrada';
  	      }
		    }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['usuario'] = $valores[0]['usuario'];
	    $entrada = $this->modelo->datosEntrada($id);
      $datos['entrada'] = $entrada[0]['titulo'];
      $datos['subtitulo'] = $entrada[0]['subtitulo'];
      $datos['contenido'] = $entrada[0]['contenido'];
      $datos['categoria'] = $entrada[0]['categoria'];
      $categorias = $this->modelo->listaCategorias();
      $datos['categorias'] = $categorias;

      $this->vista('editarEntradaVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

  /// \fn eliminar Elimina una entrada
  function eliminar($id, $email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Eliminar entrada', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'error' => '', 'acierto' => '',
      'errorContraseñaEliminar' => '', 'id' => $id, 'errorTitulo' => '',
      'errorSubtitulo' => '', 'errorContenido' => ''];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $contraseña = $_POST['contraseña'];
        $valores = ['email' => base64_decode($email), 'contraseña' => $contraseña,
        'id' => $id];

        if ($this->validar->contraseña($contraseña)) {
          if ($this->modelo->validarContraseña($valores)) {
            if ($this->modelo->eliminarEntrada($valores)) {
              $datos['acierto'] = 'Entrada eliminada';
            } else {
              $datos['error'] = 'Error al eliminar la entrada';
            }
          } else {
            $datos['error'] = 'Contraseña incorrecta';
          }
        } else {
          $datos['errorContraseñaEliminar'] = 'Debe de tener mínimo 6 caracteres';
        }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['usuario'] = $valores[0]['usuario'];
	    $entrada = $this->modelo->datosEntrada($id);
      $datos['entrada'] = $entrada[0]['titulo'];
      $datos['subtitulo'] = $entrada[0]['subtitulo'];
      $datos['contenido'] = $entrada[0]['contenido'];
      $datos['categoria'] = $entrada[0]['categoria'];
      $categorias = $this->modelo->listaCategorias();
      $datos['categorias'] = $categorias;

      $this->vista('editarEntradaVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

	/// \fn eliminarCategoria Elimina una categoría
  function eliminarCategoria($id, $email)
  {
    session_start();

    if (isset($_SESSION[base64_decode($email)])) {
      $datos = ['RUTA' => RUTA, 'titulo' => 'Eliminar categoría', 'email' => $email,
      'usuario' => '', 'imagen' => '', 'error' => '', 'acierto' => '',
      'errorContraseñaEliminar' => '', 'id' => $id];

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $contraseña = $_POST['contraseña'];
        $valores = ['email' => base64_decode($email), 'contraseña' => $contraseña,
        'id' => $id];

        if ($this->validar->contraseña($contraseña)) {
          if ($this->modelo->validarContraseña($valores)) {
            if ($this->modelo->eliminarCategoria($valores)) {
              $datos['acierto'] = 'Categoría eliminada';
            } else {
              $datos['error'] = 'Error al eliminar la categoría';
            }
          } else {
            $datos['error'] = 'Contraseña incorrecta';
          }
        } else {
          $datos['errorContraseñaEliminar'] = 'Debe de tener mínimo 6 caracteres';
        }
      }

      $valores = $this->modelo->datosUsuario(base64_decode($email));
      $categoria = $this->modelo->categoriaNombre($id);
      $datos['imagen'] = $valores[0]['imagen'];
      $datos['usuario'] = $valores[0]['usuario'];
      $datos['categoria'] = $categoria['nombre'];

      $this->vista('eliminarCategoriaVista', $datos);
    } else {
      header('Location:'.RUTA.'login');
    }
  }

}
