<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        if ($this->db->conn_id) {
            echo "Conexion exitosa a PostgreSQL";
        } else {
            echo "Error de conexion";
        }
    }
}