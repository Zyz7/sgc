<?php

/*
 * \date 2021
 * \author Mario Alberto Zayas González
 */

/*
 * Define la constante RUTA
 * En modo local se cambia por el nombre de la carpeta
 * Ejemplo: /nombre_carpeta/
 */
define('RUTA', '/');

/// Si no se pueden incluir los siguientes archivos se detiene la ejecución
require_once('librerias/MysqlConexion.php');
require_once('librerias/Controlador.php');
require_once('librerias/ControlUrl.php');
require_once('librerias/Validar.php');
require_once('librerias/Exception.php');
require_once('librerias/PHPMailer.php');
require_once('librerias/SMTP.php');
