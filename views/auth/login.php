<h1 class="page-name">Login</h1>
<p class="page-description">Inicia sesión con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="form" method="POST" action="/">
    <div class="field">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" placeholder="Tu Email" name="email">
    </div>

    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Tu Contraseña" name="password">
    </div>

    <input type="submit" class="button" value="Iniciar sesión">
</form>

<div class="actions">
    <a href="/create-account">¿Aún no tienes una cuenta? Crea una</a>
    <a href="/forget">¿Olvidaste tu contraseña?</a>
</div>




