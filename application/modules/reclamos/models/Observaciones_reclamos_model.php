<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Observaciones_reclamos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_observaciones_incidentes';
		$this->msg_name = 'Observación de Reclamo';
		$this->id_name = 'id';
		$this->columnas = array('id', 'fecha', 'incidente_id', 'observacion', 'icono', 'grupo_id', 'user_id');
		$this->fields = array(
			array('name' => 'fecha', 'label' => 'Fecha', 'type' => 'date', 'required' => TRUE),
			array('name' => 'incidente', 'label' => 'Reclamo', 'input_type' => 'combo', 'id_name' => 'incidente_id', 'required' => TRUE),
			array('name' => 'observacion', 'label' => 'Observación', 'required' => TRUE),
			array('name' => 'grupo', 'label' => 'Grupo', 'input_type' => 'combo', 'id_name' => 'grupo_id', 'required' => TRUE),
			array('name' => 'user', 'label' => 'Usuario', 'input_type' => 'combo', 'id_name' => 'user_id', 'required' => TRUE)
		);
		$this->requeridos = array('fecha', 'incidente_id', 'observacion', 'grupo_id', 'user_id');
	}
}
/* End of file Observaciones_reclamos_model.php */
/* Location: ./application/modules/reclamos/models/Observaciones_reclamos_model.php */