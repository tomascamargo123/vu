<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.ticket";
		$this->msg_name = 'Ticket';
		$this->id_name = 'id';
		$this->columnas = array('id', 'cantexpe', 'fecha', 'usuario', 'ip','oficina_emisora','oficina_receptora');
		$this->fields = array(
			array('name' => 'id', 'label' => 'Código', 'type' => 'integer', 'maxlength' => '10', 'required' => TRUE),
			array('name' => 'usaurio', 'label' => 'Usuario', 'maxlength' => '50'),
                    array('name' => 'ip', 'label' => 'Ip', 'maxlength' => '50'),
                    array('name' => 'fecha', 'label' => 'Fecha', 'maxlength' => '50'),
		);
		$this->requeridos = array('id', 'nombre');
		//$this->unicos = array();
	}
        
        public function getAll($id_ofic = 0){
            $this->db->select('id, cantexpe,fecha,usuario,ip,oficina_emisora','oficina_receptora');
            $this->db->where('oficina', $id_ofic);
            $this->db->order_by('fecha','DESC');
            $result = $this->db->get('sigmu.oficina');
            
            return $result->result_array();
        }
        
        public function registerTicket($data = array()){
            $last_id = 0;
            $this->db->trans_begin();

            $this->db->insert('sigmu.ticket',$data);
            
            $this->db->select_max('id','id');
            $last_id = $this->db->get('sigmu.ticket')->row_array()['id'];

            if ($this->db->trans_status() === FALSE)
            {
                    $this->db->trans_rollback();
            }
            else
            {
                    $this->db->trans_commit();
            }
            return $last_id;
        }
        
        public function get_detalle($ticket_id = 0, $emitido){
            if($ticket_id > 0 ){
                $this->db->select('e.numero, e.ano, e.anexo');
                $this->db->join('sigmu.expediente e', 'e.id = p.id_expediente');
                $this->db->where('p.ticket_id', $ticket_id);
                ($emitido ? $this->db->where('p.origen', $this->session->userdata('oficina_actual_id')) : '');
                $this->db->where('p.ticket_id >',0);
                $this->db->order_by('p.id','asc');
                $query = $this->db->get('sigmu.pase p');
                return $query->result_array();
                
            }
            return null;
        }
}


