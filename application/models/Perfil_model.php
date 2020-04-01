<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'users';
		$this->msg_name = 'Usuario';
		$this->id_name = 'id';
		$this->columnas = array('id', 'username', 'first_name', 'last_name', 'email', 'created_on', 'CodiUsua');
		$this->fields = array(
			array('name' => 'first_name', 'label' => 'Nombre', 'maxlength' => '50', 'readonly' => 'readonly'),
			array('name' => 'last_name', 'label' => 'Apellido', 'maxlength' => '50', 'readonly' => 'readonly'),
			array('name' => 'old', 'label' => 'Contraseña', 'minlength' => '8', 'maxlength' => '32', 'type' => 'password', 'required' => TRUE, 'error_text' => 'Completa este campo. Mínimo 8 caracteres'),
			array('name' => 'new', 'label' => 'Nueva contraseña (si cambia)', 'minlength' => '8', 'maxlength' => '32', 'matches' => 'new_confirm', 'type' => 'password', 'error_text' => 'Completa este campo. Mínimo 8 caracteres'),
			array('name' => 'new_confirm', 'label' => 'Confirmar nueva contraseña (si cambia)', 'maxlength' => '32', 'val_match' => 'new', 'val_match_text' => 'Debe coincidir con Nueva contraseña', 'type' => 'password')
		);
		$this->requeridos = array();
		$this->unicos = array('username');
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

	public function primeraOficina($usuario, $oficina, $orden){
		$this->db->trans_start();
		$query = $this->db->query("UPDATE sigmu.usuario_oficina SET ORDEN = $orden WHERE ID_USUARIO = '$usuario' AND ORDEN = 1;");
		$query = $this->db->query("UPDATE sigmu.usuario_oficina SET ORDEN = 1 WHERE ID_USUARIO = '$usuario' AND ID_OFICINA = $oficina;");
		$this->db->trans_complete();
		if($this->db->trans_status()){
			$this->db->trans_commit();
			return $this->db->trans_status();
		} else {
			$this->db->trans_rollback();
			return $this->db->trans_status();
		}
	}
}
/* End of file Perfil_model.php */
/* Location: ./application/models/Perfil_model.php */