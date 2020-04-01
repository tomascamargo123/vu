<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Personas extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
	}

	public function listar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$tableData = array(
			'columns' => array(
				array('label' => 'Nombre', 'data' => 'DetaPers', 'sort' => 'DetaPers', 'width' => 50, 'query' => 'like'),
				array('label' => 'N° de documento', 'data' => 'NudoPers', 'sort' => 'NudoPers', 'width' => 45, 'class' => 'dt-body-right', 'query' => 'like'),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'personas_table',
			'order' => array(array(0, 'asc')),
			'source_url' => 'expedientes/personas/listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#personas_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#personas_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['box_title'] = 'Buscar';
		$data['title'] = 'Expedientes - Buscar Expediente por persona';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$this->load_template('expedientes/personas/personas_listar', $data);
	}

	public function listar_data()
	{
		$data = $this->input->post('data');
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('CucuPers, NudoPers, DetaPers')
			->from("$this->sigmu_schema.persona");
			if($data != ""){
				$query = json_decode($data, TRUE);
				foreach($query as $q){
					if($q['query'] == 'like'){
						$this->datatables->like($q['name'], $q['value']);
					} else {
						$this->datatables->where($q['name'], $q['value']);
					}
				}
			}
			$this->datatables
			->add_column('opciones', '<a href="expedientes/personas/ver/$1" title="Ver" class="btn btn-xs btn-primary" style="width: 100px;">Ver</a>', 'CucuPers')
			->add_column('select', '<a data-dismiss="modal" href="" onclick="$(\'#persona_id\').val(\'$1\');$(\'#caratula\').val(\'$2\');$(\'#caratula\').focus();$(\'#btn_buscar_solicitante\').focus();" title="Seleccionar"><i class="fa fa-check"></i></a>', 'CucuPers,DetaPers');

		echo $this->datatables->generate();
	}

	public function ver($CucuPers = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $CucuPers == NULL || !ctype_digit($CucuPers))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/personas_model');
		$persona = $this->personas_model->get(array('CucuPers' => $CucuPers));
		if (empty($persona))
		{
			show_404();
		}
		$data['error'] = $this->session->flashdata('error');

		$this->load->model('expedientes/expedientes_model');
		$expedientes = $this->expedientes_model->get(array('persona_id' => $persona->CucuPers));

		$data['fields'] = array();
		foreach ($this->personas_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			$this->add_input_field($data['fields'], $field, $persona->{$field['name']});
		}

		$data['persona'] = $persona;
		$data['expedientes'] = $expedientes;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '', 'adjuntos' => '');
		$data['title'] = 'Expedientes - Personas - Ver';
		$data['css'][] = 'plugins/kartik-v-bootstrap-tabs-x/css/bootstrap-tabs-x.min.css';
		$data['js'][] = 'plugins/kartik-v-bootstrap-tabs-x/js/bootstrap-tabs-x.min.js';
		$this->load_template('expedientes/personas/personas_ver', $data);
	}
}
/* End of file Personas.php */
/* Location: ./application/modules/expedientes/controllers/Personas.php */