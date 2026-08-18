<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $data['usuarios'] = $this->Usuario_model->obtener_todos();

        $data['total_usuarios'] = count($data['usuarios']);

        $data['masculinos'] = 0;
        $data['femeninos'] = 0;

        foreach ($data['usuarios'] as $usuario) {
            if ($usuario->us_sexo == 'Masculino') {
                $data['masculinos']++;
            }

            if ($usuario->us_sexo == 'Femenino') {
                $data['femeninos']++;
            }
    }

    $this->load->view('usuarios_view', $data);
     }
    public function guardar()
    {

        $telefono = $this->input->post('us_telefono');

        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            echo "El telefono debe contener exactamente 10 numeros.";
            return;
        }

        $correo = $this->input->post('us_correo');

        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $correo)) {
            echo "El correo electronico no tiene un formato valido.";
            return;
        }

        $curp_rfc = strtoupper($this->input->post('us_curp_rfc'));

        $regex_curp = '/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9][0-9]$/';
        $regex_rfc = '/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/';

        if (
            !preg_match($regex_curp, $curp_rfc) &&
            !preg_match($regex_rfc, $curp_rfc)
        ) {
            echo "El CURP o RFC no tiene un formato valido.";
            return;
        }

        $password_hash = password_hash(
            $this->input->post('us_password'),
            PASSWORD_BCRYPT
        );

       $datos = array(
           'us_nombre'   => $this->input->post('us_nombre'),
           'us_apellido' => $this->input->post('us_apellido'),
           'us_correo'   => $this->input->post('us_correo'),
           'us_telefono' => $this->input->post('us_telefono'),
           'us_curp_rfc' => $this->input->post('us_curp_rfc'),
           'us_sexo'     => $this->input->post('us_sexo'),
           'us_password' => $password_hash
        );

        $this->Usuario_model->insertar($datos);

        redirect('usuarios');
    }
    
    public function importar()
{
    if (!isset($_FILES['archivo_csv']) || $_FILES['archivo_csv']['error'] != 0) {
        echo "No se pudo cargar el archivo.";
        return;
    }

    $archivo = fopen($_FILES['archivo_csv']['tmp_name'], 'r');

    if (!$archivo) {
        echo "No se pudo abrir el archivo.";
        return;
    }

    // Leer y descartar encabezados
    $encabezados = fgetcsv($archivo, 0, ';');

    $insertados = 0;
    $errores = 0;
    $detalle_errores = array();
    $numero_fila = 1; // Contador de filas para el detalle de errores

    while (($fila = fgetcsv($archivo, 0, ';')) !== FALSE) {

        $numero_fila++;

        if (count($fila) < 7) {
            $errores++;
            continue;
        }

        $nombre    = trim($fila[0]);
        $apellido  = trim($fila[1]);
        $correo    = trim($fila[2]);
        $telefono  = trim($fila[3]);
        $curp_rfc  = strtoupper(trim($fila[4]));
        $sexo      = trim($fila[5]);
        $password  = trim($fila[6]);

        // Validación de teléfono
        if (!preg_match('/^[0-9]{10}$/', $telefono)) {
            $errores++;
            $detalle_errores[] = "Fila $numero_fila: teléfono inválido.";
            continue;
        }

        // Validación de correo
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $correo)) {
            $errores++;
            $detalle_errores[] = "Fila $numero_fila: correo inválido.";
            continue;
        }

        // Validación CURP / RFC
        $regex_curp = '/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[A-Z0-9][0-9]$/';
        $regex_rfc  = '/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/';

        if (
            !preg_match($regex_curp, $curp_rfc) &&
            !preg_match($regex_rfc, $curp_rfc)
        ) {
            $errores++;
            $detalle_errores[] = "Fila $numero_fila: CURP/RFC inválido.";
            continue;
        }

        // Validación de sexo
        if ($sexo != 'Masculino' && $sexo != 'Femenino') {
            $errores++;
            $detalle_errores[] = "Fila $numero_fila: sexo inválido.";
            continue;
        }

        // Validación básica de campos vacíos
        if ($nombre == '' || $apellido == '' || $password == '') {
            $errores++;
            $detalle_errores[] = "Fila $numero_fila: campos vacíos.";
            continue;
        }

      
        $datos = array(
            'us_nombre'   => $nombre,
            'us_apellido' => $apellido,
            'us_correo'   => $correo,
            'us_telefono' => $telefono,
            'us_curp_rfc' => $curp_rfc,
            'us_sexo'     => $sexo,
            'us_password' => password_hash($password, PASSWORD_BCRYPT)
        );

        if ($this->Usuario_model->insertar($datos)) {
            $insertados++;
        } else {
            $errores++;
            $detalle_errores[] = "Fila $numero_fila: error al insertar en la base de datos.";
        }
    }

    fclose($archivo);

    

    echo "<h2>Importación terminada</h2>";

echo "Usuarios insertados: " . $insertados . "<br>";
echo "Registros con error: " . $errores . "<br><br>";

if (!empty($detalle_errores)) {
    echo "<h3>Detalle de errores:</h3>";
    
    foreach ($detalle_errores as $error) {
        echo $error . "<br>";
    }
    echo "<br>";
}
echo '<a href="' . site_url('usuarios') . '">
        <button type="button">Regresar a usuarios</button>
      </a>';
}

}