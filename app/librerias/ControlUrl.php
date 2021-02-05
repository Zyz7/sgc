<?php
/*
* Maneja la url y lanza los procesos
* Primer elemento: constante: /solarboon/ (en modo local)
* Segundo elemento: archivo de la carpeta controladores: login/, admin/
* Tercer elemento: método del archivo controlador: registrar/, alta
* Tercer elemento o más: los parámetros
* Ejemplo ruta: /solarboon/login/registrar/
*/

class ControlUrl {
  protected $controlador = "Login";
  protected $metodo = "caratula";
  protected $parametros = [];

  function __construct() {
    
    $url = $this->separarURL();

    //ucwords convierte a mayúsculas el primer caracter de cada palabra de la cadena
    if($url != "" && file_exists("../app/controladores/".ucwords($url[0]).".php")) {
      $this->controlador = ucwords($url[0]);
      //unset elimina la variable
      unset($url[0]);
    }
    
    //Carga el controlador Login
    require_once("../app/controladores/".ucwords($this->controlador).".php");
    $this->controlador = new $this->controlador;

    //isset determina si la variable esta definida
    if (isset($url[1])) {
      //verifica la existencia del método dentro de la clase (clase, método)
	    if (method_exists($this->controlador, $url[1])) {
		    $this->metodo = $url[1];
		    unset($url[1]);
	    }
	  }

    //array_values regresa un arreglo con los índices
	  $this->parametros = $url ? array_values($url):[];
    //([clase, método], parámetros)
	  call_user_func_array([$this->controlador, $this->metodo],$this->parametros);
  }

  function separarURL() {
    $url = "";

    //isset determina si la variable esta definida
    if (isset($_GET["url"])) {
      //rtrim retira los caracteres / y \\ del final de la cadena
      $url = rtrim($_GET["url"],"/");
      $url = rtrim($_GET["url"],"\\");

      //elimina los caracteres ilegales de la url
      $url = filter_var($url, FILTER_SANITIZE_URL);

      //divide la cadena mediante el caracter /
      $url = explode("/", $url);
    }
    return $url;
  }

}

?>
