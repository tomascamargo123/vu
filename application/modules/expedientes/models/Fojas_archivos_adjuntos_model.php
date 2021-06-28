<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fojas_archivos_adjuntos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = "fojas_archivos_adjuntos_alt";
		$this->msg_name = 'Foja de archivo adjunto';
		$this->id_name = 'id';
		$this->columnas = array('id', 'archivo_adjunto_id', 'foja_desde', 'foja_hasta');
		$this->requeridos = array('archivo_adjunto_id', 'foja_desde', 'foja_hasta');
		$this->unicos = array('archivo_adjunto_id');
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

	public function get_archivo($expediente_id, $foja)
	{
		$sigmu_schema = $this->config->item('sigmu_schema');
		$archivo_schema = $this->config->item('archivo_schema');
		return $this->db->select('aa.*')
				->from("$archivo_schema.archivoadjunto aa")
				->join('fojas_archivos_adjuntos faa', 'aa.id=faa.archivo_adjunto_id')
				->where('aa.id_expediente', $expediente_id)
				->where('faa.foja_desde <=', $foja)
				->where('faa.foja_hasta >=', $foja)
				->get()->row();
	}
}
/* End of file Fojas_archivos_adjuntos_model.php */
/* Location: ./application/modules/expedientes/models/Fojas_archivos_adjuntos_model.php */