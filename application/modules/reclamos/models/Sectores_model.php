<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sectores_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_sectores';
		$this->msg_name = 'Sector';
		$this->id_name = 'id';
		$this->columnas = array('id', 'descripcion', 'grupo_id', 'activo', 'icono');
		$this->fields = array(
			array('name' => 'descripcion', 'label' => 'Descripción', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'grupo', 'label' => 'Grupo', 'input_type' => 'combo', 'id_name' => 'grupo_id', 'required' => TRUE),
			array('name' => 'activo', 'label' => 'Estado', 'input_type' => 'combo', 'required' => TRUE),
			array('name' => 'icono', 'label' => 'Icono', 'input_type' => 'combo', 'required' => TRUE)
		);
		$this->requeridos = array('descripcion', 'grupo_id', 'activo', 'icono');
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
		if ($this->db->where('sector_id', $delete_id)->count_all_results('rc_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a reclamos.');
			return FALSE;
		}
		if ($this->db->where('sector_id', $delete_id)->count_all_results('rc_motivos_reclamos') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a motivos de reclamos.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Sectores_model.php */
/* Location: ./application/modules/reclamos/models/Sectores_model.php */