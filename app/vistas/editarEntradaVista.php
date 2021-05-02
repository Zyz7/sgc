<!DOCTYPE html>

<!--
 * https://sgcphp.herokuapp.com
 * Vista para editar una entrada
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
          <img src="<?php print RUTA; ?>admin/imagen/{email}" alt="Imagen de perfil"
          aria-describedby=""/>
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
          <span>Actividad</span>
          <span>Autoconfigurar</span>
	        <a href="<?php print RUTA; ?>login/salir/<?php print $datos["email"]; ?>">
            Salir</a>
        </div>
      </section>

      <section class="menuDer">
	      <h1 class="h1Login"><?php print $datos["entrada"]; ?></h1>
	      <span class="error"><?php print $datos["error"]; ?></span>
        <span class="acierto"><?php print $datos["acierto"]; ?></span>

	      <div class="contendorFormUsuario">

          <div class="form1">
	          <form class="formUsuario" method="post"
              action="<?php print RUTA; ?>entradas/editar/<?php print $datos["id"]; ?>/<?php print $datos["email"]; ?>">

            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" autofocus="true"
              value="<?php print $datos["tituloEntrada"]; ?>"
              pattern="[0-9a-zA-Z\sáéíóúÁÉÍÓÚñÑ]{2,150}"
              title="Ingrese sólo letras y números" required/>
            <span class="spanLogin"><?php print $datos["errorTitulo"]; ?></span>

            <label for="subtitulo">Subtítulo</label>
            <input type="text" id="subtitulo" name="subtitulo"
              value="<?php print $datos["subtitulo"]; ?>"
              pattern="[0-9a-zA-Z\sáéíóúÁÉÍÓÚñÑ]{2,50}"
              title="Ingrese sólo letras y números"/>
            <span class="spanLogin"><?php print $datos["errorSubtitulo"]; ?></span>

            <label for="contenido">Contenido</label>
            <textarea rows="50" cols="50" maxlength="2500"
              name="contenido" id="contenido" required><?php print $datos["contenido"]; ?></textarea>
            <span class="spanLogin"><?php print $datos["errorContenido"]; ?></span>

            <label for="categoria">Categoría</label>
            <select name="categoria">
              <option selected><?php print $datos["categoria"]; ?></option>
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
            <form class="formUsuario formEliminar" method="post"
            action="<?php print RUTA; ?>entradas/eliminar/<?php print $datos["id"]; ?>/<?php print $datos["email"]; ?>">
              <label for="">Verifique antes de eliminar</label>

              <label for="contraseña">Contraseña</label>
              <input type="password" id="contraseña" name="contraseña" value=""
                pattern="[!-~]{6,12}" title="Debe de tener entre 6 y 12 caracteres"
                required/>
              <span class="spanLogin"><?php print $datos["errorContraseñaEliminar"]; ?></span>

              <button class="botonEliminar">Eliminar</button>
	          </form>
          </div>
        </div>
      </section>
    </div>
  </body>
</html>
