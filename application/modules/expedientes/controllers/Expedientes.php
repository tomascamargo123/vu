<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expedientes extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/expedientes_model');
		$this->grupos_acceso_especial = array('admin');
		$this->grupos_acceso_especial_reducido = array('admin', 'expedientes_admin');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
		$this->grupos_admin = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
                $this->grupos_iniciar_exp = array(862,1);
	}

	public function listar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY") : "";
					}
				}
				return data;
			}';
		$acciones_render = 'function (data, type, full, meta) {
				if(type === "display") {
					if(full.ayuda_social_id>0) {
						data = \'<a style="width: 100px;" href="javascript:ver_estado_expediente(\'+full.id+\');" title="Estado" class="btn btn-xs btn-success">Estado</a>\';
					}else{
						data = \'<a style="width: 100px;" href="javascript:ver_estado_expediente(\'+full.id+\');" title="Estado" class="btn btn-xs btn-success">Estado</a> <a style="width: 100px;" href="expedientes/expedientes/ver/\'+full.id+\'" title="Ver" class="btn btn-xs btn-primary">Ver</a>\';
					}
				}
				return data;
			}';
		$tableData = array(
			'columns' => array(
				array('label' => 'Cód.Barra', 'data' => 'codigo', 'sort' => 'expediente.id', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Tipo', 'data' => 'tramite_tipo', 'sort' => 'tramite.tipo', 'width' => 5, 'query' => 'like'),
				array('label' => 'Trámite/Asunto', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 20, 'query' => 'like'),
				array('label' => 'Fecha', 'data' => 'inicio', 'sort' => 'expediente.inicio', 'width' => 11, 'class' => 'dt-body-right', 'render' => $fecha_render, 'query' => 'like'),
				array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'expediente.fojas', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Solicitante/Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 20, 'query' => 'like'),
				array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 19, 'query' => 'like'),
				array('label' => 'Usuario', 'data' => 'usuario', 'sort' => 'expediente.usuario', 'width' => 5, 'query' => 'like'),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false', 'render' => $acciones_render)
			),
			'table_id' => 'expedientes_listar_table',
			'order' => array(array(1, 'desc'), array(2, 'desc')),
			'source_url' => 'expedientes/expedientes/listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#expedientes_listar_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#expedientes_listar_table thead').append(r);$('#search_0').css('text-align', 'center');} ",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['box_title'] = 'Buscar';
		$data['title'] = 'Expedientes - Expedientes - Buscar';
		$data['css'][] = 'plugins/datepicker/css/bootstrap-datepicker3.min.css';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$data['js'][] = 'plugins/datepicker/js/bootstrap-datepicker.min.js';
		$data['js'][] = 'plugins/datepicker/locales/bootstrap-datepicker.es.min.js';
		$this->load_template('expedientes/expedientes/expedientes_listar', $data);
	}

	public function listar_data()
	{
		$data = $this->input->post('data');
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!empty($_POST['columns'][5]['search']['value']))
		{
			$date = date_create_from_format('d/m/Y', $_POST['columns'][5]['search']['value']);
			if ($date)
			{
				$_POST['columns'][5]['search']['value'] = $date->format('Y-m-d');
			}
			else
			{
				$_POST['columns'][5]['search']['value'] = '';
			}
		}
		
		$this->datatables
			->select('expediente.id, expediente.id as codigo, expediente.ano, expediente.numero, expediente.anexo, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, tramite.nombre as tramite_nombre, expediente.inicio, expediente.fojas, expediente.caratula, expediente.objeto, expediente.ayuda_social_id, (SELECT MAX(anexo)+1 FROM ' . $this->sigmu_schema . '.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, expediente.usuario')
			->unset_column('expediente.id')
			->exact_where_column('ano,numero,anexo')
			->from("$this->sigmu_schema.expediente")
			->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'left');
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
			->add_column('opciones', '$1', 'id')
			->add_column('select', '<a data-dismiss="modal" style="width: 100px;" href="" onclick="seleccionar_expediente(\'$1\',\'$2\',\'$3\',\'$4\');" title="Seleccionar"><i class="fa fa-check"></i></a>', 'numero, ano, anexo, nuevo_anexo')
			->add_column('acumular', '<a style="width: 100px;" href="javascript:acumular_expediente(\'$1\',\'$2\',\'$3\',\'$4\');" title="Acumular"><i class="fa fa-check"></i></a>', 'id, numero, ano, anexo');
		if($data == ""){
			$this->datatables->set_limit(10);
		}
		
		echo $this->datatables->generate();
	}

	public function listar_data_acumular($expediente_id)
	{
		$data = $this->input->post('data');
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $expediente_id == NULL || !ctype_digit($expediente_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!empty($_POST['columns'][5]['search']['value']))
		{
			$date = date_create_from_format('d/m/Y', $_POST['columns'][5]['search']['value']);
			if ($date)
			{
				$_POST['columns'][5]['search']['value'] = $date->format('Y-m-d');
			}
			else
			{
				$_POST['columns'][5]['search']['value'] = '';
			}
		}
		$this->datatables
			->select('expediente.id, expediente.ano, expediente.numero, expediente.anexo, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, tramite.nombre as tramite_nombre, expediente.inicio, expediente.fojas, expediente.caratula, expediente.objeto, expediente.ayuda_social_id, (SELECT MAX(anexo)+1 FROM ' . $this->sigmu_schema . '.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo')
			->unset_column('expediente.id')
			->from("$this->sigmu_schema.expediente")
                        ->join("$this->sigmu_schema.pase", 'pase.id_expediente = expediente.id')
			->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'left')
			->where('expediente.id <>', $expediente_id)
                        ->where('pase.origen', 862)
                        ->where('pase.destino', -1)
                        ->where('pase.respuesta', 'pendiente')
                        ->where('expediente.acumulado is null');
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
			->add_column('opciones', '$1', 'id')
			->add_column('select', '<a style="width: 100px;" data-dismiss="modal" href="" onclick="seleccionar_expediente(\'$1\',\'$2\',\'$3\',\'$4\');" title="Seleccionar"><i class="fa fa-check"></i></a>', 'numero, ano, anexo, nuevo_anexo')
			->add_column('acumular', '<a style="width: 100px;" href="javascript:acumular_expediente(\'$1\',\'$2\',\'$3\',\'$4\');" title="Acumular" id="row_$1"><i class="fa fa-check"></i></a>', 'id, numero, ano, anexo');

		echo $this->datatables->generate();
	}

	public function listar_acumulados()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY") : "";
					}
				}
				return data;
			}';
		$tableData = array(
			'columns' => array(
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Trámite/Asunto', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 20, 'query' => 'where'),
				array('label' => 'Fecha', 'data' => 'inicio', 'sort' => 'expediente.inicio', 'width' => 11, 'class' => 'dt-body-right', 'render' => $fecha_render, 'query' => 'like'),
				array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'expediente.fojas', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Solicitante/Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 20, 'query' => 'like'),
				array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 24, 'query' => 'like'),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'expedientes_table',
			'order' => array(array(0, 'desc'), array(1, 'desc')),
			'source_url' => 'expedientes/expedientes/listar_data_acumulados',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#expedientes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#expedientes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['box_title'] = 'Acumulados';
		$data['title'] = 'Expedientes - Expedientes - Acumulados';
		$data['css'][] = 'plugins/datepicker/css/bootstrap-datepicker3.min.css';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$data['js'][] = 'plugins/datepicker/js/bootstrap-datepicker.min.js';
		$data['js'][] = 'plugins/datepicker/locales/bootstrap-datepicker.es.min.js';
		$this->load_template('expedientes/expedientes/expedientes_listar', $data);
	}

	public function listar_data_acumulados()
	{
		$data = $this->input->post('data');
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!empty($_POST['columns'][4]['search']['value']))
		{
			$date = date_create_from_format('d/m/Y', $_POST['columns'][4]['search']['value']);
			if ($date)
			{
				$_POST['columns'][4]['search']['value'] = $date->format('Y-m-d');
			}
			else
			{
				$_POST['columns'][4]['search']['value'] = '';
			}
		}
		$this->datatables
			->select('expediente.id, expediente.ano, expediente.numero, expediente.anexo, tramite.nombre as tramite_nombre, expediente.inicio, expediente.fojas, expediente.caratula, expediente.objeto, expediente.acumulado')
			->unset_column('expediente.id')
			->exact_where_column('ano,numero,anexo')
			->from("$this->sigmu_schema.expediente")
			->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'left')
			->where('acumulado >', '0');
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
			->add_column('opciones', '<a href="expedientes/expedientes/ver/$1" title="Ver" class="btn btn-xs btn-primary" style="width: 100px;">Ver</a> <a href="expedientes/expedientes/ver/$2" title="Ver Madre" class="btn btn-xs btn-primary" style="width: 100px;">Ver Madre</a><br /><a href="javascript:confirmar_accion($1, \'desacumular\', \'$3/$4 (Anexo $5)\');" title="Desacumular" class="btn btn-xs btn-danger" style="width: 100px;">Desacumular</a>', 'id, acumulado, numero, ano, anexo');
			$this->datatables->set_limit(10);
		echo $this->datatables->generate();
	}

	public function listar_archivados()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY") : "";
					}
				}
				return data;
			}';
		$tableData = array(
			'columns' => array(
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Trámite/Asunto', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 13, 'query' => 'like'),
				array('label' => 'Fecha', 'data' => 'inicio', 'sort' => 'expediente.inicio', 'width' => 11, 'class' => 'dt-body-right', 'render' => $fecha_render, 'query' => 'like'),
				array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'expediente.fojas', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 21, 'query' => 'like'),
				array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 25, 'query' => 'like'),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'expedientes_table',
			'order' => array(array(0, 'desc'), array(1, 'desc')),
			'source_url' => 'expedientes/expedientes/listar_data_archivados',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#expedientes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#expedientes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['box_title'] = 'Archivados en Archivo General';
		$data['title'] = 'Expedientes - Expedientes - Archivados';
		$data['css'][] = 'plugins/datepicker/css/bootstrap-datepicker3.min.css';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$data['js'][] = 'plugins/datepicker/js/bootstrap-datepicker.min.js';
		$data['js'][] = 'plugins/datepicker/locales/bootstrap-datepicker.es.min.js';
		$this->load_template('expedientes/expedientes/expedientes_listar', $data);
	}

	public function listar_data_archivados()
	{
		$data = $this->input->post('data');
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!empty($_POST['columns'][4]['search']['value']))
		{
			$date = date_create_from_format('d/m/Y', $_POST['columns'][4]['search']['value']);
			if ($date)
			{
				$_POST['columns'][4]['search']['value'] = $date->format('Y-m-d');
			}
			else
			{
				$_POST['columns'][4]['search']['value'] = '';
			}
		}
		$this->datatables
			->select('expediente.id, expediente.ano, expediente.numero, expediente.anexo, tramite.nombre as tramite_nombre, expediente.inicio, expediente.fojas, expediente.caratula, expediente.objeto, expediente.acumulado, pase.id as pase_id')
			->unset_column('expediente.id')
			->exact_where_column('ano,numero,anexo')
			->from("$this->sigmu_schema.expediente")
			->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'left')
			->join("$this->sigmu_schema.pase", 'pase.id_expediente = expediente.id')
			->where('pase.origen', '1')
			->where('pase.destino', '-1');
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
			->add_column('opciones', '<a href="javascript:ver_estado_expediente($1);" title="Estado" class="btn btn-xs btn-success" style="width: 100px;">Estado</a> <a href="expedientes/expedientes/ver/$1" title="Ver" class="btn btn-xs btn-primary" style="width: 100px;">Ver</a><br /><a href="javascript:confirmar_accion($2, \'desarchivar\', \'$3/$4 (Anexo $5)\');" title="Desarchivar" class="btn btn-xs btn-danger" style="width: 100px;">Desarchivar</a>', 'id, pase_id, numero, ano, anexo');
			$this->datatables->set_limit(10);
			echo $this->datatables->generate();
	}

	public function listar_ayuda_social()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY") : "";
					}
				}
				return data;
			}';
		$tableData = array(
			'columns' => array(
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Trámite/Asunto', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 20),
				array('label' => 'Fecha', 'data' => 'inicio', 'sort' => 'expediente.inicio', 'width' => 11, 'class' => 'dt-body-right', 'render' => $fecha_render),
				array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'expediente.fojas', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 20),
				array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 24),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'expedientes_table',
			'order' => array(array(0, 'desc'), array(1, 'desc')),
			'source_url' => 'expedientes/expedientes/listar_data_ayuda_social',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#expedientes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#expedientes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['box_title'] = 'Ayuda Social';
		$data['title'] = 'Expedientes - Expedientes - Ayuda Social';
		$data['css'][] = 'plugins/datepicker/css/bootstrap-datepicker3.min.css';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$data['js'][] = 'plugins/datepicker/js/bootstrap-datepicker.min.js';
		$data['js'][] = 'plugins/datepicker/locales/bootstrap-datepicker.es.min.js';
		$this->load_template('expedientes/expedientes/expedientes_listar', $data);
	}

	public function listar_data_ayuda_social()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!empty($_POST['columns'][4]['search']['value']))
		{
			$date = date_create_from_format('d/m/Y', $_POST['columns'][4]['search']['value']);
			if ($date)
			{
				$_POST['columns'][4]['search']['value'] = $date->format('Y-m-d');
			}
			else
			{
				$_POST['columns'][4]['search']['value'] = '';
			}
		}
		$this->datatables
			->select('expediente.id, expediente.ano, expediente.numero, expediente.anexo, tramite.nombre as tramite_nombre, expediente.inicio, expediente.fojas, expediente.caratula, expediente.objeto, expediente.acumulado')
			->unset_column('expediente.id')
			->exact_where_column('ano,numero,anexo')
			->from("$this->sigmu_schema.expediente")
			->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'left')
			->where('ayuda_social_id IS NOT NULL')
			->add_column('opciones', '<a href="expedientes/expedientes/ver/$1" title="Ver" class="btn btn-xs btn-primary">Ver</a> <a href="javascript:ver_estado_expediente($1);" title="Estado" class="btn btn-xs btn-success">Estado</a>', 'id');

		echo $this->datatables->generate();
	}

	public function iniciar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/expedientes/listar", 'refresh');
		}
		if(!boolval($this->session->userdata('inicia_expediente')) ){
			$this->session->set_flashdata('error', 'Oficina sin permisos de inicio de expediente');
			redirect("expedientes/expedientes/listar", 'refresh');
		}
                //computadora del partido que esta ofina desrrollo economico - juan jaime
		$this->load->model('expedientes/tipos_ayudas_sociales_model');
		$this->load->model('expedientes/ayudas_sociales_model');
		$this->load->model('expedientes/tramites_model');
		$this->load->model('expedientes/pases_model');
		$this->load->model('expedientes/oficinas_model');
		//var_dump($this->input->post('oficina_id'));die();
		if($this->input->post('oficina_id') != ''){
			$options = array();
			$options['id'] = $this->input->post('oficina_id');
			$options['proceso_usuario'] = 'A';
			$existe_oficina = $this->oficinas_model->get($options);
			if(empty($existe_oficina)){
				$this->session->set_flashdata('error', 'La oficina seleccionada está deshabilitada');
				redirect("expedientes/expedientes/iniciar", 'refresh');
			}
		}	
		$this->array_tipo_ayuda_social_control = $array_tipo_ayuda_social = $this->get_array('tipos_ayudas_sociales', 'nombre', 'id', null, array(0 => '-- Seleccionar tipo de ayuda --'));
		unset($this->array_tipo_ayuda_social_control[0]);
		$this->array_tipo_tramite_control = $array_tipo_tramite = array(0 => '-- Seleccionar tipo --', 'I' => 'Interno', 'E' => 'Externo');
		$this->array_tramite_control = $this->get_array('tramites', 'nombre');
		$array_tramite = array(0 => '-- Seleccionar trámite --');
		$this->set_model_validation_rules($this->expedientes_model);
		if ($this->form_validation->run() === TRUE)
		{
			$this->db->trans_begin();
			$trans_ok = TRUE;
			$numero_expt = $this->input->post('numero');
                        $digital_row = $this->tramites_model->is_digital($this->input->post('tramite'),true);
			if (empty($numero_expt))
			{
				$expt = $this->expedientes_model->get(array('select' => 'COALESCE(MAX(numero), 0)+1 as max_nro', 'ano' => $this->input->post('ano')));
				$numero_expt = $expt[0]->max_nro;
			}
			$ayuda_social_id = 'NULL';
			if ($this->input->post('tramite') === '100' || $this->input->post('tramite') === '101')
			{ //AYUDA SOCIAL
				$trans_ok&= $this->ayudas_sociales_model->create(array(
					'numeroDeFichaApros' => $this->input->post('numeroDeFichaApros'),
					'nombreDelBeneficiario' => $this->input->post('nombreDelBeneficiario'),
					'detalleSolicitud' => $this->input->post('detalleSolicitud'),
					'detalleFamiliares' => $this->input->post('detalleFamiliares'),
					'detalleBeneficioEntregado' => $this->input->post('detalleBeneficioEntregado'),
					'tipo_ayuda_social_id' => $this->input->post('tipo_ayuda_social')
					), FALSE);
				$ayuda_social_id = $this->ayudas_sociales_model->get_row_id();
			}
			if ($this->input->post('tramite') === '18' || $this->input->post('tramite') === '17' || $this->input->post('tramite') === '1' || $this->input->post('tramite') === '61' || $this->input->post('tramite') === '29' || $this->input->post('tramite') === '2' || $this->input->post('tramite') === '19') //BAJA COMERCIO/HAB COMERCIO/CONEXION AGUA/CONEXION CLOACA/CONEXION GAS/CONEXION LUZ/TRASLADO DE COMERCIO
			{
				$inmueble_id = (empty($this->input->post('inmueble_id')) || $this->input->post('inmueble_id') == '' ? 'NULL' : $this->input->post('inmueble_id'));
			}
			else
			{
				$inmueble_id = 'NULL';
			}
			$acumulado = 'NULL';
			if ($this->input->post('ano_madre') !== '' && $this->input->post('numero_madre') !== '' && $this->input->post('anexo_madre') !== '')
			{
				$exp_acumulado = $this->expedientes_model->get(array(
					'ano' => $this->input->post('ano_madre'),
					'numero' => $this->input->post('numero_madre'),
					'anexo' => $this->input->post('anexo_madre')));
				if (!empty($exp_acumulado))
				{
					$acumulado = $exp_acumulado[0]->id;
				}
			}
			$trans_ok&= $this->expedientes_model->create(array(
				'ano' => $this->input->post('ano'),
				'numero' => $numero_expt,
				'anexo' => $this->input->post('anexo'),
				'inicio' => date_format(new DateTime(), 'Y-m-d H:i:s'),
				'fojas' => $this->input->post('fojas'),
				'tramite_id' => $this->input->post('tramite'),
				'caratula' => $this->input->post('caratula'),
				'objeto' => $this->input->post('objeto'),
				'acumulado' => $acumulado,
				'digital' => $digital_row,
				'usuario' => $this->session->userdata('CodiUsua'),
				'terminal' => 'EXPT. DIGITAL',
				'ayuda_social_id' => $ayuda_social_id,
				'inmueble_id' => $inmueble_id,
				'persona_id' => $this->input->post('tipo_tramite') === 'E' ? $this->input->post('persona_id') : 'NULL'
				), FALSE);
			$expediente_id = $this->expedientes_model->get_row_id();
                        //queda en la oficina que crea el exp como pend de emision
                        
                        $ofic_dest = -1;
                        $resp_pase = 'pendiente';
                        if($acumulado != 'NULL'){
                            $ofic_dest = 2;
                            $resp_pase = 'acumulado';
                        }else{
                            if(!empty($this->input->post('oficina_id')))
                                $ofic_dest = $this->input->post('oficina_id');
                        }
                        
			$trans_ok&= $this->pases_model->create(array(
				'id_expediente' => $expediente_id,
				'ano' => $this->input->post('ano'),
				'numero' => $numero_expt,
				'anexo' => $this->input->post('anexo'),
				'origen' => $this->session->userdata('oficina_actual_id'),
				'destino' => $ofic_dest,
				'respuesta' => $resp_pase,
				'fojas' => $this->input->post('fojas'),
				'usuario_emisor' => $this->session->userdata('CodiUsua'),
				'fecha_usuario' => date_format(new DateTime(), 'Y-m-d H:i:s')
				), FALSE);
			if ($this->db->trans_status() && $trans_ok)
			{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', $this->expedientes_model->get_msg());
				redirect("expedientes/expedientes/ver/$expediente_id", 'refresh');
			}
			else
			{
				$this->db->trans_rollback();
				$error_msg = 'Se ha producido un error con la base de datos.';
				if ($this->ayudas_sociales_model->get_error())
				{
					$error_msg .='<br>' . $this->ayudas_sociales_model->get_error();
				}
				if ($this->expedientes_model->get_error())
				{
					$error_msg .='<br>' . $this->expedientes_model->get_error();
				}
				if ($this->pases_model->get_error())
				{
					$error_msg .='<br>' . $this->pases_model->get_error();
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		$fields_iniciar = $this->expedientes_model->fields;
		unset($fields_iniciar[4]); //Fecha
		foreach ($fields_iniciar as $field)
		{
			if (empty($field['input_type']))
			{
				if ($field['name'] === 'ano')
				{
					$this->add_input_field($data['fields'], $field, date_format(new DateTime(), 'Y'));
				}
				elseif ($field['name'] === 'anexo' || $field['name'] === 'fojas')
				{
					$this->add_input_field($data['fields'], $field, 0);
				}
				else
				{
					$this->add_input_field($data['fields'], $field);
				}
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']});
				}
			}
		}

		$data['fields_ayuda_social'] = array();
		foreach ($this->ayudas_sociales_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields_ayuda_social'], $field);
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields_ayuda_social'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields_ayuda_social'], $field, ${'array_' . $field['name']});
				}
			}
		}

		$tableData_expedientes = array(
			'columns' => array(
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 8, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 8, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 8, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Solicitante/Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 33, 'query' => 'like'),
				array('label' => 'Trámite/Asunto', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 38, 'query' => 'like'),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'expedientes_table',
			'source_url' => 'expedientes/expedientes/listar_data',
			'order' => array(array(0, 'desc'), array(1, 'desc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#expedientes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#expedientes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_expedientes'] = buildHTML($tableData_expedientes);
		$data['js_table_expedientes'] = buildJS($tableData_expedientes);

		$tableData_oficinas_solicitante = array(
			'columns' => array(
				array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 15, 'class' => 'dt-body-right', 'responsive_class' => 'all', 'query' => 'where'),
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'oficina.nombre', 'width' => 80, 'query' => 'like'),
				array('label' => '', 'data' => 'select_solicitante', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'oficinas_solicitante_table',
			'source_url' => 'expedientes/oficinas/listar_data/TRUE',
			'order' => array(array(1, 'asc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#oficinas_solicitante_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#oficinas_solicitante_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_oficinas_solicitante'] = buildHTML($tableData_oficinas_solicitante);
		$data['js_table_oficinas_solicitante'] = buildJS($tableData_oficinas_solicitante);
                
		$tableData_oficinas_destino = array(
			'columns' => array(
				array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 15, 'class' => 'dt-body-right', 'responsive_class' => 'all', 'query' => 'where'),
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'oficina.nombre', 'width' => 80, 'query' => 'like'),
				array('label' => '', 'data' => 'select_destino', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'oficinas_destino_table',
			'source_url' => 'expedientes/oficinas/listar_data/TRUE',
			'order' => array(array(1, 'asc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#oficinas_destino_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#oficinas_destino_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_oficinas_destino'] = buildHTML($tableData_oficinas_destino);
		$data['js_table_oficinas_destino'] = buildJS($tableData_oficinas_destino);
                
		$tableData_solicitantes = array(
			'columns' => array(
				array('label' => 'Nombre', 'data' => 'DetaPers', 'sort' => 'DetaPers', 'width' => 50, 'query' => 'like'),
				array('label' => 'N° de documento', 'data' => 'NudoPers', 'sort' => 'NudoPers', 'width' => 45, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'solicitantes_table',
			'order' => array(array(0, 'asc')),
			'source_url' => 'expedientes/personas/listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#solicitantes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#solicitantes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_solicitantes'] = buildHTML($tableData_solicitantes);
		$data['js_table_solicitantes'] = buildJS($tableData_solicitantes);

		$tableData_inmuebles = array(
			'columns' => array(
				array('label' => 'N° de cuenta', 'data' => 'CodiInmu', 'sort' => 'inmueble.CodiInmu', 'width' => 15, 'class' => 'dt-body-right'),
				array('label' => 'Nomenclatura Catastral', 'data' => 'NomeInmu', 'sort' => 'inmueble.NomeInmu', 'width' => 25, 'class' => 'dt-body-right'),
				array('label' => 'Propietario', 'data' => 'DetaPers', 'sort' => 'persona.DetaPers', 'width' => 25),
				array('label' => 'Calle', 'data' => 'DecpInmu', 'sort' => 'inmueble.DecpInmu', 'width' => 10),
				array('label' => 'N°', 'data' => 'NupoInmu', 'sort' => 'inmueble.NupoInmu', 'width' => 10, 'class' => 'dt-body-right'),
				array('label' => 'Dpto / Distrito', 'data' => 'DelpInmu', 'sort' => 'inmueble.DelpInmu', 'width' => 10),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'inmuebles_table',
			'order' => array(array(0, 'asc')),
			'source_url' => 'expedientes/inmuebles/listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#inmuebles_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#inmuebles_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_inmuebles'] = buildHTML($tableData_inmuebles);
		$data['js_table_inmuebles'] = buildJS($tableData_inmuebles);

		$anexar = $this->input->get('anexar');
		if (!empty($anexar))
		{
			$data['anexar_expediente'] = $this->expedientes_model->get(array('id' => $anexar));
		}

		$data['txt_btn'] = 'Iniciar Circuito';
		$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled', 'adjuntos' => 'disabled');
		$data['title'] = 'Expedientes - Expedientes - Iniciar';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$this->load_template('expedientes/expedientes/expedientes_iniciar', $data);
	}

	public function editar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/expedientes/ver/$id", 'refresh');
		}
		$expediente = $this->expedientes_model->get(array('id' => $id, 'join' => array(array('table' => "$this->sigmu_schema.tramite", 'where' => 'tramite.id=expediente.tramite_id', 'columnas' => array('tramite.tipo as tipo_tramite')))));
		if (empty($expediente))
		{
			show_404();
		}
		if (!in_groups($this->grupos_acceso_especial, $this->grupos)){
			$sitioDeExpediente = $this->expedientes_model->sitioDeExpediente($id);
			if($sitioDeExpediente[0]['origen'] == $this->session->userdata('oficina_actual_id')){
				if(!$this->expedientes_model->iniciaExpediente($this->session->userdata('oficina_actual_id'))){
					$this->session->set_flashdata('error', 'No tiene permiso para editar la carátula');
					redirect("expedientes/expedientes/ver/$id", 'refresh');
				}
				if (count($pases) > 1 || ($pases[0]->origen != $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))){
					$this->session->set_flashdata('error', 'No es posible editar la carátula de un expediente que ya tiene un pase');
					redirect("expedientes/expedientes/ver/$id", 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'El expediente no se encuentra en su oficina');
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			}
		}
		$this->load->model('expedientes/pases_model');
		$pases = $this->pases_model->get(array(
			'select' => "destino, origen",
			'id_expediente' => $expediente->id,
			'sort_by' => 'id DESC',
			'limit' => 2
		));
		if (isset($expediente->acumulado))
		{
			$acumulado = $this->expedientes_model->get(array('id' => $expediente->acumulado));
			$expediente->ano_madre = $acumulado->ano;
			$expediente->numero_madre = $acumulado->numero;
			$expediente->anexo_madre = $acumulado->anexo;
		}
		else
		{
			$expediente->ano_madre = '';
			$expediente->numero_madre = '';
			$expediente->anexo_madre = '';
		}
		if (isset($expediente->inmueble_id))
		{
			$this->load->model('expedientes/inmuebles_model');
			$expediente->inmueble = '';//$this->inmuebles_model->get(array('CodiInmu' => $expediente->inmueble_id))->NomeInmu;
		}
		else
		{
			$expediente->inmueble = '';
		}
		$this->load->model('expedientes/ayudas_sociales_model');
		if (isset($expediente->ayuda_social_id))
		{
			$ayuda_social = $this->ayudas_sociales_model->get(array('id' => $expediente->ayuda_social_id));
		}
		$this->load->model('expedientes/tipos_ayudas_sociales_model');
		$this->load->model('expedientes/tramites_model');
		$this->array_tipo_ayuda_social_control = $array_tipo_ayuda_social = $this->get_array('tipos_ayudas_sociales', 'nombre', 'id', null, array(0 => '-- Seleccionar tipo de ayuda --'));
		unset($this->array_tipo_ayuda_social_control[0]);
		$this->array_tramite_control = $array_tramite = $this->get_array('tramites', 'nombre', 'id', array('tipo' => "$expediente->tipo_tramite", 'sort_by' => 'nombre'));
		$model_editar = new stdClass();
		$model_editar->fields = $this->fields = array(
			array('name' => 'persona_id', 'label' => 'Persona', 'readonly' => TRUE, 'type' => 'hidden'),
			array('name' => 'caratula', 'label' => 'Solicitante', 'required' => TRUE, 'readonly' => TRUE),
			array('name' => 'tramite', 'label' => 'Trámite', 'input_type' => 'combo', 'id_name' => 'tramite_id', 'required' => TRUE, 'onchange' => 'ver_extras_expediente();'),
			array('name' => 'objeto', 'label' => 'Objeto', 'maxlength' => '100', 'required' => TRUE),
			array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer', 'maxlength' => '11', 'required' => TRUE),
			array('name' => 'inmueble_id', 'label' => 'ID Inmueble', 'type' => 'hidden', 'maxlength' => '11', 'readonly' => TRUE),
			array('name' => 'inmueble', 'label' => 'Inmueble', 'maxlength' => '50', 'readonly' => TRUE),
		);

		$this->set_model_validation_rules($model_editar);
		$error_msg = FALSE;
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$ayuda_social_id = isset($expediente->ayuda_social_id) ? $expediente->ayuda_social_id : 'NULL';
				if ($this->input->post('tramite') === '100' || $this->input->post('tramite') === '101') //AYUDA SOCIAL
				{
					if (!empty($expediente->ayuda_social_id))
					{
						$trans_ok&= $this->ayudas_sociales_model->update(array(
							'id' => $ayuda_social_id,
							'numeroDeFichaApros' => $this->input->post('numeroDeFichaApros'),
							'nombreDelBeneficiario' => $this->input->post('nombreDelBeneficiario'),
							'detalleSolicitud' => $this->input->post('detalleSolicitud'),
							'detalleFamiliares' => $this->input->post('detalleFamiliares'),
							'detalleBeneficioEntregado' => $this->input->post('detalleBeneficioEntregado'),
							'tipo_ayuda_social_id' => $this->input->post('tipo_ayuda_social')
							), FALSE);
					}
					else
					{
						$trans_ok&= $this->ayudas_sociales_model->create(array(
							'numeroDeFichaApros' => $this->input->post('numeroDeFichaApros'),
							'nombreDelBeneficiario' => $this->input->post('nombreDelBeneficiario'),
							'detalleSolicitud' => $this->input->post('detalleSolicitud'),
							'detalleFamiliares' => $this->input->post('detalleFamiliares'),
							'detalleBeneficioEntregado' => $this->input->post('detalleBeneficioEntregado'),
							'tipo_ayuda_social_id' => $this->input->post('tipo_ayuda_social')
							), FALSE);
						$ayuda_social_id = $this->ayudas_sociales_model->get_row_id();
					}
				}
				elseif (isset($expediente->ayuda_social_id))
				{
					$trans_ok&= $this->ayudas_sociales_model->delete(array('id' => $ayuda_social_id), FALSE);
					$ayuda_social_id = 'NULL';
				}
				if ($this->input->post('tramite') === '18' || $this->input->post('tramite') === '17' || $this->input->post('tramite') === '1' || $this->input->post('tramite') === '61' || $this->input->post('tramite') === '29' || $this->input->post('tramite') === '2' || $this->input->post('tramite') === '19') //BAJA COMERCIO/HAB COMERCIO/CONEXION AGUA/CONEXION CLOACA/CONEXION GAS/CONEXION LUZ/TRASLADO DE COMERCIO
				{
					$inmueble_id = $this->input->post('inmueble_id');
				}
				else
				{
					$inmueble_id = 'NULL';
				}
				$trans_ok&= $this->expedientes_model->update(array(
					'id' => $this->input->post('id'),
					'ano' => $expediente->ano,
					'numero' => $expediente->numero,
					'anexo' => $expediente->anexo,
					'fojas' => $this->input->post('fojas'),
					'tramite_id' => $this->input->post('tramite'),
					'caratula' => $this->input->post('caratula'),
					'objeto' => $this->input->post('objeto'),
					'ayuda_social_id' => $ayuda_social_id,
					'inmueble_id' => $inmueble_id,
					'persona_id' => $this->input->post('persona_id')
					), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->expedientes_model->get_msg());
					redirect("expedientes/expedientes/ver/$expediente->id", 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->ayudas_sociales_model->get_error())
					{
						$error_msg .='<br>' . $this->ayudas_sociales_model->get_error();
					}
					if ($this->expedientes_model->get_error())
					{
						$error_msg .='<br>' . $this->expedientes_model->get_error();
					}
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($error_msg ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		$fields_editar = $this->expedientes_model->fields;
		
		unset($fields_editar[0]); //Tipo
		unset($fields_editar[12]); //Oficina_id
		unset($fields_editar[13]); //Oficina
                unset($fields_editar[15]); 
                unset($fields_editar[16]); 
		foreach ($fields_editar as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $expediente->{$field['name']});
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $expediente->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['fields_ayuda_social'] = array();
		foreach ($this->ayudas_sociales_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields_ayuda_social'], $field, isset($ayuda_social) ? $ayuda_social->{$field['name']} : null);
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields_ayuda_social'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields_ayuda_social'], $field, ${'array_' . $field['name']}, isset($ayuda_social) ? $ayuda_social->{isset($field['id_name']) ? $field['id_name'] : $field['name']} : null);
				}
			}
		}

		$tableData_oficinas_solicitante = array(
			'columns' => array(
				array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 15, 'class' => 'dt-body-right', 'responsive_class' => 'all', 'query' => 'where'),
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'oficina.nombre', 'width' => 80, 'query' => 'like'),
				array('label' => '', 'data' => 'select_solicitante', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'oficinas_solicitante_table',
			'source_url' => 'expedientes/oficinas/listar_data/TRUE',
			'order' => array(array(1, 'asc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#oficinas_solicitante_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#oficinas_solicitante_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_oficinas_solicitante'] = buildHTML($tableData_oficinas_solicitante);
		$data['js_table_oficinas_solicitante'] = buildJS($tableData_oficinas_solicitante);

		$tableData_solicitantes = array(
			'columns' => array(
				array('label' => 'Nombre', 'data' => 'DetaPers', 'sort' => 'DetaPers', 'width' => 50, 'query' => 'like'),
				array('label' => 'N° de documento', 'data' => 'NudoPers', 'sort' => 'NudoPers', 'width' => 45, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'solicitantes_table',
			'order' => array(array(0, 'asc')),
			'source_url' => 'expedientes/personas/listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#solicitantes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#solicitantes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_solicitantes'] = buildHTML($tableData_solicitantes);
		$data['js_table_solicitantes'] = buildJS($tableData_solicitantes);

		$tableData_inmuebles = array(
			'columns' => array(
				array('label' => 'N° de cuenta', 'data' => 'CodiInmu', 'sort' => 'inmueble.CodiInmu', 'width' => 15, 'class' => 'dt-body-right'),
				array('label' => 'Nomenclatura Catastral', 'data' => 'NomeInmu', 'sort' => 'inmueble.NomeInmu', 'width' => 25, 'class' => 'dt-body-right'),
				array('label' => 'Propietario', 'data' => 'DetaPers', 'sort' => 'persona.DetaPers', 'width' => 25),
				array('label' => 'Calle', 'data' => 'DecpInmu', 'sort' => 'inmueble.DecpInmu', 'width' => 10),
				array('label' => 'N°', 'data' => 'NupoInmu', 'sort' => 'inmueble.NupoInmu', 'width' => 10, 'class' => 'dt-body-right'),
				array('label' => 'Dpto / Distrito', 'data' => 'DelpInmu', 'sort' => 'inmueble.DelpInmu', 'width' => 10),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'inmuebles_table',
			'order' => array(array(0, 'asc')),
			'source_url' => 'expedientes/inmuebles/listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#inmuebles_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#inmuebles_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_inmuebles'] = buildHTML($tableData_inmuebles);
		$data['js_table_inmuebles'] = buildJS($tableData_inmuebles);

		$data['expediente'] = $expediente;
		//var_dump($expediente);die();

		$data['txt_btn'] = 'Guardar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '', 'adjuntos' => '');
		$data['title'] = 'Expedientes - Expedientes - Modificar';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$this->load_template('expedientes/expedientes/expedientes_editar', $data);
	}

	public function eliminar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/expedientes/ver/$id", 'refresh');
		}
		$expediente = $this->expedientes_model->get(array('id' => $id, 'join' => array(array('table' => "$this->sigmu_schema.tramite", 'where' => 'tramite.id=expediente.tramite_id', 'columnas' => array('tramite.tipo as tipo_tramite')))));
		if (empty($expediente))
		{
			show_404();
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/expedientes/ver/$id", 'refresh');
		}
		$this->load->model('expedientes/expedientes_model');
		if (!in_groups($this->grupos_acceso_especial, $this->grupos)){
			if($this->expedientes_model->verificarEliminacion($id) == 'Existe posterior'){
				$this->session->set_flashdata('error', 'No se puede eliminar el expediente, ya que se creó uno posterior');
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			} else if($this->expedientes_model->verificarEliminacion($id) == 'Tiene mas de un pase') {
				$this->session->set_flashdata('error', 'El expediente tiene más de un pase');
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			} else if($this->expedientes_model->verificarEliminacion($id) == 'Pendiente de recepcion') {
				$this->session->set_flashdata('error', 'El expediente se encuentra pendiente de recepción');
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			} 
		} else {
			if($this->expedientes_model->eliminar_e($id)){
				$this->session->set_flashdata('message', 'Expediente eliminado correctamente');
				redirect("expedientes/expedientes/listar");
			}else{
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			}
		}
	}
        
	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if (empty($expediente))
		{
			show_404();
		}

		$this->load->model('expedientes/ayudas_sociales_model');
		$this->load->model('expedientes/tipos_ayudas_sociales_model');
		$array_tipo_ayuda_social = $this->get_array('tipos_ayudas_sociales', 'nombre');
		if (isset($expediente->ayuda_social_id))
		{
			$ayuda_social = $this->ayudas_sociales_model->get(array('id' => $expediente->ayuda_social_id));
		}
		$this->load->model('expedientes/tramites_model');
		$data['message'] = $this->session->flashdata('message');
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		$fake_model = array(
			array('name' => 'numero', 'label' => 'Nº', 'type' => 'integer'),
			array('name' => 'ano', 'label' => 'Año', 'type' => 'integer'),
			array('name' => 'anexo', 'label' => 'Anexo', 'type' => 'integer'),
			array('name' => 'caratula', 'label' => 'Solicitante'),
			array('name' => 'objeto', 'label' => 'Objeto'),
			array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer'),
			array('name' => 'inicio', 'label' => 'Fecha', 'type' => 'date')
		);
		foreach ($fake_model as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $expediente->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $expediente->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['fields_ayuda_social'] = array();
		foreach ($this->ayudas_sociales_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields_ayuda_social'], $field, isset($ayuda_social) ? $ayuda_social->{$field['name']} : null);
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields_ayuda_social'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields_ayuda_social'], $field, ${'array_' . $field['name']}, isset($ayuda_social) ? $ayuda_social->{isset($field['id_name']) ? $field['id_name'] : $field['name']} : null);
				}
			}
		}

		$data['expediente'] = $expediente;
                
                $data['firmas'] = $this->expedientes_model->get(array(
                    'select' => 'aa.id as documento_id,aa.nombre as documento, u1.username as firmante, u2.username as solicitante, faa.fecha_solicitud as fecha',
                    'join' => array(
                        array('type' => 'left', 'table' => 'sigmu.archivoadjunto aa', 'where' => 'aa.id_expediente = expediente.id'),
                        array('type' => 'inner', 'table' => 'expedientes.firmas_archivos_adjuntos faa', 'where' => 'faa.archivo_adjunto_id = aa.id AND faa.estado = \'Solicitada\''),
                        array('type' => 'left', 'table' => 'expedientes.users u1', 'where' => 'u1.id = faa.usuario_id'),
                        array('type' => 'left', 'table' => 'expedientes.users u2', 'where' => 'u2.id = faa.solicitante_id'),
                    ),
                    'id' => $expediente->id,
                    'sort_by' => 'faa.fecha_solicitud desc'
				));
		
                
		$this->load->model('expedientes/pases_model');
		
		$data['pases'] = $this->pases_model->get(array(
			'select' => 'pase.id, pase.fecha, pase.origen, oe.nombre ofi_emi, pase.usuario_emisor usu_emi, pase.destino, or.nombre ofi_rec, pase.usuario_receptor usu_rec, pase.respuesta, pase.fojas, pase.nota_pase_id, np.contenido, IF(e.firma_pendiente = 1, \'display: none;\',\'\') as btn_disabled, r.estado as revision_estado',
			'join' => array(
                                array('type' => 'left','table' => $this->sigmu_schema.".expediente e",'where' => "e.id = pase.id_expediente"),
				array('type' => 'left', 'table' => "$this->sigmu_schema.oficina oe", 'where' => 'pase.origen=oe.id'),
				array('type' => 'left', 'table' => "$this->sigmu_schema.oficina or", 'where' => 'pase.destino=or.id'),
				array('type' => 'left', 'table' => "$this->sigmu_schema.notapase np", 'where' => 'pase.nota_pase_id=np.id'),
				array('type' => 'left', 'table' => "$this->sigmu_schema.revision r", 'where' => 'pase.revision_id=r.id')
			),
			'id_expediente' => $expediente->id,
			'sort_by' => 'id desc'
		));
		if (!empty($data['pases'][0]))
		{
			$data['archivado'] = $data['pases'][0]->origen == 1 && $data['pases'][0]->destino == -1;
		}
		else
		{
			$data['archivado'] = FALSE;
		}
		$data['anexos'] = $this->expedientes_model->get(array(
			'select' => "expediente.id, expediente.inicio, expediente.numero, expediente.anexo, tramite.nombre tramite, expediente.objeto, expediente.fojas",
			'join' => array(
				array('type' => 'left', 'table' => "$this->sigmu_schema.tramite", 'where' => 'expediente.tramite_id=tramite.id'),
			),
			'numero' => $expediente->numero,
			'ano' => $expediente->ano,
			'anexo !=' => $expediente->anexo,
			'sort_by' => 'anexo',
			'sort_direction' => 'desc'
		));
		$data['acumulados'] = $this->expedientes_model->get(array(
			'select' => "expediente.id, expediente.inicio, expediente.numero, expediente.anexo, tramite.nombre tramite, expediente.objeto, expediente.fojas",
			'join' => array(
				array('type' => 'left', 'table' => "$this->sigmu_schema.tramite", 'where' => 'expediente.tramite_id=tramite.id'),
			),
			'acumulado' => $expediente->id,
			'sort_by' => 'inicio'
		));
		$this->load->model('expedientes/archivos_adjuntos_model');
		$data['adjuntos'] = $this->archivos_adjuntos_model->get_adjuntos($expediente->id);
                //var_dump($data['adjuntos']);die();

		$tableData_usuarios = array(
			'columns' => array(
				array('label' => 'Usuario', 'data' => 'CodiUsua', 'sort' => 'CodiUsua', 'width' => 10),
				array('label' => 'Nombre', 'data' => 'DetaUsua', 'sort' => 'DetaUsua', 'width' => 95),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'usuarios_table',
			'source_url' => 'expedientes/usuarios/listar_users_signers_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#usuarios_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#usuarios_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_usuarios'] = buildHTML($tableData_usuarios);
		$data['js_table_usuarios'] = buildJS($tableData_usuarios);



		$this->load->model('expedientes/pases_model');
		$pases = $this->pases_model->get(array(
			'id_expediente' => $id,
			'sort_by' => 'id DESC',
			'limit' => 2
		));
                if(!empty($this->session->userdata('groups')) && (in_array('expedientes_admin', $this->session->userdata('groups')) || in_array('admin',$this->session->userdata('groups')))){
                    $data['admin_exp'] = true;
                    $data['acumular'] = ($pases[0]->origen == $this->session->userdata('oficina_actual_id') && $pases[0]->destino == -1) ? true : false;
				
		}else{
                	$data['admin_exp'] = false;
			$data['acumular'] = false;
		}
                
		if (count($pases) == 1 && $pases[0]->origen == $this->session->userdata('oficina_actual_id') && $data['admin_exp'])
		{
			$data['editar_caratula'] = true;
		}
		else
		{
			$data['editar_caratula'] = false;
		}

		$imprime_caratula = false;
		$sitioDeExpediente = $this->expedientes_model->sitioDeExpediente($id);
		if($sitioDeExpediente[0]['origen'] == $this->session->userdata('oficina_actual_id')){
			if($this->expedientes_model->iniciaExpediente($this->session->userdata('oficina_actual_id'))){
				$imprime_caratula = true;
			}
		} else {
			$imprime_caratula = false;
		}

                $this->load->model('expedientes/firmas_archivos_adjuntos_model');
		if (
                        $pases[0]->origen === $this->session->userdata('oficina_actual_id') //la oficina en que se encuentra el expediente
                        //|| $pases[0]->destino === $this->session->userdata('oficina_actual_id') //la oficina que recibira el expedinte
                        || $this->firmas_archivos_adjuntos_model->tieneFirmaPendiente($pases[0]->id_expediente, $this->session->userdata('user_id')) //el usuario al que se solicito la firma
                    )
		{
			$data['ver_expediente'] = TRUE;
		}
		else
		{
			#monica de secretaria, impresora. Nora, estudio contable, fabian.
			if($this->expedientes_model->iniciaExpediente($this->session->userdata('oficina_actual_id'))){
				$data['ver_expediente'] = TRUE;
			} else {
				$data['ver_expediente'] = FALSE;
			}
		}
		if(in_groups($this->grupos_acceso_especial, $this->grupos)){
			$data['acceso_total'] = TRUE; 
		} else {
			$data['acceso_total'] = FALSE; 
		}
		$pase_id = $this->expedientes_model->get(array(
			'select' => 'id',
			'from' => 'sigmu.pase',
			'where' => array(
				'origen = '. $this->session->userdata('oficina_actual_id'),
				'id_expediente = '. $id, 
				'respuesta = "pendiente"'
			)
		))[0]->id;
		$data['ver_expediente'] = TRUE;
		$data['pase_id'] = $pase_id;
		$data['imprime_caratula'] = $imprime_caratula;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '', 'adjuntos' => '');
		$data['title'] = 'Expedientes - Expedientes - Ver';
		$data['css'][] = 'plugins/kartik-v-bootstrap-tabs-x/css/bootstrap-tabs-x.min.css';
		$data['js'][] = 'plugins/kartik-v-bootstrap-tabs-x/js/bootstrap-tabs-x.min.js';
		$data['css'][] = 'plugins/bootstrap-fileinput/css/fileinput.min.css';
		$data['js'][] = 'plugins/bootstrap-fileinput/js/fileinput.min.js';
		$data['js'][] = 'plugins/bootstrap-fileinput/js/fileinput_locale_es.js';
		$this->load_template('expedientes/expedientes/expedientes_ver', $data);
	}

	public function acumular($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede acumular expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$id");
		}

		$this->form_validation->set_rules('id', 'Expediente', 'integer|required');
		$this->form_validation->set_rules('expedientes[]', 'Expedientes', 'integer|required');
		$error_msg = FALSE;
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$expedientes = $this->input->post('expedientes');
				foreach ($expedientes as $exp_acumular_id)
				{
					$exp = $this->expedientes_model->get(array('id' => $exp_acumular_id));
					$trans_ok&= $this->expedientes_model->update(array(
						'id' => $exp_acumular_id,
						'numero' => $exp->numero,
						'ano' => $exp->ano,
						'anexo' => $exp->anexo,
						'acumulado' => $id
						), FALSE);
                                        $this->load->model('expedientes/pases_model');
                                        $trans_ok&= $this->pases_model->acumularPase($exp_acumular_id);
				}
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->expedientes_model->get_msg());
					redirect("expedientes/expedientes/ver/$id", 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->expedientes_model->get_error())
					{
						$error_msg .='<br>' . $this->expedientes_model->get_error();
					}
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($error_msg ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		$fake_model = array(
			array('name' => 'numero', 'label' => 'Nº', 'type' => 'integer'),
			array('name' => 'ano', 'label' => 'Año', 'type' => 'integer'),
			array('name' => 'anexo', 'label' => 'Anexo', 'type' => 'integer'),
			array('name' => 'caratula', 'label' => 'Solicitante'),
			array('name' => 'objeto', 'label' => 'Objeto'),
			array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer'),
			array('name' => 'tramite', 'label' => 'Trámite')
		);
		foreach ($fake_model as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $expediente->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $expediente->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$tableData_expedientes = array(
			'columns' => array(
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 8, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 8, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 8, 'class' => 'dt-body-right', 'query' => 'where'),
				array('label' => 'Solicitante/Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 33, 'query' => 'like'),
				array('label' => 'Trámite/Asunto', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 38, 'query' => 'like'),
				array('label' => '', 'data' => 'acumular', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'expedientes_table',
			'source_url' => "expedientes/expedientes/listar_data_acumular/$id",
			'order' => array(array(0, 'desc'), array(1, 'desc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#expedientes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#expedientes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_expedientes'] = buildHTML($tableData_expedientes);
		$data['js_table_expedientes'] = buildJS($tableData_expedientes);

		$data['expediente'] = $expediente;
		$data['txt_btn'] = 'Acumular';
		$data['title'] = 'Expedientes - Expedientes - Acumular';
		$this->load_template('expedientes/expedientes/expedientes_acumular', $data);
	}

	public function pdf_caratula($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if(!in_groups($this->grupos_acceso_especial, $this->grupos)){
			$sitioDeExpediente = $this->expedientes_model->sitioDeExpediente($id);
			if($sitioDeExpediente[0]['origen'] == $this->session->userdata('oficina_actual_id')){
				if(!$this->expedientes_model->iniciaExpediente($this->session->userdata('oficina_actual_id'))){
					$this->session->set_flashdata('error', 'No tiene permiso para imprimir la carátula');
					redirect("expedientes/expedientes/ver/$id", 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'El expediente no se encuentra en su oficina');
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			}
		}
		if (empty($expediente))
		{
			show_404();
		}
		$data['expediente'] = $expediente;
//			ini_set('memory_limit', '32M'); // boost the memory limit if it's low
		$html = $this->load->view('expedientes/expedientes/expedientes_pdf_caratula', $data, true);

		$this->load->library('pdf');
		if($expediente->idgital == 0) $pdf = $this->pdf->load('','LEGAL');
//			$pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output("caratula_{$expediente->numero}_{$expediente->ano}_{$expediente->anexo}.pdf", 'I');
	}

	public function pdf_comprobante($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if (empty($expediente))
		{
			show_404();
		}
		$data['expediente'] = $expediente;
//			ini_set('memory_limit', '32M'); // boost the memory limit if it's low
		$html = $this->load->view('expedientes/expedientes/expedientes_pdf_comprobante', $data, true);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
//			$pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pdf->Output("Comprobante_{$expediente->numero}_{$expediente->ano}_{$expediente->anexo}.pdf", 'I');
	}

	public function formularios_inicio($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite', 'tramite.plantilla_id as plantilla_id')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede generar formularios de inicio de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$id");
		}
		if (empty($expediente->plantilla_id))
		{
			$this->session->set_flashdata('error', "No se encontró formulario para $expediente->tramite");
			redirect("expedientes/expedientes/ver/$expediente->id", 'refresh');
		}
		else
		{
			redirect("expedientes/expedientes/generar_informe/$expediente->id/$expediente->plantilla_id", 'refresh');
		}
	}

	public function generar_informe($id = NULL, $pase_id = NULL, $plantilla_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!in_groups($this->grupos_acceso_especial, $this->grupos)){
			$sitioDeExpediente = $this->expedientes_model->sitioDeExpediente($id);
			if($sitioDeExpediente[0]['origen'] == $this->session->userdata('oficina_actual_id')){
				if(in_groups($this->grupos_acceso_especial_reducido, $this->grupos)){
					if(!$this->expedientes_model->iniciaExpediente($this->session->userdata('oficina_actual_id'))){
						$this->session->set_flashdata('error', 'No tiene permiso para imprimir la carátula');
						redirect("expedientes/expedientes/ver/$id", 'refresh');
					}
				}
			} else {
				$this->session->set_flashdata('error', 'El expediente no se encuentra en su oficina');
				redirect("expedientes/expedientes/ver/$id", 'refresh');
			}
		}
		$this->load->model('expedientes/pases_model');
		$ultimo_pase = $this->pases_model->get(array(
			'select' => 'id',
			'id_expediente' => $expediente->id,
			'sort_by' => 'id desc',
			'limit' => '1'
		));
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede generar informe de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$id");
		}
		$this->form_validation->set_rules('id', 'Expediente', 'integer|required');
		$this->form_validation->set_rules('texto', 'Texto', 'required');
		if (isset($plantilla_id))
		{
			$this->load->model('expedientes/plantillas_model');
			$plantilla = $this->plantillas_model->get(array('id' => $plantilla_id));
		}
		if (isset($_POST) && !empty($_POST) && isset($plantilla))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->load->library('pdf');
				$pdf = $this->pdf->load();
				$html = $this->input->post('texto', FALSE);

				if ($this->input->post('firmapad') != '') {
					$firmas_array = explode('<separator>', $this->input->post('firmapad'));
					if (sizeof($firmas_array) - 1 < $this->input->post('firmapad')) {
						$this->session->set_flashdata('error', 'Error, faltan firmas en el formulario.');
						redirect("expedientes/pases/generar_informe/".$id."/".$plantilla_id, 'refresh');
					}
					for ($i = 1; $i <= sizeof($firmas_array); $i++) {
						if (strpos($html, "#{firma_pad_" . $i . "}")) {
							$firma_b64 = '<img src="data:image/png;base64,' . $firmas_array[$i - 1] . '" height="110" width="220">';
							$html = str_replace("#{firma_pad_" . $i . "}", $firma_b64, $html);
						}
					}
				}
				$pdf->WriteHTML($html);
				$pdf_content = $pdf->Output("$plantilla->nombre.pdf", 'S');
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$this->load->model('expedientes/archivos_adjuntos_model');
				$trans_ok&= $this->archivos_adjuntos_model->create(array(
					'nombre' => "$plantilla->nombre.pdf",
					'tamanio' => strlen($pdf_content),
					'tipodecontenido' => "application/pdf",
					'contenido' => $pdf_content,
					'id_expediente' => $expediente->id,
					'descripcion' => 'NULL',
					'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
					'pase_id' => $pase_id
					), FALSE);
				$archivo_adjunto_id = $this->archivos_adjuntos_model->get_row_id();

				$query_fojas = $this->archivos_adjuntos_model->get(array('select' => 'COALESCE(MAX(foja_hasta),0)+1 as foja_desde',
					'join' => array(array('table' => 'fojas_archivos_adjuntos', 'where' => 'fojas_archivos_adjuntos.archivo_adjunto_id=archivoadjunto.id')),
					'id_expediente' => $expediente->id));
				$foja_desde = $query_fojas[0]->foja_desde;
				$this->load->model('expedientes/fojas_archivos_adjuntos_model');
				$trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
					'archivo_adjunto_id' => $archivo_adjunto_id,
					'foja_desde' => $foja_desde,
					'foja_hasta' => $foja_desde + count($pdf->pages) - 1
					), FALSE);
				if ($this->expedientes_model->is_digital($expediente->id))
				{
                                    $this->load->model('expedientes/pases_model');
                                    $last_pase = $this->pases_model->getIdUltimoPase($expediente->id);
                                    $trans_ok &= $this->pases_model->update(array(
                                        'id' => $last_pase,
                                        'fojas' => $foja_desde + count($pdf->pages) - 1
                                    ),false);
                                    $trans_ok&= $this->expedientes_model->update(array(
                                            'id' => $expediente->id,
                                            'fojas' => $foja_desde + count($pdf->pages) - 1
                                            ), FALSE);
				}
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', 'Se generó el informe');
					redirect("expedientes/expedientes/ver/$expediente->id", 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->archivos_adjuntos_model->get_error())
					{
						$error_msg .='<br>' . $this->archivos_adjuntos_model->get_error();
					}
					if ($this->fojas_archivos_adjuntos_model->get_error())
					{
						$error_msg .='<br>' . $this->fojas_archivos_adjuntos_model->get_error();
					}
					$data['error'] = $error_msg;
				}
			}
		}
		if (isset($plantilla))
		{
			$registro = $this->armar_registro($expediente);
			//$texto = $this->evaluar($plantilla->texto, $registro);
			$html = "<html><head></head><body>$plantilla->texto</body></html>";
			$plantilla->texto = $html;
			$data['plantilla'] = $plantilla;
		}
		$tableData_plantillas = array(
			'columns' => array(
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'plantilla.nombre', 'width' => 95),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'plantillas_table',
			'source_url' => 'expedientes/plantillas/listar_data/dinamica',
			'order' => array(array(0, 'asc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#plantillas_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#plantillas_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_plantillas'] = buildHTML($tableData_plantillas);
		$data['js_table_plantillas'] = buildJS($tableData_plantillas);

		$data['expediente'] = $expediente;
		$data['ultimo_pase'] = $ultimo_pase;
		if($plantilla_id != NULL){
			$data['firma_pad'] = $this->plantillas_model->getCantFirmasPad($plantilla_id);
		}
		$data['title'] = 'Expedientes - Generar Informe';
		$data['js'][] = 'plugins/ckeditor/ckeditor.js';
		$data['js'][] = 'plugins/ckeditor/adapters/jquery.js';
		$data['js'][] = 'plugins/ckeditor/config.js';
		$data['js'][] = 'plugins/ckeditor/lang/es.js';
		$data['js'][] = 'js/expedientes/SigWebTablet.js';
		$data['css'][] = 'plugins/ckeditor/skins/bootstrapck/editor.css';
		$this->load_template('expedientes/expedientes/expedientes_generar_informe', $data);
	}

	public function generar_informe_infogov($id = NULL, $informe_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				))
		));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede generar informes de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$id");
		}
		if (!empty($informe_id))
		{
			switch ($informe_id)
			{
				case 1:
					$informe = new stdClass();
					$informe->id = $informe_id;
					$informe->nombre = 'Orden de Pago';
					$informe->view = 'expedientes/informes_infogov/infogov_orden_pago';
					$informe->fields = [
						[
							'name' => 'periodo', 'label' => 'Periodo',
							'type' => 'integer', 'maxlength' => '4',
							'required' => TRUE, 'value' => date('Y')
						],
						[
							'name' => 'numero', 'label' => 'Nº Orden de Pago',
							'type' => 'integer', 'maxlength' => '11',
							'required' => TRUE
						]
					];
					break;
				case 2:
					$informe = new stdClass();
					$informe->id = $informe_id;
					$informe->nombre = 'Constancia Retención';
					$informe->view = 'expedientes/informes_infogov/infogov_constancia_retencion';
					$informe->fields = [
						[
							'name' => 'periodo', 'label' => 'Periodo',
							'type' => 'integer', 'maxlength' => '4',
							'required' => TRUE, 'value' => date('Y')
						],
						[
							'name' => 'codigo', 'label' => 'Tipo Retención',
							'type' => 'integer', 'maxlength' => '4',
							'required' => TRUE//, 'input_type' => 'combo'
						],
						[
							'name' => 'numero', 'label' => 'Certificado',
							'type' => 'integer', 'maxlength' => '11',
							'required' => TRUE
						]
					];
					break;
				default:
					break;
			}
			$this->set_model_validation_rules($informe);
		}
		$this->form_validation->set_rules('id', 'Expediente', 'integer|required');
		$error_msg = FALSE;
		if (isset($_POST) && !empty($_POST) && isset($informe))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				switch ($informe->id)
				{
					case 1:
						$periodo = $this->input->post('periodo');
						$numero = $this->input->post('numero');
						$db_infogov = $this->load->database('infogov', TRUE);
						$informe->objeto = 'orden_pago';
						$informe->nombre.="_$numero/$periodo";
						$informe->footer_c = "Orden de Pago N° $numero";
						$informe->datos = $db_infogov->select('*')
								->from('v_ordenpago')
								->where('numero_op', $numero)
								->where('periodo', $periodo)
								->get()->row();
						if (!empty($informe->datos))
						{
							$informe->datos->cheques = $db_infogov->select('*')
									->from('v_op_cheque')
									->where('numero_op', $numero)
									->where('periodo', $periodo)
									->get()->result();
							$informe->datos->erogaciones = $db_infogov->select('*')
									->from('v_op_erogacion')
									->where('numero_op', $numero)
									->where('periodo', $periodo)
									->order_by('proveedor')
									->get()->result();
							$informe->datos->retenciones = $db_infogov->select('*')
									->from('v_op_retencion')
									->where('numero_op', $numero)
									->where('periodo', $periodo)
									->order_by('proveedor')
									->get()->result();
						}
						else
						{
							$error_msg = 'No se encontró la orden de pago';
						}
						break;
					case 2:
						$periodo = $this->input->post('periodo');
						$codigo = $this->input->post('codigo');
						$numero = $this->input->post('numero');
						$db_infogov = $this->load->database('infogov', TRUE);
						$informe->objeto = 'retencion';
						$informe->nombre.="_$periodo/$codigo-$numero";
						$informe->datos = $db_infogov->select('*')
								->from('v_op_retencion')
								->where('periodo', $periodo)
								->where('retencion_codigo', $codigo)
								->where('nro_certificado', $numero)
								->get()->row();
						if (!empty($informe->datos))
						{
							$informe->footer_c = "Constancia de Retención - {$informe->datos->retencion_detalle}";
							$informe->datos->orden_pago = $db_infogov->select('*')
									->from('v_ordenpago')
									->where('numero_op', $informe->datos->numero_op)
									->where('periodo', $informe->datos->periodo)
									->get()->row();
							$informe->datos->erogaciones = $db_infogov->select('*')
									->from('v_op_erogacion')
									->where('numero_op', $informe->datos->numero_op)
									->where('periodo', $informe->datos->periodo)
									->order_by('proveedor')
									->get()->result();
						}
						else
						{
							$error_msg = 'No se encontró la constancia de retención';
						}
						break;
					default:
						break;
				}
				if (!empty($informe->datos))
				{
					$this->load->library('pdf');
					$pdf = $this->pdf->load();
					$pdf->SetTitle($informe->nombre);
					$pdf->SetFooter(array(
						'C' => array('content' => $informe->footer_c),
						'R' => array('content' => 'Hoja: {PAGENO}/{nb}')
						), 'O');
					$html = $this->load->view($informe->view, [$informe->objeto => $informe->datos], true);
					$pdf->WriteHTML($html);
					$testing = FALSE;
					if ($testing)
					{
						$pdf_content = $pdf->Output("$informe->nombre.pdf", 'I');
					}
					else
					{
						$pdf_content = $pdf->Output("$informe->nombre.pdf", 'S');
						$this->db->trans_begin();
						$trans_ok = TRUE;
						$this->load->model('expedientes/archivos_adjuntos_model');
						$trans_ok&= $this->archivos_adjuntos_model->create(array(
							'nombre' => "$informe->nombre.pdf",
							'tamanio' => strlen($pdf_content),
							'tipodecontenido' => "application/pdf",
							'contenido' => $pdf_content,
							'id_expediente' => $expediente->id,
							'descripcion' => 'NULL',
							'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s')
							), FALSE);
						$archivo_adjunto_id = $this->archivos_adjuntos_model->get_row_id();

						$query_fojas = $this->archivos_adjuntos_model->get(array('select' => 'COALESCE(MAX(foja_hasta),0)+1 as foja_desde',
							'join' => array(array('table' => 'fojas_archivos_adjuntos', 'where' => 'fojas_archivos_adjuntos.archivo_adjunto_id=archivoadjunto.id')),
							'id_expediente' => $expediente->id));
						$foja_desde = $query_fojas[0]->foja_desde;
						$this->load->model('expedientes/fojas_archivos_adjuntos_model');
						$trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
							'archivo_adjunto_id' => $archivo_adjunto_id,
							'foja_desde' => $foja_desde,
							'foja_hasta' => $foja_desde + count($pdf->pages) - 1
							), FALSE);
						if (FOJA_AUTOMATICA)
						{
							$trans_ok&= $this->expedientes_model->update(array(
								'id' => $expediente->id,
								'fojas' => $foja_desde + count($pdf->pages) - 1
								), FALSE);
						}
					}
				}
				else
				{
					$trans_ok = FALSE;
				}

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', 'Se generó el informe de infogov');
					redirect("expedientes/expedientes/ver/$expediente->id", 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->archivos_adjuntos_model->get_error())
					{
						$error_msg .='<br>' . $this->archivos_adjuntos_model->get_error();
					}
					if ($this->fojas_archivos_adjuntos_model->get_error())
					{
						$error_msg .='<br>' . $this->fojas_archivos_adjuntos_model->get_error();
					}
				}
			}
		}
		$data['error'] = $error_msg;
		if (isset($informe))
		{
			$data['informe'] = $informe;
			$data['fields'] = array();
			foreach ($informe->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field);
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']});
					}
				}
			}
		}
		$data['expediente'] = $expediente;
		$data['title'] = 'Expedientes - Generar Informe Infogov';
		$this->load_template('expedientes/expedientes/expedientes_generar_informe_infogov', $data);
	}

	private function armar_registro($expediente)
	{
		$registro = new stdClass();
		$registro->fecha = date_format(new DateTime(), 'd/m/Y H:i:s');
		$registro->expediente = $expediente;
		$this->load->model('expedientes/personas_model');
		if (!empty($registro->expediente->persona_id))
		{
			$registro->solicitante = $this->personas_model->get(array(
				'CucuPers' => $registro->expediente->persona_id,
				'select' => array(
					'CucuPers as id',
					'DetaPers as nombre',
					'NudoPers as dni',
					'DecrPers as domicilio_calle',
					'DelrPers as domicilio_distrito',
					'NurePers as domicilio_numero',
					'TelePers as telefono_fijo',
					'CeluPers as telefono_celular')
			));
			if (!empty($registro->solicitante))
			{
				if (strlen($registro->solicitante->id) == 11)
				{
					$registro->solicitante->cuit = substr($registro->solicitante->id, 0, 2) . '-' . substr($registro->solicitante->id, 2, 8) . '-' . substr($registro->solicitante->id, 10);
				}
				else
				{
					$registro->solicitante->cuit = '. . . . - . . . . . . . . . . . . . - . . .';
				}
			}
		}
		if (!empty($registro->expediente->inmueble_id))
		{
			$this->load->model('expedientes/inmuebles_model');
			$registro->propiedad = $this->inmuebles_model->get(array(
				'CodiInmu' => $registro->expediente->inmueble_id,
				'select' => array(
					'CodiInmu as id',
					'CodiCall as numero',
					'FojaInmu as fojas',
					'PateInmu as patente',
					'MatrInmu as matricula',
					'NomeInmu as nomenclatura',
					'TomoInmu as tomo',
					'CucuPers as persona_id',
					'DelpInmu as domicilio_departamento',
					'DecpInmu as domicilio_calle',
					'NupoInmu as domicilio_numero',
				)
			));
			if (!empty($registro->propiedad))
			{
				if (strlen($registro->propiedad->nomenclatura) == 21)
				{
					$registro->propiedad->nomenclatura_catastral = substr($registro->propiedad->nomenclatura, 0, 2) . '-' .
						substr($registro->propiedad->nomenclatura, 2, 2) . '-' .
						substr($registro->propiedad->nomenclatura, 4, 2) . '-' .
						substr($registro->propiedad->nomenclatura, 6, 4) . '-' .
						substr($registro->propiedad->nomenclatura, 10, 4) . '-' .
						substr($registro->propiedad->nomenclatura, 16, 4) . '-' .
						substr($registro->propiedad->nomenclatura, 20, 1);
				}
				else
				{
					$registro->propiedad->nomenclatura_catastral = '';
				}
				if (!empty($registro->propiedad->persona_id))
				{
					$registro->propietario = $this->personas_model->get(array(
						'CucuPers' => $registro->propiedad->persona_id,
						'select' => array(
							'CucuPers as id',
							'DetaPers as nombre',
							'NudoPers as dni',
							'DecrPers as domicilio_calle',
							'DelrPers as domicilio_distrito',
							'NurePers as domicilio_numero',
							'TelePers as telefono_fijo',
							'CeluPers as telefono_celular')
					));
					if (!empty($registro->propietario))
					{
						if (strlen($registro->propietario->id) == 11)
						{
							$registro->propietario->cuit = substr($registro->propietario->id, 0, 2) . '-' . substr($registro->propietario->id, 2, 8) . '-' . substr($registro->propietario->id, 10);
						}
						else
						{
							$registro->propietario->cuit = '. . . . - . . . . . . . . . . . . . - . . .';
						}
					}
				}
			}
		}
		return $registro;
	}

	private function evaluar($texto, $registro)
	{
		$texto_arr = str_split($texto);
		$index = 0;
		while ($index !== FALSE)
		{
			$index = strpos($texto, "#{", $index);
			if ($index !== FALSE)
			{
				$texto_arr[$index] = '$';
				$index++;
			}
		}
		$texto_nuevo = implode($texto_arr);
		$campos_valores = $this->armar_valores($registro);
		return str_replace($campos_valores[0], $campos_valores[1], $texto_nuevo);
	}

	private function armar_valores($registro, $prefijo = '')
	{
		$campos = array();
		$valores = array();
		foreach ($registro as $campo => $valor)
		{
			if (!is_object($valor))
			{
				$campos[] = '${' . $prefijo . $campo . '}';
				$valores[] = $valor;
			}
			else
			{
				$ret = $this->armar_valores($valor, $campo . '_');
				$campos = array_merge($campos, $ret[0]);
				$valores = array_merge($valores, $ret[1]);
			}
		}
		return array($campos, $valores);
	}

	public function get_estado()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->form_validation->set_rules('id', 'ID', 'required|integer');
		$estado = new stdClass();
		$estado->estado = '';
		$estado->oficina = '';
		$estado->fecha = '';
		$estado->nota = '';
		if ($this->form_validation->run() === TRUE)
		{
			$expediente = $this->expedientes_model->get(array('id' => $this->input->post('id')));
			if (empty($expediente))
			{
				show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
			}
			$this->load->model('expedientes/pases_model');
			$this->load->model('expedientes/notas_pases_model');
			$this->load->model('expedientes/oficinas_model');
			$lista = $this->pases_model->get(array('id_expediente' => $expediente->id, 'sort_by' => 'id desc', 'limit' => 2));
			$ultimo_pase = new stdClass();
			if (count($lista) >= 1)
			{
				$ultimo_pase = $lista[0];
				if ($ultimo_pase->destino == -1 OR $ultimo_pase->destino == -2)
				{
					$respuesta = $ultimo_pase->respuesta;

					// Si es -1 el pase se encuentra aceptado en alguna oficina
					if (count($lista) > 1)
					{
						$penultimo_pase = $lista[1];
						if (!empty($respuesta))
						{
							// Los pases antiguos tienen respuesta null salvo en el ult. pase
							// En los pases nuevos, tengo que tomar la respuesta del penultimo pase,
							// por si estuviera aceptado.
							if (!empty($penultimo_pase->respuesta))
							{
								$estado->estado = strtoupper($penultimo_pase->respuesta);
							}
							else
							{
								$estado->estado = strtoupper($ultimo_pase->respuesta);
							}
						}
					}
					else
					{
						$estado->estado = strtoupper($ultimo_pase->respuesta);
					}
					$of = $this->oficinas_model->get(array('id' => $ultimo_pase->origen))->nombre;
					$of = str_replace("  ", "", $of);
					$estado->oficina = $of;
					if (!empty($ultimo_pase->nota_pase_id))
					{
						$n = $this->notas_pases_model->get(array('id' => $ultimo_pase->nota_pase_id));
						if (!empty($n->contenido))
						{
							$estado->nota = $n->contenido;
						}
					}

					$fecha = null;
					switch (strtoupper($respuesta))
                                        {       case "":break;
                                                case "FIRMAR":
							$estado->estado = "PENDIENTE DE FIRMA";
							$fecha = $ultimo_pase->fecha_usuario;
                                                        break;
						case "PENDIENTE":
							$estado->estado = "PENDIENTE DE EMISIÓN";
						case "RECHAZADO":
							$fecha = $ultimo_pase->fecha_usuario;
							break;
						case "ACEPTADO":
							$fecha = $ultimo_pase->fecha;
							break;
                                                case "FINALIZADO":
							$estado->estado = "FINALIZADO";
                                                        break;
					}
					if (isset($fecha))
					{
						$estado->fecha = date_format(new DateTime($fecha), 'd/m/Y');
					}
					echo json_encode($estado);
				}
				else
				{       
					if (isset($respuesta))
					{
						$estado->estado = strtoupper($ultimo_pase->respuesta);
					}
                                        
                                        /*REVISO SI TIENE FIRMA PENDIENTE*/
                                        $this->load->model('expediente/expedientes_model');
                                        if($this->expedientes_model->pendienteDeFirma($ultimo_pase->id_expediente)){
                                            $respuesta = "FIRMA";
                                            $of = $this->oficinas_model->get(array('id' => $ultimo_pase->origen))->nombre;
                                            $of = str_replace("  ", "", $of);
                                            $estado->oficina = $of;
                                        }else{
                                            $respuesta = $ultimo_pase->respuesta;
                                            $of = $this->oficinas_model->get(array('id' => $ultimo_pase->destino))->nombre;
                                            $of = str_replace("  ", "", $of);
                                            $estado->oficina = $of;
                                        }
                                        
					if (!empty($ultimo_pase->nota_pase_id))
					{
						$n = $this->notas_pases_model->get(array('id' => $ultimo_pase->nota_pase_id));
						if (!empty($n->contenido))
						{
							$estado->nota = $n->contenido;
						}
					}

					$fecha = null;
					switch (strtoupper($respuesta))
					{
						case "PENDIENTE":
							$estado->estado = "PENDIENTE DE RECEPCION";
							$fecha = $ultimo_pase->fecha_usuario;
							break;
						case "ACEPTADO":
							$fecha = $ultimo_pase->fecha;
							break;
						case "ARCHIVADO":
                                                        $estado->estado = "ARCHIVADO";
							$fecha = $ultimo_pase->fecha;
							break;
					}
					if (isset($fecha))
					{
						$estado->fecha = date_format(new DateTime($fecha), 'd/m/Y');
					}
					echo json_encode($estado);
				}
			}
			else
			{
				$estado->estado = 'DESCONOCIDO';
				echo json_encode($estado);
			}
		}
		else
		{
			$estado->estado = 'DESCONOCIDO';
			echo json_encode($estado);
		}
	}

	public function desacumular($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/expedientes/listar_acumulados", 'refresh');
		}
		$expediente = $this->expedientes_model->get(array('id' => $id));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede desacumular expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$id");
		}
		if (isset($expediente->acumulado))
		{
			$this->expedientes_model->update(array('id' => $id, 'numero' => $expediente->numero, 'ano' => $expediente->ano, 'anexo' => $expediente->anexo, 'acumulado' => 'NULL'));
                        $this->load->model('expedientes/pases_model');
                        $this->pases_model->acumularPase($id,false);
			$this->session->set_flashdata('message', "Se desacumuló el Expediente $expediente->numero / $expediente->ano - $expediente->anexo");
			redirect("expedientes/expedientes/listar_acumulados", 'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', 'No se puede desacumular Expediente no acumulado');
			redirect("expedientes/expedientes/listar_acumulados", 'refresh');
		}
	}

	public function desarchivar($pase_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $pase_id == NULL || !ctype_digit($pase_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('pases_model');
		$pase = $this->pases_model->get(array('id' => $pase_id));
		if (empty($pase))
		{
			show_404();
		}
		$expediente = $this->expedientes_model->get(array('id' => $pase->id_expediente));
		if (empty($pase))
		{
			show_404();
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/expedientes/listar_archivados", 'refresh');
		}
		if ($pase->origen == 1)
		{
			$this->db->trans_begin();
			$trans_ok = TRUE;
			$trans_ok&= $this->pases_model->update(array('id' => $pase->id, 'respuesta' => 'aceptado', 'destino' => 862), FALSE);
			$trans_ok&= $this->pases_model->create(array(
				'fecha_usuario' => date_format(new DateTime(), 'Y-m-d H:i:s'),
				'origen' => 862,
				'id_expediente' => $pase->id_expediente,
				'ano' => $pase->ano,
				'numero' => $pase->numero,
				'anexo' => $pase->anexo,
				'fojas' => $pase->fojas,
				'respuesta' => 'pendiente',
				'terminal' => 'EXPT. DIGITAL',
				'destino' => -1,
				'usuario_emisor' => $this->session->userdata('CodiUsua')
				), FALSE);
			if ($this->db->trans_status() && $trans_ok)
			{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', "Se desarchivó el Expediente $expediente->numero / $expediente->ano - $expediente->anexo");
				redirect("expedientes/expedientes/listar_archivados", 'refresh');
			}
			else
			{
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', 'Ocurrió un error al desarchivar el expediente');
				redirect("expedientes/expedientes/listar_archivados", 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'No se puede desarchivar Expediente no archivado');
			redirect("expedientes/expedientes/listar_archivados", 'refresh');
		}
	}

	public function pdf_exportar($id = NULL, $dest_type = 'I')
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id) || !in_array($dest_type, array('I', 'D')))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		/*if($dest_type == 'I'){
			if(in_groups($this->grupos_acceso_especial)){
				$sitioDeExpediente = $this->expedientes_model->sitioDeExpediente($id);
				if($sitioDeExpediente[0]['origen'] == $this->session->userdata('oficina_actual_id')){
					if(!$this->expedientes_model->iniciaExpediente($this->session->userdata('oficina_actual_id'))){
						$this->session->set_flashdata('error', 'No tiene permiso para imprimir la carátula');
						redirect("expedientes/expedientes/ver/$id", 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'El expediente no se encuentra en su oficina');
					redirect("expedientes/expedientes/ver/$id", 'refresh');
				}
			}
		}*/
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.tramite",
					'where' => 'tramite.id=expediente.tramite_id',
					'columnas' => array('tramite.nombre as tramite')
				),
				array(
					'type' => 'left',
					'table' => "$this->sigmu_schema.expediente em",
					'where' => 'em.id=expediente.acumulado',
					'columnas' => array('em.numero as madre_numero', 'em.ano as madre_ano', 'em.anexo as madre_anexo')
				)
			)
		));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($id);
                $this->load->model('expedientes/firmas_archivos_adjuntos_model');
                $firma_pendiente =  $this->firmas_archivos_adjuntos_model->tieneFirmaPendiente($id, $this->session->userdata('user_id'));
		/*if (($oficina !== $this->session->userdata('oficina_actual_id') && !$firma_pendiente) && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede exportar expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$id");
		}*/
		$this->load->model('expedientes/archivos_adjuntos_model');
		$adjuntos_pdf = $this->archivos_adjuntos_model->get(array('id_expediente' => $expediente->id, 'tipodecontenido' => 'application/pdf', 'sort_by' => 'id'));
		$this->load->library('pdf');
                $pdf = $this->pdf->load();
		require_once _MPDF_PATH . 'vendor/setasign/fpdi/fpdi_pdf_parser.php';
		$pdf->SetImportUse();
		$html = $this->load->view('expedientes/expedientes/expedientes_pdf_caratula', array('expediente' => $expediente), true);
		$pdf->WriteHTML($html); // write the HTML into the PDF
		$pagina = 1;
		$paginas = array("$pagina" => 'Caratula');
		if (!empty($adjuntos_pdf))
		{
			$this->load->model('expedientes/firmas_archivos_adjuntos_model');
			foreach ($adjuntos_pdf as $adjunto_pdf)
			{
				$pagina++;
				$paginas["$pagina"] = substr($adjunto_pdf->nombre, 0, -4);
				$pagina--;
				$tmp_file = tempnam('tmp', 'tmp');
				file_put_contents($tmp_file, $adjunto_pdf->contenido);
				$pagecount = $pdf->SetSourceFile($tmp_file);
				$firmas_adjunto = $this->firmas_archivos_adjuntos_model->get_firmas($adjunto_pdf->id);
				if (!empty($firmas_adjunto))
				{
					foreach ($firmas_adjunto as $firma)
					{
						if (isset($firma->firma))
						{
							$firma->valida = openssl_verify($adjunto_pdf->contenido, base64_decode($firma->firma), $firma->public_key, OPENSSL_ALGO_SHA256);
						}
					}
				}
				for ($i = 1; $i <= $pagecount; $i++)
				{
					$pagina++;
					$pdf->AddPage();
					$import_page = $pdf->ImportPage($i);
					$pdf->UseTemplate($import_page);
					$pdf->WriteHTML('<div style="position:absolute;top:83px;width:80px;float:right;right:57px;text-align:center;font-size:24px">' . ($pagina - 1) . '</div>');
					$pdf->WriteHTML('<img style="position:absolute; float:right;" src="img/expedientes/folio.png"/>');
					if (!empty($firmas_adjunto))
					{
						$i_firma = 0;
						foreach ($firmas_adjunto as $firma)
						{
							if (isset($firma->firma) && $firma->valida)
							{
								if (!isset($firma->cargo))
								{
									$firma->cargo = '';
								}
								$pdf->WriteHTML('<div style="background-repeat:no-repeat;background-position:center;background-image:url(\'img/expedientes/firma.png\');font-family:\'courier\';font-weight:bold;float:left;position:absolute;top:1015px;left:' . (50 + $i_firma * 150) . 'px;width:150px;text-align:center;font-size:10px;">' .
									"$firma->usuario_nombre<br/>$firma->usuario_apellido<br/>$firma->cargo<br/>" .
									date_format(new DateTime($firma->fecha_firma), 'd/m/y H:i:s') .
									'</div>');
								$i_firma++;
							}
						}
					}
				}
			}
		}
		$this->session->set_userdata("pdf_$id", $paginas);
		$pdf->Output("Expediente_{$expediente->numero}-{$expediente->ano}-{$expediente->anexo}.pdf", $dest_type);
	}

	public function indice($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		echo json_encode($this->session->userdata("pdf_$id"));
		return 1;
	}

	public function firmas($expediente_id = NULL, $pagina = 1)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $expediente_id == NULL || !ctype_digit($expediente_id) || $pagina == NULL || !ctype_digit($pagina))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/fojas_archivos_adjuntos_model');
		$this->load->model('expedientes/firmas_archivos_adjuntos_model');
		$foja = $pagina - 1;
		$archivo_adjunto = $this->fojas_archivos_adjuntos_model->get_archivo($expediente_id, $foja);
		if (isset($archivo_adjunto))
		{
			$oficina = $this->expedientes_model->get_oficina($expediente_id);
			/*
			if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
			{
				$this->session->set_flashdata('error', 'No puede ver firmas de expedientes que no estén en su oficina');
				redirect("expedientes/expedientes/ver/$expediente_id");
			}
			*/
			$firmas = $this->firmas_archivos_adjuntos_model->get_firmas($archivo_adjunto->id);
			if (!empty($firmas))
			{
				foreach ($firmas as $firma)
				{
					if (isset($firma->firma))
					{
						$firma->valida = openssl_verify($archivo_adjunto->contenido, base64_decode($firma->firma), $firma->public_key, OPENSSL_ALGO_SHA256);
						$firma->firma = TRUE;
					}
					else
					{
						$firma->valida = FALSE;
					}
					unset($firma->public_key);
				}
				echo json_encode(array('title' => $archivo_adjunto->nombre, 'foja' => $foja, 'firmas' => $firmas));
			}
			else
			{
				echo json_encode(array('title' => $archivo_adjunto->nombre, 'foja' => $foja, 'firmas' => array()));
			}
		}
		else
		{
			echo json_encode('no_data');
		}
		return 1;
	}

	public function visualizar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$oficina = $this->expedientes_model->get_oficina($id);
                $this->load->model('expedientes/firmas_archivos_adjuntos_model');
                $firma_pendiente =  $this->firmas_archivos_adjuntos_model->tieneFirmaPendiente($id, $this->session->userdata('user_id'));
		if (($oficina !== $this->session->userdata('oficina_actual_id') && !$firma_pendiente) && !in_groups($this->grupos_admin, $this->grupos))
		{
			//$this->session->set_flashdata('error', 'No puede visualizar expedientes que no estén en su oficina');
			//redirect("expedientes/expedientes/ver/$id");
		}
		$data['expediente_id'] = $id;
		$this->load->view('expedientes/expedientes/expedientes_visualizar', $data);
	}
        
	public function is_digital(){//si es digital el tramite
		if($this->input->post()){
			$this->load->model('expedientes/tramites_model');
			$detalle = $this->input->post('detalle');
			echo $this->tramites_model->is_digital($detalle);
		}else{
			echo "false";
		}
	}

	public function generar_reporte_pases($id = NULL){
		$this->load->model('expedientes/pases_model');
		$expediente = $this->expedientes_model->get(array(
			'id' => $id,
			'select' => 'ano, numero, anexo'
		));
		$pases = $this->pases_model->get(array(
			'id_expediente' => $id,
			'select' => 'date_format(pase.fecha, "%d/%m/%Y %H:%i") as fecha,
			oficina_origen.nombre AS origen,
			pase.usuario_emisor,
			oficina_destino.nombre AS destino,
			pase.usuario_receptor,
			pase.respuesta,
			pase.fojas',
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.oficina oficina_origen",
					'where' => 'pase.origen = oficina_origen.id'
				),
				array(
					'table' => "$this->sigmu_schema.oficina oficina_destino",
					'where' => 'pase.destino = oficina_destino.id'
				)
			),
			'sort_by' => array('pase.id DESC'),
		));
		$data['pases'] = $pases;
		$data['expediente'] = $expediente;
		$html = $this->load->view('expedientes/expedientes/expedientes_reporte_pases', $data, true);
		$this->load->library('pdf');
		if($expediente->idgital == 0) $pdf = $this->pdf->load('','LEGAL');
		$pdf->WriteHTML($html);
		$pdf->Output("pases_{$expediente->numero}_{$expediente->ano}_{$expediente->anexo}.pdf", 'I');
	}
}
/* End of file Expedientes.php */
/* Location: ./application/modules/expedientes/controllers/Expedientes.php */