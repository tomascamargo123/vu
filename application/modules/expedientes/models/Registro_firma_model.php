<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Solicitudes_model
 *
 * @author m-1
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Registro_firma_model extends MY_Model{
    //put your code here
    


	public function __construct()
	{
		parent::__construct();
		$this->table_name = "registro_firma";
		$this->msg_name = 'Registro de firmas';
		$this->id_name = 'id';
		$this->columnas = array('id','pdf_id', 'firm_id', 'user_id', 'estado','fecha');
		$this->requeridos = array('pdf_id', 'firm_id', 'user_id',);
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
