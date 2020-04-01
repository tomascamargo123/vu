<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Claves_usuarios_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'users_keys';
		$this->msg_name = 'Clave de usuario';
		$this->id_name = 'id';
		$this->columnas = array('id', 'user_id', 'private_key', 'public_key', 'created_on', 'disabled_on');
		$this->fields = array(
			array('name' => 'old', 'label' => 'Contraseña de usuario', 'maxlength' => '32', 'type' => 'password', 'required' => TRUE, 'error_text' => 'Completa este campo.'),
			array('name' => 'new', 'label' => 'Contraseña de firma', 'minlength' => '8', 'maxlength' => '32', 'matches' => 'new_confirm', 'type' => 'password', 'required' => TRUE, 'error_text' => 'Completa este campo. Mínimo 8 caracteres'),
			array('name' => 'new_confirm', 'label' => 'Confirmar contraseña de firma', 'maxlength' => '32', 'val_match' => 'new', 'val_match_text' => 'Debe coincidir con contraseña de firma', 'type' => 'password', 'required' => TRUE)
		);
		$this->requeridos = array('user_id', 'private_key', 'public_key', 'created_on');
	}

	/**
	 * _can_delete: Devuelve true si puede eliminarse el registro.
	 *
	 * @param int $delete_id
	 * @return bool
	 */
	protected function _can_delete($delete_id)
	{
		return FALSE;
	}
}
/* End of file Claves_usuarios_model.php */
/* Location: ./application/models/Claves_usuarios_model.php */