<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Personas_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.persona";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.persona";
		$this->msg_name = 'Persona';
		$this->id_name = 'CucuPers';
		$this->columnas = array('CucuPers','DetaPers','NudoPers');
		$this->fields = array(
			array('name' => 'DetaPers', 'label' => 'Nombre'),
			array('name' => 'NudoPers', 'label' => 'N° de Documento'),
                        array('name' => 'CucuPers', 'label' => 'Cuil'),
//			array('name' => 'CucuPers', 'label' => 'N° CUIL'),
		);
		$this->requeridos = array('CucuPers', 'DetaPers', 'NudoPers');
	}

	protected function _can_delete($delete_id)
	{
		return FALSE;
	}
}
/* End of file Personas_model.php */
/* Location: ./application/modules/expedientes/models/Personas_model.php */
