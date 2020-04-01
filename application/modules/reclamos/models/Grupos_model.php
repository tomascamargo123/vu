<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_grupos';
		$this->msg_name = 'Grupo';
		$this->id_name = 'id';
		$this->columnas = array('id', 'nombre', 'activo');
		$this->fields = array(
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'activo', 'label' => 'Estado', 'input_type' => 'combo', 'required' => TRUE)
		);
		$this->requeridos = array('nombre', 'activo');
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
		if ($this->db->where('grupo_id', $delete_id)->count_all_results('rc_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a reclamos.');
			return FALSE;
		}
		if ($this->db->where('grupo_id', $delete_id)->count_all_results('rc_observaciones_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a observaciones de reclamos.');
			return FALSE;
		}
		if ($this->db->where('grupo_id', $delete_id)->count_all_results('rc_sectores') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a sectores.');
			return FALSE;
		}
		if ($this->db->where('grupo_id', $delete_id)->count_all_results('rc_users_grupos') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a asignaciones de usuarios.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Grupos_model.php */
/* Location: ./application/modules/reclamos/models/Grupos_model.php */