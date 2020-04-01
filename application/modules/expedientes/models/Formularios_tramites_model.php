<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formularios_tramites_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.tramites_formularios";
		$this->msg_name = 'Formulario de trámite';
		$this->id_name = 'formulario_id';
		$this->columnas = array('tramite_id', 'formulario_id');
		$this->fields = array(
			array('name' => 'tramite', 'label' => 'Tramite', 'input_type' => 'combo', 'id_name' => 'tramite_id', 'required' => TRUE),
			array('name' => 'formulario', 'label' => 'Formulario', 'input_type' => 'combo', 'id_name' => 'formulario_id', 'required' => TRUE)
		);
		$this->requeridos = array('tramite_id', 'formulario_id');
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
/* End of file Formularios_tramites_model.php */
/* Location: ./application/modules/expedientes/models/Formularios_tramites_model.php */