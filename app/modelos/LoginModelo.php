<?php

class LoginModelo {
	private $base;
	
	function __construct() {
		$this->base = new MysqlConexion();
	}
}
?>
