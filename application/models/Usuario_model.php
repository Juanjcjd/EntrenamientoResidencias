<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insertar($datos)
    {
        return $this->db->insert('us_usuarios', $datos);
    }

    public function obtener_todos()
    {
        return $this->db
            ->order_by('us_id', 'ASC')
            ->get('us_usuarios')
            ->result();
    }
}