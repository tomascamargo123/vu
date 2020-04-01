<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form_elements
 *
 * @author m-1
 */
class Elements_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll(){
        $query = $this->db->query("SELECT * FROM sigmu.elements");
        //var_dump($query->result_array());die();
        return $query->result_array();
    }
}
