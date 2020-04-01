<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Graficos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('chartjs');
		$this->load->model('reclamos/reclamos_model');
		$this->load->model('reclamos/encuestas_respuestas_model');
		$this->load->model('reclamos/sectores_model');
		$this->load->model('reclamos/grupos_model');
		$this->load->model('distritos_model');
		$this->load->model('reclamos/asignaciones_distritos_model');
		$this->load->model('reclamos/asignaciones_grupos_model');
		$this->grupos = groups_names($this->ion_auth->get_users_groups()->result_array());
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_coordinador', 'reclamos_usuario', 'reclamos_distrito', 'reclamos_consulta_general');
		$this->grupos_usuario = array('reclamos_usuario');
		$this->grupos_distrito = array('reclamos_distrito');
		if (in_groups($this->grupos_distrito, $this->grupos))
		{
			$this->usuario_distritos = $this->get_array('asignaciones_distritos', 'distrito_id', 'distrito_id', array('user_id' => $this->session->userdata('user_id')));
			if (empty($this->usuario_distritos))
			{
				$this->session->set_flashdata('error', 'Usuario sin asignación de distrito en módulo de reclamos. Contacte al administrador.');
				redirect("escritorio", 'refresh');
			}
		}
		$this->usuario_grupos = $this->get_array('asignaciones_grupos', 'grupo_id', 'grupo_id', array('user_id' => $this->session->userdata('user_id')));
		if (empty($this->usuario_grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin asignación de grupo en módulo de reclamos. Contacte al administrador.');
			redirect("escritorio", 'refresh');
		}
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$options_distritos = array();
			$where_distritos = '';
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$where_distritos = '(' . implode(',', $this->usuario_distritos) . ')';
				$options_distritos = array('where' => array('id IN ' . $where_distritos));
			}

			$options_grupos = array();
			$where_grupos = '';
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$where_grupos = '(' . implode(',', $this->usuario_grupos) . ')';
				$options_grupos = array('where' => array('id IN ' . $where_grupos));
			}

			$desde = new DateTime('- 1 week');
			$hasta = new DateTime();
			$data['desde'] = date_format($desde, 'd/m/Y');
			$data['hasta'] = date_format($hasta, 'd/m/Y');
			$hasta->add(new DateInterval('P1D'));
			$desde_sql = date_format($desde, 'Y-m-d');
			$hasta_sql = date_format($hasta, 'Y-m-d');

			$data['inicio_reclamos'] = array(
				'name' => 'inicio_reclamos',
				'id' => 'inicio_reclamos',
				'class' => 'form-control pull-right daterange',
				'type' => 'text'
			);
			$data['sector_opt'] = $this->get_array('sectores', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$data['sector_opt_selected'] = 'Todos';
			$data['grupo_opt'] = $this->get_array('grupos', 'nombre', 'id', $options_grupos, array('Todos' => 'Todos'));
			$data['grupo_opt_selected'] = 'Todos';
			$data['distrito_opt'] = $this->get_array('distritos', 'nombre', 'id', $options_distritos, array('Todos' => 'Todos'));
			$data['distrito_opt_selected'] = 'Todos';

			$result = $this->getReclamosData($desde_sql, $hasta_sql, 'Todos', 'Todos', 'Todos', $where_grupos, $where_distritos);
			$global = new stdClass();
			$global->maintainAspectRatio = false;
			$global->lineTension = 0;
			$tmp = new stdClass();
			$tmp->ticks = new stdClass();
			$tmp->ticks->min = 0;
			$tmp->ticks->stepSize = 1;
			$array_ticks = array();
			$array_ticks[] = $tmp;
			$global->scales = new stdClass();
			$global->scales->yAxes = new stdClass();
			$global->scales->yAxes = $array_ticks;
			$this->chartjs
				->set_type('line')
				->set_height(360)
				->set_global_options($global)
				->from_result($result)
				->render_to('linechartreclamos');
			$data['linechartreclamos'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$result = $this->getReclamosSectoresData($desde_sql, $hasta_sql, 'Todos', 'Todos', 'Todos', $where_grupos, $where_distritos);
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
				->set_type('doughnut')
				->set_height(180)
				->set_global_options($global)
				->set_legend_div('piechartsectores-legend')
				->from_result($result)
				->render_to('piechartsectores');
			$data['piechartsectores'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$data['reclamos_estado'] = $this->getReclamosEstadoData($desde_sql, $hasta_sql, 'Todos', 'Todos', 'Todos', $where_grupos, $where_distritos);

			$result = $this->getVencimientosData($desde_sql, $hasta_sql, 'Todos', 'Todos', 'Todos', $where_grupos, $where_distritos);
			$global = new stdClass();
			$global->maintainAspectRatio = false;
			$tmp = new stdClass();
			$tmp->ticks = new stdClass();
			$tmp->ticks->min = 0;
			$tmp->ticks->stepSize = 1;
			$array_ticks = array();
			$array_ticks[] = $tmp;
			$global->scales = new stdClass();
			$global->scales->yAxes = new stdClass();
			$global->scales->yAxes = $array_ticks;
			$this->chartjs
				->set_type('bar')
				->set_colors(array('rgba(221, 75, 57, 1)', 'rgba(0, 166, 90, 1)'))
				->set_height(360)
				->set_global_options($global)
				->from_result($result)
				->render_to('barchartvencimiento');
			$data['barchartvencimiento'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$result = $this->getEncuestasData($desde_sql, $hasta_sql, 'Todos', 'Todos', 'Todos', $where_grupos, $where_distritos);
			$global = new stdClass();
			$global->maintainAspectRatio = false;
			$tmp = new stdClass();
			$tmp->ticks = new stdClass();
			$tmp->ticks->min = 0;
			$tmp->ticks->max = 10;
			$tmp->ticks->stepSize = 1;
			$array_ticks = array();
			$array_ticks[] = $tmp;
			$global->scales = new stdClass();
			$global->scales->yAxes = new stdClass();
			$global->scales->yAxes = $array_ticks;
			$this->chartjs
				->set_type('bar')
				->set_height(360)
				->set_global_options($global)
				->from_result($result)
				->render_to('barchartsatisfaccion');
			$data['barchartsatisfaccion'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$result = $this->getSectoresDetalleData($desde_sql, $hasta_sql, 'Todos', 'Todos', 'Todos', $where_grupos, $where_distritos);
			$global = new stdClass();
			$global->maintainAspectRatio = false;
			$tmp = new stdClass();
			$tmp->ticks = new stdClass();
			$tmp->ticks->min = 0;
			$tmp->ticks->stepSize = 1;
			$array_ticks = array();
			$array_ticks[] = $tmp;
			$global->scales = new stdClass();
			$global->scales->yAxes = new stdClass();
			$global->scales->yAxes = $array_ticks;
			$this->chartjs
				->set_type('bar')
				->set_colors(array('rgba(221, 75, 57, 1)', 'rgba(243, 156, 18, 1)', 'rgba(0, 166, 90, 1)', 'rgba(150, 150, 150, 1)'))
				->set_height(480)
				->set_global_options($global)
				->from_result($result)
				->render_to('barchartsectores');
			$data['barchartsectores'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
			$data['css'][] = 'css/reclamos/reclamos-varios.css';
			$data['js'][] = 'js/reclamos/reclamos-varios.js';
			$data['js'][] = 'plugins/chartjs/Chart.min.js';
			$data['js'][] = 'plugins/knob/jquery.knob.js';
			$data['title'] = 'Reclamos - Gráficos';
			$this->load_template('reclamos/graficos/graficos_content', $data);
		}
		else
		{
			show_404();
		}
	}

	public function getData()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$options_distritos = array();
			$where_distritos = '';
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$where_distritos = '(' . implode(',', $this->usuario_distritos) . ')';
				$options_distritos = array('where' => array('id IN ' . $where_distritos));
			}

			$options_grupos = array();
			$where_grupos = '';
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$where_grupos = '(' . implode(',', $this->usuario_grupos) . ')';
				$options_grupos = array('where' => array('id IN ' . $where_grupos));
			}

			$this->array_sector_control = $this->get_array('sectores', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$this->array_grupo_control = $this->get_array('grupos', 'nombre', 'id', $options_grupos, array('Todos' => 'Todos'));
			$this->array_distrito_control = $this->get_array('distritos', 'nombre', 'id', $options_distritos, array('Todos' => 'Todos'));

			$this->form_validation->set_rules('fecha_desde', 'Fecha Desde', 'validate_date');
			$this->form_validation->set_rules('fecha_hasta', 'Fecha Hasta', 'validate_date');
			$this->form_validation->set_rules('sector', 'Sector', 'callback_control_combo[sector]');
			$this->form_validation->set_rules('grupo', 'Grupo', 'callback_control_combo[grupo]');
			$this->form_validation->set_rules('distrito', 'Distrito', 'callback_control_combo[distrito]');
			if ($this->form_validation->run() === TRUE)
			{
				$fecha_desde = $this->input->post('fecha_desde');
				if (!empty($fecha_desde) && $fecha_desde != -1) // NO cambiar por !==
				{
					$datetime_desde = DateTime::createFromFormat('d/m/Y', $fecha_desde);
					$desde_sql = date_format($datetime_desde, 'Y-m-d');
				}

				$fecha_hasta = $this->input->post('fecha_hasta');
				if (!empty($fecha_hasta) && $fecha_hasta != -1) // NO cambiar por !==
				{
					$datetime_hasta = DateTime::createFromFormat('d/m/Y', $fecha_hasta);
					$datetime_hasta->add(new DateInterval('P1D'));
					$hasta_sql = date_format($datetime_hasta, 'Y-m-d');
				}
				$sector = $this->input->post('sector');
				$grupo = $this->input->post('grupo');
				$distrito = $this->input->post('distrito');

				$result = $this->getReclamosData($desde_sql, $hasta_sql, $sector, $grupo, $distrito, $where_grupos, $where_distritos);
				$this->chartjs
					->set_type('line')
					->set_colors(array('rgba(219, 151, 0, 1)'))
					->from_result($result);
				$return[0] = $this->chartjs->get_data();
				$this->chartjs->clear(true);

				$result = $this->getReclamosSectoresData($desde_sql, $hasta_sql, $sector, $grupo, $distrito, $where_grupos, $where_distritos);
				$this->chartjs
					->set_type('doughnut')
					->from_result($result);
				$return[1] = $this->chartjs->get_data();
				$this->chartjs->clear(true);

				$return[2] = $this->getReclamosEstadoData($desde_sql, $hasta_sql, $sector, $grupo, $distrito, $where_grupos, $where_distritos);

				$result = $this->getVencimientosData($desde_sql, $hasta_sql, $sector, $grupo, $distrito, $where_grupos, $where_distritos);
				$this->chartjs
					->set_type('bar')
					->set_colors(array('rgba(221, 75, 57, 1)', 'rgba(0, 166, 90, 1)'))
					->from_result($result);
				$return[3] = $this->chartjs->get_data();
				$this->chartjs->clear(true);

				$result = $this->getEncuestasData($desde_sql, $hasta_sql, $sector, $grupo, $distrito, $where_grupos, $where_distritos);
				$this->chartjs
					->set_type('bar')
					->set_colors(array('rgba(219, 151, 0, 1)'))
					->from_result($result);
				$return[4] = $this->chartjs->get_data();
				$this->chartjs->clear(true);

				$result = $this->getSectoresDetalleData($desde_sql, $hasta_sql, $sector, $grupo, $distrito, $where_grupos, $where_distritos);
				$this->chartjs
					->set_type('bar')
					->set_colors(array('rgba(221, 75, 57, 1)', 'rgba(243, 156, 18, 1)', 'rgba(0, 166, 90, 1)', 'rgba(150, 150, 150, 1)'))
					->from_result($result);
				$return[5] = $this->chartjs->get_data();
				$this->chartjs->clear(true);

				echo (!empty($return) ? json_encode($return) : NULL);
			}
			else
			{
				echo validation_errors();
			}
		}
		else
		{
			show_404();
		}
	}

	private function getReclamosData($desde, $hasta, $sector = 'Todos', $grupo = 'Todos', $distrito = 'Todos', $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$reclamos_options = array(
				'select' => array(
					'DATE_FORMAT(fecha_inicio, "%Y-%m-%d") AS fecha',
					'COUNT(1) AS cantidad'
				),
				'where' => array(
					array('column' => 'fecha_inicio >=', 'value' => $desde),
					array('column' => 'fecha_inicio <', 'value' => $hasta)
				),
				'group_by' => 'fecha_inicio'
			);
			if ($sector !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.sector_id', 'value' => $sector);
			}
			if ($grupo !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.grupo_id', 'value' => $grupo);
			}
			if ($distrito !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.distrito_id', 'value' => $distrito);
			}
			if (!empty($where_grupos))
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.grupo_id IN ', 'value' => $where_grupos, 'override' => TRUE);
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.distrito_id IN ', 'value' => $where_distritos, 'override' => TRUE);
			}
			$data_sql = $this->reclamos_model->get($reclamos_options);

			$reclamos = array();
			if (!empty($data_sql))
			{
				foreach ($data_sql as $row)
				{
					$reclamos[$row->fecha] = $row->cantidad;
				}
			}

			$fecha = $desde;
			$return = array();
			while ($fecha < $hasta)
			{
				if (isset($reclamos[$fecha]))
				{
					$return['data'][] = (object) array('label' => date('d-m', strtotime($fecha)), 'cantidad' => $reclamos[$fecha]);
				}
				else
				{
					$return['data'][] = (object) array('label' => date('d-m', strtotime($fecha)), 'cantidad' => 0);
				}
				$fecha = date('Y-m-d', strtotime($fecha . ' + 1 days'));
			}

			$return['series'] = array('cantidad' => 'Reclamos');
			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getReclamosSectoresData($desde, $hasta, $sector = 'Todos', $grupo = 'Todos', $distrito = 'Todos', $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			if ($sector !== 'Todos')
			{
				$reclamos_options = array(
					'select' => array(
						'rc_motivos_reclamos.descripcion AS sector',
						'COUNT(1) AS cantidad'
					),
					'join' => array(
						array(
							'type' => 'right',
							'table' => 'rc_motivos_reclamos',
							'where' => "rc_motivos_reclamos.id = rc_incidentes.motivo_id AND fecha_inicio >='$desde' AND fecha_inicio <'$hasta'")
					),
					'where' => array("rc_incidentes.sector_id = $sector OR rc_motivos_reclamos.sector_id=$sector"),
					'group_by' => 'rc_motivos_reclamos.id, motivo_id, rc_motivos_reclamos.descripcion',
					'sort_by' => 'cantidad desc'
				);
			}
			else
			{

				$reclamos_options = array(
					'select' => array(
						'rc_sectores.descripcion AS sector',
						"SUM(CASE estado WHEN 'Pendiente' THEN 1 ELSE 0 END) AS pendiente",
						"SUM(CASE estado WHEN 'En Proceso' THEN 1 ELSE 0 END) AS en_proceso",
						"SUM(CASE estado WHEN 'Finalizado' THEN 1 ELSE 0 END) AS solucionado",
						"SUM(CASE estado WHEN 'Anulado' THEN 1 ELSE 0 END) AS anulado",
						'COUNT(rc_incidentes.id) AS cantidad'
					),
					'join' => array(
						array(
							'type' => 'right',
							'table' => 'rc_sectores',
							'where' => "rc_sectores.id = rc_incidentes.sector_id AND fecha_inicio >='$desde' AND fecha_inicio <'$hasta'")
					),
					'group_by' => 'rc_sectores.id, sector_id, rc_sectores.descripcion',
					'sort_by' => 'cantidad desc'
				);
			}
			if ($grupo !== 'Todos')
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.grupo_id = $grupo";
			}
			if ($distrito !== 'Todos')
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.distrito_id = $distrito";
			}
			if (!empty($where_grupos))
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.grupo_id IN $where_grupos";
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.distrito_id IN $where_distritos";
			}
			$data_sql = $this->reclamos_model->get($reclamos_options);

			$return = array();
			if (!empty($data_sql))
			{
				foreach ($data_sql as $row)
				{
					$return['data'][] = (object) array('label' => $row->sector, 'cantidad' => $row->cantidad);
				}
			}

			$return['series'] = array('cantidad' => 'Reclamos');
			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getReclamosEstadoData($desde, $hasta, $sector = 'Todos', $grupo = 'Todos', $distrito = 'Todos', $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$reclamos_options = array(
				'select' => array(
					'estado',
					'COUNT(1) AS cantidad'
				),
				'where' => array(
					array('column' => 'fecha_inicio >=', 'value' => $desde),
					array('column' => 'fecha_inicio <', 'value' => $hasta)
				),
				'group_by' => 'estado'
			);
			if ($sector !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.sector_id', 'value' => $sector);
			}
			if ($grupo !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.grupo_id', 'value' => $grupo);
			}
			if ($distrito !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.distrito_id', 'value' => $distrito);
			}
			if (!empty($where_grupos))
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.grupo_id IN ', 'value' => $where_grupos, 'override' => TRUE);
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.distrito_id IN ', 'value' => $where_distritos, 'override' => TRUE);
			}
			$data_sql = $this->reclamos_model->get($reclamos_options);

			$return = array();
			$total = 0;
			if (!empty($data_sql))
			{
				foreach ($data_sql as $row)
				{
					$total += $row->cantidad;
				}
				foreach ($data_sql as $row)
				{
					$return[$row->estado] = number_format($row->cantidad / $total * 100, 2);
				}
			}

			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getVencimientosData($desde, $hasta, $sector = 'Todos', $grupo = 'Todos', $distrito = 'Todos', $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			if ($sector !== 'Todos')
			{
				$reclamos_options = array(
					'select' => array(
						'rc_motivos_reclamos.descripcion AS label',
						"SUM(CASE WHEN estado='Finalizado' AND vencimiento<fecha_finalizacion THEN 1 ELSE 0 END) AS vencido",
						"SUM(CASE WHEN estado='Finalizado' AND vencimiento>=fecha_finalizacion THEN 1 ELSE 0 END) AS no_vencido",
					),
					'join' => array(
						array(
							'type' => 'right',
							'table' => 'rc_motivos_reclamos',
							'where' => "rc_motivos_reclamos.id = rc_incidentes.motivo_id AND fecha_inicio >='$desde' AND fecha_inicio <'$hasta'")
					),
					'where' => array("rc_incidentes.sector_id = $sector OR rc_motivos_reclamos.sector_id=$sector"),
					'group_by' => 'rc_motivos_reclamos.id, motivo_id, rc_motivos_reclamos.descripcion'
				);
			}
			else
			{
				$reclamos_options = array(
					'select' => array(
						'rc_sectores.descripcion AS label',
						"SUM(CASE WHEN estado='Finalizado' AND vencimiento<fecha_finalizacion THEN 1 ELSE 0 END) AS vencido",
						"SUM(CASE WHEN estado='Finalizado' AND vencimiento>=fecha_finalizacion THEN 1 ELSE 0 END) AS no_vencido",
					),
					'join' => array(
						array(
							'type' => 'right',
							'table' => 'rc_sectores',
							'where' => "rc_sectores.id = rc_incidentes.sector_id AND fecha_inicio >='$desde' AND fecha_inicio <'$hasta'")
					),
					'group_by' => 'rc_sectores.id, sector_id, rc_sectores.descripcion'
				);
			}
			if ($grupo !== 'Todos')
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.grupo_id = $grupo";
			}
			if ($distrito !== 'Todos')
			{
				$reclamos_options['join'][0]['where'].=" AND rc_incidentes.distrito_id = $distrito";
			}
			if (!empty($where_grupos))
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.grupo_id IN $where_grupos";
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.distrito_id IN $where_distritos";
			}
			$return['data'] = $this->reclamos_model->get($reclamos_options);
			$return['series'] = array('vencido' => 'Vencidos', 'no_vencido' => 'A tiempo');

			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getEncuestasData($desde, $hasta, $sector = 'Todos', $grupo = 'Todos', $distrito = 'Todos', $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$reclamos_options = array(
				'select' => array(
					'descripcion_corta AS label',
					'ROUND(AVG(puntaje),2) AS puntaje'
				),
				'join' => array(
					array(
						'table' => 'rc_encuestas_preguntas P',
						'columnas' => array(),
						'where' => 'pregunta_id = P.id'),
					array(
						'table' => 'rc_encuestas S',
						'columnas' => array(),
						'where' => 'encuesta_id = S.id'),
					array(
						'table' => 'rc_incidentes I',
						'columnas' => array(),
						'where' => 'S.incidente_id = I.id')
				),
				'where' => array(
					array('column' => 'I.fecha_inicio >=', 'value' => $desde),
					array('column' => 'I.fecha_inicio <', 'value' => $hasta)
				),
				'group_by' => 'pregunta_id, pregunta',
				'sort_by' => 'pregunta_id'
			);
			if ($sector !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'I.sector_id', 'value' => $sector);
			}
			if ($grupo !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'I.grupo_id', 'value' => $grupo);
			}
			if ($distrito !== 'Todos')
			{
				$reclamos_options['where'][] = array('column' => 'I.distrito_id', 'value' => $distrito);
			}
			if (!empty($where_grupos))
			{
				$reclamos_options['where'][] = array('column' => 'I.grupo_id IN ', 'value' => $where_grupos, 'override' => TRUE);
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['where'][] = array('column' => 'I.distrito_id IN ', 'value' => $where_distritos, 'override' => TRUE);
			}
			$return['data'] = $this->encuestas_respuestas_model->get($reclamos_options);
			$return['series'] = array('puntaje' => 'Puntos');

			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getSectoresDetalleData($desde, $hasta, $sector = 'Todos', $grupo = 'Todos', $distrito = 'Todos', $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			if ($sector !== 'Todos')
			{
				$reclamos_options = array(
					'select' => array(
						'rc_motivos_reclamos.descripcion AS label',
						"SUM(CASE estado WHEN 'Pendiente' THEN 1 ELSE 0 END) AS pendiente",
						"SUM(CASE estado WHEN 'En Proceso' THEN 1 ELSE 0 END) AS en_proceso",
						"SUM(CASE estado WHEN 'Finalizado' THEN 1 ELSE 0 END) AS solucionado",
						"SUM(CASE estado WHEN 'Anulado' THEN 1 ELSE 0 END) AS anulado",
						'COUNT(1) AS cantidad'
					),
					'join' => array(
						array(
							'type' => 'right',
							'table' => 'rc_motivos_reclamos',
							'where' => "rc_motivos_reclamos.id = rc_incidentes.motivo_id AND fecha_inicio >='$desde' AND fecha_inicio <'$hasta'")
					),
					'where' => array("rc_incidentes.sector_id = $sector OR rc_motivos_reclamos.sector_id=$sector"),
					'group_by' => 'rc_motivos_reclamos.id, motivo_id, rc_motivos_reclamos.descripcion'
				);
			}
			else
			{

				$reclamos_options = array(
					'select' => array(
						'rc_sectores.descripcion AS label',
						"SUM(CASE estado WHEN 'Pendiente' THEN 1 ELSE 0 END) AS pendiente",
						"SUM(CASE estado WHEN 'En Proceso' THEN 1 ELSE 0 END) AS en_proceso",
						"SUM(CASE estado WHEN 'Finalizado' THEN 1 ELSE 0 END) AS solucionado",
						"SUM(CASE estado WHEN 'Anulado' THEN 1 ELSE 0 END) AS anulado",
						'COUNT(rc_incidentes.id) AS cantidad'
					),
					'join' => array(
						array(
							'type' => 'right',
							'table' => 'rc_sectores',
							'where' => "rc_sectores.id = rc_incidentes.sector_id AND fecha_inicio >='$desde' AND fecha_inicio <'$hasta'")
					),
					'group_by' => 'rc_sectores.id, sector_id, rc_sectores.descripcion'
				);
			}
			if ($grupo !== 'Todos')
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.grupo_id = $grupo";
			}
			if ($distrito !== 'Todos')
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.distrito_id = $distrito";
			}
			if (!empty($where_grupos))
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.grupo_id IN $where_grupos";
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['join'][0]['where'] .= " AND rc_incidentes.distrito_id IN $where_distritos";
			}
			$return['data'] = $this->reclamos_model->get($reclamos_options);
			$return['series'] = array('pendiente' => 'Pendientes', 'en_proceso' => 'En proceso', 'solucionado' => 'Solucionados', 'anulado' => 'Anulados');

			return $return;
		}
		else
			show_404();
	}
}
/* End of file Graficos.php */
/* Location: ./application/modules/reclamos/controllers/Graficos.php */
