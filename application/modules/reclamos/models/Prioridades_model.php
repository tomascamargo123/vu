<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prioridades_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_prioridades';
		$this->msg_name = 'Prioridad';
		$this->id_name = 'id';
		$this->columnas = array('id', 'nombre', 'dias', 'icono');
		$this->fields = array(
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'dias', 'label' => 'Días', 'type' => 'integer', 'maxlength' => '3', 'required' => TRUE),
			array('name' => 'icono', 'label' => 'Icono', 'input_type' => 'combo', 'required' => TRUE)
		);
		$this->requeridos = array('nombre', 'dias');
		$this->unicos = array('nombre');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('prioridad_id', $delete_id)->count_all_results('rc_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a reclamos.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Prioridades_model.php */
/* Location: ./application/modules/reclamos/models/Prioridades_model.php */