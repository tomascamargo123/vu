<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form_element_plantilla_model
 *
 * @author m-1
 */
class Formulario_elements_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert($array = null,$formname = '',$consulta_id = 0) {
        if ($array != null && $formname != '' && $consulta_id > 0) {
            //insertar formulario
            $this->db->trans_start();
            $data = array(
                'nombre' => $formname,
            );
            $this->db->insert('sigmu.formulario', $data);
            $id_formulario = $this->db->insert_id();
            //insertar formulario consulta
            $data2 = array(
                'formulario_id' => $id_formulario,
                'consulta_id'=> $consulta_id
            );
            $this->db->insert('sigmu.formulario_consulta', $data2);
            //insertar elementos_formulario
            $cont= 1;
            foreach ($array as $item) {
                $data = array(
                    'id' => $cont,
                    'element_id' => $item['elem']['id'],
                    'label' => $item['label'],
                    'name' => $item['name'],
                    'isrequired' => $item['required'],
                    'disable' => $item['disable'],
                    'formulario_id' => $id_formulario,
                );
               
                $this->db->insert('sigmu.formulario_elements', $data);
                $cont++;
            }
            $this->db->trans_complete();
        }else{
            return null;
        }  
    }

    public function getElements($id_form){
        $sql = "SELECT * FROM sigmu.formulario_elements WHERE formulario_id = ".$id_form.' ORDER BY formulario_id,id ASC';
        return $this->db->query($sql)->result();
    }

}
