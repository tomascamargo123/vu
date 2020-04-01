<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avisos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.aviso";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.aviso";
		$this->msg_name = 'Aviso';
		$this->id_name = 'id';
		$this->columnas = array('id', 'mensaje', 'activo', 'oficina_id');
		$this->fields = array(
			array('name' => 'mensaje', 'label' => 'Mensaje', 'maxlength' => '255'),
			array('name' => 'activo', 'label' => 'Activo', 'input_type' => 'combo'),
			array('name' => 'oficina', 'label' => 'Oficina', 'input_type' => 'combo', 'id_name' => 'oficina_id')
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
		return TRUE;
	}
}
/* End of file Avisos_model.php */
/* Location: ./application/modules/expedientes/models/Avisos_model.php */