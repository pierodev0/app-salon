<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion de servicios</p>
<?php
include_once __DIR__ . '/../templates/barra.php';
?>
<ul class="servicios">
   <?php foreach ($servicios as $servicio): ?>
      <li>
         <p>Nombre: <span><?= $servicio->nombre ?></span></p>
         <p>Precio: <span>$<?= $servicio->precio ?></span></p>
         <div class="acciones">
            <a href="/servicios/actualizar?id=<?= $servicio->id ?>" class="boton">Actualizar</a>
            <form action="/servicios/eliminar" method="post">
               <input type="hidden" name="id" value="<?= $servicio->id ?>">
               <input type="submit" value="Eliminar" class="boton-eliminar">
            </form>
         </div>
      </li>
   <?php endforeach; ?>
</ul>