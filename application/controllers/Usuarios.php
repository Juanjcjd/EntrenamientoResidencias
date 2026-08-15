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
        $this->load->view('usuarios_view', $data);
    }

    public function guardar()
    {
        $password_hash = password_hash(
            $this->input->post('us_password'),
            PASSWORD_BCRYPT
        );

        $datos = array(
            'us_nombre'   => $this->input->post('us_nombre'),
            'us_apellido' => $this->input->post('us_apellido'),
            'us_correo'   => $this->input->post('us_correo'),
            'us_telefono' => $this->input->post('us_telefono'),
            'us_password' => $password_hash
        );

        $this->Usuario_model->insertar($datos);

        redirect('usuarios');
    }
}