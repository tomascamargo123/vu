<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud_revision_model extends MY_Model
{

    public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "solicitud_revision";
		$this->aud_table_name = "revisor_firmante";
		$this->msg_name = 'Solicitud_revision';
		$this->id_name = 'id';
		$this->columnas = array('id', 'id_revisor', 'id_firmante', 'estado', 'archivo_adjunto_id');
		$this->fields = array(
			array('name' => 'revisor', 'label' => 'Revisor'),
			array('name' => 'firmante', 'label' => 'Firmante'),
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
    
    public function create_revision(){

    }
}
/* End of file Solicitud_revision_model.php */
/* Location: ./application/modules/expedientes/models/Solicitud_revision_model.php */