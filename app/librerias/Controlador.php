<?php

class Controlador {
	protected $controlador = "Login";
	protected $metodo = "vista";
	protected $parametros = [];

	function __construct(){
	
	}

	public function modelo($modelo) {
		require_once('../app/modelos/'.$modelo);
		return new $modelo();
	}

	public function vista($vista, $datos=[]) {
		if (file_exists('../app/vistas/'.$vista)) {
			require_once('../app/vistas/'.$vista);
		} else {
			die('La vsta no existe');
		}
	}
}
?>
