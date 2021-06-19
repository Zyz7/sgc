<!DOCTYPE html>

<!--
 * https://sgcphp.herokuapp.com
 * Vista para crear una entrada
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
          <p><a href="<?php print RUTA; ?>admin/crear/<?php print $datos["email"]; ?>">
            Crear</a></p>
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
	      <h1 class="h1Login">Agregar entrada</h1>
	      <span class="error"><?php print $datos["error"]; ?></span>
        <span class="acierto"><?php print $datos["acierto"]; ?></span>

        <div class="contendorFormularios">
			    <div class="form1">
			      <form class="formDatos" method="post"
            action="<?php print RUTA; ?>entradas/agregar/<?php print $datos["email"]; ?>">

	            <label for="titulo">Título</label>
	            <input type="text" id="titulo" name="titulo" autofocus="true"
					      value="" pattern="[0-9a-zA-Z\sáéíóúÁÉÍÓÚñÑ]{2,150}"
					      title="Ingrese sólo letras y números" required/>
				      <span class="spanLogin"><?php print $datos["errorTitulo"]; ?></span>

				      <label for="subtitulo">Subtítulo</label>
				      <input type="text" id="subtitulo" name="subtitulo" value=""
					      pattern="[0-9a-zA-Z\sáéíóúÁÉÍÓÚñÑ]{2,25}"
					      title="Ingrese sólo letras y números"/>
				      <span class="spanLogin"><?php print $datos["errorSubtitulo"]; ?></span>

				      <label for="contenido">Contenido</label>
				      <textarea rows="15" cols="50" maxlength="2500"
				        name="contenido" id="contenido" required></textarea>
				      <span class="spanLogin"><?php print $datos["errorContenido"]; ?></span>

				      <label for="categoria">Categoría</label>
				      <select name="categoria">
					      <option selected>Sin categoría</option>
                <?php
                  for ($i=0; $i<count($datos["categorias"]); $i++) {
                    print "<option>".$datos["categorias"][$i]["nombre"]."</option>";
                  }
                ?>
				      </select>

		          <button>Agregar</button>
	          </form>
	        </div>

	        <div class="form2">
				    <form class="formDatos" method="post"
            action="<?php print RUTA; ?>entradas/categoria/<?php print $datos["email"]; ?>">

				      <label for="nuevaCategoria">Categoría</label>
				      <input type="text" id="nuevaCategoria" name="nuevaCategoria"
				        value="" pattern="[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]{2,25}"
				        title="Ingrese sólo letras menores a 25 carácteres" required/>
				      <span class="spanLogin"><?php print $datos["errorCategoria"]; ?></span>

				      <button>Crear</button>
	          </form>
			    </div>

		      <div style="overflow-y: auto" class="formCategorias">
            <table>
              <tr>
                <th>Categorías</th>
		          </tr>
		          <?php
		          for ($i=0; $i<count($datos["categorias"]); $i++) {
					      print "<tr>";
					      print "<td>".$datos["categorias"][$i]["nombre"]."</td>";
					      print "<td><a href='".RUTA."entradas/eliminarCategoria/".$datos["categorias"][$i]["id"]."/".$datos["email"]."'>
                        Eliminar</a></td>";
					      print "</tr>";
				      }
		          ?>
		        </table>
			    </div>
		    </div>
	    </section>
    </div>
  </body>
</html>
