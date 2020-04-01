<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Circuito_model
 *
 * @author m-1
 */
class Circuito_model extends MY_Model{
    //put your code here
    public function __construct()
	{
		parent::__construct();
		$this->table_name = "sigmu.circuito";
		$this->msg_name = 'Circuito';
		//$this->id_name = 'orden';
		$this->columnas = array('tramite_id', 'plantilla_id','oficina_id','orden','firma');
//		$this->fields = array(
//			array('name' => 'descripcion', 'label' => 'Descripción', 'maxlength' => '200', 'required' => TRUE)
//		);
		$this->requeridos = array('tramite_id','plantilla_id');
		$this->unicos = array('tramite_id','plantilla_id');
	}
        
        public function getPlantillas_x_Tramite($tramite_id){
            $this->db->select('circuito.plantilla_id,circuito.tramite_id,circuito.orden,'
                    . ' if(circuito.plantilla_id is not null, (select p.nombre from sigmu.plantilla p where p.id  = circuito.plantilla_id),"") as name_form,'
                    . 'oficina.nombre as name_ofic,'
                    . '(SELECT o.nombre FROM sigmu.oficina o WHERE o.id = circuito.oficina_destino_id) as name_ofic_destino,'
                    . '(SELECT o2.nombre FROM sigmu.oficina o2 WHERE o2.id = circuito.oficina_rechazo_id) as name_ofic_rechazo,'
                    . '(SELECT GROUP_CONCAT(f.usuario) FROM sigmu.firmante f WHERE f.plantilla_id = circuito.plantilla_id AND f.tramite_id = circuito.tramite_id) AS firmantes');
            
            $this->db->join('sigmu.oficina', 'oficina.id = circuito.oficina_id');
            $this->db->join('sigmu.tramite','tramite.id = circuito.tramite_id');
            $this->db->order_by('circuito.orden','asc');
            $this->db->where('circuito.tramite_id',$tramite_id);
            
            $query = $this->db->get('sigmu.circuito');

            return $query->result_array();
        }
        
        public function insertar($data = null){
            if(!empty($data)){
                $this->db->set('tramite_id', $data['tramite_id']);
                $this->db->set('plantilla_id', $data['plantilla_id']);
                $this->db->set('oficina_destino_id', $data['destino_id']);
                $this->db->set('oficina_id', $data['origen_id']);
                $this->db->set('oficina_rechazo_id', $data['oficina_rechazo']);
                
                $this->db->set('orden', $data['orden']);
                $this->db->insert('sigmu.circuito');
                return true;
            }
            return false;
        }
        
        public function actualizar($data = null){
            if(!empty($data)){
                $this->db->set('plantilla_id', $data['plantilla_id']);
                $this->db->set('oficina_destino_id', $data['destino_id']);
                $this->db->set('oficina_id', $data['origen_id']);
                $this->db->set('oficina_rechazo_id', $data['oficina_rechazo']);
                
                $this->db->where('orden', $data['orden']);
                $this->db->where('tramite_id', $data['tramite_id']);
                $this->db->update('sigmu.circuito');
                return true;
            }
            return false;
        }
        
        public function eliminar($data = null){
            if(!empty($data)){
                $this->db->delete('sigmu.circuito', array('tramite_id' => $data['tramite_id'], 'orden' => $data['orden']));
                return true;
            }
            return false;
        }
        
        public function set_firmantes($data = null){
            if(!empty($data)){
                $this->db->trans_begin();
                    $this->db->query('DELETE FROM sigmu.firmante WHERE tramite_id = '.$data['tramite_id'].' AND plantilla_id = '.$data['plantilla_id']);
                    foreach ($data['firmantes'] as $firmante){
                        $this->db->query("INSERT INTO sigmu.firmante (tramite_id, plantilla_id, usuario) VALUES (".$data['tramite_id'].",".$data['plantilla_id'].",'".$firmante."');");
                    }
                if($this->db->trans_status() === TRUE){
                    $this->db->trans_commit();
                }else{
                    $this->db->trans_rollback();
                }
            }
            return null;
        }
        public function set_destino($data = null){
            if(!empty($data)){
                //var_dump($firms);die();
                $this->db->set('oficina_destino_id', $data['oficina_destino_id']);
                $this->db->where('tramite_id', $data['tramite_id']);
                $this->db->where('plantilla_id', $data['plantilla_id']);
                return $this->db->update('sigmu.circuito');
            }
            return null;
        }
        
