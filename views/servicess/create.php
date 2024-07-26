<h1 class="page-name">Nuevo Servicio</h1>
<p class="page-description">Llena todos los campos para añadir un nuevo servicio</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/services/create" method="POST" class="form">
    <?php include_once __DIR__ . '/form.php'; ?>

    <input type="submit" class="button" value="Guardar Servicio">
</form>