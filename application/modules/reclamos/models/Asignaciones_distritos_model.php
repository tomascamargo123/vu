<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciones_distritos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_users_distritos';
		$this->msg_name = 'Asignación de Distrito';
		$this->id_name = 'id';
		$this->columnas = array('id', 'user_id', 'distrito_id');
		$this->fields = array(
			array('name' => 'user', 'label' => 'Usuario', 'input_type' => 'combo', 'id_name' => 'user_id', 'required' => TRUE),
			array('name' => 'distrito', 'label' => 'Distrito', 'input_type' => 'combo', 'id_name' => 'distrito_id', 'required' => TRUE)
		);
		$this->requeridos = array('user_id', 'distrito_id');
		$this->unicos = array(array('user_id', 'distrito_id'));
	}
}
/* End of file Asignaciones_distritos_model.php */
/* Location: ./application/modules/reclamos/models/Asignaciones_distritos_model.php */