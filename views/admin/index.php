<h1 class="nombre-pagina">Panel de administracion</h1>
<?php
include_once __DIR__ . '/../templates/barra.php';
?>
<h2>Buscar citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?= s($fecha) ?>">
        </div>
    </form>
</div>
<?php if (count($citas) === 0): ?>
    <h2>No hay citas en esta fecha</h2>
<?php endif; ?>

<div class="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita): ?>
            <?php if ($idCita !== $cita->id) :
                $total = 0;
            ?>
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
            endif;
            $total += $cita->precio ?>
            <p class="servicio">
                <?= $cita->servicio . " " . $cita->precio ?>
            </p>
            <?php
            $actual = $cita->id;
            $proximo = $citas[$key + 1]->id ?? 0;
            ?>
            <?php if (esUltimo($actual, $proximo)): ?>
                <p class="total">Total: <span>$<?= $total ?></span></p>
                <form action="/api/eliminar" method="post" id="formEliminar">
                    <input type="hidden" name="id" value="<?= $cita->id ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

<?php
$script = '<script src="build/js/buscador.js"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const formEliminar = document.querySelector("#formEliminar")
        formEliminar.addEventListener('submit', (e) => {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "Quieres eliminar la cita?",
                showCancelButton: true,
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.isConfirmed) {
                    formEliminar.submit();
                }
            })
        })
    })
</script>