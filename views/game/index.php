<h1 class="page-name">Crear nueva reservación</h1>
<p class="page-description">Elige tus servicios y añade tus datos</p>

<?php
    include_once __DIR__ . '/../templates/bar.php';
?>

<div id="app">
    <nav class="tabs">
        <button class="current" type="button" data-step="1">Servicios</button>
        <button type="button" data-step="2">información Reservación</button>
        <button type="button" data-step="3">Resumen</button>
    </nav>

    <div id="step-1" class="section">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="services" class="list-services"></div>
    </div>
    <div id="step-2" class="section">
        <h2>Tus Datos y Reservación</h2>
        <p class="text-center">Coloca tus datos y la fecha de la reservación</p>

        <form class="form">
            <div class="field">
                <label for="name">Nombre</label>
                <input
                    id="name" 
                    type="text"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled
                >
            </div>

            <div class="field">
                <label for="date">Fecha</label>
                <input
                    id="date" 
                    type="date"
                    min="<?php echo date('Y-m-d') ?>"
                >
            </div>

            <div class="field">
                <label for="hour">Hora</label>
                <input
                    id="hour" 
                    type="time"
                >
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>" disabled>

        </form>
    </div>
    <div id="step-3" class="section summary-content">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="pagination">
        <button
            id="previous"
            class="button"
        >&laquo; Anterior</button>

        <button
            id="next"
            class="button"
        >Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>