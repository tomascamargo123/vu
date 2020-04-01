<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Revicion_model
 *
 * @author m-1
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Revision_model extends MY_Model{
    
    public function __construct() {
        parent::__construct();
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->table_name = "$this->sigmu_schema.revision";
        $this->msg_name = 'Revision';
        $this->id_name = 'id';
        $this->columnas = array('id', 'id_pase', 'id_expediente','id_plantilla','estado','observacion','contenido','usuario_revisor','usuario','fecha');
        $this->requeridos = array();
    }
    
    public function find($idrev){
        $this->db->select('*');
        $this->db->where('id', $idrev);
        $this->db->where('estado', 0);
        $query = $this->db->get('sigmu.revision');
        return $query->row_object();
    }
    
    public function all($oficina,$usuario = null){
        $this->db->select('id,id_pase,estado,observacion,contenido,usuario_revisor,usuario,fecha');
        $this->db->join('sigmu.pase', 'pase.id = revision.id_pase AND pase.origen = '.$oficina);
        if(isset($usuario)){
            $this->db->where('usuario_revisor', $usuario);
        }
        $query = $this->db->get('sigmu.revision');
        
        return $query->result_array();
    }
    public function insertar($data){
        $sql = "SELECT max(id) as id from sigmu.pase where id_expediente = ".$data['id_expediente'];
        $id_pase  = $this->db->query($sql)->row_array()['id'];
        
        $data['id_pase'] = $id_pase;
        $data['audi_user'] = $this->session->userdata('CodiUsua');
        if($this->db->insert('sigmu.revision', $data)){
            $last_id = $this->db->insert_id();
            $this->db->set('revision_id', $last_id);
            $this->db->where('id', $id_pase);
            $this->db->update('sigmu.pase');
            return $last_id;
        }
        return 0;
    }
    public function actualizar($data){
        $this->db->set('estado', $data['estado']);
        $this->db->set('observacion', $data['observacion']);
        $this->db->set('audi_user', $this->session->userdata('CodiUsua'));
        $this->db->set('audi_fecha', 'NOW()',FALSE);
        $this->db->set('audi_accion', 'M');
        $this->db->where('id',$data['id']);
        return $this->db->update('sigmu.revision');
    }
    
    public function nueva_revision($data,$rev_old,$pase_id){
        $this->db->trans_begin();
        
        
        $this->db->set('estado',1);       
        $this->db->where('id', $rev_old->id);
        $this->db->update('sigmu.revision');
        
        $data['audi_user'] = $this->session->userdata('CodiUsua');
        $this->db->insert('sigmu.revision', $data);
        $last_id = $this->db->insert_id();
        
        $this->db->set('revision_id', $last_id);
        $this->db->where('id',$pase_id);
        $this->db->update('sigmu.pase');
        
        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }
    
    public function update_revisor($data){
        $this->db->set('usuario_revisor', $data['usuario']);
        $this->db->set('audi_user', $this->session->userdata('CodiUsua'));
        $this->db->set('audi_fecha', date('Y-m-d h:i:s'));
        $this->db->set('observacion',$data['revobse']);
        $this->db->set('contenido',$data['revtext']);
        $this->db->set('audi_accion', 'M');
        $this->db->where('id',$data['idrev']);
        return $this->db->update('sigmu.revision');
        
    }
    
    public function finalizar($revision, $idpase){
        
        $sql = "DELETE FROM sigmu.revision WHERE id_expediente = (SELECT r1.id_expediente FROM sigmu.revision r1 WHERE r1.id = $revision->id) AND id_plantilla = (SELECT r2.id_plantilla FROM sigmu.revision r2 WHERE r2.id = $revision->id) AND estado = 1;"; //el estaod 1 significa que han  sido revisados entonces al finalizar elimino todos los anteriores
        if($this->db->simple_query($sql)){
        
            $this->db->set('id_pase', $idpase);
            $this->db->set('estado', 2);
            $this->db->set('observacion', "FINALIZADO");
            $this->db->set('audi_user', $this->session->userdata('CodiUsua'));
            $this->db->set('audi_fecha', 'NOW()',FALSE);
            $this->db->set('audi_accion', 'M');
            $this->db->where('id',$revision->id);
            return $this->db->update('sigmu.revision');
        }
        return false;
    }
}
