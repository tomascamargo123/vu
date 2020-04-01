<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reclamos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_incidentes';
		$this->msg_name = 'Reclamo';
		$this->id_name = 'id';
		$this->columnas = array('id', 'fecha_inicio', 'prioridad_id', 'vencimiento', 'sector_id', 'motivo_id', 'grupo_id', 'tipo_solicitante', 'solicitante_id', 'apellido', 'nombre', 'mail', 'telefono', 'tarea', 'descripcion', 'calle', 'numero', 'manzana', 'casa', 'distrito_id', 'lat_mapa', 'long_mapa', 'numero_luminaria', 'estado', 'fecha_finalizacion', 'resolucion', 'user_id');
		$this->fields = array(
			array('name' => 'fecha_inicio', 'label' => 'Fecha Inicio', 'type' => 'date', 'readonly' => 'readonly', 'required' => TRUE),
			array('name' => 'prioridad', 'label' => 'Prioridad', 'input_type' => 'combo', 'id_name' => 'prioridad_id', 'required' => TRUE),
			array('name' => 'vencimiento', 'label' => 'Vencimiento', 'type' => 'date', 'readonly' => 'readonly'),
			array('name' => 'sector', 'label' => 'Sector', 'input_type' => 'combo', 'id_name' => 'sector_id', 'required' => TRUE),
			array('name' => 'motivo', 'label' => 'Motivo', 'input_type' => 'combo', 'id_name' => 'motivo_id', 'required' => TRUE),
			array('name' => 'grupo', 'label' => 'Grupo', 'input_type' => 'combo', 'id_name' => 'grupo_id', 'required' => TRUE),
			array('name' => 'tipo_solicitante', 'label' => 'Tipo Solicitante', 'input_type' => 'combo', 'required' => TRUE),
			array('name' => 'solicitante', 'label' => 'Solicitante', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'apellido', 'label' => 'Apellido', 'maxlength' => '50'),
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '50'),
			array('name' => 'mail', 'label' => 'Mail', 'maxlength' => '50'),
			array('name' => 'telefono', 'label' => 'Télefono', 'maxlength' => '50'),
			array('name' => 'tarea', 'label' => 'Tarea', 'maxlength' => '50', 'required' => TRUE),
			array('name' => 'descripcion', 'label' => 'Descripción', 'form_type' => 'textarea', 'rows' => '2'),
			array('name' => 'calle', 'label' => 'Calle', 'maxlength' => '50'),
			array('name' => 'numero', 'label' => 'Número', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'manzana', 'label' => 'Manzana', 'maxlength' => '50'),
			array('name' => 'casa', 'label' => 'Casa', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'distrito', 'label' => 'Distrito', 'input_type' => 'combo', 'id_name' => 'distrito_id', 'required' => TRUE),
			array('name' => 'lat_mapa', 'label' => 'Lat Mapa', 'maxlength' => '25', 'type' => 'hidden'),
			array('name' => 'long_mapa', 'label' => 'Long Mapa', 'maxlength' => '25', 'type' => 'hidden'),
			array('name' => 'numero_luminaria', 'label' => 'Número luminaria', 'type' => 'integer', 'maxlength' => '11'),
			array('name' => 'estado', 'label' => 'Estado', 'input_type' => 'combo', 'required' => TRUE),
			array('name' => 'fecha_finalizacion', 'label' => 'Fecha Finalización', 'type' => 'date'),
			array('name' => 'resolucion', 'label' => 'Resolución', 'form_type' => 'textarea', 'rows' => '2'),
		);
		$this->requeridos = array('fecha_inicio', 'prioridad_id', 'sector_id', 'motivo_id', 'tipo_solicitante', 'tarea', 'distrito_id', 'estado', 'user_id');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		if ($this->db->where('incidente_id', $delete_id)->count_all_results('rc_documentos') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a documentos.');
			return FALSE;
		}
		if ($this->db->where('incidente_id', $delete_id)->count_all_results('rc_encuestas') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a encuestas.');
			return FALSE;
		}
		if ($this->db->where('incidente_id', $delete_id)->count_all_results('rc_observaciones_incidentes') > 0)
		{
			$this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a observaciones de reclamos.');
			return FALSE;
		}
		return TRUE;
	}
}
/* End of file Reclamos_model.php */
/* Location: ./application/modules/reclamos/models/Reclamos_model.php */