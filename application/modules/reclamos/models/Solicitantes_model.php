<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitantes_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_solicitantes';
		$this->msg_name = 'Solicitante';
		$this->id_name = 'id';
		$this->columnas = array('id', 'dni', 'nombre', 'apellido', 'mail', 'telefono', 'et_user_id');
		$this->fields = array(
			array('name' => 'dni', 'label' => 'DNI', 'maxlength' => '10'),
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'apellido', 'label' => 'Apellido', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'mail', 'label' => 'Mail', 'maxlength' => '50'),
			array('name' => 'telefono', 'label' => 'Teléfono', 'maxlength' => '50')
		);
		$this->requeridos = array('dni', 'nombre', 'apellido');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('solicitante_id', $delete_id)->count_all_results('rc_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a reclamos.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Solicitantes_model.php */
/* Location: ./application/modules/reclamos/models/Solicitantes_model.php */