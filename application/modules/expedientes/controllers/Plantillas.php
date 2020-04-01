<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plantillas extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('oficina_actual_id'))) {
            redirect('expedientes/escritorio');
        }
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->load->model('expedientes/plantillas_model');
        $this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
        $this->grupos_ajax = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
        $this->grupos_solo_consulta = array('expedientes_consulta_general');
    }

    public function listar() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $tableData = array(
            'columns' => array(
                array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'plantilla.nombre', 'width' => 70),
                array('label' => 'Pad de firmas', 'data' => 'firmapad', 'sort' => 'plantilla.firmapad', 'width' => 25),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'plantillas_table',
            'source_url' => 'expedientes/plantillas/listar_data'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Plantillas';
        $this->load_template('expedientes/plantillas/plantillas_listar', $data);
    }

    public function listar_data($tipo = 'comun') {
        if (!in_groups($this->grupos_ajax, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('plantilla.id, plantilla.nombre, plantilla.texto, IF(plantilla.firmapad > 0, "SI", "NO") AS firmapad')
                ->unset_column('id')
                ->from("$this->sigmu_schema.plantilla")
                ->where(($tipo == 'comun') ? ['plantilla.id >' => '0'] : ['plantilla.dinamica' => '0'])
                ->add_column('edit', '<a href="expedientes/plantillas/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id')
                ->add_column('select', '<a data-dismiss="modal" href="" onclick="seleccionar_plantilla($1);" title="Seleccionar"><i class="fa fa-check"></i></a>', 'id');

        echo $this->datatables->generate();
    }

    public function agregar() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/plantillas/listar", 'refresh');
        }
        $this->set_model_validation_rules($this->plantillas_model);
        if ($this->form_validation->run() === TRUE) {
            $trans_ok = TRUE;
            $trans_ok&= $this->plantillas_model->create(array(
                'nombre' => $this->input->post('nombre'),
                'texto' => $this->input->post('texto', FALSE),
                'dinamica' => ($this->input->post('dinamica') == 'on' ? '1' : '0'),
            ));

            if ($trans_ok) {
                $this->session->set_flashdata('message', $this->plantillas_model->get_msg());
                redirect('expedientes/plantillas/listar', 'refresh');
            }
        }
        $data['error'] = (validation_errors() ? validation_errors() : ($this->plantillas_model->get_error() ? $this->plantillas_model->get_error() : $this->session->flashdata('error')));

        $data['fields'] = array();
        foreach ($this->plantillas_model->fields as $field) {
            if (empty($field['input_type'])) {
                $this->add_input_field($data['fields'], $field);
            } elseif ($field['input_type'] === 'combo') {
                if (isset($field['type']) && $field['type'] === 'multiple') {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
                } else {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']});
                }
            }
        }

        $data['txt_btn'] = 'Agregar';
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled', 'formulario' => 'disabled', 'vista_previa' => 'disabled');
        $data['title'] = 'Expedientes - Plantillas - Agregar';
        $this->load_template('expedientes/plantillas/plantillas_abm', $data);
    }

    public function editar($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/plantillas/ver/$id", 'refresh');
        }
        $plantilla = $this->plantillas_model->get(array('id' => $id));
        if (empty($plantilla)) {
            show_404();
        }
        $this->set_model_validation_rules($this->plantillas_model);
        if (isset($_POST) && !empty($_POST)) {
            if ($id !== $this->input->post('id')) {
                show_error('Esta solicitud no pasó el control de seguridad.');
            }

            if ($this->form_validation->run() === TRUE) {
                $trans_ok = TRUE;
                $trans_ok&= $this->plantillas_model->update(array(
                    'id' => $this->input->post('id'),
                    'nombre' => $this->input->post('nombre'),
                    'texto' => $this->input->post('texto', FALSE),
                    'firmapad' => $this->input->post('firmapad'),
                    'dinamica' => ($this->input->post('dinamica') == 'on' ? '1' : '0'),
                    ));
                if ($trans_ok) {
                    $this->session->set_flashdata('message', $this->plantillas_model->get_msg());
                    redirect('expedientes/plantillas/listar', 'refresh');
                }
            }
        }
        $data['error'] = (validation_errors() ? validation_errors() : ($this->plantillas_model->get_error() ? $this->plantillas_model->get_error() : $this->session->flashdata('error')));

        $data['fields'] = array();
        foreach ($this->plantillas_model->fields as $field) {
            if (empty($field['input_type'])) {
                $this->add_input_field($data['fields'], $field, $plantilla->{$field['name']});
            } elseif ($field['input_type'] === 'combo') {
                if (isset($field['type']) && $field['type'] === 'multiple') {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
                } else {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $plantilla->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
                }
            }
        }
        $data['plantilla'] = $plantilla;

        $data['txt_btn'] = 'Editar';
        $data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '', 'formulario' => 'disabled', 'vista_previa' => 'disabled');
        $data['title'] = 'Expedientes - Plantillas - Editar';
        $this->load_template('expedientes/plantillas/plantillas_abm', $data);
    }

    public function eliminar($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/plantillas/ver/$id", 'refresh');
        }
        $plantilla = $this->plantillas_model->get(array('id' => $id));
        if (empty($plantilla)) {
            show_404();
        }
        if (isset($_POST) && !empty($_POST)) {
            if ($id !== $this->input->post('id')) {
                show_error('Esta solicitud no pasó el control de seguridad.');
            }

            $trans_ok = TRUE;
            $trans_ok&= $this->plantillas_model->delete(array('id' => $this->input->post('id')));
            if ($trans_ok) {
                $this->session->set_flashdata('message', $this->plantillas_model->get_msg());
                redirect('expedientes/plantillas/listar', 'refresh');
            }
        }
        $data['error'] = (validation_errors() ? validation_errors() : ($this->plantillas_model->get_error() ? $this->plantillas_model->get_error() : $this->session->flashdata('error')));

        $data['fields'] = array();
        foreach ($this->plantillas_model->fields as $field) {
            $field['disabled'] = TRUE;
            if (empty($field['input_type'])) {
                $this->add_input_field($data['fields'], $field, $plantilla->{$field['name']});
            } elseif ($field['input_type'] == 'combo') {
                if (isset($field['type']) && $field['type'] === 'multiple') {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
                } else {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $plantilla->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
                }
            }
        }

        $data['plantilla'] = $plantilla;

        $data['txt_btn'] = 'Eliminar';
        $data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active','formulario'=>'diabled','vista_previa'=>'disable');
        $data['title'] = 'Expedientes - Plantillas - Eliminar';
        $this->load_template('expedientes/plantillas/plantillas_abm', $data);
    }

    public function ver($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $plantilla = $this->plantillas_model->get(array('id' => $id));
        if (empty($plantilla)) {
            show_404();
        }
        $data['error'] = $this->session->flashdata('error');

        $data['fields'] = array();
        foreach ($this->plantillas_model->fields as $field) {
            $field['disabled'] = TRUE;
            if (empty($field['input_type'])) {
                $this->add_input_field($data['fields'], $field, $plantilla->{$field['name']});
            } elseif ($field['input_type'] == 'combo') {
                if (isset($field['type']) && $field['type'] === 'multiple') {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
                } else {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $plantilla->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
                }
            }
        }

        $data['plantilla'] = $plantilla;
        $data['txt_btn'] = NULL;
        $data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '', 'formulario' => '', 'vista_previa' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
        #var_dump($data);die();
        $this->load_template('expedientes/plantillas/plantillas_abm', $data);
    }

    public function circuito_firmas($plantilla_id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $plantilla_id == NULL || !ctype_digit($plantilla_id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $plantilla = $this->plantillas_model->get(array('id' => $plantilla_id));
        if (empty($plantilla)) {
            show_404();
        }
        $tableData = array(
            'columns' => array(
                array('label' => 'Cargo', 'data' => 'descripcion', 'width' => 20, 'sortable' => 'false'),
                array('label' => 'Usuario', 'data' => 'username', 'width' => 20, 'sortable' => 'false'),
                array('label' => 'Nombre', 'data' => 'first_name', 'width' => 20, 'sortable' => 'false'),
                array('label' => 'Apellido', 'data' => 'last_name', 'width' => 20, 'sortable' => 'false'),
                array('label' => 'Orden', 'data' => 'orden', 'width' => 15, 'sortable' => 'false'),
                array('label' => '', 'data' => 'remove', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'plantillas_table',
            'source_url' => 'expedientes/plantillas/circuito_firmas_data/' . $plantilla_id,
            'order' => array(array(4, 'asc')),
            'disableSearching' => TRUE,
            'paging' => 'false'
        );
        $data['fields'] = array();
        foreach ($this->plantillas_model->fields as $field) {
            $field['disabled'] = TRUE;
            if (empty($field['input_type'])) {
                $this->add_input_field($data['fields'], $field, $plantilla->{$field['name']});
            }
        }
        $this->load->model('expedientes/cargos_model');
        $array_cargo = $this->get_array('cargos', 'descripcion', 'id', array(
            'sort_by' => 'id',
            'where' => array("id NOT IN (SELECT cargo_id FROM firmas_circuitos fc JOIN circuitos c ON fc.circuito_id=c.id WHERE c.plantilla_id=$plantilla_id)")
                ), array(0 => '-- Seleccionar cargo --'));

        $data['array_cargo'] = $array_cargo;
        $data['plantilla'] = $plantilla;
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Plantillas';
        $this->load_template('expedientes/plantillas/plantillas_circuito_firmas', $data);
    }

    public function circuito_firmas_data($plantilla_id) {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('cargos.descripcion, users.first_name, users.last_name, users.username, firmas_circuitos.orden, firmas_circuitos.id')
                ->from('firmas_circuitos')
                ->join('circuitos', 'circuitos.id=firmas_circuitos.circuito_id')
                ->join('cargos', 'cargos.id=firmas_circuitos.cargo_id')
                ->join('cargos_usuarios', 'cargos_usuarios.cargo_id=cargos.id', 'left')
                ->join('users', 'cargos_usuarios.user_id=users.id', 'left')
                ->where('plantilla_id', $plantilla_id)
                ->where('cargos_usuarios.hasta IS NULL')
                ->add_column('remove', '<a href="expedientes/plantillas/circuito_firmas_op/$1/del" title="Quitar"><i class="fa fa-ban"></i></a> <a href="expedientes/plantillas/circuito_firmas_op/$1/up" title="Subir"><i class="fa fa-arrow-up"></i></a><a href="expedientes/plantillas/circuito_firmas_op/$1/down" title="Bajar"><i class="fa fa-arrow-down"></i></a>', 'id');

        echo $this->datatables->generate();
    }

    public function circuito_firmas_add($plantilla_id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $plantilla_id == NULL || !ctype_digit($plantilla_id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $plantilla = $this->plantillas_model->get(array('id' => $plantilla_id));
        if (empty($plantilla)) {
            show_404();
        }
        $cargo = $this->input->post('cargo');
        if ($cargo == 0) {
            $this->session->set_flashdata('error', 'Debe seleccionar un cargo');
            redirect("expedientes/plantillas/circuito_firmas/$plantilla_id", 'refresh');
        }
        $this->load->model('expedientes/cargos_model');
        $array_cargo = $this->get_array('cargos', 'descripcion', 'id', array(
            'sort_by' => 'id',
            'where' => array("id NOT IN (SELECT cargo_id FROM firmas_circuitos fc JOIN circuitos c ON fc.circuito_id=c.id WHERE c.plantilla_id=$plantilla_id)")
        ));
        if (!array_key_exists($cargo, $array_cargo)) {
            $this->session->set_flashdata('error', 'Cargo seleccionado no válido');
            redirect("expedientes/plantillas/circuito_firmas/$plantilla_id", 'refresh');
        }
        $this->load->model('expedientes/circuitos_model');
        $this->load->model('expedientes/firmas_circuitos_model');
        $circuito = $this->circuitos_model->get_circuito($plantilla_id);
        $this->db->trans_begin();
        $trans_ok = TRUE;
        if ($circuito === FALSE) {
            $trans_ok&= $this->circuitos_model->create(array('plantilla_id' => $plantilla_id), FALSE);
            $circuito_id = $this->circuitos_model->get_row_id();
            $orden = 1;
        } else {
            $circuito_id = $circuito->id;
            $orden = $circuito->orden;
        }
        $trans_ok&= $this->firmas_circuitos_model->create(array(
            'circuito_id' => $circuito_id,
            'orden' => $orden,
            'cargo_id' => $cargo
                ), FALSE);
        if ($this->db->trans_status() && $trans_ok) {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', 'Se agregó la firma al circuito exitosamente');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Ocurrió un error al agregar firma a circuito');
        }
        redirect("expedientes/plantillas/circuito_firmas/$plantilla_id", 'refresh');
    }

    public function circuito_firmas_op($firma_circuito_id = NULL, $accion = '') {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $firma_circuito_id == NULL || !ctype_digit($firma_circuito_id) || !in_array($accion, array('del', 'up', 'down'))) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->load->model('expedientes/firmas_circuitos_model');
        $firma_circuito = $this->firmas_circuitos_model->get(array('id' => $firma_circuito_id, 'join' => array(array('table' => 'circuitos', 'where' => 'circuitos.id=firmas_circuitos.circuito_id', 'columnas' => array('circuitos.plantilla_id')))));
        if (empty($firma_circuito)) {
            show_404();
        }
        if ($this->firmas_circuitos_model->operacion($firma_circuito, $accion)) {
            $this->session->set_flashdata('message', 'Se modificó el circuito exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Ocurrió un error al modificar el circuito');
        }
        redirect("expedientes/plantillas/circuito_firmas/$firma_circuito->plantilla_id", 'refresh');
    }

    public function formulario($id = 0) {
        $this->load->model('expedientes/formularios_model');
        $formularios = $this->formularios_model->getFormularios(); //trae un array con todos los formularios
        $this->load->model('expedientes/plantillas_model');
        $misform = $this->plantillas_model->misFormularios($id); //trae un array con el id_formulario y el id_plantilla

        $data['formsdisp'] = $formularios;
        $data['misforms'] = $misform;

        $data['txt_btn'] = NULL;
        $data['idplantilla'] = $id;
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => '', 'eliminar' => '', 'formulario' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
        $this->load_template('expedientes/plantillas/formulario', $data);
    }

    public function crear_form($id = 0) {

        $data['txt_btn'] = NULL;
        $data['idplantilla'] = $id;
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => '', 'eliminar' => '', 'formulario' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
        $this->load_template('expedientes/plantillas/crear_form', $data);
    }

    public function ver_formulario($id_plantilla, $id_formulario) {
        $this->load->model('expedientes/formularios_model');
        $data['title'] = 'Expedientes - Formulario - Ver';

        $data['idplan'] = $id_plantilla;
        $data['idform'] = $id_formulario;
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => '', 'eliminar' => '', 'formulario' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
        $this->load_template('expedientes/plantillas/ver_form', $data);
    }

    public function crear_formulario_back() {

        /* Leemos los parámetros enviados por post */
        $post = json_decode(file_get_contents('php://input'), true);
        if (isset($post)) {
            header('Content-type: application/json; charset=utf-8');
//            echo json_encode(array("elementos" => $post['formarray']));
            $this->load->model('expedientes/formulario_elements_model');
            $this->formulario_elements_model->insert($post['formarray'], $post['formname'], $post['consultaid']);
        }
    }

    public function get_elements_json() {
        $this->load->model('expedientes/elements_model');
        $data = $this->elements_model->getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function get_consultas_json() {
        $this->load->model('expedientes/consulta_model');
        $data = $this->consulta_model->getAll();
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function get_campos_json() {

        $post = json_decode(file_get_contents('php://input'), true);
        if (isset($post)) {
            $this->load->model('expedientes/formularios_model');
            $data = $this->formularios_model->getCampos($post['idcons']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

    public function get_forms($id = 0) {
        $this->load->model('expedientes/formularios_model');
        $data = $this->formularios_model->getFormulariosDisponibles($id, true);
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function get_my_forms_get($idplant) {

        $this->load->model('expedientes/formularios_model');
        $data = $this->formularios_model->getFormulariosNoDisponibles($idplant, true);
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function get_my_forms() {

        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $this->load->model('expedientes/formularios_model');
            $data = $this->formularios_model->getFormulariosNoDisponibles($post['idplant'], true);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            //echo 'nada';
        }
    }

    public function get_my_forms_complete() {
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $this->load->model(['expedientes/formularios_model','expedientes/consulta_model','expedientes/expedientes_model']);
            $forms = $this->formularios_model->getFormulariosNoDisponibles($post['idplant'], true);
            
            $idtram = $this->db->query("SELECT tramite_id FROM sigmu.expediente WHERE id = ".$post['idexp'])->row_array()['tramite_id'];
            $cont = 0;
            foreach ($forms as $f) {
                $elements = $this->formularios_model->getDataForm($f['id'],$idtram);
                $consulta = $this->consulta_model->getConsulta($f['id']);
                $campos_key = $this->consulta_model->getElementsWhere($f['id']); //son las referencias de que campo llenara que dato en el formulario
                $forms[$cont]['elements'] = $elements;
                $forms[$cont]['consulta'] = $consulta;
                $forms[$cont]['search_param'] = '0';
                $forms[$cont]['campos_key'] = $campos_key;
                $forms[$cont]['consulta_index'] = 0;
                $forms[$cont]['data_table'] = array();
                $cont++;
            }


            header('Content-type: application/json; charset=utf-8');
            echo json_encode($forms);
        } else {
            echo 'nada';
        }
    }

    public function get_form_data() {
        /* Leemos los parámetros enviados por post */
        $post = json_decode(file_get_contents('php://input'), true);

        if (isset($post)) {
            $this->load->model('expedientes/formularios_model');
            $data = $this->formularios_model->getDataForm($post['id_form']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

    public function get_form_by_id() {
        /* Leemos los parámetros enviados por post */
        $post = json_decode(file_get_contents('php://input'), true);

        if (isset($post)) {
            $this->load->model('expedientes/formularios_model');
            $data = $this->formularios_model->findForm($post['id_form']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        }
    }

    public function action_form_themplate() {
        /* Leemos los parámetros enviados por post */
        $post = json_decode(file_get_contents('php://input'), true);
        if (isset($post)) {
            header('Content-type: application/json; charset=utf-8');
//            echo json_encode(array("elementos" => $post['formarray']));
            $this->load->model('expedientes/formularios_model');
            switch ($post['action']) {
                case "add":
                    $this->formularios_model->addFormPlantilla($post['idform'], $post['idplant']);
                    break;
                case "remove":
                    $this->formularios_model->removeFormPlantilla($post['idform'], $post['idplant']);
                    break;
            }
        }
    }

    public function create_form() {
        $post = json_decode(file_get_contents('php://input'), true);
        if (isset($post)) {
            $plant = $this->plantillas_model->getPlantilla($post['idplant']);
            $html = $plant->texto;
            foreach ($post['data'] as $item) {
                $html = str_replace("#{" . $item['name'] . "}", $item['value'], $html);
            }
            //echo $html;
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
//			$pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure
            $pdf->WriteHTML($html); // write the HTML into the PDF
            $pdf->Output(str_replace(" ", "_", $plant->titulo) . ".pdf", 'I');
        }
    }

    public function create_pdf() {
        $post = $this->input->post();
        //var_dump($post);die();
        if (!empty($post)) {
            $this->load->model('expedientes/consulta_model');
            $plant = $this->plantillas_model->getPlantilla($post['idplant']);
           
            $html = '<br><br><br>'.$plant->texto;
            
            if(strpos($html, "#{fecha_hoy}")){
                $fecha_str = date("d F Y",  strtotime(date("Y-m-d")));
                $html = str_replace("#{fecha_hoy}", $this->parsearFecha($fecha_str), $html);
            }
            //pongo nombre de usuario sistema
            if(strpos($html, "#{usuario_sistema}")){
                $html = str_replace("#{usuario_sistema}", $this->session->userdata('first_name').' '.$this->session->userdata('last_name'), $html);
            }
            //coloco firmas
            if(!empty($post['firmapad'])){
                $firmas_array = explode('<separator>', $post['firmapad']);

                for($i = 1; $i <= $plant->firmapad; $i++){
                    if(strpos($html, "#{firma_pad_".$i."}")){
                        $firma_b64 = '<img src="@data:image/png;base64,'.$firmas_array[$i-1].'" height="100" width="200">';
                        $html = str_replace("#{firma_pad_".$i."}", $firma_b64, $html);
                    }
                }
            }
            //completo todos los valores de la plantilla
            foreach ($post as $key => $value) {
                if ($key != 'idplant') {
                    if ($value == "") {
                        $html = str_replace("#{" . $key . "}", " -- ", $html);
                    } else {
                        if(strpos($key, "fecha")){//contiene la palabra fecha en la key entonces hay que parsear
                            $fecha_str = date("d F Y",  strtotime($value));
                            
                            $html = str_replace("#{" . $key . "}", $this->parsearFecha($fecha_str), $html);
                        }else{
                            $html = str_replace("#{" . $key . "}", $value, $html);
                        }
                    }
                } else {
                    $html = str_replace("#{" . $key . "}", "", $html);
                }
            }

//            echo $html;
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->defaultheaderline = false;
            ////<img style="position:absolute; float:right;" src="img/expedientes/folio.png"/>
//			$pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure
            $pdf->setHeader('<div style="height: 57px;width: 80px;background-image: url(\'img/expedientes/folio.png\');position:absolute;float:right;text-align:center;padding-top: 22px;"><span style="font-size:24px">{PAGENO}</span></div>
                            <table width="100%" style="border: 0.1mm solid #000000;font-family: `Times New Roman`, Times, serif;">
                                <tr>
                                    <td width="25%" style="text-align: center;">
                                        <img src="img/generales/municipalidad_marca_lavalle.png" height="50" style="margin: 10px;" width="100">
                                    </td>
                                    <td width="50%" style="border-left: 0.1mm solid; border-right: 0.1mm solid;text-align: center;">
                                        <h4>TITULO DE TRAMITE MUNICIPAL</h4>
                                    </td>
                                    <td width="25%" style="font-size: 11px;">
                                        <p>Hoja N° {PAGENO}</p><p>Oficina: '.$this->session->userdata('oficina_actual').'</p>
                                    </td>
                                </tr>
                            </table>');
            
            $pdf->setFooter('<table width="100%">
                                <tr>
                                    <td style="text-align: left;font-size: 8px;">
                                        Fecha: '.date('d-m-Y H:i:s').'
                                    </td>
                                    <td style="text-align: right;font-size: 8px;">
                                        Usuario: '.$this->session->userdata('CodiUsua').'
                                    </td>
                                </tr>
                            </table>');
            
            $pdf->AddPage();
            $pdf->WriteHTML($html); // write the HTML into the PDF
            //var_dump($pdf->HTMLHeader);die();
            $this->load->helper("pdftool");
           
           $pdf->Output(str_replace(" ", "_", $plant->nombre) . ".pdf", 'I');
        }
    }

    public function get_elements_consulta() {
        $post = json_decode(file_get_contents('php://input'), true);
        $id_form = $post['id_form'];
        if (!empty($id_form)) {
            $this->load->model('expedientes/consulta_model');
            $data = $this->consulta_model->getElementsWhere($id_form);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            echo 'no encuentra la info';
        }
    }

    public function get_consulta() {
        $post = json_decode(file_get_contents('php://input'), true);
        $id_form = $post['id_form'];
        if (!empty($id_form)) {
            $this->load->model('expedientes/consulta_model');
            $data = $this->consulta_model->getConsulta($id_form);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            echo 'no encuentra la consulta';
        }
    }

    public function search_data() {

        $post = json_decode(file_get_contents('php://input'), true);
        if (empty($post['buscar'])) {
            echo json_encode(['error' => "No hay datos que buscar"]);
        } else {
            if (!empty($post)) {
                $parametro = trim($post['buscar']);
                $consulta = $post['consulta'];
                $campow = $post['campow'];
                $this->load->model('expedientes/consulta_model');
//            var_dump($consulta); 
//            var_dump($parametro);
//            var_dump($campow);
//            die();
                $data = $this->consulta_model->ejecutarSQL($consulta, $parametro, $campow);
                header('Content-type: application/json; charset=utf-8');
//            $array_head = array();
                if (!empty($data)) {
//                $cont = 0;
//                foreach ($data[0] as $key => $val) {
//                    array_push($array_head, $key);
//                    $cont++;
//                    if($cont == 4){
//                        break;// solo mostraremos las dos primeras columnas
//                    }
//                }
//                $array_return = array(
//                    'head' => $array_head,
//                    'body' => $data,
//                );

                    echo json_encode($data);
                } else {
                    echo json_encode(['error' => "No hay resultado", 'query' => $consulta, 'campo_where' => $campow, 'parametro' => $parametro]);
                }
            }else{
                echo json_encode(['error' => "No hay datos en la solicitud post"]);
            }
        }
    }

    public function vista_previa($idplant) {
        $this->load->model('expedientes/formularios_model');
        $data['title'] = 'Expedientes - Plantilla - Vista Previa';
        $data['idplan'] = $idplant;
        $data['firma_pad'] = $this->plantillas_model->getCantFirmasPad($idplant);
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => '', 'eliminar' => '', 'formulario' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
            if($data['firma_pad'] > 0)
                $data['js'][] = 'js/expedientes/SigWebTablet.js';
                $data['js'][] = 'plugins/ckeditor/ckeditor.js?ver=1.1';
                $data['js'][] = 'plugins/ckeditor/adapters/jquery.js?ver=1.1';
                $data['js'][] = 'plugins/ckeditor/config.js?ver=1.1';
                $data['js'][] = 'plugins/ckeditor/lang/es.js?ver=1.1';
                $data['css'][] = 'plugins/ckeditor/skins/bootstrapck/editor.css';
        $this->load_template('expedientes/plantillas/vista_previa', $data);
    }

    public function buscarhistorial($idexp, $alias){
        $valor = $this->plantillas_model->getBuscarHistorial($idexp,$alias);
        header('Content-Type: application/json');
        echo json_encode(['value'=>$valor]);
    }
    
    protected function load_template($view = 'general_content', $view_data = NULL, $data = array()) {
        $view_data['js'][] = 'plugins/ckeditor/ckeditor.js';
        $view_data['js'][] = 'plugins/ckeditor/adapters/jquery.js';
        $view_data['js'][] = 'plugins/ckeditor/config.js';
        $view_data['js'][] = 'plugins/ckeditor/lang/es.js';
        $view_data['css'][] = 'plugins/ckeditor/skins/bootstrapck/editor.css';
        return parent::load_template($view, $view_data, $data);
    }
    
    protected function parsearFecha($fecha_str){
        $mes = explode(" ", $fecha_str)[1];
        switch ($mes){
            case "January":
                $fecha_str = str_replace("January", "de Enero de ", $fecha_str);
                break;
            case "February":
                $fecha_str = str_replace("February", "de Febrero de ", $fecha_str);
                break;
            case "March":
                $fecha_str = str_replace("March", "de Marzo de ", $fecha_str);
                break;
            case "April":
                $fecha_str = str_replace("April", "de Abril de ", $fecha_str);
                break;
            case "May":
                $fecha_str = str_replace("May", "de Mayo de ", $fecha_str);
                break;
            case "June":
                $fecha_str = str_replace("June", "de Junio de ", $fecha_str);
                break;
            case "July":
                $fecha_str = str_replace("July", "de Julio de ", $fecha_str);
                break;
            case "August":
                $fecha_str = str_replace("August", "de Agosto de ", $fecha_str);
                break;
            case "September":
                $fecha_str = str_replace("September", "de Septiembre de ", $fecha_str);
                break;
            case "October":
                $fecha_str = str_replace("October", "de Octubre de ", $fecha_str);
                break;
            case "November":
                $fecha_str = str_replace("November", "de Noviembre de ", $fecha_str);
                break;
            case "December":
                $fecha_str = str_replace("December", "de Diciembre de ", $fecha_str);
                break;
        }
        return $fecha_str;
    }

}

/* End of file Plantillas.php */
/* Location: ./application/modules/expedientes/controllers/Plantillas.php */