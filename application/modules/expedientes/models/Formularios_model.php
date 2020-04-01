<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formularios_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->table_name = "$this->sigmu_schema.formulario";
        $this->msg_name = 'Formulario';
        $this->id_name = 'id';
        $this->columnas = array('id', 'nombre','ver_filtro');
        $this->fields = array(
            array('name' => 'id', 'label' => 'Id', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE),
            array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '45')
        );
        $this->requeridos = array('id');
        //$this->unicos = array();
    }

    /**
     * _can_delete: Devuelve true si puede eliminarse el registro.
     *
     * @param int $delete_id
     * @return bool
     */
    protected function _can_delete($delete_id) {
        if ($this->db->where('formulario_id', $delete_id)->count_all_results('formulario_plantilla') > 0 || $this->db->where('formulario_id', $delete_id)->count_all_results('formulario_consulta') > 0 || $this->db->where('formulario_id', $delete_id)->count_all_results('formulario_elements') > 0) {
            $this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a ninguna plantilla, elementos o consulta.');
            return FALSE;
        }
        return TRUE;
    }

    public function getFormularios($asArray = false) {
        $query = $this->db->query("SELECT f.id,f.nombre, f.ver_filtro FROM sigmu.formulario f"
                . " INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id"
                . " GROUP BY f.nombre");
        if ($asArray) {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    public function getFormulariosNoDisponibles($id_plantilla, $asArray = false) {
        $query = $this->db->query("SELECT f.id,f.nombre,c.titulo,f.alias, f.ver_filtro FROM sigmu.formulario f"
                . " INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id"
                . " INNER JOIN sigmu.formulario_consulta fc ON fc.formulario_id = f.id"
                . " INNER JOIN sigmu.consulta c ON c.id = fc.consulta_id"
                . " INNER JOIN sigmu.formulario_plantilla fp ON  fp.formulario_id = f.id"
                . " WHERE fp.plantilla_id = $id_plantilla"
                . " GROUP BY f.nombre ORDER BY f.id ASC;");
        if ($asArray) {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    public function getFormulariosDisponibles($id_plantilla, $asArray = false) {
        $query = $this->db->query("SELECT f.id,f.nombre, c.titulo, f.ver_filtro FROM sigmu.formulario f"
                . " INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id"
                . " INNER JOIN sigmu.formulario_consulta fc ON fc.formulario_id = f.id"
                . " INNER JOIN sigmu.consulta c ON c.id = fc.consulta_id"
                . " WHERE f.id NOT IN (SELECT fp.formulario_id FROM sigmu.formulario_plantilla fp WHERE fp.plantilla_id = $id_plantilla)"
                . " GROUP BY f.nombre;");
        if ($asArray) {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }

    public function addFormPlantilla($idform, $idplant) {
        if (!empty($idform) && !empty($idplant)) {
            $this->db->trans_start();
            $data = array(
                'formulario_id' => $idform,
                'plantilla_id' => $idplant
            );
            $this->db->insert('sigmu.formulario_plantilla', $data);
            $this->db->trans_complete();
        }
    }

    public function removeFormPlantilla($idform, $idplant) {
        if (!empty($idform) && !empty($idplant)) {
            $this->db->trans_start();
            $this->db->where('formulario_id', $idform);
            $this->db->where('plantilla_id', $idplant);
            $this->db->delete('sigmu.formulario_plantilla');
            $this->db->trans_complete();
        }
    }

    public function getCampos($idcons) {
        if (!empty($idcons)) {
            $this->db->select('id,campo,alias,where');
            $this->db->from('sigmu.campos');
            $this->db->where('consulta_id', $idcons);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function getDataForm($id_form, $id_tram) {
        $query = $this->db->query("SELECT  e.element, fe.name,fe.label, e.class, e.type, e.options, e.value, fe.isrequired, fe.disable, def.plantilla_origen, def.alias_origen FROM sigmu.formulario f "
                . " INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id"
                . " INNER JOIN sigmu.elements e ON e.id = fe.element_id"
                . " LEFT JOIN sigmu.datos_elements_form def ON def.form_element_id = fe.id AND def.formulario_id = fe.formulario_id AND def.element_id = fe.element_id AND def.tramite_id = $id_tram"
                . " WHERE f.id = $id_form ORDER BY fe.id ASC;");
        return $query->result_array();
    }
    public function findForm($id_form) {
        $query = $this->db->query("SELECT  f.id, f.nombre, f.ver_filtro FROM sigmu.formulario f "
                . " WHERE f.id = $id_form;");
        return $query->row();
    }

    public function getFormitems_data($id = NULL){
        if($id != NULL){
            $query = $this->db->query("SELECT formulario_elements.formulario_id, formulario_elements.element_id, formulario_elements.label, formulario_elements.name, 
            formulario_elements.isrequired, formulario_elements.disable FROM sigmu.formulario_elements WHERE formulario_id = $id;");
            return $query->result_array();
        } else {
            return "Error";
        }
    }

    public function getFormattr_data($id = NULL){
        if($id != NULL){
            $query = $this->db->query("SELECT formulario.nombre, formulario_consulta.consulta_id
            FROM sigmu.formulario_consulta
            JOIN sigmu.formulario
            ON formulario_consulta.formulario_id = formulario.id
            WHERE formulario_consulta.formulario_id = $id;");
            return $query->result_array();
        } else {
            return "Error";
        }
    }

    public function updateForm($array = null,$formname = '',$consulta_id = 0, $id) {
        if ($array != null && $formname != '' && $consulta_id > 0) {
            //insertar formulario
            $this->db->trans_start();
            $data = array(
                'nombre' => $formname,
            );
            $this->db->where('id', $id);
            $this->db->update('sigmu.formulario', $data);
            //insertar consulta_formulario
            $id_formulario = $id;
            $this->db->where('formulario_id', $id_formulario);
            $this->db->delete('sigmu.formulario_consulta');
            $data2 = array(
                'formulario_id' => $id_formulario,
                'consulta_id'=> $consulta_id
            );
            $this->db->insert('sigmu.formulario_consulta', $data2);
            //insertar elementos_formulario
            $this->db->where('formulario_id', $id_formulario);
            $this->db->delete('sigmu.formulario_elements');
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
        }  
        return $resp;
    }

    public function getListAlias($id_plantilla,$as_array = false){
        $sql = "SELECT fe.name FROM sigmu.plantilla p
            INNER JOIN sigmu.formulario_plantilla fp ON fp.plantilla_id = p.id
            INNER JOIN sigmu.formulario f ON f.id = fp.formulario_id
            INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id
            WHERE p.id = $id_plantilla;";
        
        if($as_array){
            return $this->db->query($sql)->result_array();
        }
        return $this->db->query($sql)->result();
    }
    public function buscarForm($id = NULL){
        if($id != NULL){
            $query = $this->db->query("SELECT COUNT(*) AS 'vinculos' FROM sigmu.formulario_plantilla WHERE formulario_id = $id;");
            return $query->result_array();
        }
    }

    public function getDataFormByTramite($id_form,$id_tram){
        $sql = "SELECT  e.id, e.element, fe.name,fe.label, fe.id as form_element_id ,fe.formulario_id, fe.element_id, e.class, e.type, e.options, e.value, fe.isrequired, fe.disable, def.plantilla_origen, def.alias_origen,'' as alias_list FROM sigmu.formulario f
        INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id
        INNER JOIN sigmu.elements e ON e.id = fe.element_id
        LEFT JOIN sigmu.datos_elements_form def ON def.form_element_id = fe.id AND def.formulario_id = fe.formulario_id AND def.element_id = fe.element_id AND def.tramite_id = $id_tram
        WHERE f.id = $id_form ORDER BY fe.id ASC;
        ";
        return $this->db->query($sql)->result_array();
    }

    public function guardarReferencia($data){

        $this->db->trans_start();

        $data = array(
            'form_element_id' => $data['form_element_id'],
            'formulario_id' => $data['formulario_id'],
            'element_id' => $data['element_id'],
            'tramite_id' => $data['tramite_id'],
            'plantilla_origen' => $data['plantilla_origen'],
            'alias_origen' => $data['alias_origen']
        );
        
        $this->db->replace('sigmu.datos_elements_form', $data);

        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            return false;
        }
        else 
            $this->db->trans_commit();
        
        return true;
    }

    public function eliminarForm($id = NULL){
        if($id != NULL){
            $query = $this->db->query("DELETE FROM sigmu.formulario_elements WHERE formulario_id = $id;");
            $query = $this->db->query("DELETE FROM sigmu.formulario_consulta WHERE formulario_id = $id;");
            $query = $this->db->query("DELETE FROM sigmu.formulario WHERE id = $id;");
        }
    }
}

/* End of file Formularios_model.php 

 * 
$this->db->select('*');
$this->db->from('blogs');
$this->db->join('comments', 'comments.id = blogs.id');
$query = $this->db->get(); 
 */
/* Location: ./application/modules/expedientes/models/Formularios_model.php */