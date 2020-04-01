<?php
//Cambio
defined('BASEPATH') OR exit('No direct script access allowed');

class Formularios extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('oficina_actual_id'))) {
            redirect('expedientes/escritorio');
        }
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->load->model('expedientes/formularios_model');
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
                array('label' => '#', 'data' => 'id', 'sort' => 'formulario.id', 'width' => 2),
                array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'formulario.nombre', 'width' => 70),
                array('label' => 'Alias', 'data' => 'alias', 'sort' => 'formulario.alias', 'width' => 25),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'sortable' => 'false', 'searchable' => 'false'),
                array('label' => '', 'data' => 'delete', 'width' => 5, 'sortable' => 'false', 'searchable' => 'false'),
            ),
            'table_id' => 'formularios_table',
            'source_url' => 'expedientes/formularios/listar_data'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Plantillas - Formularios';
        $this->load_template('expedientes/formularios/formulario_abm', $data);
    }

    public function listar_data() {
        if (!in_groups($this->grupos_ajax, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('formulario.id, formulario.nombre, formulario.alias')
                ->unset_column('id')
                ->from("$this->sigmu_schema.formulario")
                ->add_column('edit', '<a href="expedientes/formularios/editar/$1" title="Editar formulario" style="width: 100px;"><i class="fa fa-cogs" ></i></a>', 'id') 
                ->add_column('delete', '<a onclick="modal(); setId($1);" title="Eliminar formulario" style="width: 100px;"><i class="fa fa-trash" aria-hidden="true"></i></a>', 'id'); 
        echo $this->datatables->generate();
    }

    public function editar($id = NULL){
        $data['txt_btn'] = NULL;
        $data['idplantilla'] = $id;
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => '', 'eliminar' => '', 'formulario' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
        $this->load_template('expedientes/formularios/formulario_editar', $data);
    }

    public function editar_data($id = NULL){
        $this->load->model('expedientes/formularios_model');
        $data = array(
            "formitems_data" => $this->formularios_model->getFormitems_data($id),
            "formattr_data" => $this->formularios_model->getFormattr_data($id),
        );
        echo json_encode($data);
    }

    public function editarForm($id = NULL){

        $post = json_decode(file_get_contents('php://input'), true);
        if (isset($post)) {
            header('Content-type: application/json; charset=utf-8');
            $this->load->model('expedientes/formularios_model');
            $resp = $this->formularios_model->updateForm($post['formarray'], $post['formname'], $post['consultaid'], $id);
            echo json_encode($resp);
        } else {
            echo "ERROR";
        }
    }

    public function eliminar($id = NULL){
        if($id != NULL){
            $resp = $this->formularios_model->buscarForm($id);
            if($resp ){
            } else if(intval($resp[0]['vinculos']) > 0){
                $this->session->set_flashdata('error', 'El formulario tiene una o más plantillas vinculadas');
                redirect("expedientes/formularios/listar", "refresh");
            } else {
                $this->formularios_model->eliminarForm($id);
                $this->session->set_flashdata('message', 'Formulario eliminado correctamente');
                redirect("expedientes/formularios/listar", "refresh");
            }
        } else {
            show_404();
        }
    }
}
?>