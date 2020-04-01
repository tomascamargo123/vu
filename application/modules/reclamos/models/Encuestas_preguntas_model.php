<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas_preguntas_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_encuestas_preguntas';
		$this->msg_name = 'Pregunta de Encuesta';
		$this->id_name = 'id';
		$this->columnas = array('id', 'pregunta', 'descripcion_corta', 'activo', 'web');
		$this->fields = array(
			array('name' => 'pregunta', 'label' => 'Pregunta', 'required' => TRUE),
			array('name' => 'descripcion_corta', 'label' => 'Descripción corta', 'required' => TRUE, 'maxlength' => '15'),
			array('name' => 'activo', 'label' => 'Estado', 'input_type' => 'combo', 'required' => TRUE),
			array('name' => 'web', 'label' => 'Web', 'input_type' => 'combo', 'required' => TRUE)
		);
		$this->requeridos = array('pregunta', 'descripcion_corta', 'activo', 'web');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('pregunta_id', $delete_id)->count_all_results('rc_encuestas_respuestas') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a encuestas de respuestas.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Encuestas_preguntas_model.php */
/* Location: ./application/modules/reclamos/models/Encuestas_preguntas_model.php */