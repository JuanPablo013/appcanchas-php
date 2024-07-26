<h1 class="page-name">Olvide mi Contraseña</h1>
<p class="page-description">Reestablece tu Contraseña, escribiendo tu Correo Electrónico a continuación</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="form" method="POST" action="/forget">
    <div class="field">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" placeholder="Tu Correo Electrónico">
    </div>

    <input type="submit" value="Enviar Instrucciones" class="button">

</form>

<div class="actions">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/create-account">¿Aún no tienes una cuenta? Crea una</a>
</div>