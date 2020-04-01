<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expedientes_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->table_name = "$this->sigmu_schema.expediente";
        $this->aud_table_name = "{$this->sigmu_schema}_aud.expediente";
        $this->msg_name = 'Expediente';
        $this->id_name = 'id';
        $this->columnas = array('id', 'ano', 'numero', 'anexo', 'inicio', 'fojas', 'tramite_id', 'caratula', 'objeto', 'ultimo_pase', 'fecha_ultimo_pase', 'entrega_pendiente', 'destino_pendiente', 'usuario_pase_emisor', 'fecha_emisor', 'fojas_pendiente', 'acumulado', 'usuario', 'terminal', 'fecha_usuario', 'proceso_usuario', 'monto', 'destinoDeLaConstruccion', 'persona_id', 'ayuda_social_id', 'inmueble_id','digital','firma_pendiente');

        if ($this->session->userdata['oficina_actual_id'] == "1") {
            $this->fields = array(
                array('name' => 'tipo_tramite', 'label' => 'Tipo', 'input_type' => 'combo', 'required' => TRUE, 'onchange' => 'actualizar_tramites();'),
                array('name' => 'numero', 'label' => 'Nº', 'type' => 'integer', 'maxlength' => '11'),
                array('name' => 'ano', 'label' => 'Año', 'type' => 'integer', 'maxlength' => '4', 'required' => TRUE),
                array('name' => 'anexo', 'label' => 'Anexo', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE),
                array('name' => 'inicio', 'label' => 'Fecha', 'type' => 'datetime', 'readonly' => 'readonly'),
                array('name' => 'persona_id','label' => 'Persona', 'onblur' => 'actualizar_solicitante();'),
                array('name' => 'caratula', 'label' => 'Solicitante', 'required' => TRUE, 'readonly' => 'readonly'),
                array('name' => 'tramite', 'label' => 'Trámite', 'input_type' => 'combo', 'id_name' => 'tramite_id', 'required' => TRUE, 'onchange' => 'ver_extras_expediente();'),
                array('name' => 'objeto', 'label' => 'Objeto', 'maxlength' => '100', 'required' => TRUE),
                array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE),
                array('name' => 'inmueble_id', 'label' => 'Inmueble', 'type' => 'hidden'),
                array('name' => 'inmueble', 'label' => 'Inmueble', 'maxlength' => '50', 'readonly' => 'readonly'),
                array('name' => 'numero_madre', 'label' => 'Nº', 'type' => 'integer', 'maxlength' => '11', 'readonly' => 'readonly'),
                array('name' => 'ano_madre', 'label' => 'Año', 'type' => 'integer', 'maxlength' => '4', 'readonly' => 'readonly'),
                array('name' => 'anexo_madre', 'label' => 'Anexo', 'type' => 'integer', 'maxlength' => '11', 'readonly' => 'readonly'),
                array('name' => 'oficina_id', 'label' => 'Destino', 'type' => 'integer', 'maxlength' => '11', 'onblur' => 'actualizar_oficina();', 'required' => FALSE),
                array('name' => 'oficina', 'label' => 'Oficina', 'required' => FALSE, 'readonly' => 'readonly'),   
            );
        } else {
            $this->fields = array(
                array('name' => 'tipo_tramite', 'label' => 'Tipo', 'input_type' => 'combo', 'required' => TRUE, 'onchange' => 'actualizar_tramites();'),
                array('name' => 'numero', 'label' => 'Nº', 'type' => 'integer', 'maxlength' => '11', 'readonly' => 'readonly'),
                array('name' => 'ano', 'label' => 'Año', 'type' => 'integer', 'maxlength' => '4', 'required' => TRUE, 'readonly' => 'readonly'),
                array('name' => 'anexo', 'label' => 'Anexo', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE, 'readonly' => 'readonly'),
                array('name' => 'inicio',  'label' => 'Fecha', 'type' => 'datetime', 'readonly' => 'readonly'),
                array('name' => 'persona_id','label' => 'Persona', 'onblur' => 'actualizar_solicitante();'),
                array('name' => 'caratula', 'label' => 'Solicitante', 'required' => TRUE, 'readonly' => 'readonly'),
                array('name' => 'tramite',       'label' => 'Trámite', 'input_type' => 'combo', 'id_name' => 'tramite_id', 'required' => TRUE, 'onchange' => 'ver_extras_expediente();'),
                array('name' => 'objeto', 'label' => 'Objeto', 'maxlength' => '100', 'required' => TRUE),
                array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE),
                array('name' => 'inmueble_id', 'label' => 'Inmueble', 'type' => 'hidden'),
                array('name' => 'inmueble', 'label' => 'Inmueble', 'maxlength' => '50', 'readonly' => 'readonly'),
                array('name' => 'numero_madre', 'label' => 'Nº', 'type' => 'integer', 'maxlength' => '11', 'readonly' => 'readonly'),
                array('name' => 'ano_madre', 'label' => 'Año', 'type' => 'integer', 'maxlength' => '4', 'readonly' => 'readonly'),
                array('name' => 'anexo_madre', 'label' => 'Anexo', 'type' => 'integer', 'maxlength' => '11', 'readonly' => 'readonly'),
                array('name' => 'oficina_id', 'label' => 'Destino', 'type' => 'integer', 'maxlength' => '11', 'onblur' => 'actualizar_oficina();', 'required' => FALSE),
                array('name' => 'oficina', 'label' => 'Oficina', 'required' => FALSE, 'readonly' => 'readonly'),
            );
        }
        $this->requeridos = array('ano', 'numero', 'anexo', 'tramite_id', 'objeto', 'fojas');
        $this->unicos = array(array('ano', 'numero', 'anexo'));
    }

    /**
     * _can_delete: Devuelve true si puede eliminarse el registro.
     *
     * @param int $delete_id
     * @return bool
     */
    protected function _can_delete($delete_id) {
        if ($this->db->where('id_expediente', $delete_id)->count_all_results("$this->sigmu_schema.archivoadjunto") > 0) {
            $this->_set_error('No se ha podido eliminar el registro de ' . $this->msg_name . '. Verifique que no esté asociado a un archivo adjunto.');
            return FALSE;
        }
        return TRUE;
    }

    public function get_oficina($expediente_id) {
        $pase = $this->db
                        ->where('id_expediente', $expediente_id)
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get($this->config->item('sigmu_schema') . '.pase')->row();
        return empty($pase) ? null : $pase->origen;
    }

    public function is_digital($id_expediente) {
        $this->db->select('t.digital');
        $this->db->join('sigmu.tramite t', 't.id = e.tramite_id');
        $this->db->where('e.id', $id_expediente);
        $query = $this->db->get('sigmu.expediente e');
        $result = $query->row_array();
        if ($result['digital'] == 1 || $result['digital'] == 2) {
            return true;
        } else {
            return false;
        }
    }

    public function get_solicitante($id_expediente = 0) {
        if ($id_expediente > 0) {
            $this->db->select("s.cucupers as cuil, s.detapers as nombre");
            $this->db->join("infogov.persona s", "s.cucupers = e.persona_id");
            $this->db->where("e.id", $id_expediente);
            $query = $this->db->get('sigmu.expediente e');
            return $query->row_array();
        }
        return ["error" => "No se puede busacar expediente " . $id_expediente];
    }

    public function getNombreTramite($idexp){
            $this->db->select("t.*");
            $this->db->join("sigmu.tramite t", "t.id = e.tramite_id");
            $this->db->where("e.id", $idexp);
            $query = $this->db->get('sigmu.expediente e');
            return $query->row_array();
    }
    
    public function firma_pendiente($id_expedinte = 0, $silicita = false) {
        if ($id_expedinte == 0)
            return false;

        $this->db->set('firma_pendiente', $silicita);
        $this->db->where('id', $id_expedinte);
        return $this->db->update('sigmu.expediente');
    }

    public function pendienteDeFirma($id_expediente = 0) {
        if ($id_expediente == 0)
            return FALSE;

        $this->db->select('firma_pendiente');
        $this->db->where('id', $id_expediente);
        $pfrm = $this->db->get('sigmu.expediente')->row_array()['firma_pendiente'];
        return ($pfrm == '1' ? true : false );
    }

    public function verificarEliminacion($id){
        $flag = "";
        $anio = date("Y");
        $query = $this->db->query("SELECT COUNT(*) AS cantidad FROM sigmu.expediente WHERE numero > (SELECT COALESCE(MAX(numero), 0) AS max_nro FROM sigmu.expediente WHERE ano = $anio AND id = $id) AND ano = $anio;");
        if($query->result_array()[0]['cantidad'] > 0 ){
            $flag = "Existe posterior";
        } else {
            $query = $this->db->query("SELECT COUNT(*) AS cantidad FROM sigmu.pase WHERE id_expediente = $id;");
            if($query->result_array()[0]['cantidad'] > 1 ){
                $flag = "Tiene mas de un pase";
            } else {
                $query = $this->db->query("SELECT COUNT(*) AS cantidad FROM sigmu.pase WHERE id_expediente = $id AND destino = -1;");
                if($query->result_array()[0]['cantidad'] = 1 ){
                    $flag = "Pendiente de recepcion";
                }
            }
        }
        return $flag;
    }

    public function eliminar_e($id) {
        
        $this->db->trans_begin();

        $this->db->query('DELETE FROM sigmu.pase WHERE pase.id_expediente = ?',array($id));
        $query = $this->db->query('SELECT COUNT(*) AS cantidad FROM sigmu.archivoadjunto WHERE id_expediente = '.$id);
        if($query->result_array()[0]['cantidad'] > 0 ){
            $this->db->query('DELETE FROM sigmu.archivoadjunto WHERE id_expediente = ?',array($id));
        }
        $this->db->query('DELETE FROM sigmu.expediente WHERE expediente.id = ?',array($id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }
    
    public function find_by_id($id){
            $this->db->select("e.*");
            $this->db->where("e.id", $id);
            $query = $this->db->get('sigmu.expediente e');
            return $query->row_object();
    }

    //Devuelve la oficina en la que se encuentra el expediente
    public function sitioDeExpediente($id){
        $query = $this->db->query("SELECT origen FROM sigmu.pase WHERE id_expediente = $id ORDER BY id DESC LIMIT 1;");
        return $query->result_array();
    }

    public function iniciaExpediente($id){
        $query = $this->db->query("SELECT inicia_expediente FROM sigmu.oficina WHERE id = $id;");
        if($query->result_array()[0]['inicia_expediente'] == '1'){
            return true;
        } else {
            return false;
        }
    }

}

/* End of file Expedientes_model.php */
/* Location: ./application/modules/expedientes/models/Expedientes_model.php */
