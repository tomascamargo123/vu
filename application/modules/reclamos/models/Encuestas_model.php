<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_encuestas';
		$this->msg_name = 'Encuesta';
		$this->id_name = 'id';
		$this->columnas = array('id', 'incidente_id', 'fecha', 'observacion', 'user_id');
		$this->fields = array(
			array('name' => 'observacion', 'label' => 'Observación', 'form_type' => 'textarea', 'rows' => '3'),
		);
		$this->requeridos = array('incidente_id', 'fecha', 'user_id');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('encuesta_id', $delete_id)->count_all_results('rc_encuestas_respuestas') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a respuestas de encuestas.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Encuestas_model.php */
/* Location: ./application/modules/reclamos/models/Encuestas_model.php */