<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Revisor_firmante_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "revisor_firmante";
		$this->aud_table_name = "revisor_firmante";
		$this->msg_name = 'Revisor_firmante';
		$this->id_name = 'id';
		$this->columnas = array('id', 'id_revisor', 'id_firmante');
		$this->fields = array(
			array('name' => 'revisor', 'label' => 'Revisor'),
			array('name' => 'firmante', 'label' => 'Firmante'),
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

	function get_firmantes($id = NULL){
		if($id == NULL){
			$query = "SELECT id, username, CONCAT(first_name, ' ', last_name) AS nombre FROM users WHERE firma_digital = 1 ORDER BY nombre;";
			return $this->db->query($query)->result_array();
		} else {
			$query = "SELECT id, CONCAT(first_name, ' ', last_name) AS nombre FROM users WHERE id = (SELECT id_firmante FROM revisor_firmante WHERE id = $id)			";
			return $this->db->query($query)->result_array();
		}
	}

	function get_firmante_username($id_firmante = NULL){
		if($id_firmante != NULL){
			$query = "SELECT username FROM users WHERE id = $id_firmante";
			return $this->db->query($query)->result_array()[0]['username'];
		}
	}

	function get_revisores_username($username = NULL){
		if($username != NULL){
			$query = "SELECT ID_USUARIO
			FROM sigmu.usuario_oficina
			WHERE ID_OFICINA IN (SELECT
								  id_oficina
								FROM sigmu.usuario_oficina
								WHERE id_usuario LIKE '%$username%'
								GROUP BY id_oficina)
			GROUP BY id_usuario";
			return $this->db->query($query)->result_array();
		}
	}

	function get_revisor($username = NULL){
		if($username != NULL){
			$query = "SELECT id, CONCAT(first_name, ' ', last_name) AS nombre FROM users WHERE username = '$username'";
			return $this->db->query($query)->result_array();
		}
	}
}
/* End of file Revisor_firmante_model.php */
/* Location: ./application/models/Revisor_firmante_model.php */