<!DOCTYPE html>

<!--
 * https://sgcphp.herokuapp.com
 * Vista para mostrar todas las entradas
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
            Crear</a></p>
          <p><a href="<?php print RUTA; ?>admin/crear/<?php print $datos["email"]; ?>">
          <a href="<?php print RUTA; ?>admin/administradores/<?php print $datos["email"]; ?>">
            Administradores</a>
          <span>Actividad</span>
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
			        <th>Título</th>
			        <th>Subtítulo</th>
			        <th>Autor</th>
				      <th>Creación</th>
              <th>Modificación</th>
		        </tr>

            <?php
              for ($i=0; $i<count($datos["entradas"]); $i++) {
                print "<tr>";
                print "<td>".$datos["entradas"][$i]["titulo"]."</td>";
                print "<td>".$datos["entradas"][$i]["subtitulo"]."</td>";
                print "<td>".$datos["entradas"][$i]["autor"]."</td>";
                print "<td>".$datos["entradas"][$i]["creacion"]."</td>";
                print "<td>".$datos["entradas"][$i]["modificacion"]."</td>";
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