        //devuelve el ultimo circuito realizado
        public function findByExpediente($id_exp = null){
            /*
            if(!empty($id_exp)){
                $this->db->select('ct.tramite_id, ct.plantilla_id, c.orden');
                $this->db->join('sigmu.circuito c', 'c.tramite_id = ct.tramite_id and c.plantilla_id = ct.plantilla_id', 'left');
                $this->db->join('sigmu.tramite t','t.id = ct.tramite_id');
                $this->db->join('sigmu.expediente e', 'e.tramite_id = t.id');
                $this->db->where('ct.expediente_id', $id_exp);
                $this->db->order_by('c.orden', 'desc');
                $this->db->limit(1);
                $query = $this->db->get('sigmu.circuito_firmas_historico ct');
                
                return $query->row_array();
            }
             */
            
            if(!empty($id_exp)){
                $sql = "SELECT e.tramite_id, c.plantilla_id, c.orden  FROM sigmu.pase p
                        INNER JOIN sigmu.expediente e ON e.id = p.id_expediente
                        INNER JOIN sigmu.tramite t ON t.id = e.tramite_id
                        INNER JOIN sigmu.circuito c ON c.tramite_id = t.id
                        WHERE e.id = ".$id_exp." AND p.etapa_circuito = c.orden
                        GROUP BY orden
                        ORDER BY c.orden desc LIMIT 1;";
                $query = $this->db->query($sql);
                return $query->row_array();
            }
            return array();
        }
        
        public function getSigCircuito($id_exp, $id_ofi, $orden = 0){
            //var_dump($id_exp,$id_ofi,$orden);die();
            if(!empty($id_exp)){
                $this->db->select('c.plantilla_id, c.tramite_id, c.orden, c.oficina_id, o1.nombre as origen, c.oficina_destino_id, o2.nombre as destino, IF( c.plantilla_id IS NOT NULL, (SELECT `p`.`nombre` FROM `sigmu`.`plantilla` `p` WHERE `p`.`id` = `c`.`plantilla_id`), null ) as plantilla_nombre');
                $this->db->join('sigmu.tramite t', 't.id = c.tramite_id');
                $this->db->join('sigmu.oficina o1', 'o1.id = c.oficina_id');
                $this->db->join('sigmu.oficina o2', 'o2.id = c.oficina_destino_id');
                $this->db->join('sigmu.expediente e', 'e.tramite_id = t.id');
                $this->db->where('e.id', $id_exp);
                $this->db->where('c.orden > '. $orden);
                $this->db->where('c.oficina_id', $id_ofi);
                $this->db->order_by('c.orden', 'asc');
                $this->db->limit(1);
                $query = $this->db->get('sigmu.circuito c');
                return $query->row_array();
            }
        }
        
        public function getCircuito($id_plantilla, $id_tramite){
            $this->db->select('tramite_id, plantilla_id, oficina_id, oficina_destino_id, (SELECT GROUP_CONCAT(f.usuario) FROM sigmu.firmante f WHERE f.plantilla_id = circuito.plantilla_id AND f.tramite_id = circuito.tramite_id) AS firmantes, o.nombre as origen_name, o2.nombre as destino_name');
            $this->db->join('sigmu.oficina o', 'o.id = circuito.oficina_id','left');
            $this->db->join('sigmu.oficina o2', 'o2.id = circuito.oficina_destino_id','left');
            $this->db->where('tramite_id',$id_tramite);
            $this->db->where('plantilla_id',$id_plantilla);
            $query = $this->db->get('sigmu.circuito');
            
            return $query->row_array();
        }
        
        
        public function solicitar_firmas($data){
                $this->db->trans_begin();
                foreach ($data['firmantes'] as $firmante){
                    if(!empty($firmante)){
                        
                        $this->db->set('estado', $data['estado']);
                        $this->db->set('estado_lectura', $data['estado_lectura']);
                        $this->db->set('fecha_solicitud', $data['fecha_solicitud']);
                        $this->db->set('solicitante_id', $data['solicitante_id']);
                        $this->db->set('archivo_adjunto_id', $data['archivo_adjunto_id']);
                        $this->db->set('usuario_id', "(SELECT id FROM expedientes.users WHERE users.username = '$firmante' LIMIT 1)",false);
                        $this->db->set('audi_user',$data['solicitante_name']);
                        $this->db->set('audi_fecha',date('Y:m:d H:i:s'));
                        $this->db->set('audi_accion','I');
                        $this->db->set('pase_id',$data['pase_id']);
                        $this->db->insert('expedientes.firmas_archivos_adjuntos');
                        //indicamos al expediente que se tiene firmas pendientes
                        $this->db->set('firma_pendiente',true);
                        $this->db->where('id',"(SELECT pase.id_expediente FROM sigmu.pase WHERE pase.id = ".$data['pase_id'].")",false);
                        $this->db->update('sigmu.expediente');
                    }
                }
                if($this->db->trans_status() == false){
                    $this->db->trans_rollback();
                    return false;
                }else{
                    $this->db->trans_commit();
                    return true;
                }
            
        }
        
