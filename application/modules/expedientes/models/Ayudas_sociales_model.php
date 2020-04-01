<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ayudas_sociales_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.ayuda_social";
		$this->aud_table_name = "{$this->sigmu_schema}_aud.ayuda_social";
		$this->msg_name = 'Ayuda social';
		$this->id_name = 'id';
		$this->columnas = array('id', 'detalleBeneficioEntregado', 'detalleFamiliares', 'detalleSolicitud', 'nombreDelBeneficiario', 'numeroDeFichaApros', 'tipo_ayuda_social_id');
		$this->fields = array(
			array('name' => 'numeroDeFichaApros', 'label' => 'N° de ficha APROS', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'nombreDelBeneficiario', 'label' => 'Nombre del beneficiario', 'maxlength' => '255', 'required' => TRUE),
			array('name' => 'detalleSolicitud', 'label' => 'Solicitud', 'maxlength' => '255', 'required' => TRUE),
			array('name' => 'detalleFamiliares', 'label' => 'Datos de la familia', 'maxlength' => '255'),
			array('name' => 'detalleBeneficioEntregado', 'label' => 'Beneficio entregado', 'maxlength' => '255', 'required' => TRUE),
			array('name' => 'tipo_ayuda_social', 'label' => 'Tipo de ayuda', 'input_type' => 'combo', 'id_name' => 'tipo_ayuda_social_id', 'required' => TRUE)
		);
		$this->requeridos = array('nombreDelBeneficiario', 'detalleSolicitud', 'detalleBeneficioEntregado', 'tipo_ayuda_social_id');
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
		if ($this->db->where('ayuda_social_id', $delete_id)->count_all_results('expediente') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a expediente.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Ayudas_sociales_model.php */
/* Location: ./application/modules/expedientes/models/Ayudas_sociales_model.php */