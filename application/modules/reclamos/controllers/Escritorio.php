<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Escritorio extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/reclamos_model');
		$this->load->model('reclamos/asignaciones_distritos_model');
		$this->load->model('reclamos/asignaciones_grupos_model');
		$this->modulo = 'reclamos';
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

	public function index()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$where_distritos = '';
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$where_distritos = '(' . implode(',', $this->usuario_distritos) . ')';
			}

			$where_grupos = '';
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$where_grupos = '(' . implode(',', $this->usuario_grupos) . ')';
			}

			$this->load->library('chartjs');
			$desde = date_format(new DateTime('-1 week'), 'Y-m-d');

			$result = $this->getReclamosData($desde, $where_grupos, $where_distritos);
			$global = new stdClass();
			$global->maintainAspectRatio = true;
			$global->responsive = true;
			$global->datasetFill = false;
			$global->tooltipTemplate = "<%=label %>: <%=value %> reclamos";
			$this->chartjs
					->set_type('line')
					->set_colors(array('rgba(219, 151, 0, 1)'))
					->set_global_options($global)
					->from_result($result)
					->set_height(200)
					->render_to('linechart');
			$data['linechart'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$result2 = $this->getReclamosSectoresData($desde, $where_grupos, $where_distritos);
			$global2 = new stdClass();
			$global2->segmentStrokeWidth = 1;
			$global2->responsive = true;
			$global2->maintainAspectRatio = false;
			$global2->legendTemplate = "<ul class=\"chart-legend clearfix\"><% for (var i=0; i<segments.length; i++){%><li><i class=\"fa fa-circle\" style=\"color:<%=segments[i].fillColor%>\"></i><%if(segments[i].label){%> <%=segments[i].label%><%}%></li><%}%></ul>";
			$global2->tooltipTemplate = "<%=label%>: <%=value %> reclamos";
			$this->chartjs
					->set_type('doughnut')
					->set_global_options($global2)
					->from_result($result2)
					->set_height(180)
					->render_to('piechart');
			$data['piechart'] = $this->chartjs->render();
			$this->chartjs->clear(true);

			$data['reclamos_estado'] = $this->getReclamosEstadoData($desde, $where_grupos, $where_distritos);

			$data['css'][] = 'css/reclamos/reclamos-varios.css';
			$data['js'][] = 'plugins/chartjs/Chart.min.js';
			$data['js'][] = 'plugins/knob/jquery.knob.js';
			$data['js'][] = 'https://maps.googleapis.com/maps/api/js';
			$data['js'][] = 'js/reclamos/map-escritorio.js';
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Escritorio';
			$data['accesos'] = load_permisos_escritorio_reclamos($this->grupos);
			$this->load_template('reclamos/template/reclamos_content', $data);
		}
		else
		{
			show_404();
		}
	}

	private function getReclamosData($desde, $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$hasta = date_format(new DateTime(), 'Y-m-d');
			$reclamos_options = array(
				'select' => array(
					'DATE_FORMAT(fecha_inicio, "%Y-%m-%d") AS fecha',
					'COUNT(1) AS cantidad'
				),
				'where' => array(
					array('column' => 'fecha_inicio >=', 'value' => $desde)
				),
				'group_by' => 'fecha_inicio'
			);
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
			while ($fecha <= $hasta)
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

			$return['series'] = array('cantidad' => 'cantidad');
			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getReclamosSectoresData($desde, $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$reclamos_options = array(
				'select' => array(
					'rc_sectores.descripcion AS sector',
					'COUNT(rc_incidentes.id) AS cantidad'
				),
				'join' => array(
					array(
						'type' => 'right',
						'table' => 'rc_sectores',
						'where' => "rc_sectores.id = rc_incidentes.sector_id AND fecha_inicio >='$desde'")
				),
				'where' => array(),
				'group_by' => 'rc_sectores.id, sector_id, rc_sectores.descripcion'
			);
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

			$return['series'] = array('cantidad' => 'cantidad');
			return $return;
		}
		else
		{
			show_404();
		}
	}

	private function getReclamosEstadoData($desde, $where_grupos = '', $where_distritos = '')
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$reclamos_options = array(
				'select' => array(
					'estado',
					'COUNT(1) AS cantidad'
				),
				'where' => array(
					array('column' => 'fecha_inicio >=', 'value' => $desde)
				),
				'group_by' => 'estado'
			);
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

	public function getMapData()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$where_distritos = '';
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$distritos_usuario = $this->asignaciones_distritos_model->get(array('user_id' => $this->session->userdata('user_id')));
				if (empty($distritos_usuario))
				{
					show_404();
				}
				else
				{
					$where_distritos .= '(';
					foreach ($distritos_usuario as $Distrito)
					{
						$where_distritos .= $Distrito->distrito_id . ',';
					}
					$where_distritos = rtrim($where_distritos, ',');
					$where_distritos .= ')';
				}
			}

			$where_grupos = '';
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$grupos_usuario = $this->asignaciones_grupos_model->get(array('user_id' => $this->session->userdata('user_id')));
				if (empty($grupos_usuario))
				{
					show_404();
				}
				else
				{
					$where_grupos .= '(';
					foreach ($grupos_usuario as $Grupo)
					{
						$where_grupos .= $Grupo->grupo_id . ',';
					}
					$where_grupos = rtrim($where_grupos, ',');
					$where_grupos .= ')';
				}
			}

			$reclamos_options = array(
				'join' => array(
					array('table' => 'distritos',
						'where' => 'distritos.id = rc_incidentes.distrito_id',
						'columnas' => array('distritos.nombre as distrito')),
					array('table' => 'rc_sectores',
						'where' => 'rc_sectores.id = rc_incidentes.sector_id',
						'columnas' => array('rc_sectores.descripcion as sector', 'rc_sectores.icono as icono')),
					array('table' => 'rc_motivos_reclamos',
						'where' => 'rc_motivos_reclamos.id = rc_incidentes.motivo_id',
						'columnas' => array('rc_motivos_reclamos.descripcion as motivo'))
				),
				'where' => array(
					array('column' => 'rc_incidentes.estado >=', 'value' => 'Anulado'),
					array('column' => 'rc_incidentes.fecha_inicio >=', 'value' => date_format(new DateTime('-1 week'), 'Y-m-d')),
					"rc_incidentes.lat_mapa IS NOT NULL AND rc_incidentes.long_mapa IS NOT NULL AND rc_incidentes.lat_mapa != '' AND rc_incidentes.long_mapa != ''",
				)
			);
			if (!empty($where_grupos))
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.grupo_id IN ', 'value' => $where_grupos, 'override' => TRUE);
			}
			if (!empty($where_distritos))
			{
				$reclamos_options['where'][] = array('column' => 'rc_incidentes.distrito_id IN ', 'value' => $where_distritos, 'override' => TRUE);
			}
			$reclamos = $this->reclamos_model->get($reclamos_options);
			if (!empty($reclamos))
			{
				foreach ($reclamos as $Reclamo)
				{
					$marker = $Reclamo->icono;
					switch ($Reclamo->estado)
					{
						case 'Pendiente':
							$marker.='_3';
							break;
						case 'En Proceso':
							$marker.='_2';
							break;
					}
					$figuras_mapa[] = array(
						'marker' => $marker,
						'puntos' => array((object) array('lat' => $Reclamo->lat_mapa, 'lng' => $Reclamo->long_mapa)),
						'tooltip' => '<div id="content" class="map-infowindow" style="width: 230px;">' .
						'<div id="siteNotice"></div>' .
						'<div id="firstHeading">' .
						'<span class="titulo-infowindow">Reclamo N° ' . $Reclamo->id . '</span> ' .
						'<a href="reclamos/reclamos/ver/' . $Reclamo->id . '" title="Ver Reclamo" target="_blank"><i class="fa fa-search"></i></a>' .
						'</div><hr>' .
						'<div id="bodyContent" style="overflow: auto;">' .
						'<div style="overflow:auto; max-height:180px;">' .
						'<p><b>Sector: </b>' . $Reclamo->sector . '</p>' .
						'<p><b>Motivo: </b>' . $Reclamo->motivo . '</p>' .
						'<p><b>Tarea: </b>' . $Reclamo->tarea . '</p>' .
						'<p><b>Distrito: </b>' . $Reclamo->distrito . '</p>' .
						'<p><b>Inicio: </b>' . date_format(new DateTime($Reclamo->fecha_inicio), 'd-m-Y') . '</p>' .
						'<p><b>Estado: </b>' . $Reclamo->estado . '</p>' .
						'</div>' .
						'</div></div>'
					);
				}
			}
			echo (!empty($figuras_mapa) ? json_encode($figuras_mapa) : NULL);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Escritorio.php */
/* Location: ./application/modules/reclamos/controllers/Escritorio.php */