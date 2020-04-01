<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Firmaspad_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = "sigmu.firmaspad";
		$this->msg_name = 'Imagen de firma';
		$this->id_name = 'id';
		$this->columnas = array('id', 'archivoadjunto_id', 'firma_img', 'usuario','fecha');
		$this->requeridos = array('archivoadjunto_id', 'firma_img');
		$this->unicos = array('archivo_adjunto_id');
	}

}