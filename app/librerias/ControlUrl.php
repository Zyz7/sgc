<?php

/*
 * \class ControlUrl
 * \brief  Maneja la dirección url y lanza los procesos
 *
 * Primer elemento: constante RUTA.
 * Segundo elemento: clase controladora: login, admin, etc.
 * Tercer elemento: método: registrar, modificar, etc.
 * Tercer elemento o más: los parámetros.
 * Ejemplo ruta en modo local: localhost/sgc/login/registrar
 *
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class ControlUrl
{
  protected $controlador = 'Inicio';
  protected $metodo = 'caratula';
  protected $parametros = [];

  function __construct()
  {
    $url = $this->separarUrl();

    /// Verifica la existencia del controlador
    if ($url != '' && file_exists('../app/controladores/'.ucwords($url[0]).'.php')) {
      /// ucwords convierte a mayúscula el primer caracter
      $this->controlador = ucwords($url[0]);
      /// unset elimina la variable
      unset($url[0]);
    }

    /// Asigna el controlador
    require_once('../app/controladores/'.ucwords($this->controlador).'.php');
    $this->controlador = new $this->controlador;

    /// isset determina si la variable esta definida
    if (isset($url[1])) {
      /// Verifica la existencia del método dentro de la clase (clase, método)
	    if (method_exists($this->controlador, $url[1])) {
		    $this->metodo = $url[1];
		    unset($url[1]);
	    }
	  }

    /// array_values regresa un arreglo con los parámetros
	  $this->parametros = $url ? array_values($url):[];
    /// Invoca al controlador con una de sus funciones y parámetros
	  call_user_func_array([$this->controlador, $this->metodo],$this->parametros);
  }

  /// \fn separarUrl Elimina carácteres de la url
  function separarUrl()
  {
    $url = '';

    //isset determina si la variable esta definida
    if (isset($_GET['url'])) {
      //rtrim elimina los caracteres / y \\ del final de la cadena
      $url = rtrim($_GET['url'],'/');
      $url = rtrim($_GET['url'],'\\');

      //elimina los caracteres ilegales de la url
      $url = filter_var($url, FILTER_SANITIZE_URL);

      //divide la cadena mediante el caracter /
      $url = explode('/', $url);
    }
    return $url;
  }

}
