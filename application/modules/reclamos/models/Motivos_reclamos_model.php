<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Motivos_reclamos_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_motivos_reclamos';
		$this->msg_name = 'Motivo de Reclamo';
		$this->id_name = 'id';
		$this->columnas = array('id', 'descripcion', 'sector_id', 'activo');
		$this->fields = array(
			array('name' => 'descripcion', 'label' => 'Descripción', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'sector', 'label' => 'Sector', 'input_type' => 'combo', 'id_name' => 'sector_id', 'required' => TRUE),
			array('name' => 'activo', 'label' => 'Estado', 'input_type' => 'combo', 'required' => TRUE)
		);
		$this->requeridos = array('descripcion', 'sector_id', 'activo');
		$this->unicos = array('descripcion');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('motivo_id', $delete_id)->count_all_results('rc_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a reclamos.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Motivos_reclamos_model.php */
/* Location: ./application/modules/reclamos/models/Motivos_reclamos_model.php */