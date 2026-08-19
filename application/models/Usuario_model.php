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

    public function existe_usuario($usuario)
    {
        return $this->db
            ->where('us_usuario', $usuario)
            ->count_all_results('us_usuarios') > 0;
    }

    public function obtener_por_usuario($usuario)
    {
        return $this->db
            ->where('us_usuario', $usuario)
            ->get('us_usuarios')
            ->row();
    }

    public function obtener_por_id($id)
    {
        return $this->db
            ->where('us_id', $id)
            ->get('us_usuarios')
            ->row();
    }

    public function actualizar($id, $datos)
    {
        return $this->db
            ->where('us_id', $id)
            ->update('us_usuarios', $datos);
    }

    public function existe_usuario_otro($usuario, $id)
    {
        return $this->db
            ->where('us_usuario', $usuario)
            ->where('us_id !=', $id)
            ->count_all_results('us_usuarios') > 0;
    }

    public function eliminar($id)
    {
        return $this->db
            ->where('us_id', $id)
            ->delete('us_usuarios');
    }


}