<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pases_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.pase";
		//$this->aud_table_name = "{$this->sigmu_schema}_aud.pase";
		$this->msg_name = 'Pase';
		$this->id_name = 'id';
        $this->columnas = array('id', 'id_expediente', 'ano', 'numero', 'anexo', 'fecha', 'origen', 
        'destino', 'respuesta', 'fojas', 'marca', 'impreso', 'usuario_emisor', 'usuario_receptor', 
        'usuario', 'terminal', 'fecha_usuario', 'proceso_usuario', 'nota_pase_id', 'ticket_id', 
        'etapa_circuito', 'motivo', 'usuario_derivado');
		$this->fields = array(
			array('name' => 'fecha_usuario', 'label' => 'Fecha', 'type' => 'datetime', 'readonly' => 'readonly'),
			array('name' => 'oficina_origen', 'label' => 'Origen', 'readonly' => 'readonly', 'required' => TRUE),
			array('name' => 'oficina_id', 'label' => 'Enviar pase a', 'type' => 'integer', 'maxlength' => '11', 'onblur' => 'actualizar_oficina();'),
			array('name' => 'oficina', 'label' => 'Oficina', 'required' => TRUE, 'readonly' => 'readonly'),
			array('name' => 'observaciones', 'label' => 'Observaciones', 'form_type' => 'textarea', 'rows' => '3'),
			array('name' => 'respuesta', 'label' => 'Estado', 'readonly' => 'readonly'),
			array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer', 'maxlength' => '9', 'required' => TRUE)
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
        
        public function getFojas($id_expediente){
            $this->db->select('e.fojas');
            $this->db->where('e.id_expediente',$id_expediente);
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('sigmu.pase e');
            $array_row = $query->row_array();
            return $array_row['fojas'];
        }
        
        public function get_estado_pase($id_expediente, $oficina){
            $this->db->select('p.*,o2.nombre as oficina,e.caratula,e.objeto');
            $this->db->join('sigmu.oficina o1', 'o1.id = p.destino');
            $this->db->join('sigmu.oficina o2', 'o2.id = p.origen');
            $this->db->join('sigmu.expediente e', 'e.id = p.id_expediente');
            $this->db->where('p.id_expediente',$id_expediente);
            $this->db->where('p.respuesta','pendiente');
            $this->db->where('o1.nombre',$oficina);
            $query = $this->db->get('sigmu.pase p');
            $array_row = $query->row_array();
            return $array_row;
        }
        
        public function getPendientes_r($oficina, $carrito_list = "()"){
		$this->db->select('pase.id, expediente.id as codigo, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, pase.fecha_usuario, tramite.nombre as tramite_nombre, expediente.caratula as caratula, expediente.objeto as objeto, pase.usuario_emisor, pase.nota_pase_id');
                $this->db->join("sigmu.oficina", 'oficina.id = pase.origen', 'inner');
                $this->db->join("sigmu.expediente", 'expediente.id = pase.id_expediente', 'inner');
                $this->db->join("sigmu.tramite", 'tramite.id = expediente.tramite_id', 'inner');
                $this->db->where('pase.respuesta', 'pendiente');
                $this->db->where("pase.id_expediente NOT IN ",$carrito_list,false);
                $this->db->where('pase.destino', $oficina);
                $this->db->order_by('pase.id','desc');
                $this->db->limit(20);
                
                $query = $this->db->get('sigmu.pase as pase');
                return $query->result_array();

        }
        
        public function roollback_pases($oficina_actual_id){
            //consultamos cuantos expedientes hicieron rollback en pases
            $this->db->where('destino', $oficina_actual_id);
            $this->db->where('respuesta','pendiente');
            $this->db->where("fecha_usuario BETWEEN DATE_SUB(NOW(), INTERVAL 2 DAY) AND DATE_SUB(NOW(), INTERVAL 1 DAY)",null,false );
            
            $this->db->from('sigmu.pase');
            $cant_pase = $this->db->count_all_results(); 
            
            //actualizamos
            $this->db->set('destino', -1);
            $this->db->where('destino', $oficina_actual_id);
            $this->db->where('respuesta','pendiente');
            $this->db->where("fecha_usuario BETWEEN DATE_SUB(NOW(), INTERVAL 2 DAY) AND DATE_SUB(NOW(), INTERVAL 1 DAY)",null,false );
            $this->db->update('sigmu.pase');
            return $cant_pase;
        }
        
        public function getLastPendiente_e($id_exp){
            $this->db->select();
            $this->db->where('id_expediente', $id_exp);
            $this->db->order_by('id', 'desc');
            $this->db->limit('1');
            return $this->db->get('sigmu.pase')->row_array();
        }
        public function getLastEtapaCircuito($id_exp){
            $this->db->select('etapa_circuito');
            $this->db->where('id_expediente', $id_exp);
            $this->db->order_by('etapa_circuito', 'desc');
            $this->db->limit('1');
            return $this->db->get('sigmu.pase')->row_array()['etapa_circuito'];
        }
        
        public function getIdUltimoPase($id_exp){
            $this->db->select('max(id) as id');
            $this->db->where('id_expediente', $id_exp);
            return $this->db->get('sigmu.pase')->result_array()[0]['id'];
        }
        
        public function pendienteRecepcion($pase){
            
            $this->db->select();
            $this->db->where('id_expediente', $pase->id_expediente);
            $this->db->order_by('id', 'desc');
            $this->db->limit('1');
            $last_pase = $this->db->get('sigmu.pase')->row_object();
            
            if($last_pase->id == $pase->id && $last_pase->respuesta = $pase->respuesta == 'pendiente')                
                    return true;
            
            return false;
        }
        
        public function acumularPase($exp_acumular_id,$acumular = true){
            if($acumular){
                $this->db->set('destino', 2);
                $this->db->set('respuesta', 'acumulado');
            }else{
                $this->db->set('destino', -1);
                $this->db->set('respuesta', 'pendiente');
            }
            $this->db->where('id_expediente', $exp_acumular_id);
            if($acumular){
                $this->db->where('destino', -1);
                $this->db->where('respuesta', 'pendiente');
            }else{
                $this->db->where('destino', 2);
                $this->db->where('respuesta', 'acumulado');
            }
            $this->db->update('sigmu.pase');
            return $this->db->affected_rows();
        }

        public function queryTest($sql){
            $query = $this->db->query($sql);
            return $query->result_array();
        }

    public function rechazar_expdigital($resp = NULL){
        if($resp == NULL){
            return FALSE;
        } else {
            $this->db->trans_start();
            $id1 = $resp[0]->id;
            $id2 = $resp[1]->id;
            $query1 = "DELETE FROM sigmu.pase WHERE id = $id1";
            $query2 = "UPDATE sigmu.pase SET destino = -1, respuesta = 'pendiente' WHERE id = $id2";
            $query3 = "SELECT id FROM archivo.archivoadjunto WHERE pase_id = $id2 ORDER BY id DESC LIMIT 2;";
            $this->db->query($query1);
            $this->db->query($query2);
            $adjunto_pase_id1 = $this->db->query($query3)->result_array()[0]['id'];
            $adjunto_pase_id2 = $this->db->query($query3)->result_array()[1]['id'];
            $query4 = "DELETE FROM archivo.archivoadjunto WHERE id = $adjunto_pase_id1";
            $this->db->query($query4);
            $query5 = "DELETE FROM expedientes.fojas_archivos_adjuntos WHERE archivo_adjunto_id = $adjunto_pase_id1";
            $this->db->query($query5);
            $query6 = "SELECT foja_hasta FROM expedientes.fojas_archivos_adjuntos WHERE archivo_adjunto_id = $adjunto_pase_id2";
            $cant_fojas = $this->db->query($query6)->result_array()[0]['foja_hasta'];
            $query7 = "SELECT id_expediente FROM sigmu.pase WHERE id = $id2";
            $id_exp = $this->db->query($query7)->result_array()[0]['id_expediente'];
            $query8 = "UPDATE sigmu.expediente SET fojas = $cant_fojas WHERE id = $id_exp";
            $this->db->query($query8);
            $this->db->trans_complete();

            return $this->db->trans_status();
        }
    }

    public function verificar_firma($pase_id){
        $query = "SELECT * FROM expedientes.firmas_archivos_adjuntos 
        WHERE archivo_adjunto_id = (SELECT id FROM archivo.archivoadjunto WHERE pase_id = $pase_id ORDER BY id DESC LIMIT 1)";
        return $this->db->query($query)->result_array();
    }

    

}
/* End of file Pases_model.php */
/* Location: ./application/modules/expedientes/models/Pases_model.php */