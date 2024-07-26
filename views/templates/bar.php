<div class="bar">
    <p>Hola: <?php echo $nombre ?? ''; ?></p>
    <a class="button" href="/logout">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="bar-services">
        <a class="button" href="/admin">Ver Partidos</a>
        <a class="button" href="/services">Ver Servicios</a>
        <a class="button" href="/services/create">Nuevo Servicio</a>
    </div>
<?php } ?>
