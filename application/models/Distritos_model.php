<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Distritos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'distritos';
		$this->msg_name = 'Distrito';
		$this->id_name = 'id';
		$this->columnas = array('id', 'nombre', 'codigo_postal');
		$this->fields = array(
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'codigo_postal', 'label' => 'Código Postal', 'type' => 'integer', 'maxlength' => '4', 'required' => TRUE),
		);
		$this->requeridos = array('nombre', 'codigo_postal');
		$this->unicos = array('nombre');
		// Inicializaciones necesarias colocar acá.
	}
}
/* End of file Distritos_model.php */
/* Location: ./application/models/Distritos_model.php */