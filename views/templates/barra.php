<div class="barra">
    <p>Hola : <?= $_SESSION['nombre'] ?? '' ?></p>
    <a class="boton" href="/logout">Cerrar Sesion</a>
</div>
<h2>Buscar citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" >
        </div>
    </form>
</div>

<div  id="citas-admin">

</div>