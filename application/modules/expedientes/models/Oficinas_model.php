<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oficinas_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.oficina";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.oficina";
		$this->msg_name = 'Oficina';
		$this->id_name = 'id';
		$this->columnas = array('id', 'nombre', 'organigrama', 'emisora_pase', 'receptora_pase', 'usuario', 'terminal', 'fecha_usuario', 'proceso_usuario','inicia_expediente');
		$this->fields = array(
			array('name' => 'id', 'label' => 'Código', 'type' => 'integer', 'maxlength' => '10', 'required' => TRUE),
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '50'),
		);
		$this->requeridos = array('id', 'nombre');
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
		if ($this->db->where('oficina_id', $delete_id)->count_all_results("$this->sigmu_schema.aviso") > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a aviso.');
			return FALSE;
		}
		return TRUE;
	}
        
	public function getAll(){
		$this->db->select('oficina.id, oficina.nombre');
		$this->db->where('oficina.proceso_usuario','A');
		$this->db->order_by('oficina.nombre','ASC');
		$result = $this->db->get('sigmu.oficina');
		
		return $result->result_array();
	}
}
/* End of file Oficinas_model.php */
/* Location: ./application/modules/expedientes/models/Oficinas_model.php */