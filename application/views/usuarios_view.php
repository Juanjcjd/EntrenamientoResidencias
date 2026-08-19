<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <title>Registro de usuarios</title>
</head>

<a href="<?php echo site_url('logout'); ?>">
    <button type="button">Cerrar sesión</button>
</a>

<br><br>

<body>

 <?php if ($this->session->userdata('us_rol') == 'Administrador'): ?>

    <h2>Registro de usuarios</h2>

    <form action="<?php echo site_url('usuarios/guardar'); ?>" method="post">

        <label>Nombre:</label>
        <input type="text" name="us_nombre" required>
        <br><br>

        <label>Apellido:</label>
        <input type="text" name="us_apellido" required>
        <br><br>

        <label>Usuario:</label>
        <input type="text" name="us_usuario" required>
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

 <?php endif; ?>    

<br><br>
    <hr>

      <a href="<?php echo base_url('plantillas/plantilla_usuarios.csv'); ?>">
      Descargar plantilla CSV
  </a>

  <h3>Importar usuarios</h3>

<form action="<?php echo site_url('usuarios/importar'); ?>" method="post" enctype="multipart/form-data">

    <input type="file" name="archivo_csv" accept=".csv" required>

    <button type="submit">Importar CSV</button>

</form>

<br>

<br><br>
    <hr>

    <h2>Usuarios registrados</h2>

    <table id="tablaUsuarios" border="1" cellpadding="8">

        <thead>
            <tr>
                <th>Seleccionar</th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Contraseña Hash</th>
                <th>CURP/RFC</th>
                <th>Sexo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td>
                    <input
                        type="checkbox"
                        class="seleccionar-usuario"
                        value="<?php echo $usuario->us_id; ?>"
                    >
                </td>

                <td><?php echo $usuario->us_id; ?></td>
                <td><?php echo $usuario->us_nombre; ?></td>
                <td><?php echo $usuario->us_apellido; ?></td>
                <td><?php echo $usuario->us_usuario; ?></td>
                <td><?php echo $usuario->us_correo; ?></td>
                <td><?php echo $usuario->us_telefono; ?></td>
                <td><?php echo $usuario->us_password; ?></td>
                <td><?php echo $usuario->us_curp_rfc; ?></td>
                <td><?php echo $usuario->us_sexo; ?></td>

                <td>

                    <?php if (
                        $this->session->userdata('us_rol') == 'Administrador' ||
                        $this->session->userdata('us_id') == $usuario->us_id
                    ): ?>

                        <a href="<?php echo site_url('usuarios/editar/' . $usuario->us_id); ?>">
                            <button type="button">Editar</button>
                        </a>

                    <?php endif; ?>

                    <?php if ($this->session->userdata('us_rol') == 'Administrador'): ?>

                        <a href="<?php echo site_url('usuarios/eliminar/' . $usuario->us_id); ?>"
                           onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            <button type="button">Eliminar</button>
                        </a>

                    <?php endif; ?>

                </td>
            </tr>
            <?php endforeach; ?>

        </tbody>

            </tbody>
    </table>


    <script>
    $(document).ready(function() {

        var tabla = $('#tablaUsuarios').DataTable({
            dom: 'Bfrtip',

            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Exportar Excel',
                    title: 'Usuarios registrados',
                    exportOptions: {
                        columns: ':not(:first-child)',

                        rows: function(idx, data, node) {
                            return $(node)
                                .find('.seleccionar-usuario')
                                .is(':checked');
                        }
                    } 
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Exportar PDF',
                    title: 'Usuarios registrados',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':not(:first-child)',

                        rows: function(idx, data, node) {
                            return $(node)
                                .find('.seleccionar-usuario')
                                .is(':checked');
                        }
                    }
                }
            ]
       });

    });
    </script>





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