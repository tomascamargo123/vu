<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciones_grupos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_users_grupos';
		$this->msg_name = 'Asignación de Grupo';
		$this->id_name = 'id';
		$this->columnas = array('id', 'user_id', 'grupo_id');
		$this->fields = array(
			array('name' => 'user', 'label' => 'Usuario', 'input_type' => 'combo', 'id_name' => 'user_id', 'required' => TRUE),
			array('name' => 'grupo', 'label' => 'Grupo', 'input_type' => 'combo', 'id_name' => 'grupo_id', 'required' => TRUE)
		);
		$this->requeridos = array('user_id', 'grupo_id');
		$this->unicos = array(array('user_id', 'grupo_id'));
	}
}
/* End of file Asignaciones_grupos_model.php */
/* Location: ./application/modules/reclamos/models/Asignaciones_grupos_model.php */