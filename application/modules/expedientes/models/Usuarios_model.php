<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.usuario";
		$this->msg_name = 'Usuario';
		$this->id_name = 'CodiUsua';
		$this->columnas = array('CodiUsua', 'CucuPers', 'DetaUsua', 'ClavUsua', 'FeveUsua', 'InhaUsua', 'CodiEnre', 'ObseUsua', 'CodiOrga', 'AcreUsua', 'FirmUsua', 'CargUsua', 'CoenUsua', 'CosaUsua', 'SemaUsua', 'PumaUsua', 'UsmaUsua', 'ComaUsua', 'UsslUsua', 'UtlsUsua', 'AltaUsua', 'AltaFeho', 'BajaUsua', 'BajaFeho', 'ModiUsua', 'ModiFeho', 'BajaMoti');
		$this->fields = array(
			array('name' => 'CodiUsua', 'label' => 'CodiUsua', 'maxlength' => '20'),
			array('name' => 'CucuPers', 'label' => 'CucuPers', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'DetaUsua', 'label' => 'DetaUsua', 'maxlength' => '40'),
			array('name' => 'ClavUsua', 'label' => 'ClavUsua', 'maxlength' => '32'),
			array('name' => 'FeveUsua', 'label' => 'FeveUsua', 'type' => 'date'),
			array('name' => 'InhaUsua', 'label' => 'InhaUsua', 'type' => 'integer', 'maxlength' => '1'),
			array('name' => 'CodiEnre', 'label' => 'CodiEnre', 'type' => 'integer', 'maxlength' => '3'),
			array('name' => 'ObseUsua', 'label' => 'ObseUsua', 'maxlength' => '200'),
			array('name' => 'CodiOrga', 'label' => 'CodiOrga', 'maxlength' => '6'),
			array('name' => 'AcreUsua', 'label' => 'AcreUsua', 'type' => 'integer', 'maxlength' => '1'),
			array('name' => 'FirmUsua', 'label' => 'FirmUsua'),
			array('name' => 'CargUsua', 'label' => 'CargUsua', 'maxlength' => '100'),
			array('name' => 'CoenUsua', 'label' => 'CoenUsua', 'maxlength' => '50'),
			array('name' => 'CosaUsua', 'label' => 'CosaUsua', 'maxlength' => '50'),
			array('name' => 'SemaUsua', 'label' => 'SemaUsua', 'maxlength' => '50'),
			array('name' => 'PumaUsua', 'label' => 'PumaUsua', 'type' => 'integer', 'maxlength' => '4'),
			array('name' => 'UsmaUsua', 'label' => 'UsmaUsua', 'maxlength' => '50'),
			array('name' => 'ComaUsua', 'label' => 'ComaUsua', 'maxlength' => '50'),
			array('name' => 'UsslUsua', 'label' => 'UsslUsua', 'type' => 'integer', 'maxlength' => '1'),
			array('name' => 'UtlsUsua', 'label' => 'UtlsUsua', 'type' => 'integer', 'maxlength' => '1'),
			array('name' => 'AltaUsua', 'label' => 'AltaUsua', 'maxlength' => '8'),
			array('name' => 'AltaFeho', 'label' => 'AltaFeho'),
			array('name' => 'BajaUsua', 'label' => 'BajaUsua', 'maxlength' => '8'),
			array('name' => 'BajaFeho', 'label' => 'BajaFeho', 'type' => 'date'),
			array('name' => 'ModiUsua', 'label' => 'ModiUsua', 'maxlength' => '8'),
			array('name' => 'ModiFeho', 'label' => 'ModiFeho', 'type' => 'date'),
			array('name' => 'BajaMoti', 'label' => 'BajaMoti', 'maxlength' => '100')
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
        
    public function get_users(){
        $this->db->select("codiusua");
        $this->db->where('inhausua',0);
        $rs = $this->db->get('infogov.usuario');
        return $rs->result_array();
    }
}
/* End of file Usuarios_model.php */
/* Location: ./application/modules/expedientes/models/Usuarios_model.php */