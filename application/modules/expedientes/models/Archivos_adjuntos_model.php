<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos_adjuntos_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->table_name = "$this->sigmu_schema.archivoadjunto";
		$this->msg_name = 'Archivo adjunto';
		$this->id_name = 'id';
		$this->columnas = array('id', 'nombre', 'tamanio', 'tipodecontenido', 'contenido', 'id_expediente', 'descripcion', 'fecha', 'pase_id', 'orden');
		$this->fields = array(
			array('name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '255'),
			array('name' => 'tamanio', 'label' => 'Tamaño', 'type' => 'integer', 'maxlength' => '20'),
			array('name' => 'tipodecontenido', 'label' => 'Tipo', 'maxlength' => '100'),
//			array('name' => 'descripcion', 'label' => 'Descripción', 'maxlength' => '45'),
			array('name' => 'fecha', 'label' => 'Fecha', 'type' => 'datetime')
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
        public function getPDF($id = 0) {
        if ($id != 0) {
            $this->db->select('contenido');
            $this->db->where('id', $id);
            $this->db->where('tipodecontenido', 'application/pdf');
            $this->db->from('sigmu.archivoadjunto');
            $query = $this->db->get();

            return $query->result_array();
        }
        return null;
    }

    public function savePDFSigned($array_xml = null) {
        if (empty($array_xml)) {
            $this->db->set(
                    'contenido',
                    base64_decode($array_xml['file']),
                    FALSE);
            $this->db->where('id', $array_xml['id']);
            $this->db->update('sigmu.archivoadjunto');
            return true;
        }
        return false;
    }
    
    public function insert_pdf($data = null){
        if(empty($data)){
            return false;
        }
        
        $this->db->set('tipodecontenido', $data['tipodecontenido']);
        $this->db->set('contenido', $data['contenido']);
        $this->db->set('descripcion', $data['descripcion']);
        $this->db->set('id_expediente', $data['id_expediente']);
        $this->db->set('fecha', $data['fecha']);
        $this->db->set('nombre', $data['nombre']);
        $this->db->set('tamanio', $data['tamanio']);
        $this->db->set('audi_user', $data['user']);
        $this->db->set('audi_fecha', date('Y-m-d H:i:s'));
        $this->db->set('audi_accion', 'I');
        $this->db->set('pase_id', $data['pase_id']);
        return $this->db->insert('sigmu.archivoadjunto');
    }
    
    public function max_id(){
        return $this->db->insert_id();
    }

    public function get_paseId($id_expediente = NULL){
        if($id_expediente != NULL){
            return $this->db->query("SELECT id FROM sigmu.pase WHERE id_expediente = $id_expediente AND respuesta = 'pendiente';")->result_array();
        }
    }

    public function get_adjuntos($id_expediente = NULL){
        if($id_expediente != NULL){
            return $this->db->query("SELECT
            `archivoadjunto`.`id`,
            `archivoadjunto`.`nombre`,
            `archivoadjunto`.`tamanio`,
            `archivoadjunto`.`tipodecontenido`,
            `archivoadjunto`.`pase_id`,
            `archivoadjunto`.`id_expediente`,
            `archivoadjunto`.`fecha`,
            `archivoadjunto`.`orden`,
            firmas_archivos_adjuntos.estado,
            CASE 
            WHEN estado = 'Solicitada' THEN 1
            ELSE 0
            END AS firma_pendiente
          FROM `sigmu`.`archivoadjunto`
            LEFT JOIN `expedientes`.`firmas_archivos_adjuntos`
              ON `archivoadjunto`.`id` = `firmas_archivos_adjuntos`.`archivo_adjunto_id`
          WHERE firmas_archivos_adjuntos.id IN (SELECT
            MAX(firmas_archivos_adjuntos.id)
          FROM expedientes.firmas_archivos_adjuntos 
          RIGHT JOIN sigmu.archivoadjunto 
          ON firmas_archivos_adjuntos.archivo_adjunto_id = archivoadjunto.id
          WHERE `sigmu`.`archivoadjunto`.`id_expediente` = '$id_expediente'
          GROUP BY nombre) OR (firmas_archivos_adjuntos.id IS NULL AND 
          `sigmu`.`archivoadjunto`.`id_expediente` = '$id_expediente')
          ORDER BY firmas_archivos_adjuntos.id DESC")->result_array();
        }
    }
}
/* End of file Archivos_adjuntos_model.php */
/* Location: ./application/modules/expedientes/models/Archivos_adjuntos_model.php */