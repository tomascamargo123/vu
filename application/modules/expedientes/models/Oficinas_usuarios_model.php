<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oficinas_usuarios_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->table_name = "$this->sigmu_schema.usuario_oficina";
        $this->aud_table_name = "{$this->sigmu_schema}_aud.usuario_oficina";
        $this->msg_name = 'Oficina de usuario';
        $this->id_name = 'ID';
        $this->columnas = array('ID', 'ID_OFICINA', 'ID_USUARIO','ORDEN');
        $this->fields = array(
            array('name' => 'ID', 'label' => 'ID', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE),
            array('name' => 'ID_OFICINA', 'label' => 'ID de OFICINA', 'type' => 'integer', 'maxlength' => '11'),
            array('name' => 'ID_USUARIO', 'label' => 'ID de USUARIO', 'maxlength' => '255')
        );
        $this->requeridos = array('ID_OFICINA', 'ID_USUARIO');
        //$this->unicos = array();
    }

    /**
     * _can_delete: Devuelve true si puede eliminarse el registro.
     *
     * @param int $delete_id
     * @return bool
     */
    protected function _can_delete($delete_id) {
        return TRUE;
    }

    public function delete_rela($array = null, $bool = false) {//id 2075
        if ($array != NULL) {
            $this->db->where('id', $array['ID']);
            $this->db->delete($this->table_name);
        }
    }

    public function create_rela($array = null, $bool = false) {
        //array('ID_OFICINA' => $ofi, 'ID_USUARIO' => $CodiUsua
        if ($array != NULL) {
            $data = array(
                'ID_OFICINA' => $array['ID_OFICINA'],
                'ID_USUARIO' => $array['ID_USUARIO'],
                'ORDEN' => $array['ORDEN']
            );

            $this->db->insert($this->table_name, $data);
        }
    }

    public function get_primer_oficina($CodiUsua){
        return $this->db->get_where($this->table_name, array('ID_USUARIO' => $CodiUsua, 'ORDEN' => 1))->result_array();
    }

    public function get_usuario_oficina($id_oficina, $id_user){
        $query = "SELECT
        users.id,
        users.username,
        CONCAT(users.username, ' - ', UCASE(users.first_name),' ', UCASE(users.last_name)) AS nombre
        FROM sigmu.usuario_oficina
        JOIN expedientes.users
        ON usuario_oficina.ID_USUARIO = users.username
        WHERE id_oficina = $id_oficina AND users.id != $id_user
        GROUP BY users.id 
        ORDER BY nombre ASC;";
        $result = $this->db->query($query)->result_array();
        return $result;
    }
}

/* End of file Oficinas_usuarios_model.php */
/* Location: ./application/modules/expedientes/models/Oficinas_usuarios_model.php */