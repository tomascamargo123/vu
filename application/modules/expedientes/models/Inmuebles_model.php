<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inmuebles_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.inmueble";
		$this->msg_name = 'Inmueble';
		$this->id_name = 'CodiInmu';
		$this->columnas = array('CodiInmu', 'CucuPers', 'DptoInmu', 'DistInmu', 'SeccInmu', 'ManzInmu', 'ParcInmu', 'SubpInmu', 'DigiInmu', 'NomeInmu', 'FealInmu', 'FemoInmu', 'FebaInmu', 'MobaInmu', 'PateInmu', 'MensInmu', 'InscInmu', 'FojaInmu', 'TomoInmu', 'FeinInmu', 'MatrInmu', 'AsieInmu', 'FemaInmu', 'PaprInmu', 'ExpeInmu', 'CodiCall', 'NucaInmu', 'UbicInmu', 'CodiBarr', 'MansInmu', 'CasaInmu', 'CodiLoca', 'CocpInmu', 'DecpInmu', 'NupoInmu', 'CobpInmu', 'DebpInmu', 'MapoInmu', 'CapoInmu', 'UbpoInmu', 'ColpInmu', 'DelpInmu', 'CoppInmu', 'FeesInmu', 'SupeInmu', 'SutiInmu', 'SucuInmu', 'SudeInmu', 'SuscInmu', 'SucmInmu', 'PohoInmu', 'SuprInmu', 'SusuInmu', 'SubaInmu', 'SuenInmu', 'CodiEsin', 'CodiZoin', 'CodiGrin', 'CodiExce', 'FfexInmu', 'ExexInmu', 'MoexInmu', 'ObseInmu', 'PeriInmu', 'BimeInmu', 'CacoInmu', 'AltaUsua', 'ModiUsua', 'BajaUsua', 'AltaFeho', 'ModiFeho', 'BajaFeho');
		$this->fields = array(
			array('name' => 'CodiInmu', 'label' => 'CodiInmu', 'type' => 'integer', 'maxlength' => '8', 'required' => TRUE),
			array('name' => 'CucuPers', 'label' => 'CucuPers', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'DptoInmu', 'label' => 'DptoInmu', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'DistInmu', 'label' => 'DistInmu', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'SeccInmu', 'label' => 'SeccInmu', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'ManzInmu', 'label' => 'ManzInmu', 'type' => 'integer', 'maxlength' => '4'),
			array('name' => 'ParcInmu', 'label' => 'ParcInmu', 'type' => 'integer', 'maxlength' => '6'),
			array('name' => 'SubpInmu', 'label' => 'SubpInmu', 'type' => 'integer', 'maxlength' => '4'),
			array('name' => 'DigiInmu', 'label' => 'DigiInmu', 'type' => 'integer', 'maxlength' => '1'),
			array('name' => 'NomeInmu', 'label' => 'NomeInmu', 'maxlength' => '21'),
			array('name' => 'FealInmu', 'label' => 'FealInmu', 'type' => 'date'),
			array('name' => 'FemoInmu', 'label' => 'FemoInmu', 'type' => 'date'),
			array('name' => 'FebaInmu', 'label' => 'FebaInmu', 'type' => 'date'),
			array('name' => 'MobaInmu', 'label' => 'MobaInmu', 'maxlength' => '30'),
			array('name' => 'PateInmu', 'label' => 'PateInmu', 'maxlength' => '12'),
			array('name' => 'MensInmu', 'label' => 'MensInmu', 'type' => 'integer', 'maxlength' => '5'),
			array('name' => 'InscInmu', 'label' => 'InscInmu', 'type' => 'integer', 'maxlength' => '8'),
			array('name' => 'FojaInmu', 'label' => 'FojaInmu', 'type' => 'integer', 'maxlength' => '5'),
			array('name' => 'TomoInmu', 'label' => 'TomoInmu', 'maxlength' => '3'),
			array('name' => 'FeinInmu', 'label' => 'FeinInmu', 'type' => 'date'),
			array('name' => 'MatrInmu', 'label' => 'MatrInmu', 'type' => 'integer', 'maxlength' => '8'),
			array('name' => 'AsieInmu', 'label' => 'AsieInmu', 'maxlength' => '5'),
			array('name' => 'FemaInmu', 'label' => 'FemaInmu', 'type' => 'date'),
			array('name' => 'PaprInmu', 'label' => 'PaprInmu', 'type' => 'integer', 'maxlength' => '8'),
			array('name' => 'ExpeInmu', 'label' => 'ExpeInmu', 'maxlength' => '15'),
			array('name' => 'CodiCall', 'label' => 'CodiCall', 'type' => 'integer', 'maxlength' => '4'),
			array('name' => 'NucaInmu', 'label' => 'NucaInmu', 'type' => 'integer', 'maxlength' => '6'),
			array('name' => 'UbicInmu', 'label' => 'UbicInmu', 'maxlength' => '40'),
			array('name' => 'CodiBarr', 'label' => 'CodiBarr', 'type' => 'integer', 'maxlength' => '4'),
			array('name' => 'MansInmu', 'label' => 'MansInmu', 'maxlength' => '5'),
			array('name' => 'CasaInmu', 'label' => 'CasaInmu', 'maxlength' => '5'),
			array('name' => 'CodiLoca', 'label' => 'CodiLoca', 'type' => 'integer', 'maxlength' => '3'),
			array('name' => 'CocpInmu', 'label' => 'CocpInmu', 'type' => 'integer', 'maxlength' => '5'),
			array('name' => 'DecpInmu', 'label' => 'DecpInmu', 'maxlength' => '50'),
			array('name' => 'NupoInmu', 'label' => 'NupoInmu', 'type' => 'integer', 'maxlength' => '6'),
			array('name' => 'CobpInmu', 'label' => 'CobpInmu', 'type' => 'integer', 'maxlength' => '4'),
			array('name' => 'DebpInmu', 'label' => 'DebpInmu', 'maxlength' => '40'),
			array('name' => 'MapoInmu', 'label' => 'MapoInmu', 'maxlength' => '5'),
			array('name' => 'CapoInmu', 'label' => 'CapoInmu', 'maxlength' => '5'),
			array('name' => 'UbpoInmu', 'label' => 'UbpoInmu', 'maxlength' => '80'),
			array('name' => 'ColpInmu', 'label' => 'ColpInmu', 'type' => 'integer', 'maxlength' => '3'),
			array('name' => 'DelpInmu', 'label' => 'DelpInmu', 'maxlength' => '40'),
			array('name' => 'CoppInmu', 'label' => 'CoppInmu', 'maxlength' => '15'),
			array('name' => 'FeesInmu', 'label' => 'FeesInmu', 'type' => 'date'),
			array('name' => 'SupeInmu', 'label' => 'SupeInmu'),
			array('name' => 'SutiInmu', 'label' => 'SutiInmu'),
			array('name' => 'SucuInmu', 'label' => 'SucuInmu'),
			array('name' => 'SudeInmu', 'label' => 'SudeInmu'),
			array('name' => 'SuscInmu', 'label' => 'SuscInmu'),
			array('name' => 'SucmInmu', 'label' => 'SucmInmu'),
			array('name' => 'PohoInmu', 'label' => 'PohoInmu'),
			array('name' => 'SuprInmu', 'label' => 'SuprInmu'),
			array('name' => 'SusuInmu', 'label' => 'SusuInmu'),
			array('name' => 'SubaInmu', 'label' => 'SubaInmu'),
			array('name' => 'SuenInmu', 'label' => 'SuenInmu'),
			array('name' => 'CodiEsin', 'label' => 'CodiEsin', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'CodiZoin', 'label' => 'CodiZoin', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'CodiGrin', 'label' => 'CodiGrin', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'CodiExce', 'label' => 'CodiExce', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'FfexInmu', 'label' => 'FfexInmu', 'type' => 'date'),
			array('name' => 'ExexInmu', 'label' => 'ExexInmu', 'maxlength' => '15'),
			array('name' => 'MoexInmu', 'label' => 'MoexInmu', 'maxlength' => '50'),
			array('name' => 'ObseInmu', 'label' => 'ObseInmu'),
			array('name' => 'PeriInmu', 'label' => 'PeriInmu'),
			array('name' => 'BimeInmu', 'label' => 'BimeInmu', 'type' => 'integer', 'maxlength' => '2'),
			array('name' => 'CacoInmu', 'label' => 'CacoInmu', 'type' => 'integer', 'maxlength' => '3'),
			array('name' => 'AltaUsua', 'label' => 'AltaUsua', 'maxlength' => '8'),
			array('name' => 'ModiUsua', 'label' => 'ModiUsua', 'maxlength' => '8'),
			array('name' => 'BajaUsua', 'label' => 'BajaUsua', 'maxlength' => '8'),
			array('name' => 'AltaFeho', 'label' => 'AltaFeho', 'required' => TRUE),
			array('name' => 'ModiFeho', 'label' => 'ModiFeho', 'type' => 'date'),
			array('name' => 'BajaFeho', 'label' => 'BajaFeho', 'type' => 'date')
		);
		$this->requeridos = array('CodiInmu', 'AltaFeho');
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
/* End of file Inmuebles_model.php */
/* Location: ./application/modules/expedientes/models/Inmuebles_model.php */