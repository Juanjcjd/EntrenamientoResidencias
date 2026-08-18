<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        <label>CURP o RFC:</label>
        <input type="text" name="us_curp_rfc" required>
        <br><br>

        <label>Sexo:</label>
        <select name="us_sexo" required>
        <option value="">Seleccione</option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
        </select>
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
            <th>CURP/RFC</th>
            <th>Sexo</th>
        </tr>

        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?php echo $usuario->us_id; ?></td>
            <td><?php echo $usuario->us_nombre; ?></td>
            <td><?php echo $usuario->us_apellido; ?></td>
            <td><?php echo $usuario->us_correo; ?></td>
            <td><?php echo $usuario->us_telefono; ?></td>
            <td><?php echo $usuario->us_password; ?></td>
            <td><?php echo $usuario->us_curp_rfc; ?></td>
            <td><?php echo $usuario->us_sexo; ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

    <h2>Total de usuarios registrados</h2>
    
    <div style="width: 500px; height: 300px;">
        <canvas id="graficaTotal"></canvas>
    </div>
    
    <script>
    const ctxTotal = document.getElementById('graficaTotal');

    new Chart(ctxTotal, {
        type: 'bar',
        data: {
            labels: ['Usuarios registrados'],
            datasets: [{
                label: 'Total',
                data: [<?php echo $total_usuarios; ?>]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>

    <h2>Usuarios por sexo</h2>

    <div style="width: 400px; height: 400px;">
        <canvas id="graficaSexo"></canvas>
    </div>     

    <script>
    const ctxSexo = document.getElementById('graficaSexo');

    new Chart(ctxSexo, {
        type: 'pie',
        data: {
            labels: ['Masculino', 'Femenino'],
            datasets: [{
                label: 'Usuarios',
                data: [
                    <?php echo $masculinos; ?>,
                    <?php echo $femeninos; ?>
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    </script>

</body>
</html>