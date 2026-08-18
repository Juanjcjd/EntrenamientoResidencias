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
}