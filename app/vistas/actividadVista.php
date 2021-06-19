<!DOCTYPE html>

<!--
 * https://sgcphp.herokuapp.com
 * Vista actividad
 * Febrero 2021
 * Mario Alberto Zayas González
-->

<html lang="es">
  <head>
    <title><?php print $datos["titulo"]; ?></title>
    <meta charset="utf-8"/>
    <meta name="author" content=""/>
    <meta http-equiv="x-ua-compatible" content="ie-edge"/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>

    <link rel="canonical" href="https://sgcphp.herokuapp.com"/>
    <link rel="stylesheet" href="<?php print RUTA; ?>css/estilos.css"/>
    <link rel="shortcut icon" href="<?php print RUTA; ?>img/logo.png"/>
  </head>

  <body>
    <div class="contenedor">
      <section class="menuIzq">
        <figure class="imagenPerfil">
          <img src="<?php print RUTA; ?>admin/imagen/<?php print $datos["email"]; ?>"
          alt="Imagen de perfil" aria-describedby=""/>
        </figure>

        <div class="menu">
          <a href="<?php print RUTA; ?>admin/<?php print $datos["email"]; ?>">
            Inicio</a>
	        <p><a href="<?php print RUTA; ?>admin/editar/<?php print $datos["email"]; ?>">
            <?php print $datos["usuario"]; ?></a></p>
          <span>Plantillas</span>
          <a href="<?php print RUTA; ?>entradas/<?php print $datos["email"]; ?>">
            Entradas</a>
          <p><a href="<?php print RUTA; ?>entradas/agregar/<?php print $datos["email"]; ?>">
            Agregar</a></p>
          <a href="<?php print RUTA; ?>admin/operadores/<?php print $datos["email"]; ?>">
            Operadores</a>
          <p><a>Crear</a></p>
          <p><a href="<?php print RUTA; ?>admin/crear/<?php print $datos["email"]; ?>">
          <a href="<?php print RUTA; ?>admin/administradores/<?php print $datos["email"]; ?>">
            Administradores</a>
          <a href="<?php print RUTA; ?>admin/actividad/<?php print $datos["email"]; ?>">
            Actividad</a>
          <span>Autoconfigurar</span>
	        <a href="<?php print RUTA; ?>login/salir/<?php print $datos["email"]; ?>">
            Salir</a>
        </div>
      </section>

	    <section class="menuDer">
	      <h1 class="h1Login">Entradas</h1>

        <div style="overflow-x: auto">
	        <table>
            <tr>
			        <th>IP Servidor</th>
			        <th>Nombre</th>
			        <th>Software</th>
				      <th>Protocolo</th>
              <th>Método</th>
              <th>Tiempo</th>
			        <th>IP Cliente</th>
				      <th>Agente</th>
              <th>Puerto</th>
              <th>Fecha</th>
		        </tr>

            <?php
              for ($i=0; $i<count($datos["actividad"]); $i++) {
                print "<tr>";
                print "<td>".$datos["actividad"][$i]["ip_servidor"]."</td>";
                print "<td>".$datos["actividad"][$i]["nombre"]."</td>";
                print "<td>".$datos["actividad"][$i]["software"]."</td>";
                print "<td>".$datos["actividad"][$i]["protocolo"]."</td>";
                print "<td>".$datos["actividad"][$i]["metodo"]."</td>";
                print "<td>".$datos["actividad"][$i]["tiempo"]."</td>";
                print "<td>".$datos["actividad"][$i]["ip_cliente"]."</td>";
                print "<td>".$datos["actividad"][$i]["agente"]."</td>";
                print "<td>".$datos["actividad"][$i]["puerto"]."</td>";
                print "<td><a href='".RUTA."entradas/editar/".$datos["entradas"][$i]["id"]."/".$datos["email"]."'>
                  Editar</a></td>";
                print "</tr>";
              }
            ?>
          </table>
        </div>
	    </section>
    </div>
  </body>
</html>
