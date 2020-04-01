<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'groups';
		$this->msg_name = 'Grupo';
		$this->id_name = 'id';
		$this->columnas = array('id', 'name', 'description');
		$this->fields = array(
			array('name' => 'name', 'label' => 'Grupo', 'maxlength' => '30', 'required' => TRUE),
			array('name' => 'description', 'label' => 'Descripción', 'maxlength' => '100')
		);
		$this->requeridos = array('name');
		$this->unicos = array('name');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('group_id', $delete_id)->count_all_results('users_groups') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a algún usuario.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */