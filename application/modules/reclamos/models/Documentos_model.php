<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Documentos_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_documentos';
		$this->msg_name = 'Documento';
		$this->id_name = 'id';
		$this->columnas = array('id', 'fecha', 'incidente_id', 'ruta', 'grupo_id', 'user_id');
		$this->requeridos = array('fecha', 'incidente_id', 'ruta');
	}
}
/* End of file Documentos_model.php */
/* Location: ./application/modules/reclamos/models/Documentos_model.php */