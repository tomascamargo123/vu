<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plantillas_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->table_name = "$this->sigmu_schema.plantilla";
        $this->aud_table_name = "{$this->sigmu_schema}_aud.plantilla";
        $this->msg_name = 'Plantilla';
        $this->id_name = 'id';
        $this->columnas = array('id', 'nombre', 'texto','firmapad','cabecera','pie','dinamica');
        $this->fields = array(
            array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '45'),
            array('name' => 'texto', 'label' => 'Texto', 'form_type' => 'textarea', 'rows' => '5')
        );
        $this->requeridos = array();
        //$this->unicos = array();
    }
    /**
     * _can_delete: Devuelve true si puede eliminarse el registro.
     *
     * @param int $delete_id
     * @return bool
     */
    protected function _can_delete($delete_id) {
        if ($this->db->where('plantilla_id', $delete_id)->count_all_results("$this->sigmu_schema.circuito") > 0) {
            $this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a trámites.');
            return FALSE;
        }
        return TRUE;
    }

    public function misFormularios($idplantilla = null, $asArray = false) {
        if (!empty($idplantilla)) {
            $query = $this->db->query("SELECT fp.formulario_id,fp.plantilla_id FROM sigmu.formulario_plantilla fp"
                    . " WHERE fp.plantilla_id = $idplantilla;");
            if($asArray){
                return $query->result_array();
            }else{
                return $query->result();
            }
        }
    }
    
    public function getPlantilla($id = null){
        if(isset($id)){
            $this->db->select('id,nombre,texto,firmapad,cabecera,pie');
            $this->db->where('id',$id);
            $query = $this->db->get('sigmu.plantilla');
            return $query->row();
        }
    }
    
    
    public function disponibles($id_tram){
        $query = $this->db->query("SELECT * FROM sigmu.plantilla WHERE plantilla.id NOT IN (SELECT circuito.plantilla_id FROM sigmu.circuito WHERE tramite_id = $id_tram AND plantilla_id IS NOT null);");
        return $query->result_array();
    }
    
    public function plantilla_actual($id_tram,$orden_c = 0){
        $query = $this->db->query("SELECT * FROM sigmu.plantilla WHERE plantilla.id IN (SELECT circuito.plantilla_id FROM sigmu.circuito WHERE tramite_id = $id_tram and circuito.orden = $orden_c) Limit 1;");
        return $query->row_array();
    }
    
    public function getCantFirmasPad($idplant){
            $this->db->select('firmapad');
            $this->db->where('id',$idplant);
            $query = $this->db->get('sigmu.plantilla');
            $plantilla = $query->row();
            if(empty($plantilla))
                return 0;
           else
                return $plantilla->firmapad;
    }
    
    public function guardarHistoricoPlantilla($id_pase,$id_plantilla,$data_post = array()){
        if(sizeof($data_post) > 0){
            $array_insert = array();
            foreach($data_post as $key => $value){
                $data = array();
                $data['id_pase'] = $id_pase;
                $data['id_plantilla'] = $id_plantilla;
                $data['alias'] = $key;
                $data['valor'] = $value;
                $data['AltaUsua'] = $this->session->userdata('username');
                
                array_push($array_insert, $data);
                
            }
            $this->db->insert_batch('sigmu.plantilla_historico', $array_insert);
        }
    }
    
    public function getBuscarHistorial($id_expediente,$alias_element){
        
        $this->db->select('ph.*');
        $this->db->join('sigmu.pase p', 'p.id = ph.id_pase AND p.id_expediente = '.$id_expediente);
        $this->db->where('ph.alias', $alias_element);
        $this->db->order_by('p.id', 'asc');
        $this->db->limit(1);
        $obj_row = $this->db->get('sigmu.plantilla_historico ph')->row();
        if(empty($obj_row))
            return "";
        else
            return  $obj_row->valor;
    }
}

/* End of file Plantillas_model.php */
/* Location: ./application/modules/expedientes/models/Plantillas_model.php */