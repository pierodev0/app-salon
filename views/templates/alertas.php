<?php foreach($alertas as $tipo => $mensajes):?>
    <?php foreach($mensajes as $mensaje):?>
        <p class="alerta <?php echo $tipo; ?>"> <?php echo $mensaje; ?> </p>
    <?php endforeach;?>
<?php endforeach;?>