        public function guardar_temporal($data){
            $this->db->set('tramite_id',$data['tramite_id']);
            $this->db->set('plantilla_id',$data['plantilla_id']);
            $this->db->set('expediente_id',$data['expediente_id']);
            $this->db->set('estado',$data['estado']);
            $this->db->set('audi_user',$data['audi_user']);
            $this->db->set('audi_fecha',date('Y:m:d H:i:s'));
            $this->db->set('audi_accion','I');
            $this->db->insert('sigmu.circuito_firmas_historico');
        }
        
        public function continuar_pase($pase,$con_firma,$oficina_destino,$user,$expediente_id,$num_pag = 0, $etapa_circuito = 0){
            //realizamos la primera parte de la fase la firma, aqui modificarmos la cantidad de fojas que tiene el expediente ahora mismo
           $fecha = date('Y-m-d H:i:s');
            //busco la cantidad de fojas actuales
            $p_sql = "UPDATE sigmu.pase SET respuesta = '".($con_firma ? "firma pendiente" : "aceptado" )."',destino = ".($con_firma ? "-1" : $oficina_destino).",fecha = ?,fecha_usuario = ?, fojas = fojas+".$num_pag.", audi_fecha = NOW(), audi_user = ? , audi_accion = 'U'"
                    . " WHERE pase.id = ? AND id_expediente = ?";
            $e_sql = "UPDATE sigmu.expediente e SET e.fojas = (SELECT (p.fojas) as fojas FROM sigmu.pase p WHERE p.id_expediente = ? ORDER BY p.id DESC Limit 1), e.fecha_ultimo_pase = CURRENT_TIMESTAMP() WHERE e.id = ?";
            
           $this->db->trans_begin();
            //actualizamos el pase
           $this->db->query($p_sql, array( $fecha, $fecha, $user, $pase['id'], $expediente_id));
           /* actualizamos el expediente*/
            $this->db->query($e_sql,array($expediente_id,$expediente_id));
            
            if(!$con_firma){
                $this->db->query(
                        "INSERT INTO sigmu.pase (id_expediente,ano,numero,anexo,origen,destino,respuesta,fojas,usuario_emisor,fecha_usuario,fecha,etapa_circuito) values (?,?,?,?,?,?,?,?,?,?,?,?)",
                        array($expediente_id,$pase['ano'],$pase['numero'],$pase['anexo'],$oficina_destino,'-1','pendiente',$pase['fojas']+$num_pag,$user,$fecha,$fecha,$etapa_circuito +1)
                        );
            }
            
            //var_dump($this->db->queries);die();
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                return true;
            }
        }
        
        /*borrar*/
        public function continuar_pase_old($data,$user,$expediente_id,$estado = "pendiente",$num_pag = 1){
            /*if($estado != "pendiente"){
                $data['oficina_destino_id'] = -3;
            }*/
            $fecha = date('Y-m-d H:i:s');
            //busco la cantidad de fojas actuales
            $p_sql = "UPDATE sigmu.pase SET respuesta = ? , destino = ?, fecha = ?,fecha_usuario = ?, fojas = fojas+".$num_pag.", audi_fecha = NOW(), audi_user = ? , audi_accion = 'U'"
                    . " WHERE origen = ? AND destino = -1 AND id_expediente = ?";
            $e_sql = "UPDATE sigmu.expediente e SET e.fojas = (SELECT (p.fojas) as fojas FROM sigmu.pase p WHERE p.id_expediente = ? ORDER BY p.id DESC Limit 1), e.fecha_ultimo_pase = CURRENT_TIMESTAMP() WHERE e.id = ?";
            
           $this->db->trans_begin();
            //actualizamos el pase
           $this->db->query($p_sql, array($estado, $data['oficina_destino_id'], $fecha, $fecha, $user, $data['oficina_id'], $expediente_id));
           /* actualizamos el expediente*/
            $this->db->query($e_sql,array($expediente_id,$expediente_id));
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                return true;
            }
        }
        
        public function ultimoPase($id_exp){
            $this->db->select('id');
            $this->db->where('id_expediente', $id_exp);
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $query = $this->db->get('sigmu.pase');
            return $query->row_array();
        }
        
        public function getMax($id_tram){
            $query = $this->db->query("SELECT MAX(circuito.orden) as max FROM sigmu.circuito WHERE tramite_id = $id_tram;");
            return $query->row_array();
        }
        
	public function get_last_destino($tramite_id)
	{
		$circuito = $this->db->select('c.oficina_destino_id')->from('sigmu.circuito c')->where('c.tramite_id', $tramite_id)->order_by('c.orden','desc')->get()->row_array();
		if (empty($circuito))
		{
			return FALSE;
		}
		else
		{
			return $circuito;
		}
	}
        
        public function siguienteOficina($id_exp){
            if(!empty($id_exp)){
                //SELECT origen, destino FROM pase WHERE pase.id_expediente = 253584 ORDER BY pase.id ASC;
                $this->db->select('p.origen, p.destino, p.etapa_circuito');
                $this->db->where('p.id_expediente', $id_exp);
                $this->db->order_by('p.id', 'desc');
                $query = $this->db->get('sigmu.pase p');
                
                $pases =  $query->result_array();
                $query->free_result();
                $this->db->select('c.oficina_id AS origen, c.oficina_destino_id AS destino, c.orden');
                $this->db->join('sigmu.expediente e', 'e.tramite_id = c.tramite_id');
                $this->db->where('e.id', $id_exp);
                $this->db->order_by('c.orden', 'asc');
                $query = $this->db->get('sigmu.circuito c');
                $cicuito_pases = $query->result_array();
                $query->free_result();
                
                $sgte_ofi = isset($cicuito_pases[0]['destino']) ? $cicuito_pases[0]['destino'] : null;//si aun no empieza el circuito devuelve la primer oficina del circuito
                
                $index = 0;
                if($pases[0]['etapa_circuito'] > 0){//cuando es circuito sin plantilla indica la siguiente oficina a la que debe ir el exp
                    foreach ($cicuito_pases as $cp){
                        if($cp['origen'] == $pases[0]['origen'] && $cp['orden'] == ($pases[0]['etapa_circuito']+1)){
                            ( $index < sizeof($cicuito_pases) ? $sgte_ofi = $cicuito_pases[$index]['destino']: '');
                            break;
                        }
                        $index++;
                    }
                }else{
                    foreach ($cicuito_pases as $cp){//cuando se esta fuera del circuito indica siempre la oficina de donde salio el expediente
                        foreach ($pases as $p){
                            if(/*$cp['origen'] == $p['origen'] && */$cp['destino'] == $p['destino'] && $cp['orden'] == ($p['etapa_circuito']+1)){
                                ( $index+1 < sizeof($cicuito_pases) ? $sgte_ofi = $cicuito_pases[$index+1]['origen']: '');
                                break;
                            }
                        }
                        $index++;
                    }
                }
//                var_dump("Sig ofi".$sgte_ofi);die();
                return $sgte_ofi;
            }
//            var_dump("id exp: ".$id_exp);die();
            return null;
        }
        
        public function  getNodos($id_tramite){
            $this->db->select('c.orden, c.tramite_id, c.plantilla_id, c.oficina_id, c.oficina_destino_id, c.oficina_rechazo_id, o.nombre as oficina_origen');
            $this->db->join('sigmu.oficina o', 'o.id = c.oficina_destino_id');
            $this->db->where('tramite_id',$id_tramite);
            $this->db->order_by('c.orden', 'asc');
            $query = $this->db->get('sigmu.circuito c');
            return $query->result_array();
        }

        public function get_plantillas_before($etapa,$idtram,$as_array = false){
            $sql = "SELECT p.id,p.nombre FROM sigmu.plantilla p INNER JOIN sigmu.circuito c ON c.plantilla_id = p.id WHERE c.orden < $etapa AND c.tramite_id = $idtram ORDER BY c.orden;";
            if($as_array){
                return $this->db->query($sql)->result_array();
            }
            return $this->db->query($sql)->result();
        }
    }
