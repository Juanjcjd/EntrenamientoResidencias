<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
</head>
<body>

    <h2>Editar usuario</h2>

    <form action="<?php echo site_url('usuarios/actualizar/' . $usuario->us_id); ?>" method="post">

        <label>Nombre:</label>
        <input type="text"
               name="us_nombre"
               value="<?php echo $usuario->us_nombre; ?>"
               required>
        <br><br>

        <label>Apellido:</label>
        <input type="text"
               name="us_apellido"
               value="<?php echo $usuario->us_apellido; ?>"
               required>
        <br><br>

        <label>Usuario:</label>
        <input type="text"
               name="us_usuario"
               value="<?php echo $usuario->us_usuario; ?>"
               required>
        <br><br>

        <label>Correo:</label>
        <input type="email"
               name="us_correo"
               value="<?php echo $usuario->us_correo; ?>"
               required>
        <br><br>

        <label>Teléfono:</label>
        <input type="text"
               name="us_telefono"
               value="<?php echo $usuario->us_telefono; ?>"
               required>
        <br><br>

        <label>CURP o RFC:</label>
        <input type="text"
               name="us_curp_rfc"
               value="<?php echo $usuario->us_curp_rfc; ?>"
               required>
        <br><br>

        <label>Sexo:</label>
        <select name="us_sexo" required>

            <option value="Masculino"
                <?php echo ($usuario->us_sexo == 'Masculino') ? 'selected' : ''; ?>>
                Masculino
            </option>

            <option value="Femenino"
                <?php echo ($usuario->us_sexo == 'Femenino') ? 'selected' : ''; ?>>
                Femenino
            </option>

        </select>

        <br><br>

        <label>Nueva contraseña:</label>
        <input type="password" name="us_password">
        <br>

        <small>
            Déjala vacía si no deseas cambiar la contraseña.
        </small>

        <br><br>

        <button type="submit">Guardar cambios</button>

        <a href="<?php echo site_url('usuarios'); ?>">
            <button type="button">Cancelar</button>
        </a>

    </form>

</body>
</html>