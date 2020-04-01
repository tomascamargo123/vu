<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notas_pases_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.notapase";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.notapase";
		$this->msg_name = 'Nota de pase';
		$this->id_name = 'id';
		$this->columnas = array('id', 'contenido', 'fecha');
		$this->fields = array(
			array('name' => 'fecha', 'label' => 'Fecha', 'type' => 'datetime', 'readonly' => ''),
			array('name' => 'numero', 'label' => 'N°', 'readonly' => ''),
			array('name' => 'ano', 'label' => 'Año', 'readonly' => ''),
			array('name' => 'anexo', 'label' => 'Anexo', 'readonly' => ''),
			array('name' => 'oficina_origen', 'label' => 'Pase recibido de', 'readonly' => ''),
			array('name' => 'contenido', 'label' => 'Nota', 'maxlength' => '255', 'form_type' => 'textarea', 'rows' => '2')
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
		if ($this->db->where('nota_pase_id', $delete_id)->count_all_results("$this->sigmu_schema.pase") > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a pase.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Notas_pases_model.php */
/* Location: ./application/modules/expedientes/models/Notas_pases_model.php */