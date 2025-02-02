<h1 class="nombre-pagina">Crear nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios</p>
<div class="app">
    <div class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </div>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige los servicios que deseas</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Datos y Cita</h2>
        <p>Coloca tus datos y fecha de la cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre" value="<?= s($nombre) ?? '' ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora" min="">
            </div>
            <input type="hidden" id="id" value="<?= s($_SESSION['id']) ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>


    <div class="paginacion">
        <button
            id="anterior"
            class="boton">&laquo; Anterior</button>

        <button
            id="siguiente"
            class="boton">Siguiente &raquo;</button>

    </div>
</div>

<?php
$style = '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
';
$script = '
<script src="build/js/app.js"></script> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>';

?>