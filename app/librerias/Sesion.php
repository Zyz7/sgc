<?php

class Sesion {
  private $login = false;

  function __construct($usuario) {

    session_start();
    if (isset($_SESSION[$usuario])) {
      $this->login = true;
    } else {
      $this->login = false;
    }
  }

  public function iniciarLogin($usuario) {

    $_SESSION[$usuario] = $usuario;
    $this->login = true;
  }

  public function finalizarLogin($usuario) {

    unset($_SESSION[$usuario]);
    $this->login = false;
    session_destroy();
  }

  public function getLogin($usuario) {

    if (isset($_SESSION[$usuario])) {
      $this->login = true;
    } else {
      $this->login = false;
    }
    return $this->login;
  }

}

?>
