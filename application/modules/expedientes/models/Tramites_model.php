<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tramites_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.tramite";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.tramite";
		$this->msg_name = 'Trámite';
		$this->id_name = 'id';
		$this->columnas = array('id', 'estado', 'nombre', 'tipo', 'digital');
		$this->fields = array(
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '255'),
			array('name' => 'estado', 'label' => 'Estado', 'type' => 'integer', 'maxlength' => '2', 'input_type' => 'combo'),
			array('name' => 'tipo', 'label' => 'Tipo', 'type' => 'integer', 'maxlength' => '11', 'input_type' => 'combo')
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
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('tramite_id', $delete_id)->count_all_results("$this->sigmu_schema.expediente") > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a expediente.');
			return FALSE;
		}
		if ($this->db->where('tramite_id', $delete_id)->count_all_results("$this->sigmu_schema.circuito") > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a trámites de formularios.');
			return FALSE;
		}
		return TRUE;
	}
        
        public function is_digital($param,$return_number = false){
            
            $idparam = is_numeric($param) ? $param : -1;
            
            $sql = "SELECT t.digital FROM sigmu.tramite t WHERE t.nombre = '$param' OR t.id = $idparam";
            
            $result = $this->db->query($sql)->row_array();
            if($result['digital'] > 0){
                if($return_number) return $result['digital']; else return "true";
            }else{
                if($return_number) return $result['digital']; else return "false";
            }
        }
        
}
/* End of file Tramites_model.php */
/* Location: ./application/modules/expedientes/models/Tramites_model.php */