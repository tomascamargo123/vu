<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Firmas_archivos_adjuntos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table_name = "firmas_archivos_adjuntos";
		$this->msg_name = 'Firma de archivo adjunto';
		$this->id_name = 'id';
		$this->columnas = array('id', 'archivo_adjunto_id', 'usuario_id', 'estado', 'estado_lectura', 'fecha_solicitud', 'solicitante_id', 'fecha_firma', 'firma', 'fecha_rechazo', 'motivo_rechazo');
		$this->requeridos = array('archivo_adjunto_id', 'usuario_id', 'estado', 'estado_lectura');
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

	public function get_firmas($id)
	{
		return $this->db->select('faa.id, faa.fecha_solicitud, faa.fecha_firma,UPPER(faa.estado) AS estado, faa.firma, u.CodiUsua as usuario, u.first_name as usuario_nombre, u.last_name as usuario_apellido, s.CodiUsua as solicitante, s.first_name as solicitante_nombre, s.last_name as solicitante_apellido, uk.public_key, c.descripcion as cargo')
				->from('firmas_archivos_adjuntos faa')
				->join('users u', 'u.id=faa.usuario_id')
				->join('users s', 's.id=faa.solicitante_id', 'left')
				->join('users_keys uk', 'uk.user_id=faa.usuario_id AND faa.fecha_firma >= uk.created_on AND faa.fecha_firma <= COALESCE(uk.disabled_on, \'2100-01-01\')', 'left')
				->join('cargos_usuarios cu', 'cu.user_id=u.id AND faa.fecha_firma BETWEEN cu.desde AND COALESCE(cu.hasta, \'2100-01-01\')', 'left', FALSE)
				->join('cargos c', 'c.id=cu.cargo_id', 'left')
				->where('faa.archivo_adjunto_id', $id)
				->where('faa.estado !=', 'Rechazada')
				->get()->result();
	}
        
        public function get_cant_pendientes($id_arch_adj)
	{
		$array_res = $this->db->select('faa.id, faa.fecha_solicitud, faa.fecha_firma, faa.firma, u.CodiUsua as usuario, u.first_name as usuario_nombre, u.last_name as usuario_apellido, s.CodiUsua as solicitante, s.first_name as solicitante_nombre, s.last_name as solicitante_apellido, uk.public_key, c.descripcion as cargo')
				->from('firmas_archivos_adjuntos faa')
				->join('users u', 'u.id=faa.usuario_id')
				->join('users s', 's.id=faa.solicitante_id', 'left')
				->join('users_keys uk', 'uk.user_id=faa.usuario_id AND faa.fecha_firma >= uk.created_on AND faa.fecha_firma <= COALESCE(uk.disabled_on, \'2100-01-01\')', 'left')
				->join('cargos_usuarios cu', 'cu.user_id=u.id AND faa.fecha_firma BETWEEN cu.desde AND COALESCE(cu.hasta, \'2100-01-01\')', 'left', FALSE)
				->join('cargos c', 'c.id=cu.cargo_id', 'left')
				->where('faa.archivo_adjunto_id', $id_arch_adj)
				->where('faa.estado !=', 'Rechazada')
				->where('faa.estado !=', 'Realizada')
				->get()->result_array();
                
                return count($array_res);
	}
        
        public function tieneFirmaPendiente($id_expediente, $user_id = null){
            /*
            SELECT COUNT(faa.id) AS cant FROM expedientes.firmas_archivos_adjuntos faa
            INNER JOIN sigmu.archivoadjunto aa ON aa.id = faa.archivo_adjunto_id
            WHERE faa.usuario_id = 38 AND aa.id_expediente = 253587 AND faa.estado = "Solicitada";
             */
            $this->db->select('faa.id');
            $this->db->join('sigmu.archivoadjunto aa', 'aa.id = faa.archivo_adjunto_id');
            $this->db->where('faa.usuario_id'.($user_id == null  ? '> 0' : '='.$user_id));
            $this->db->where('aa.id_expediente', $id_expediente);
            $this->db->where('faa.estado', 'Solicitada');
            $query = $this->db->get('expedientes.firmas_archivos_adjuntos faa');
            $arr_result = $query->result_array();
            if(count($arr_result) > 0){
                return true;
            }  else {
                return false;
            }
            
        }
}
/* End of file Firmas_archivos_adjuntos_model.php */
/* Location: ./application/modules/expedientes/models/Firmas_archivos_adjuntos_model.php */