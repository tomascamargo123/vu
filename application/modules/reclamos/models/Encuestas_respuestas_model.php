<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas_respuestas_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'rc_encuestas_respuestas';
		$this->msg_name = 'Respuesta de Encuesta';
		$this->id_name = 'id';
		$this->columnas = array('id', 'encuesta_id', 'pregunta_id', 'puntaje');
		$this->fields = array(
			array('name' => 'encuesta', 'label' => 'Encuesta', 'input_type' => 'combo', 'id_name' => 'encuesta_id', 'required' => TRUE),
			array('name' => 'pregunta', 'label' => 'Pregunta', 'input_type' => 'combo', 'id_name' => 'pregunta_id', 'required' => TRUE),
			array('name' => 'puntaje', 'label' => 'Puntaje', 'required' => TRUE)
		);
		$this->requeridos = array('encuesta_id', 'pregunta_id', 'puntaje');
	}
}
/* End of file Encuestas_respuestas_model.php */
/* Location: ./application/modules/reclamos/models/Encuestas_respuestas_model.php */