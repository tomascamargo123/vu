<?php
//Cambio
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultas extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('oficina_actual_id'))) {
            redirect('expedientes/escritorio');
        }
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->load->model('expedientes/consulta_model');
        $this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
        $this->grupos_ajax = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
        $this->grupos_solo_consulta = array('expedientes_consulta_general');
    }

    public function listar(){
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $tableData = array(
            'columns' => array(
                array('label' => '#', 'data' => 'id', 'sort' => 'consulta.id', 'width' => 2),
                array('label' => 'Titulo', 'data' => 'titulo', 'sort' => 'consulta.titulo', 'width' => 20),
                array('label' => 'Alias', 'data' => 'alias', 'sort' => 'consulta.alias', 'width' => 20),
                array('label' => 'Placeholder', 'data' => 'placeholder', 'sort' => 'consulta.placeholder', 'width' => 20),
                array('label' => 'Columnas', 'data' => 'colums_table', 'sort' => 'consulta.colums_table', 'width' => 40),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'sortable' => 'false', 'searchable' => 'false'),
                array('label' => '', 'data' => 'delete', 'width' => 5, 'sortable' => 'false', 'searchable' => 'false'),
            ),
            'table_id' => 'consultas_table',
            'source_url' => 'expedientes/consultas/listar_data'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Consultas';
        $this->load_template('expedientes/consultas/consultas_list', $data);
    }

    public function listar_data() {
        if (!in_groups($this->grupos_ajax, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('consulta.id, consulta.titulo, consulta.alias, consulta.placeholder, consulta.colums_table')
                ->unset_column('id')
                ->from("$this->sigmu_schema.consulta")
                ->add_column('edit', '<a href="expedientes/consultas/editar/$1" title="Editar consulta"><i class="fa fa-cogs"></i></a>', 'id') 
                ->add_column('delete', '<a onclick="modal(); setId($1);" title="Eliminar consulta"><i class="fa fa-trash" aria-hidden="true"></i></a>', 'id'); 
        echo $this->datatables->generate();
    }

    
    public function editar($id = NULL){
        $data['id_consulta'] = $id;
        $data['title'] = 'Expedientes - Consultas - Editar';
        $data['js'][] = 'js/expedientes/vue/vue.js';
        $data['js'][] = 'js/expedientes/vue/axios.js';
        $data['js'][] = 'js/expedientes/vue/consulta_abm.js';
        $this->load_template('expedientes/consultas/consulta_abm', $data);
    }

    
    public function crear(){
        $data['id_consulta'] = 0;
        $data['title'] = 'Expedientes - Consultas - Editar';
        $data['js'][] = 'js/expedientes/vue/vue.js';
        $data['js'][] = 'js/expedientes/vue/axios.js';
        $data['js'][] = 'js/expedientes/vue/consulta_abm.js';
        $this->load_template('expedientes/consultas/consulta_abm', $data);
    }

    /**************************** METODOS JSON *************************** */

    public function get_consulta() {
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $consulta = $this->consulta_model->find($post['idcons'], true);

            if(!empty($consulta)){
                $data['status'] = "success";
                $data['message'] = "Consulta encontrada";
                $data['consulta'] = $consulta;
            }else{
                $data['status'] = "failed";
                $data['message'] = "No se encontro consulta";
            }
        } else {
            $data['status'] = "failed";
            $data['message'] = "No hay datos en la request";
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    
    public function get_campos($idcons) {
        $campos = $this->consulta_model->findCampos($idcons, true);

        if(!empty($campos)){
            $data['status'] = "success";
            $data['message'] = "Campos encontrados";
            $data['campos'] = $campos;
        }else{
            $data['status'] = "failed";
            $data['message'] = "No se encontro consulta asdasd";
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function generate_campos(){
        
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {

            $labels_array = $this->consulta_model->generar_campos($post['sql']); //$query->list_fields(); [['label' => 'CampoUno'],['label' => 'CampoDos']]
            
            foreach($labels_array as $field){
                $campos[] = [
                    'id' => 0,
                    'campo' => $field,
                    'alias' => '',
                    'consulta_id' => $post['idcons'],
                    'where' => 0
                ];
            }
            
            if(!empty($campos)){
                $data['status'] = "success";
                $data['message'] = "Campos encontrados";
                $data['campos'] = $campos;
            }else{
                $data['status'] = "failed";
                $data['message'] = "La consulta no genero campos";
            }
        
        } else {
            $data['status'] = "failed";
            $data['message'] = "No hay datos en la request";
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function save_consulta(){
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $success = $this->consulta_model->save($post['consulta'], $post['campos'],$post['camposdel']);
        
            if(!empty($success)){
                $data['status'] = "success";
                $data['message'] = "Consulta Guardada";
            }else{
                $data['status'] = "failed";
                $data['message'] = "No se encontro consulta";
            }
        } else {
            $data['status'] = "failed";
            $data['message'] = "No hay datos en la request";
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function eliminar($id = NULL){
        if($id != NULL){
            $resp = $this->consulta_model->eliminarConsulta($id);
            if($resp['code'] == 1451){
                $this->session->set_flashdata('error', 'La consulta está relacionada con uno o más trámites');
                redirect("expedientes/consultas/listar", "refresh"); 
            } else {
                $this->session->set_flashdata('message', 'Consulta eliminada correctamente');
                redirect("expedientes/consultas/listar", "refresh"); 
            }
        } else {
            show_404();
        }
    }

}
?>