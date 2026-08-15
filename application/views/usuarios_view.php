<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuarios</title>
</head>
<body>

    <h2>Registro de usuarios</h2>

    <form action="<?php echo site_url('usuarios/guardar'); ?>" method="post">

        <label>Nombre:</label>
        <input type="text" name="us_nombre" required>
        <br><br>

        <label>Apellido:</label>
        <input type="text" name="us_apellido" required>
        <br><br>

        <label>Correo:</label>
        <input type="email" name="us_correo" required>
        <br><br>

        <label>Teléfono:</label>
        <input type="text" name="us_telefono">
        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="us_password" required>
        <br><br>

        <button type="submit">Guardar usuario</button>

    </form>

    <hr>

    <h2>Usuarios registrados</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Contraseña Hash</th>
        </tr>

        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?php echo $usuario->us_id; ?></td>
            <td><?php echo $usuario->us_nombre; ?></td>
            <td><?php echo $usuario->us_apellido; ?></td>
            <td><?php echo $usuario->us_correo; ?></td>
            <td><?php echo $usuario->us_telefono; ?></td>
            <td><?php echo $usuario->us_password; ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

</body>
</html>