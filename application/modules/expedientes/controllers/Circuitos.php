<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Circuitos
 *
 * @author m-1
 */
class Circuitos extends MY_Controller{
    //put your code here
    

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/circuito_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
		$this->grupos_admin = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
	}
        
	public function listar($id=0){
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
                $this->load->model('expedientes/tramites_model');
                $tramite = $this->tramites_model->get(array('id'=>$id));
		if (empty($tramite))
		{
			show_404();
		}
                $data_table = $this->circuito_model->getPlantillas_x_Tramite($id);
                
                $this->load->model('expedientes/oficinas_model');
                $oficinas  = $this->oficinas_model->getAll();
                
		$data['data_table'] = $data_table;
                $data['tramite'] = $tramite;
                $data['oficinas'] = $oficinas;
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Circuitos';
		$data['css'][] = 'css/expedientes/circuitos_style.css';
//		$data['js'][] = 'js/pagination/pagination.js';
//		$data['js'][] = 'js/expedientes/vue/vue.js';
//		$data['js'][] = 'js/expedientes/vue/axios.js';
//		$data['js'][] = 'js/expedientes/vue/paginated_vue.js';
//		$data['js'][] = 'js/expedientes/vue/firmantes.js';
		$this->load_template('expedientes/circuitos/circuitos_listar', $data);
        }
        
        public function firmantes($id_tram, $id_plant){
            
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
                $data['idtram'] = $id_tram;
                $data['idplan'] = $id_plant;
		$data['title'] = 'Expedientes - Firmantes';
		$data['js'][] = 'js/expedientes/vue/vue.js';
		$data['js'][] = 'js/expedientes/vue/axios.js';
		$data['js'][] = 'js/expedientes/vue/paginated_vue.js';
		$data['js'][] = 'js/expedientes/vue/boostrap-vue.min.js';
		$data['js'][] = 'js/expedientes/vue/firmantes.js';
		$this->load_template('expedientes/circuitos/firmantes_listar', $data);
        }
        
        public function get_usuarios($idtram,$idplant){
            header("Content-Type: application/json");
            $this->load->model('expedientes/firmante_model');
            $usuarios = $this->firmante_model->get_usuarios($idtram,$idplant);
            echo json_encode(array('usuarios' => $usuarios));
        }
        
        public function get_firmantes($idtram,$idplant){
            header("Content-Type: application/json");
            $this->load->model('expedientes/firmante_model');
            $firmantes = $this->firmante_model->get_firmantes($idtram,$idplant);
            echo json_encode(array('firmantes' => $firmantes));
        }
        
        public function quitar_firmante(){
            header("Content-Type: application/json");
            $post = json_decode(file_get_contents('php://input'), true);
            if(!empty($post)){
                $this->load->model('expedientes/firmante_model');
                $this->firmante_model->quitar_firmante($post['id_firmante']);
                
                $usuarios = $this->firmante_model->get_usuarios($post['id_tram'],$post['id_plan']);
                $firmantes = $this->firmante_model->get_firmantes($post['id_tram'],$post['id_plan']);
                echo json_encode(array('firmantes' => $firmantes,'usuarios' => $usuarios));
                return;
            }
            echo json_encode(array('status' => 'error','message' => 'NO hay dato en el post'));
        }
        
        public function confirmar_nuevos_firmantes(){
            header("Content-Type: application/json");
            $post = json_decode(file_get_contents('php://input'), true);
            if(!empty($post)){
                $nuevos = json_decode($post['firmantes']);
                $this->load->model('expedientes/firmante_model');
                $this->firmante_model->agregar_firmantes($nuevos);
                
                $usuarios = $this->firmante_model->get_usuarios($post['id_tram'],$post['id_plan']);
                $firmantes = $this->firmante_model->get_firmantes($post['id_tram'],$post['id_plan']);
                echo json_encode(array('firmantes' => $firmantes,'usuarios' => $usuarios));
                return;
            }
            echo json_encode(array('status' => 'error','message' => 'NO hay dato en el post'));
        }
        
        public function agregar_plantilla($id_tramite){
            //los tratamos como formularios luego a los formularios asignados a esta plantilla seran los subformularios con los que podremos cargar completamente la plantilla
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            $this->load->model('expedientes/tramites_model');
            $tramite = $this->tramites_model->get(array('id'=>$id_tramite));
            if (empty($tramite))
            {
                    show_404();
            }
            
            $this->load->model('expedientes/plantillas_model');
            $table_forms = $this->plantillas_model->disponibles($id_tramite);
            
            
            $this->load->model('expedientes/oficinas_model');
            $oficinas  = $this->oficinas_model->getAll();
            
            $data['data_table'] = $table_forms;
            $data['data_ofices'] = $oficinas;
            $data['tramite'] = $tramite;
            $data['error'] = $this->session->flashdata('error');
            $data['message'] = $this->session->flashdata('message');
            $data['title'] = 'Agregar Formularios - Circuitos';
            $data['js'][] = 'js/pagination/pagination.js';
            $this->load_template('expedientes/circuitos/agregar_plant', $data);
        }
        
        
        public function agregar_nodo($id_tramite){
            //los tratamos como formularios luego a los formularios asignados a esta plantilla seran los subformularios con los que podremos cargar completamente la plantilla
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            $this->load->model('expedientes/tramites_model');
            $tramite = $this->tramites_model->get(array('id'=>$id_tramite));
            if (empty($tramite))
            {
                    show_404();
            }
            
            $this->load->model('expedientes/plantillas_model');
            $table_forms = $this->plantillas_model->disponibles($id_tramite);
            
            $this->load->model('expedientes/circuito_model');
            $data['nodos'] = $this->circuito_model->getNodos($id_tramite);
            $this->load->model('expedientes/oficinas_model');
            $oficinas  = $this->oficinas_model->getAll();
            
            $data['formularios'] = $table_forms;
            $data['oficinas'] = $oficinas;
            $data['tramite'] = $tramite;
            $data['edit'] = false;
            $data['error'] = $this->session->flashdata('error');
            $data['message'] = $this->session->flashdata('message');
            $data['title'] = 'Agregar Formularios - Circuitos';
            $this->load_template('expedientes/circuitos/circuitos_nodo', $data);
        }
        
        public function editar_nodo($id_tramite, $orden_nodo){
            //los tratamos como formularios luego a los formularios asignados a esta plantilla seran los subformularios con los que podremos cargar completamente la plantilla
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            $this->load->model('expedientes/tramites_model');
            $tramite = $this->tramites_model->get(array('id'=>$id_tramite));
            if (empty($tramite))
            {
                    show_404();
            }
            
            $this->load->model('expedientes/plantillas_model');
            $table_forms = $this->plantillas_model->disponibles($id_tramite);
            
            $this->load->model('expedientes/circuito_model');
            $data['nodos'] = $this->circuito_model->getNodos($id_tramite);
            
            $this->load->model('expedientes/oficinas_model');
            $oficinas  = $this->oficinas_model->getAll();
            //buscamos los datos de plantillas y oficinas del nodo
            $data['formulario_act'] = $this->plantillas_model->plantilla_actual($id_tramite,$orden_nodo);
            $data['ofic_si'] = null;
            $data['ofic_no'] = null;
            foreach ($data['nodos'] as $nodo){
                if($nodo['orden'] == $orden_nodo){
                    $data['orden_edit'] = $nodo['orden'];
                    foreach ($oficinas as $ofi){
                        if($ofi['id'] == $nodo['oficina_destino_id']){
                            $data['ofic_si'] = $ofi;
                        }
                        
                        if($ofi['id'] == $nodo['oficina_rechazo_id']){
                            $data['ofic_no'] = $ofi;
                        }
                        if(isset($data['ofic_no']) && isset($data['ofic_si'])){
                            break;
                        }
                    }
                    break;
                }
            }
            $data['formularios'] = $table_forms;
            $data['oficinas'] = $oficinas;
            $data['tramite'] = $tramite;
            $data['index_act'] = $orden_nodo;
            $data['edit'] = true;
            $data['error'] = $this->session->flashdata('error');
            $data['message'] = $this->session->flashdata('message');
            $data['title'] = 'Agregar Formularios - Circuitos';
            $this->load_template('expedientes/circuitos/circuitos_nodo', $data);
        }
        
        public function agregar_oficina($id_tramite){
            //los tratamos como formularios luego a los formularios asignados a esta plantilla seran los subformularios con los que podremos cargar completamente la plantilla
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            $this->load->model('expedientes/tramites_model');
            $tramite = $this->tramites_model->get(array('id'=>$id_tramite));
            if (empty($tramite))
            {
                    show_404();
            }
            $ultima_ofi = $this->circuito_model->get_last_destino($id_tramite);
            
            
            $this->load->model('expedientes/oficinas_model');
            $oficinas_origen = $this->oficinas_model->getAll();
            
            
            $oficinas_destino  = $this->oficinas_model->getAll();
            
            $data['ultimo_destino'] = $ultima_ofi;
            $data['data_oforigen'] = $oficinas_origen;
            $data['data_ofdestino'] = $oficinas_destino;
            $data['tramite'] = $tramite;
            $data['error'] = $this->session->flashdata('error');
            $data['message'] = $this->session->flashdata('message');
            $data['title'] = 'Agregar Oficina - Circuitos';
            $data['js'][] = 'js/pagination/pagination.js';
            $this->load_template('expedientes/circuitos/agregar_ofi', $data);
        }
        
        public function asignar_plantilla(){
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            $pid = $this->input->post('pid');
            $oid = $this->input->post('oid');
            $tid = $this->input->post('tid');
            
            $max = $this->circuito_model->getMax($tid)['max'];
            if(empty($max)){
                $max = 1;
            }else{
                $max++;
            }
            $data = array(
                'tramite_id' => $tid,
                'plantilla_id' => $pid,
                'oficina_id' => $oid,
                'orden' => $max
            );
            
            if($this->circuito_model->insertar($data)){
                echo "OK";
            }
        }
        
        
        public function asignar_oficina(){
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            $destino_id = $this->input->post('destinoid');
            $origen_id = $this->input->post('origenid');
            $tid = $this->input->post('tid');
            
            $max = $this->circuito_model->getMax($tid)['max'];
            if(empty($max)){
                $max = 1;
            }else{
                $max++;
            }
            $data = array(
                'tramite_id' => $tid,
                'origen_id' => $origen_id,
                'destino_id' => $destino_id,
                'orden' => $max
            );
            
            if($this->circuito_model->insertar($data)){
                echo "OK";
            }
        }
        
        public function crear_nodo_back(){
            
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            $plan_id = $this->input->post('plan_id');
            $ofic_id = $this->input->post('ofic_id');
            $ofic_destino_id = $this->input->post('ofic_dest_id');
            $ofic_rech_id = $this->input->post('ofic_id');
            $tram_id = $this->input->post('tram_id');
            
            $max = $this->circuito_model->getMax($tram_id)['max'];
            if(empty($max)){
                $max = 1;
            }else{
                $max++;
            }
            $data = array(
                'tramite_id' => $tram_id,
                'plantilla_id' => $plan_id,
                'origen_id' => $ofic_id,
                'destino_id' => $ofic_destino_id,
                'oficina_rechazo' => $ofic_rech_id,
                'orden' => $max
            );
            
            if($this->circuito_model->insertar($data)){
                echo "OK";
            }else{
                echo "ERROR";
            }
        }
        
        
        public function editar_nodo_back(){
            
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            $plan_id = $this->input->post('plan_id');
            $ofic_id = $this->input->post('ofic_id');
            $ofic_destino_id = $this->input->post('ofic_dest_id');
            $ofic_rech_id = $this->input->post('ofic_id');
            $tram_id = $this->input->post('tram_id');
            $orden = $this->input->post('orden_e');
            
            $data = array(
                'tramite_id' => $tram_id,
                'plantilla_id' => $plan_id,
                'origen_id' => $ofic_id,
                'destino_id' => $ofic_destino_id,
                'oficina_rechazo' => $ofic_rech_id,
                'orden' => $orden
            );
            
            if($this->circuito_model->actualizar($data)){
                echo "OK";
            }else{
                echo "ERROR";
            }
        }
        
        public function remove_data(){
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            
            $orden = $this->input->post('odt');
            $tid = $this->input->post('tid');
            $data = array('orden'=>$orden, 'tramite_id'=>$tid);
            $this->load->model('expedientes/circuito_model');
            if($this->circuito_model->eliminar($data)){
                echo 'OK';
            }else{
                echo "ERROR!!";
            }
            
        }
        
        public function guardar_firmantes(){
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            
            $firmantes = json_decode($this->input->post('array_firm'), true);
            $pid = $this->input->post('pid');
            $tid = $this->input->post('tid');
            $data = array(
                'plantilla_id'=>$pid,
                'tramite_id'=>$tid,
                'firmantes' => $firmantes
                    );
            $this->load->model('expedientes/circuito_model');
            if($this->circuito_model->set_firmantes($data)){
                echo 'OK';
            }else{
                echo "ERROR!!";
            }
        }
        
        public function save_destino(){
             if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            if(empty($this->input->post())){
                redirect(base_url('/expedientes'));
            }
            
            
            $pid = $this->input->post('pid');
            $tid = $this->input->post('tid');
            $ofic_dest_id = $this->input->post('destino');
            $data = array(
                'plantilla_id'=>$pid,
                'tramite_id'=>$tid,
                'oficina_destino_id' => $ofic_dest_id
            );
            $this->load->model('expedientes/circuito_model');
            if($this->circuito_model->set_destino($data)){
                echo 'OK';
            }else{
                echo "ERROR!!";
            }
        }

        

    public function cargar_formularios( $orden, $id_plan, $id_tram){
        //traer todos los elementos de los formularios
        
        $data ['idtram'] = $id_tram;
        $data ['idplan'] = $id_plan;
        $data ['orden'] = $orden;
        $data['js'][] = 'js/expedientes/vue/vue.js';
        $data['js'][] = 'js/expedientes/vue/axios.js';
        $data['js'][] = 'js/expedientes/vue/circuito_autocargado.js';
        $this->load_template('expedientes/circuitos/autocargado', $data);
    }
     
    
    public function get_elements_formulario() {
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $this->load->model(['expedientes/formularios_model','expedientes/consulta_model']);
            $forms = $this->formularios_model->getFormulariosNoDisponibles($post['idplan'], true);

            $cont = 0;
            foreach ($forms as $f) {
                $elements = $this->formularios_model->getDataFormByTramite($f['id'],$post['idtram']);
                $plantillas_before = $this->circuito_model->get_plantillas_before($post['orden'],$post['idtram'],true);
                $forms[$cont]['elements'] = $elements;
                $forms[$cont]['plantillas_before'] = $plantillas_before;
                $cont++;
            }


            header('Content-type: application/json; charset=utf-8');
            echo json_encode($forms);
        } else {
            echo '';
        }
    }

    public function get_alias_list_formulario() {
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $this->load->model(['expedientes/formularios_model']);
            $alias_list = $this->formularios_model->getListAlias($post['idplant'], true);


            header('Content-type: application/json; charset=utf-8');
            echo json_encode($alias_list);
        } else {
            echo '';
        }
    }

    public function save_reference(){
        $post = json_decode(file_get_contents('php://input'), true);
        if (!empty($post)) {
            $this->load->model(['expedientes/formularios_model']);
            if($this->formularios_model->guardarReferencia($post)){
                $data['message'] = "Registro guardado";
                $data['status'] = "success";
            }else{
                $data['message'] = "Ha ocurrido una falla en el transacción!";
                $data['status'] = "failed";
            }

        } else {
            $data['message'] = "No hay datos en el request POST";
            $data['status'] = "failed";
        }
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }


}
