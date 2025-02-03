<h1 class="nombre-pagina">Panel de administracion</h1>
<?php
include_once __DIR__ . '/../templates/barra.php';
?>
<div class="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $cita): ?>
            <?php if ($idCita !== $cita->id) : ?>
                <li>
                    <p>Id: <span><?= $cita->id ?></span></p>
                </li>
                <li>
                    <p>Cliente: <span><?= $cita->cliente ?></span></p>
                </li>
                <li>
                    <p>Hora: <span><?= $cita->hora ?></span></p>
                </li>
                <li>
                    <p>Email: <span><?= $cita->email ?></span></p>
                </li>
                <li>
                    <p>Telefono: <span><?= $cita->telefono ?></span></p>
                </li>
                <h3>Servicios</h3>
            <?php $idCita = $cita->id;
            endif; ?>
            <p class="servicio">
                <?= $cita->servicio. " " . $cita->precio ?>
            </p>
        <?php endforeach; ?>     
    </ul>
</div>