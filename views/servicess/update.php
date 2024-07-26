<h1 class="page-name">Actualizar Servicio</h1>
<p class="page-description">Modifica los valores del formulario</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="form">
    <?php include_once __DIR__ . '/form.php'; ?>

    <input type="submit" class="button" value="Actualizar">
</form>