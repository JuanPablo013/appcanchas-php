<h1 class="page-name">Panel de Administración</h1>

<?php
    include_once __DIR__ . '/../templates/bar.php';
?>

<h2>Buscar Partidos</h2>
<div class="search">
    <form class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input 
                type="date"
                id="date"
                name="date"
                value="<?php echo $fecha ?>"
            >
        </div>
    </form>
</div>

<?php
    if(count($games) === 0) {
        echo "<h2>No hay partidos en esta fecha</h2>";
    }
?>

<div id="admin-games">
    <ul class="games">
        <?php
            $idGame = 0;
            foreach( $games as $key => $game ) {
                if($idGame !== $game->id) {
                    $total = 0;
        ?>
        <li>
            <p>ID: <span><?php echo $game->id; ?></span></p>
            <p>Hora: <span><?php echo $game->hora; ?></span></p>
            <p>Cliente: <span><?php echo $game->cliente; ?></span></p>
            <p>Correo Electrónico: <span><?php echo $game->email; ?></span></p>
            <p>Teléfono: <span><?php echo $game->telefono; ?></span></p>

            <h3>Servicios</h3>
        <?php
            $idGame = $game->id;
            } //Fin de If 
            $total += $game->precio;
        ?>
            <p class="service"><?php echo $game->servicio . " " . $game->precio; ?></p>
        <?php
            $actual = $game->id;
            $next = $games[$key + 1]->id ?? 0;

            if(latest($actual, $next)) { ?> 
                <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                <form action="/api/delete" method="POST">
                    <input type="hidden" name="id" value="<?php echo $game->id; ?>">
                    <input type="submit" class="delete-button" value="Eliminar">
                </form>
        <?php }
            } //Fin de Foreach 
        ?>
    </ul>

</div>

<?php
    $script = "<script src='build/js/search.js'></script>"
?>