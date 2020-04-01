<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends MY_Controller // @TODO HACER QUERIES BIEN
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
	}

	public function pases_oficina_usuario()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->array_mostrar_control = $array_mostrar = array('E' => 'Enviados', 'R' => 'Recibidos');
		$fake_model = new stdClass();
		$fake_model->fields = array(
			array('name' => 'desde', 'label' => 'Fecha desde', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
			array('name' => 'hasta', 'label' => 'Fecha hasta', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
			array('name' => 'mostrar', 'label' => 'Mostrar', 'input_type' => 'combo', 'required' => TRUE)
		);

		$this->set_model_validation_rules($fake_model);
		if ($this->form_validation->run() === TRUE)
		{
			$this->load->model('expedientes/pases_model');
			$datetime_desde = DateTime::createFromFormat('d/m/Y', $this->input->post('desde'));
			$fecha_desde = date_format($datetime_desde, 'Y-m-d');
			$datetime_hasta = DateTime::createFromFormat('d/m/Y', $this->input->post('hasta'));
			$fecha_hasta_title = date_format($datetime_hasta, 'Y-m-d');
			$datetime_hasta->add(new DateInterval('P1D'));
			$fecha_hasta = date_format($datetime_hasta, 'Y-m-d');
			if ($this->input->post('mostrar') === 'E')
			{
				$tipo_usuario = "pase.usuario_emisor";
				$tipo_oficina = "pase.origen";
				$title_pdf = 'Pases emitidos';
			}
			else
			{
				$tipo_usuario = 'pase.usuario_receptor';
				$tipo_oficina = "pase.destino";
				$title_pdf = 'Pases recibidos';
			}
			$pases = $this->pases_model->get(array(
				'select' => "$tipo_usuario usuario, o.nombre oficina, o.id oficina_id, count(1) cantidad",
				'join' => array(
					array(
						'type' => 'left',
						'table' => "$this->sigmu_schema.usuario_oficina u",
						'where' => "$tipo_usuario = (u.ID_USUARIO COLLATE latin1_spanish_ci) AND $tipo_oficina = u.ID_OFICINA"
					),
					array(
						'type' => 'left',
						'table' => "$this->sigmu_schema.oficina o",
						'where' => "o.id = u.ID_OFICINA"
					)
				),
				'where' => array("fecha between '$fecha_desde' and '$fecha_hasta'"),
				'group_by' => "$tipo_usuario, $tipo_oficina",
				'sort_by' => "oficina, $tipo_usuario"
			));
			if ($this->input->post('btn_grafico'))
			{
				$this->load->library('chartjs');

				$result = array();
				if (!empty($pases))
				{
					foreach ($pases as $row)
					{
						$result['data'][] = (object) array('label' => $row->usuario, 'cantidad' => $row->cantidad);
					}
				}

				$result['series'] = array('cantidad' => $title_pdf);
				$global = new stdClass();
				$global->segmentStrokeWidth = 1;
				$global->responsive = true;
				$global->maintainAspectRatio = false;
				$global->legendTemplate = "<ul class=\"chart-legend clearfix\"><% for (var i=0; i<segments.length; i++){%><li><i class=\"fa fa-circle\" style=\"color:<%=segments[i].fillColor%>\"></i><%if(segments[i].label){%> <%=segments[i].label%><%}%></li><%}%></ul>";
				$global->tooltipTemplate = "<%=label%>: <%=value %> $title_pdf";
				$this->chartjs
					->set_type('doughnut')
					->set_height(180)
					->set_global_options($global)
					->from_result($result)
					->render_to('piechartpases');
				$data['piechartpases'] = $this->chartjs->render();
				$this->chartjs->clear(true);
			}
			else
			{
				$html = $this->load->view('expedientes/estadisticas/pases_oficina_usuario_pdf', array('pases' => $pases), TRUE);
				$this->load->library('pdf');
				$pdf = $this->pdf->load('', 'A4', 0, '', 13, 13, 34, 28, 13, 9, 'P');
				setlocale(LC_TIME, 'es');
				$pdf->SetTitle($title_pdf);
				$pdf->SetHeader('<div style="width:100%;border-top:1px solid #000;border-bottom:1px solid #000;"><div style="float:left;text-alignt:left;width:20%;"><img style="float:left;margin-top:5px;margin-bottom:5px;" height="50" src="img/generales/logo_bn.png"></div><div style="font-style:normal;font-size:13pt;text-align:center;float:left;width:50%;padding-top:15px;">' . $title_pdf . ' por usuario</div><div style="font-weight:normal;font-style:normal;font-size:12pt;padding-top:10px;float:left;width:30%;text-align:lef;">' . strftime('%d de %B de %Y', strtotime($fecha_desde)) . '<br />' . strftime('%d de %B de %Y', strtotime($fecha_hasta_title)) . '</div></div>');
				$pdf->SetFooter('<div style="font-weight:normal;font-style:normal;text-align:center;border-bottom:1px solid #000;padding:10px;">{PAGENO}</div>');
				$pdf->WriteHTML($html);
				$pdf->Output("$title_pdf.pdf", 'I');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($fake_model->fields as $field)
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

		$data['elige_oficina'] = FALSE;
		$data['elige_mostrar'] = TRUE;
		$data['metodo_visual'] = 'Pases por Oficina/Usuario';
		$data['box_title'] = 'Informe de pases emitidos/recibidos por Oficina/Usuario';
		$data['title'] = 'Expedientes - Estadisticas - Pases por Oficina/Usuario';
		$data['js'][] = 'plugins/chartjs/Chart.min.js';
		$this->load_template('expedientes/estadisticas/estadisticas_content', $data);
	}

	public function pases_usuario()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/pases_model');
		$this->array_mostrar_control = $array_mostrar = array('E' => 'Enviados', 'R' => 'Recibidos');
		$fake_model = new stdClass();
		$fake_model->fields = array(
			array('name' => 'oficina_id', 'label' => 'Oficina', 'type' => 'hidden'),
			array('name' => 'oficina', 'label' => 'Oficina', 'required' => TRUE, 'readonly' => 'readonly'),
			array('name' => 'desde', 'label' => 'Fecha desde', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
			array('name' => 'hasta', 'label' => 'Fecha hasta', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
			array('name' => 'mostrar', 'label' => 'Mostrar', 'input_type' => 'combo', 'required' => TRUE)
		);

		$this->set_model_validation_rules($fake_model);
		if ($this->form_validation->run() === TRUE)
		{
			$datetime_desde = DateTime::createFromFormat('d/m/Y', $this->input->post('desde'));
			$fecha_desde = date_format($datetime_desde, 'Y-m-d');
			$datetime_hasta = DateTime::createFromFormat('d/m/Y', $this->input->post('hasta'));
			$fecha_hasta_title = date_format($datetime_hasta, 'Y-m-d');
			$datetime_hasta->add(new DateInterval('P1D'));
			$fecha_hasta = date_format($datetime_hasta, 'Y-m-d');
			if (ctype_digit($this->input->post('oficina_id')))
			{
				$oficina_nombre = $this->input->post('oficina_id') . ' - ' . $this->input->post('oficina');
				$oficina = $this->input->post('oficina_id');
			}
			else
			{
				show_404();
			}
			if ($this->input->post('mostrar') === 'E')
			{
				$tipo_usuario = "pase.usuario_emisor";
				$tipo_oficina = "pase.origen";
				$title_pdf = 'Pases emitidos';
			}
			else
			{
				$tipo_usuario = 'pase.usuario_receptor';
				$tipo_oficina = "pase.destino";
				$title_pdf = 'Pases recibidos';
			}
			$pases = $this->pases_model->get(array(
				'select' => "$tipo_usuario usuario, o.nombre oficina_nombre, o.id oficina_id, count(1) cantidad",
				'join' => array(
					array(
						'type' => 'left',
						'table' => "$this->sigmu_schema.usuario_oficina u",
						'where' => "$tipo_usuario = (u.ID_USUARIO COLLATE latin1_spanish_ci) AND $tipo_oficina = u.ID_OFICINA"
					),
					array(
						'type' => 'left',
						'table' => "$this->sigmu_schema.oficina o",
						'where' => "o.id = u.ID_OFICINA"
					)
				),
				'where' => array("fecha between '$fecha_desde' and '$fecha_hasta' and o.id = $oficina"),
				'group_by' => "$tipo_usuario, $tipo_oficina",
				'sort_by' => "oficina_nombre, $tipo_usuario"
			));
			if ($this->input->post('btn_informe'))
			{
				$html = $this->load->view('expedientes/estadisticas/pases_usuario_pdf', array('pases' => $pases, 'oficina_nombre' => $oficina_nombre), TRUE);
				$this->load->library('pdf');
				$pdf = $this->pdf->load('', 'A4', 0, '', 13, 13, 34, 28, 13, 9, 'P');
				setlocale(LC_TIME, 'es');
				$pdf->SetTitle($title_pdf);
				$pdf->SetHeader('<div style="width:100%;border-top:1px solid #000;border-bottom:1px solid #000;"><div style="float:left;text-alignt:left;width:20%;"><img style="float:left;margin-top:5px;margin-bottom:5px;" height="50" src="img/generales/logo_bn.png"></div><div style="font-style:normal;font-size:13pt;text-align:center;float:left;width:50%;padding-top:15px;">' . $title_pdf . ' por una oficina</div><div style="font-weight:normal;font-style:normal;font-size:12pt;padding-top:10px;float:left;width:30%;text-align:lef;">' . strftime('%d de %B de %Y', strtotime($fecha_desde)) . '<br />' . strftime('%d de %B de %Y', strtotime($fecha_hasta_title)) . '</div></div>');
				$pdf->SetFooter('<div style="font-weight:normal;font-style:normal;text-align:center;border-bottom:1px solid #000;padding:10px;">{PAGENO}</div>');
				$pdf->WriteHTML($html);
				$pdf->Output("$title_pdf.pdf", 'I');
			}
			else
			{
				$this->load->library('chartjs');

				$result = array();
				if (!empty($pases))
				{
					foreach ($pases as $row)
					{
						$result['data'][] = (object) array('label' => $row->usuario, 'cantidad' => $row->cantidad);
					}
				}
				$result['series'] = array('cantidad' => $title_pdf);
				$global = new stdClass();
				$global->tooltips = new stdClass();
				$global->tooltips->callbacks = new stdClass();
				$global->legend = new stdClass();
				$global->maintainAspectRatio = false;
				$global->tooltips->callbacks->label = 'function(tooltipItem, data) {
      var dataset = data.datasets[tooltipItem.datasetIndex];
      var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
        return parseInt(previousValue) + parseInt(currentValue);
      });
      var currentValue = dataset.data[tooltipItem.index];
      var precentage = Math.round(currentValue * 100)/total;
      return data.labels[tooltipItem.index] + ": \n" + currentValue + " (" + precentage.toFixed(1) + "%)";
			}';
				$global->legend->display = false;
				$global->legendCallback = 'function(chart) {
                var text = [];
                text.push(\'<ul style="list-style-type:none;">\');
                for (var i=0; i<chart.data.datasets[0].data.length; i++) {
                    text.push(\'<li>\');
                    text.push(\'<div style="margin-right:2px;padding:0 4px;font-weight: bold;float:left;text-align:right;width:44px;background-color:\' + chart.data.datasets[0].backgroundColor[i] + \'">\' + chart.data.datasets[0].data[i] + \'</div>\');
                    if (chart.data.labels[i]) {
                        text.push(chart.data.labels[i]);
                    }
                    text.push(\'</li>\');
                }
                text.push(\'</ul>\');
                return text.join("");
            }';
				$this->chartjs
					->set_type('pie')
					->set_height(480)
					->set_global_options($global)
					->set_legend_div('chart-legend')
					->from_result($result)
					->render_to('chart');
				$data['chart'] = $this->chartjs->render();
				$this->chartjs->clear(true);
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($fake_model->fields as $field)
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
		$tableData_oficinas = array(
			'columns' => array(
				array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 15, 'class' => 'dt-body-right', 'responsive_class' => 'all', 'query' => 'where'),
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'oficina.nombre', 'width' => 80, 'query' => 'like'),
				array('label' => '', 'data' => 'select_destino', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'oficinas_estadisticas_table',
			'source_url' => 'expedientes/oficinas/listar_data',
			'order' => array(array(1, 'asc')),
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#oficinas_estadisticas_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#oficinas_estadisticas_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_oficinas'] = buildHTML($tableData_oficinas);
		$data['js_table_oficinas'] = buildJS($tableData_oficinas);

		$data['elige_oficina'] = TRUE;
		$data['elige_mostrar'] = TRUE;
		$data['metodo_visual'] = 'Pases por Usuario';
		$data['box_title'] = 'Informe de pases emitidos/recibidos por Usuario';
		$data['grafico_title'] = 'Cantidad de pases';
		$data['title'] = 'Expedientes - Estadisticas - Pases por Usuario';
		$data['js'][] = 'plugins/chartjs/Chart.js';
		$this->load_template('expedientes/estadisticas/estadisticas_content', $data);
	}

	public function pases_pendientes()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fake_model = new stdClass();
		$fake_model->fields = array(
			array('name' => 'desde', 'label' => 'Fecha desde', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
			array('name' => 'hasta', 'label' => 'Fecha hasta', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
		);

		$this->set_model_validation_rules($fake_model);
		if ($this->form_validation->run() === TRUE)
		{
			$this->load->model('expedientes/pases_model');
			$datetime_desde = DateTime::createFromFormat('d/m/Y', $this->input->post('desde'));
			$fecha_desde = date_format($datetime_desde, 'Y-m-d');
			$datetime_hasta = DateTime::createFromFormat('d/m/Y', $this->input->post('hasta'));
			$fecha_hasta_title = date_format($datetime_hasta, 'Y-m-d');
			$datetime_hasta->add(new DateInterval('P1D'));
			$fecha_hasta = date_format($datetime_hasta, 'Y-m-d');
			$pases = $this->pases_model->get(array(
				'select' => "pase.destino, o.nombre oficina, count(1) cantidad",
				'join' => array(
					array(
//					'type' => 'left',
						'table' => "$this->sigmu_schema.oficina o",
						'where' => "pase.destino = o.id"
					)
				),
				'where' => array("pase.respuesta = 'pendiente' and pase.destino <> -1 and pase.fecha_usuario between '$fecha_desde' and '$fecha_hasta'"),
				'group_by' => "pase.destino",
				'sort_by' => "count(1) desc"
			));
			if ($this->input->post('btn_informe'))
			{
				$html = $this->load->view('expedientes/estadisticas/pases_pendientes_pdf', array('pases' => $pases), TRUE);
				$this->load->library('pdf');
				$pdf = $this->pdf->load('', 'A4', 0, '', 13, 13, 34, 28, 13, 9, 'P');
				setlocale(LC_TIME, 'es');
				$pdf->SetTitle('Pases emitidos');
				$pdf->SetHeader('<div style="width:100%;border-top:1px solid #000;border-bottom:1px solid #000;"><div style="float:left;text-alignt:left;width:20%;"><img style="float:left;margin-top:5px;margin-bottom:5px;" height="50" src="img/generales/logo_bn.png"></div><div style="font-style:normal;font-size:13pt;text-align:center;float:left;width:50%;padding-top:15px;">Pases pendientes</div><div style="font-weight:normal;font-style:normal;font-size:12pt;padding-top:10px;float:left;width:30%;text-align:lef;">' . strftime('%d de %B de %Y', strtotime($fecha_desde)) . '<br />' . strftime('%d de %B de %Y', strtotime($fecha_hasta_title)) . '</div></div>');
				$pdf->SetFooter('<div style="font-weight:normal;font-style:normal;text-align:center;border-bottom:1px solid #000;padding:10px;">{PAGENO}</div>');
				$pdf->WriteHTML($html);
				$pdf->Output("Pases pendientes.pdf", 'I');
			}
			else
			{
				$this->load->library('chartjs');
				$result = array();
				if (!empty($pases))
				{
					foreach ($pases as $idx => $row)
					{
						$result['data'][] = (object) array('label' => trim($row->oficina), 'cantidad' => $row->cantidad);
					}
				}
				$result['series'] = array('cantidad' => 'Pases atrasados');
				$global = new stdClass();
				$global->maintainAspectRatio = false;
				$this->chartjs
					->set_type('horizontalBar')
					->set_height(16 * count($pases) + 60)
					->set_global_options($global)
					->from_result($result)
					->render_to('chart');
				$data['chart'] = $this->chartjs->render();
				$this->chartjs->clear(true);
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($fake_model->fields as $field)
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

		$data['elige_oficina'] = FALSE;
		$data['elige_mostrar'] = FALSE;
		$data['metodo_visual'] = 'Pases pendientes';
		$data['box_title'] = 'Informe de pases pendientes de recepción';
		$data['grafico_title'] = 'Pases atrasados por oficina';
		$data['title'] = 'Expedientes - Estadisticas - Pases pendientes';
		$data['js'][] = 'plugins/chartjs/Chart.js';
		$this->load_template('expedientes/estadisticas/estadisticas_content', $data);
	}

	public function expedientes_tipo()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fake_model = new stdClass();
		$fake_model->fields = array(
			array('name' => 'desde', 'label' => 'Fecha desde', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
			array('name' => 'hasta', 'label' => 'Fecha hasta', 'type' => 'date', 'class' => 'datepicker', 'required' => TRUE),
		);

		$this->set_model_validation_rules($fake_model);
		if ($this->form_validation->run() === TRUE)
		{
			$this->load->model('expedientes/tramites_model');
			$datetime_desde = DateTime::createFromFormat('d/m/Y', $this->input->post('desde'));
			$fecha_desde = date_format($datetime_desde, 'Y-m-d');
			$datetime_hasta = DateTime::createFromFormat('d/m/Y', $this->input->post('hasta'));
			$fecha_hasta_title = date_format($datetime_hasta, 'Y-m-d');
			$datetime_hasta->add(new DateInterval('P1D'));
			$fecha_hasta = date_format($datetime_hasta, 'Y-m-d');
			$expedientes = $this->tramites_model->get(array(
				'select' => "tramite.nombre tipo_tramite, count(1) cantidad",
				'join' => array(
					array(
						'type' => 'left',
						'table' => "$this->sigmu_schema.expediente e",
						'where' => "tramite.id = e.tramite_id"
					)
				),
				'where' => array("inicio between '$fecha_desde' and '$fecha_hasta'"),
				'group_by' => 'tramite.nombre',
				'sort_by' => "count(1) desc"
			));
			if ($this->input->post('btn_informe'))
			{
				$html = $this->load->view('expedientes/estadisticas/expedientes_tipo_pdf', array('expedientes' => $expedientes), TRUE);
				$this->load->library('pdf');
				$pdf = $this->pdf->load('', 'A4', 0, '', 13, 13, 34, 28, 13, 9, 'P');
				setlocale(LC_TIME, 'es');
				$pdf->SetTitle('Expedientes iniciados');
				$pdf->SetHeader('<div style="width:100%;border-top:1px solid #000;border-bottom:1px solid #000;"><div style="float:left;text-alignt:left;width:20%;"><img style="float:left;margin-top:5px;margin-bottom:5px;" height="50" src="img/generales/logo_bn.png"></div><div style="font-style:normal;font-size:13pt;text-align:center;float:left;width:50%;padding-top:6px;">Cantidad de expedientes iniciados<br />por tipo de trámite</div><div style="font-weight:normal;font-style:normal;font-size:12pt;padding-top:10px;float:left;width:30%;text-align:lef;">' . strftime('%d de %B de %Y', strtotime($fecha_desde)) . '<br />' . strftime('%d de %B de %Y', strtotime($fecha_hasta_title)) . '</div></div>');
				$pdf->SetFooter('<div style="font-weight:normal;font-style:normal;text-align:center;border-bottom:1px solid #000;padding:10px;">{PAGENO}</div>');
				$pdf->WriteHTML($html);
				$pdf->Output("Expedientes iniciados.pdf", 'I');
			}
			else
			{
				$this->load->library('chartjs');

				$result = array();
				if (!empty($expedientes))
				{
					foreach ($expedientes as $row)
					{
						$result['data'][] = (object) array('label' => $row->tipo_tramite, 'cantidad' => $row->cantidad);
					}
				}
				$result['series'] = array('cantidad' => 'Trámites');
				$global = new stdClass();
				$global->tooltips = new stdClass();
				$global->tooltips->callbacks = new stdClass();
				$global->legend = new stdClass();
				$global->maintainAspectRatio = false;
				$global->tooltips->callbacks->label = 'function(tooltipItem, data) {
      var dataset = data.datasets[tooltipItem.datasetIndex];
      var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
        return parseInt(previousValue) + parseInt(currentValue);
      });
      var currentValue = dataset.data[tooltipItem.index];
      var precentage = Math.round(currentValue * 100)/total;
      return data.labels[tooltipItem.index] + ": \n" + currentValue + " (" + precentage.toFixed(1) + "%)";
			}';
				$global->legend->display = false;
				$global->legendCallback = 'function(chart) {
                var text = [];
                text.push(\'<ul style="list-style-type:none;">\');
                for (var i=0; i<chart.data.datasets[0].data.length; i++) {
                    text.push(\'<li>\');
                    text.push(\'<div style="margin-right:2px;padding:0 4px;font-weight: bold;float:left;text-align:right;width:44px;background-color:\' + chart.data.datasets[0].backgroundColor[i] + \'">\' + chart.data.datasets[0].data[i] + \'</div>\');
                    if (chart.data.labels[i]) {
                        text.push(chart.data.labels[i]);
                    }
                    text.push(\'</li>\');
                }
                text.push(\'</ul>\');
                return text.join("");
            }';
				$this->chartjs
					->set_type('pie')
					->set_height(480)
					->set_global_options($global)
					->set_legend_div('chart-legend')
					->from_result($result)
					->render_to('chart');
				$data['chart'] = $this->chartjs->render();
				$this->chartjs->clear(true);
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($fake_model->fields as $field)
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

		$data['elige_oficina'] = FALSE;
		$data['elige_mostrar'] = FALSE;
		$data['metodo_visual'] = 'Expedientes por tipo';
		$data['box_title'] = 'Cantidad de expedientes iniciados por tipo de trámite';
		$data['grafico_title'] = 'Cantidad de trámites por tipo';
		$data['title'] = 'Expedientes - Estadisticas - Expedientes por tipo';
		$data['js'][] = 'plugins/chartjs/Chart.js';
		$this->load_template('expedientes/estadisticas/estadisticas_content', $data);
	}
}
/* End of file Estadisticas.php */
/* Location: ./application/modules/reclamos/controllers/Estadisticas.php */
