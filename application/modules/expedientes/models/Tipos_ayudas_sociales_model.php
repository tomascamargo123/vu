<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_ayudas_sociales_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.tipo_ayuda_social";
		$this->msg_name = 'Tipo de ayuda social';
		$this->id_name = 'id';
		$this->columnas = array('id', 'descripcion', 'nombre');
		$this->fields = array(
			array('name' => 'descripcion', 'label' => 'Descripcion', 'maxlength' => '255'),
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '255')
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
		if ($this->db->where('tipo_ayuda_social_id', $delete_id)->count_all_results('ayuda_social') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a ayuda de social.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Tipos_ayudas_sociales_model.php */
/* Location: ./application/modules/expedientes/models/Tipos_ayudas_sociales_model.php */