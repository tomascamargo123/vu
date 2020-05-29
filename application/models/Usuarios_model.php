<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'users';
        $this->msg_name = 'Usuario';
        $this->id_name = 'id';
        $this->columnas = array('id', 'username', 'first_name', 'last_name', 'email', 'password', 'active', 'last_login', 'CodiUsua', 'firma_digital', 'organigrama');
        $this->fields = array(
            array('name' => 'username', 'label' => 'Usuario', 'maxlength' => '100', 'required' => TRUE),
            array('name' => 'first_name', 'label' => 'Nombre', 'maxlength' => '50', 'required' => TRUE),
            array('name' => 'last_name', 'label' => 'Apellido', 'maxlength' => '50', 'required' => TRUE),
            array('name' => 'email', 'label' => 'Email', 'maxlength' => '100', 'type' => 'email', 'required' => TRUE),
            array('name' => 'last_login', 'label' => 'Último ingreso'),
            array('name' => 'groups', 'label' => 'Grupos', 'type' => 'multiple', 'input_type' => 'combo', 'required' => TRUE),
            array('name' => 'rec_grupos', 'label' => 'Grupos Reclamos', 'type' => 'multiple', 'input_type' => 'combo', 'plugin' => 'duallistbox'),
            array('name' => 'exp_oficinas', 'label' => 'Oficinas Expediente', 'type' => 'multiple', 'input_type' => 'combo', 'plugin' => 'duallistbox'),
            array('name' => 'organigrama', 'label' => 'Oganigrama', 'input_type' => 'combo', 'required' => TRUE)
        );
        $this->requeridos = array('username', 'email', 'password');
        $this->unicos = array('username');
    }

    /**
     * _can_delete: Devuelve true si puede eliminarse el registro.
     *
     * @param int $delete_id
     * @return bool
     */
    protected function _can_delete($delete_id) { 
        return FALSE;
    }
    
    function update_data($data){
        $this->db->set('first_name', $data['first_name']);
        $this->db->set('last_name', $data['last_name']);
        $this->db->set('email', $data['email']);

        #Código agregado para Ticket Nro 30
        $this->db->set('firma_digital', $data['firma_digital']);
        #Fin Ticket Nro 30

        $this->db->set('organigrama', $data['organigrama']);

        $this->db->where('id', $data['id']);
        $this->db->update('users');
    }
    
    #Código agregado para Ticket Nro 30
    function es_firmante($username){
        $query = 'SELECT firma_digital FROM expedientes.users WHERE username = "'.$username.'"';
        $result = $this->db->query($query)->result_array();
        return $result[0]['firma_digital'];
    }
    #Fin Ticket Nro 30

}

/* End of file Usuarios_model.php */
/* Location: ./application/models/Usuarios_model.php */