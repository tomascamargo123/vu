<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requerimientos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.aviso";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.aviso";
		$this->msg_name = 'Requerimiento';
		$this->id_name = 'id';
		$this->columnas = array('id', 'mensaje', 'estado', 'importancia', 'usuario', 'detalle', 'solicitante', 'comentario');
		$this->fields = array(
			array('name' => 'mensaje', 'label' => 'Mensaje', 'maxlength' => '255'),
			array('name' => 'detalle', 'label' => 'Detalle', 'form_type' => 'textarea', 'rows' => '4'),
			array('name' => 'importancia', 'label' => 'Importancia', 'input_type' => 'combo'),
			array('name' => 'estado', 'label' => 'Estado', 'input_type' => 'combo'),
			array('name' => 'comentario', 'label' => 'Comentario', 'maxlength' => '255'),
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
		return TRUE;
	}
}
/* End of file Avisos_model.php */
/* Location: ./application/modules/expedientes/models/Avisos_model.php */