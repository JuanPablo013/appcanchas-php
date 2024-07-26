<h1 class="page-name">Crear Cuenta</h1>
<p class="page-description">Llena el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="form" method="POST" action="/create-account">
    <div class="field">
        <label for="nombre">Nombre</label>
        <input 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Tu Nombre" 
            value="<?php echo s($usuario->nombre); ?>"
        >
    </div>

    <div class="field">
        <label for="apellido">Apellido</label>
        <input 
            type="text" 
            id="apellido" 
            name="apellido" 
            placeholder="Tu Apellido"
            value="<?php echo s($usuario->apellido); ?>"
        >
    </div>

    <div class="field">
        <label for="telefono">Teléfono</label>
        <input 
            type="tel" 
            id="telefono" 
            name="telefono" 
            placeholder="Tu número de Teléfono"
            value="<?php echo s($usuario->telefono); ?>"
        >
    </div>

    <div class="field">
        <label for="email">Correo Electrónico</label>
        <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Tu Correo Electrónico"
            value="<?php echo s($usuario->email); ?>"
        >
    </div>

    <div class="field">
        <label for="password">Contraseña</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Tu Contraseña"
        >
    </div>

    <input type="submit" value="Crear Cuenta" class="button">

</form>

<div class="actions">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/forget">¿Olvidaste tu contraseña?</a>
</div>