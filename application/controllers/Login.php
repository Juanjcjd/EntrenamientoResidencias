<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('Usuario_model');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('logueado')) {
            redirect('usuarios');
        }
        $this->load->view('login_view');
    }

    public function autenticar()
{
    $usuario = $this->input->post('us_usuario');
    $password = $this->input->post('us_password');

    $registro = $this->Usuario_model->obtener_por_usuario($usuario);

    if ($registro && password_verify($password, $registro->us_password)) {

        $datos_sesion = array(
            'us_id'      => $registro->us_id,
            'us_usuario' => $registro->us_usuario,
            'us_rol'     => $registro->us_rol,
            'logueado'   => TRUE
        );

        $this->session->set_userdata($datos_sesion);

        redirect('usuarios');

    } else {

        echo "<h2>Usuario o contraseña incorrectos.</h2>";

        echo '<a href="' . site_url('login') . '">
                <button type="button">Volver al inicio de sesión</button>
              </a>';
    }
}

    public function logout()
{
    $this->session->sess_destroy();
    redirect('login');
}
}