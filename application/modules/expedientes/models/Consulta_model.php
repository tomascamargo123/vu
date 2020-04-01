<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consulta_model
 *
 * @author m-1
 */
class Consulta_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    public function getAll($as_array = false){
        $query = $this->db->query("SELECT id,consulta,titulo FROM sigmu.consulta;");
        if($as_array)
            return $query->result_array();
        else
            return $query->result();
    }
    public function find($idcons, $as_array = false){
        $query = $this->db->query("SELECT * FROM sigmu.consulta WHERE id = $idcons;");
        if($as_array)
            return $query->row_array();
        else
            return $query->row();
    }

    
    public function findCampos($idcons, $as_array = false){
        $query = $this->db->query("SELECT `id`,`campo`,`alias`,`consulta_id`,`where` FROM `sigmu`.`campos` WHERE `consulta_id` = $idcons;");
        if($as_array)
            return $query->result_array();
        else
            return $query->result();
    }

    public function save($consulta, $campos, $camposdel){
        $this->db->trans_begin();

            $this->db->set('consulta',"\"".$consulta['consulta']."\"",false);
            $this->db->set('titulo',$consulta['titulo']);
            $this->db->set('alias',$consulta['alias']);
            $this->db->set('colums_table',$consulta['colums_table']);
            $this->db->set('placeholder',$consulta['placeholder']);
            if($consulta['id'] > 0){
                $this->db->where('id',$consulta['id']);
                $this->db->update('sigmu.consulta');
                $id = $consulta['id'];
            }else{
                $this->db->insert('sigmu.consulta');
                $id = $this->db->insert_id();
            }
            //borramos los campos
            foreach($camposdel as $item){
                    $this->db->where('id', $item['id']);
                    $this->db->delete('sigmu.campos');
            }
            //insertamos o actualizamos loca campos
            $data_i = [];
            foreach($campos as $item){
                if($item['id'] > 0){
                    $this->db->set('campo', $item['campo']);
                    $this->db->set('alias', $item['alias']);
                    $this->db->set('consulta_id', $item['consulta_id']);
                    $this->db->set('where', $item['where']);
                    $this->db->where('id', $item['id']);
                    $this->db->update('sigmu.campos');
                }else{
                    array_push($data_i,[
                        'campo'=>$item['campo'],
                        'alias'=>$item['alias'],
                        'consulta_id'=>$id,
                        'where'=>$item['where']
                    ]);
                }
            }
            if(sizeof($data_i) > 0)$this->db->insert_batch('sigmu.campos', $data_i);
        if ($this->db->trans_status() === FALSE)
        {
                $this->db->trans_rollback();
                return false;
        }
        else
        {
                $this->db->trans_commit();
                return true;
        }

    }

    public function generar_campos($sql){
        return $this->db->query($sql,false)->list_fields();
    }

    public function getElementsWhere($id_form){
        //trae los campos y los alias a los que hace referencia
        /*
        SELECT c.id, c.campo, c.alias,c.where, c.consulta_id FROM campos c
        INNER JOIN consulta cn ON cn.id = c.consulta_id
        INNER JOIN formulario_consulta fc ON fc.consulta_id = cn.id
        INNER JOIN formulario f ON f.id = fc.formulario_id
        WHERE f.id = 8;
         *          */
        $this->db->select('c.id, c.campo, c.alias,c.where,c.consulta_id');
        $this->db->join('sigmu.consulta cn', 'cn.id = c.consulta_id');
        $this->db->join('sigmu.formulario_consulta fc','fc.consulta_id = cn.id');
        $this->db->join('sigmu.formulario f','f.id = fc.formulario_id');
        $this->db->where('f.id',$id_form);
        $query = $this->db->get('sigmu.campos c');
        return $query->result_array();
    }
    
    public function getEjecutarConsulta($idform,$itemsw){
        $consulta['consulta'] = $this->getConsulta($idform);
        foreach ($itemsw as $item){
            $consulta['consulta']  =  str_replace('#{'.$item['name'].'}', "'".$item['value']."'", $consulta['consulta'] );
        }
        
        $query = $this->db->query($consulta['consulta'] );
        return $query->row_array();
    }
    
    public function ejecutarSQL($sql,$parametro,$campow){
        $sql = str_replace('#{'.$campow.'}',$parametro,$sql);
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function getConsulta($idform){
        /*
SELECT c.consulta FROM consulta c
INNER JOIN formulario_consulta fc ON fc.consulta_id = c.id
INNER JOIN formulario f ON f.id = fc.formulario_id
WHERE f.id = 8;
         *          */
        $this->db->select('c.consulta, c.titulo, c.id, c.alias, c.placeholder, c.colums_table');
        $this->db->join('sigmu.formulario_consulta fc', 'fc.consulta_id = c.id');
        $this->db->join('sigmu.formulario f', 'f.id = fc.formulario_id' );
        $this->db->where('f.id',$idform);
        $query = $this->db->get('sigmu.consulta c');
        
        return $query->result_array();
    }

    public function eliminarConsulta($id = NULL){
        if($id != NULL){
            $query = $this->db->query("DELETE FROM sigmu.campos WHERE consulta_id = $id;");
            $query = $this->db->query("DELETE FROM sigmu.consulta WHERE id = $id;");
        } 
        return $this->db->error(); 
    }
    
}
