<?php

/*
 * \class Entradas
 * \brief Gestiona las entradas
 * \date 2021
 * \author Mario Alberto Zayas González
 */
class Entradas extends ControladorDependiente
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

}
