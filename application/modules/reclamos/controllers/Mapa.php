<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mapa extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/reclamos_model');
		$this->load->model('reclamos/sectores_model');
		$this->load->model('reclamos/motivos_reclamos_model');
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

	public function index()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$options_distritos = array();
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$options_distritos = array('where' => array('id IN (' . implode(',', $this->usuario_distritos) . ')'));
			}

			$options_grupos = array();
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$options_grupos = array('where' => array('id IN (' . implode(',', $this->usuario_grupos) . ')'));
			}

			$data['tipo_mapa_opt'] = array('puntos' => 'Puntos', 'calor' => 'Calor');
			$data['tipo_mapa_opt_selected'] = 'puntos';

			$desde = new DateTime('- 1 week');
			$hasta = new DateTime();
			$data['desde'] = date_format($desde, 'd/m/Y');
			$data['hasta'] = date_format($hasta, 'd/m/Y');

			$data['inicio_reclamos'] = array(
				'name' => 'inicio_reclamos',
				'id' => 'inicio_reclamos',
				'class' => 'form-control pull-right daterange',
				'type' => 'text'
			);

			$data['sector_opt'] = $this->get_array('sectores', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$data['sector_opt_selected'] = 'Todos';

			$data['motivo_opt'] = $this->get_array('motivos_reclamos', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$data['motivo_opt_selected'] = 'Todos';

			$data['estado_opt'] = array('Todos' => 'Todos', 'Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'No Finalizado' => 'No Finalizado');
			$data['estado_opt_selected'] = 'Todos';

			$data['grupo_opt'] = $this->get_array('grupos', 'nombre', 'id', $options_grupos, array('Todos' => 'Todos'));
			$data['grupo_opt_selected'] = 'Todos';

			$data['distrito_opt'] = $this->get_array('distritos', 'nombre', 'id', $options_distritos, array('Todos' => 'Todos'));
			$data['distrito_opt_selected'] = 'Todos';

			$data['figuras'] = array(
				'name' => 'figuras',
				'id' => 'figuras',
				'type' => 'hidden',
				'value' => ''
			);

			$data['js'][] = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAUWE6x_ZRqLgOTpqSZxPUzRzZkRaBv17U&callback=initMap';
			$data['js'][] = 'js/reclamos/reclamos-varios.js';
			$data['js'][] = 'plugins/heatmap/heatmap.min.js';
			$data['js'][] = 'plugins/heatmap/gmaps-heatmap.js';
			$data['js'][] = 'js/reclamos/map-general.js';
			$data['title'] = 'Reclamos - Mapa de reclamos';
			$this->load_template('reclamos/mapa/mapa_content', $data);
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
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$options_distritos = array('where' => array('id IN (' . implode(',', $this->usuario_distritos) . ')'));
			}

			$options_grupos = array();
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$options_grupos = array('where' => array('id IN (' . implode(',', $this->usuario_grupos) . ')'));
			}

			$this->array_sector_control = $this->get_array('sectores', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$this->array_motivo_control = $this->get_array('motivos_reclamos', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$this->array_estado_control = array('Todos' => 'Todos', 'Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'No Finalizado' => 'No Finalizado');
			$this->array_grupo_control = $this->get_array('grupos', 'nombre', 'id', $options_grupos, array('Todos' => 'Todos'));
			$this->array_distrito_control = $this->get_array('distritos', 'nombre', 'id', $options_distritos, array('Todos' => 'Todos'));

			$this->form_validation->set_rules('fecha_desde', 'Fecha Desde', 'validate_date');
			$this->form_validation->set_rules('fecha_hasta', 'Fecha Hasta', 'validate_date');
			$this->form_validation->set_rules('sector', 'Sector', 'callback_control_combo[sector]');
			$this->form_validation->set_rules('motivo', 'Motivo', 'callback_control_combo[motivo]');
			$this->form_validation->set_rules('estado', 'Estado', 'callback_control_combo[estado]');
			$this->form_validation->set_rules('grupo', 'Grupo', 'callback_control_combo[grupo]');
			$this->form_validation->set_rules('distrito', 'Distrito', 'callback_control_combo[distrito]');

			if ($this->form_validation->run() === TRUE)
			{
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
					'where' => array("rc_incidentes.estado != 'Anulado' AND rc_incidentes.lat_mapa IS NOT NULL AND rc_incidentes.long_mapa IS NOT NULL AND rc_incidentes.lat_mapa != '' AND rc_incidentes.long_mapa != ''")
				);

				$fecha_desde = $this->input->post('fecha_desde');
				if (!empty($fecha_desde) && $fecha_desde != -1) // NO cambiar por !==
				{
					$datetime_desde = DateTime::createFromFormat('d/m/Y', $fecha_desde);
					$reclamos_options['where'][] = array('column' => 'rc_incidentes.fecha_inicio >=', 'value' => date_format($datetime_desde, 'Y-m-d'));
				}

				$fecha_hasta = $this->input->post('fecha_hasta');
				if (!empty($fecha_hasta) && $fecha_hasta != -1) // NO cambiar por !==
				{
					$datetime_hasta = DateTime::createFromFormat('d/m/Y', $fecha_hasta);
					$datetime_hasta->add(new DateInterval('P1D'));
					$reclamos_options['where'][] = array('column' => 'rc_incidentes.fecha_inicio <', 'value' => date_format($datetime_hasta, 'Y-m-d'));
				}

				$estado = $this->input->post('estado');
				if (!empty($estado) && $estado !== 'Todos')
				{
					if ($estado === 'No Finalizado')
					{
						$reclamos_options['where'][] = array('column' => 'rc_incidentes.estado <>', 'value' => 'Finalizado');
					}
					else
					{
						$reclamos_options['where'][] = array('column' => 'rc_incidentes.estado', 'value' => $estado);
					}
				}

				$this->set_filtro_datos_listar_nosession('sector', 'Todos', 'rc_incidentes.sector_id', $reclamos_options['where']);
				$this->set_filtro_datos_listar_nosession('motivo', 'Todos', 'rc_incidentes.motivo_id', $reclamos_options['where']);
				$this->set_filtro_datos_listar_nosession('grupo', 'Todos', 'rc_incidentes.grupo_id', $reclamos_options['where']);
				$this->set_filtro_datos_listar_nosession('distrito', 'Todos', 'rc_incidentes.distrito_id', $reclamos_options['where']);

				if (!empty($options_grupos))
				{
					$reclamos_options['where'][] = 'rc_incidentes.grupo_' . $options_grupos['where'][0];
				}
				if (!empty($options_distritos))
				{
					$reclamos_options['where'][] = 'rc_incidentes.distrito_' . $options_distritos['where'][0];
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
				echo validation_errors();
			}
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Mapa.php */
/* Location: ./application/modules/reclamos/controllers/Mapa.php */