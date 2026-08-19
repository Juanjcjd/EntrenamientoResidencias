<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
</head>

<body>

    <h2>Iniciar sesión</h2>

    <form action="<?php echo site_url('login/autenticar'); ?>" method="post">

        <label>Usuario:</label>
        <input type="text" name="us_usuario" required>

        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="us_password" required>

        <br><br>

        <button type="submit">Entrar</button>

    </form>

</body>
</html>