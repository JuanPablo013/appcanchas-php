<h1 class="page-name">Recuperar Contraseña</h1>
<p class="page-description">Coloca tu nueva contraseña a continuación</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if($error) return; ?>
<form class="form" method="POST">
    <div class="field">
        <label for="password">Contraseña</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Tu nueva contraseña"
        >
    </div>

    <input type="submit" value="Reestablecer Contraseña" class="button">
</form>

<div class="actions">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/create-account">¿Aún no tienes cuenta? Crea una</a>
</div>

