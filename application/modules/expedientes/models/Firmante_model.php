<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Firmante
 *
 * @author m-1
 */
class Firmante_model extends MY_Model{
    //put your code here
    public function __construct()
	{
		parent::__construct();
		$this->table_name = "sigmu.firmante";
		$this->msg_name = 'Firmante';
		$this->columnas = array('id','tramite_id', 'plantilla_id','usuario');
		$this->requeridos = array('tramite_id', 'plantilla_id','usuario');
		$this->unicos = array('tramite_id','plantilla_id','usuario');
	}
        public function get_firmantes($id_tram,$id_plant){
            $this->db->select('f.id,f.usuario,p.DetaPers');
            $this->db->join('infogov.usuario u', 'u.CodiUsua = f.usuario');
            $this->db->join('infogov.persona p', 'u.CucuPers = p.CucuPers');
            $this->db->where('f.plantilla_id', $id_plant);
            $this->db->where('f.tramite_id', $id_tram);
            return $this->db->get('sigmu.firmante f')->result_array();
        }
        
        public function get_usuarios($id_tram,$id_plant){
            
            $sql = "SELECT u1.username, p.DetaPers, '' AS checked FROM expedientes.users u1
                INNER JOIN infogov.usuario  u2 ON u1.username = u2.CodiUsua
                INNER JOIN infogov.persona p ON u2.CucuPers = p.CucuPers
                WHERE u1.firma_digital = 1 AND u1.username NOT IN (
                        SELECT f.usuario FROM sigmu.firmante f WHERE tramite_id = $id_tram AND plantilla_id = $id_plant
                );";
            return $this->db->query($sql)->result_array();
        }
        
        public function quitar_firmante($id){
            $this->db->delete('sigmu.firmante', ['id' => $id]);
        }
        public function agregar_firmantes($firmantes){
           $this->db->trans_begin();
           $this->db->insert_batch('sigmu.firmante',$firmantes);
           
           if($this->db->trans_status() === FALSE){
               $this->db->trans_rollback();
           }else{
               $this->db->trans_commit();
           }
        }
}       
