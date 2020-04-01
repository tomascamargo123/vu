<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/encuestas_model');
		$this->load->model('reclamos/asignaciones_grupos_model');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_coordinador', 'reclamos_consulta_general');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
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
					array('label' => 'Reclamo', 'data' => 'incidente', 'sort' => 'rc_encuestas.incidente_id', 'responsive_class' => 'all', 'width' => 10, 'class' => 'dt-body-right'),
					array('label' => 'Sector', 'data' => 'sector', 'sort' => 'rc_sectores.descripcion', 'width' => 20),
					array('label' => 'Motivo', 'data' => 'motivo', 'sort' => 'rc_motivos_reclamos.descripcion', 'width' => 20),
					array('label' => 'Fecha', 'data' => 'fecha', 'sort' => 'rc_encuestas.fecha', 'width' => 10, 'class' => 'dt-body-right', 'render' => $fecha_render),
					array('label' => 'Encuestador', 'data' => 'encuestador', 'sort' => 'users.username', 'width' => 20),
					array('label' => 'Observación', 'data' => 'observacion', 'sort' => 'rc_encuestas.observacion', 'width' => 20),
					array('label' => 'Puntaje', 'data' => 'puntaje', 'sort' => 'rc_encuestas_respuestas.puntaje', 'responsive_class' => 'all', 'width' => 10),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'encuestas_table',
				'source_url' => 'reclamos/encuestas/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);

			$tableData2 = array(
				'columns' => array(
					array('label' => 'N°', 'data' => 'id', 'sort' => 'rc_incidentes.id', 'width' => 5, 'responsive_class' => 'all', 'class' => 'dt-body-right'),
					array('label' => 'Inicio', 'data' => 'fecha_inicio', 'sort' => 'rc_incidentes.fecha_inicio', 'width' => 10, 'responsive_class' => 'all', 'class' => 'dt-body-right', 'render' => $fecha_render),
					array('label' => 'Tarea', 'data' => 'tarea', 'sort' => 'rc_incidentes.tarea', 'width' => 20, 'responsive_class' => 'all'),
					array('label' => 'Motivo', 'data' => 'motivo', 'sort' => 'rc_motivos_reclamos.descripcion', 'width' => 10, 'priority' => 3),
					array('label' => 'Sector', 'data' => 'sector', 'sort' => 'rc_sectores.descripcion', 'width' => 10, 'priority' => 4),
					array('label' => 'Finalización', 'data' => 'fecha_finalizacion', 'sort' => 'rc_incidentes.fecha_finalizacion', 'width' => 10, 'priority' => 6, 'class' => 'dt-body-right', 'render' => $fecha_render),
					array('label' => 'Distrito', 'data' => 'distrito', 'sort' => 'distritos.nombre', 'width' => 10, 'priority' => 2),
					array('label' => 'Grupo', 'data' => 'grupo', 'sort' => 'rc_grupos.nombre', 'width' => 10, 'priority' => 1),
					array('label' => 'Solicitante', 'data' => 'solicitante', 'sort' => 'rc_solicitantes.dni', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Apellido', 'data' => 'apellido', 'sort' => 'rc_incidentes.apellido', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_incidentes.nombre', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Mail', 'data' => 'mail', 'sort' => 'rc_incidentes.mail', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Teléfono', 'data' => 'telefono', 'sort' => 'rc_incidentes.telefono', 'width' => 10, 'responsive_class' => 'none', 'class' => 'dt-body-right'),
					array('label' => '', 'data' => 'new', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false'),
				),
				'table_id' => 'reclamos_table',
				'source_url' => 'reclamos/encuestas/listar_data_reclamos'
			);
			$data['html_table2'] = buildHTML($tableData2);
			$data['js_table2'] = buildJS($tableData2);

			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Encuestas';
			$this->load_template('reclamos/encuestas/encuestas_listar', $data);
		}
		else
		{
			show_404();
		}
	}

	public function listar_data()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$this->datatables
				->select('rc_encuestas.id, rc_encuestas.incidente_id as incidente, rc_sectores.descripcion AS sector, rc_motivos_reclamos.descripcion AS motivo, rc_encuestas.fecha, users.username as encuestador, rc_encuestas.observacion, ROUND(AVG(rc_encuestas_respuestas.puntaje), 2) as puntaje')
				->unset_column('id')
				->from('rc_encuestas')
				->join('rc_incidentes', 'rc_incidentes.id = rc_encuestas.incidente_id', 'left')
				->join('rc_sectores', 'rc_sectores.id = rc_incidentes.sector_id', 'left')
				->join('rc_motivos_reclamos', 'rc_motivos_reclamos.id = rc_incidentes.motivo_id', 'left')
				->join('rc_encuestas_respuestas', 'rc_encuestas_respuestas.encuesta_id = rc_encuestas.id', 'left')
				->join('users', 'users.id = rc_encuestas.user_id', 'left')
				->group_by('rc_encuestas.id')
				->add_column('edit', '<a href="reclamos/encuestas/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

			echo $this->datatables->generate();
		}
		else
		{
			show_404();
		}
	}

	public function listar_data_reclamos()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$this->datatables
				->select('rc_incidentes.id, rc_incidentes.fecha_inicio, rc_incidentes.tarea, rc_motivos_reclamos.descripcion as motivo, rc_sectores.descripcion as sector, rc_incidentes.fecha_finalizacion, distritos.nombre as distrito, rc_grupos.nombre as grupo, rc_solicitantes.dni as solicitante, rc_incidentes.apellido, rc_incidentes.nombre, rc_incidentes.mail, rc_incidentes.telefono')
				->unset_column('id')
				->from('rc_incidentes')
				->join('distritos', 'distritos.id = rc_incidentes.distrito_id', 'left')
				->join('rc_grupos', 'rc_grupos.id = rc_incidentes.grupo_id', 'left')
				->join('rc_motivos_reclamos', 'rc_motivos_reclamos.id = rc_incidentes.motivo_id', 'left')
				->join('rc_prioridades', 'rc_prioridades.id = rc_incidentes.prioridad_id', 'left')
				->join('rc_sectores', 'rc_sectores.id = rc_incidentes.sector_id', 'left')
				->join('rc_solicitantes', 'rc_solicitantes.id = rc_incidentes.solicitante_id', 'left')
				->where('rc_incidentes.estado = "Finalizado"')
				->where('rc_incidentes.id NOT IN (SELECT incidente_id FROM rc_encuestas)')
				->where('rc_solicitantes.et_user_id IS NULL')
				->where('(rc_solicitantes.telefono NOT IN ("", "0") OR rc_incidentes.telefono NOT IN ("", "0"))')
				->add_column('new', '<a href="reclamos/encuestas/agregar/$1" title="Encuestar"><i class="fa fa-thumbs-o-up"></i></a>', 'id');

			echo $this->datatables->generate();
		}
		else
		{
			show_404();
		}
	}

	public function agregar($id_reclamo)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			if (in_groups($this->grupos_solo_consulta, $this->grupos))
			{
				$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect("reclamos/encuestas/listar", 'refresh');
			}

			$this->load->model('reclamos/reclamos_model');
			$reclamo = $this->reclamos_model->get(array(
				'id' => $id_reclamo,
				'where' => array(
					array('column' => 'rc_incidentes.estado', 'value' => 'Finalizado'),
					array('column' => 'rc_incidentes.id NOT IN ', 'value' => '(SELECT incidente_id FROM rc_encuestas)', 'override' => TRUE),
					array('column' => 'rc_solicitantes.et_user_id IS ', 'value' => 'NULL', 'override' => TRUE),
					array('column' => '(rc_solicitantes.telefono NOT IN ("", "0") OR rc_incidentes.telefono NOT IN ("", "0"))', 'value' => '', 'override' => TRUE)
				),
				'join' => array(
					array(
						'type' => 'LEFT',
						'table' => 'rc_solicitantes',
						'where' => 'rc_solicitantes.id = rc_incidentes.solicitante_id',
						'columnas' => array('rc_solicitantes.dni as solicitante')
					))
			));
			if (empty($reclamo))
			{
				show_404();
			}

			$this->load->model('reclamos/encuestas_preguntas_model');
			$preguntas = $this->encuestas_preguntas_model->get(array('activo' => '1', 'web !=' => 'E'));
			if (empty($preguntas))
			{
				$this->session->set_flashdata('error', 'No hay preguntas configuradas para la encuesta. Contacte al administrador');
				redirect("reclamos/encuestas/listar", 'refresh');
			}
			$data['preguntas'] = $preguntas;

			$this->set_model_validation_rules($this->encuestas_model);
			foreach ($preguntas as $Pregunta)
			{
				$this->form_validation->set_rules('pregunta_' . $Pregunta->id, 'Pregunta ' . $Pregunta->id, 'required|integer');
			}
			if ($this->form_validation->run() === TRUE)
			{
				$fecha = date_format(new DateTime(), 'Y/m/d H:i');
				$this->load->model('reclamos/encuestas_respuestas_model');
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->encuestas_model->create(array(
					'incidente_id' => $id_reclamo,
					'fecha' => $fecha,
					'observacion' => $this->input->post('observacion'),
					'user_id' => $this->session->userdata('user_id')
					), FALSE);

				$encuesta_id = $this->encuestas_model->get_row_id();
				foreach ($preguntas as $Pregunta)
				{
					$trans_ok &= $this->encuestas_respuestas_model->create(array(
						'encuesta_id' => $encuesta_id,
						'pregunta_id' => $Pregunta->id,
						'puntaje' => $this->input->post('pregunta_' . $Pregunta->id)
						), FALSE);
				}

				$this->load->model('asignaciones_grupos_model');
				$this->load->model('observaciones_reclamos_model');
				$grupo_observacion = $this->asignaciones_grupos_model->get(array('user_id' => $this->session->userdata('user_id')));
				$trans_ok &= $this->observaciones_reclamos_model->create(array(
					'fecha' => $fecha,
					'incidente_id' => $id_reclamo,
					'observacion' => "Encuesta realizada",
					'icono' => "fa fa-thumbs-o-up bg-green",
					'grupo_id' => $grupo_observacion[0]->grupo_id,
					'user_id' => $this->session->userdata('user_id')
					), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->encuestas_model->get_msg());
					redirect('reclamos/encuestas/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->encuestas_model->get_error())
					{
						$error_msg .='<br>' . $this->encuestas_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->encuestas_model->fields as $field)
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

			$this->load->model('distritos_model');
			$this->load->model('reclamos/grupos_model');
			$this->load->model('reclamos/motivos_reclamos_model');
			$this->load->model('reclamos/prioridades_model');
			$this->load->model('reclamos/sectores_model');
			$array_distrito = $this->get_array('distritos', 'nombre');
			$array_grupo = $this->get_array('grupos', 'nombre');
			$array_motivo = $this->get_array('motivos_reclamos');
			$array_prioridad = $this->get_array('prioridades', 'nombre');
			$array_sector = $this->get_array('sectores');
			$array_estado = array('Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'Anulado' => 'Anulado');
			$array_tipo_solicitante = array('Vecino' => 'Vecino', 'Interno' => 'Interno');
			$data['fields_reclamo'] = array();
			foreach ($this->reclamos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields_reclamo'], $field, $reclamo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields_reclamo'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields_reclamo'], $field, ${'array_' . $field['name']}, $reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$this->load->model('reclamos/observaciones_reclamos_model');
			$this->load->model('reclamos/documentos_model');
			$observaciones = $this->observaciones_reclamos_model->get(array(
				'incidente_id' => $reclamo->id,
				'join' => array(
					array('type' => 'left', 'table' => 'users', 'where' => 'rc_observaciones_incidentes.user_id=users.id', 'columnas' => array('users.username', 'users.first_name', 'users.last_name')),
					array('type' => 'left', 'table' => 'rc_grupos', 'where' => 'rc_observaciones_incidentes.grupo_id=rc_grupos.id', 'columnas' => array('rc_grupos.nombre as grupo')),
				),
				'sort_by' => 'rc_observaciones_incidentes.fecha DESC, rc_observaciones_incidentes.id DESC'
			));
			$archivos_timeline = $this->documentos_model->get(array(
				'incidente_id' => $reclamo->id,
				'join' => array(
					array('type' => 'left', 'table' => 'users', 'where' => 'rc_documentos.user_id=users.id', 'columnas' => array('users.username', 'users.first_name', 'users.last_name')),
					array('type' => 'left', 'table' => 'rc_grupos', 'where' => 'rc_documentos.grupo_id=rc_grupos.id', 'columnas' => array('rc_grupos.nombre as grupo')),
				),
				'sort_by' => 'rc_documentos.fecha DESC, rc_documentos.id DESC'));
			$timeline = array();
			if (!empty($observaciones))
			{
				foreach ($observaciones as $observacion)
				{
					$timeline[date_format(new DateTime($observacion->fecha), 'YmdHis')]['observaciones'][] = $observacion;
				}
			}
			if (!empty($archivos_timeline))
			{
				foreach ($archivos_timeline as $archivo)
				{
					$timeline[date_format(new DateTime($archivo->fecha), 'YmdHis')]['archivos'][] = $archivo;
				}
			}
			ksort($timeline);
			$data['timeline'] = array_reverse($timeline, true);

			foreach ($preguntas as $Pregunta)
			{
				$Pregunta->puntaje = $this->input->post('pregunta_' . $Pregunta->id);
			}

			$data['txt_btn'] = 'Agregar';
			$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
			$data['title'] = 'Reclamos - Agregar encuesta';
			$data['js'][] = 'https://maps.google.com/maps/api/js?language=es';
			$data['js'][] = 'js/reclamos/map.js';
			$data['js'][] = 'plugins/lightbox/js/ekko-lightbox.min.js';
			$data['js'][] = 'plugins/ionslider/ion.rangeSlider.min.js';
			$data['css'][] = 'plugins/ionslider/ion.rangeSlider.css';
			$data['css'][] = 'plugins/ionslider/ion.rangeSlider.skinHTML5.css';
			$this->load_template('reclamos/encuestas/encuestas_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function ver($id = NULL)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			$encuesta = $this->encuestas_model->get(array('id' => $id));
			if (empty($encuesta))
			{
				show_404();
			}

			$this->load->model('reclamos/encuestas_respuestas_model');
			$preguntas = $this->encuestas_respuestas_model->get(array(
				'encuesta_id' => $encuesta->id,
				'join' => array(
					array(
						'table' => 'rc_encuestas_preguntas',
						'columnas' => array('rc_encuestas_preguntas.pregunta'),
						'where' => 'rc_encuestas_preguntas.id = rc_encuestas_respuestas.pregunta_id'
					)
				)
			));
			if (empty($preguntas))
			{
				show_404();
			}
			$data['preguntas'] = $preguntas;

			$this->load->model('reclamos/reclamos_model');
			$reclamo = $this->reclamos_model->get(array(
				'id' => $encuesta->incidente_id,
				'join' => array(
					array(
						'type' => 'LEFT',
						'table' => 'rc_solicitantes',
						'where' => 'rc_solicitantes.id = rc_incidentes.solicitante_id',
						'columnas' => array('rc_solicitantes.dni as solicitante')
					))
			));
			if (empty($reclamo))
			{
				show_404();
			}

			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->encuestas_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $encuesta->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $encuesta->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$this->load->model('distritos_model');
			$this->load->model('reclamos/grupos_model');
			$this->load->model('reclamos/motivos_reclamos_model');
			$this->load->model('reclamos/prioridades_model');
			$this->load->model('reclamos/sectores_model');
			$array_distrito = $this->get_array('distritos', 'nombre');
			$array_grupo = $this->get_array('grupos', 'nombre');
			$array_motivo = $this->get_array('motivos_reclamos');
			$array_prioridad = $this->get_array('prioridades', 'nombre');
			$array_sector = $this->get_array('sectores');
			$array_estado = array('Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'Anulado' => 'Anulado');
			$array_tipo_solicitante = array('Vecino' => 'Vecino', 'Interno' => 'Interno');
			$data['fields_reclamo'] = array();
			foreach ($this->reclamos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields_reclamo'], $field, $reclamo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields_reclamo'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields_reclamo'], $field, ${'array_' . $field['name']}, $reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$this->load->model('reclamos/observaciones_reclamos_model');
			$this->load->model('reclamos/documentos_model');
			$observaciones = $this->observaciones_reclamos_model->get(array(
				'incidente_id' => $reclamo->id,
				'join' => array(
					array('type' => 'left', 'table' => 'users', 'where' => 'rc_observaciones_incidentes.user_id=users.id', 'columnas' => array('users.username', 'users.first_name', 'users.last_name')),
					array('type' => 'left', 'table' => 'rc_grupos', 'where' => 'rc_observaciones_incidentes.grupo_id=rc_grupos.id', 'columnas' => array('rc_grupos.nombre as grupo')),
				),
				'sort_by' => 'rc_observaciones_incidentes.fecha DESC, rc_observaciones_incidentes.id DESC'
			));
			$archivos_timeline = $this->documentos_model->get(array(
				'incidente_id' => $reclamo->id,
				'join' => array(
					array('type' => 'left', 'table' => 'users', 'where' => 'rc_documentos.user_id=users.id', 'columnas' => array('users.username', 'users.first_name', 'users.last_name')),
					array('type' => 'left', 'table' => 'rc_grupos', 'where' => 'rc_documentos.grupo_id=rc_grupos.id', 'columnas' => array('rc_grupos.nombre as grupo')),
				),
				'sort_by' => 'rc_documentos.fecha DESC, rc_documentos.id DESC'));
			$timeline = array();
			if (!empty($observaciones))
			{
				foreach ($observaciones as $observacion)
				{
					$timeline[date_format(new DateTime($observacion->fecha), 'YmdHis')]['observaciones'][] = $observacion;
				}
			}
			if (!empty($archivos_timeline))
			{
				foreach ($archivos_timeline as $archivo)
				{
					$timeline[date_format(new DateTime($archivo->fecha), 'YmdHis')]['archivos'][] = $archivo;
				}
			}
			ksort($timeline);
			$data['timeline'] = array_reverse($timeline, true);

			$data['encuesta'] = $encuesta;

			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver encuesta';
			$data['js'][] = 'https://maps.google.com/maps/api/js?language=es';
			$data['js'][] = 'js/reclamos/map.js';
			$data['js'][] = 'plugins/lightbox/js/ekko-lightbox.min.js';
			$data['js'][] = 'plugins/ionslider/ion.rangeSlider.min.js';
			$data['css'][] = 'plugins/ionslider/ion.rangeSlider.css';
			$data['css'][] = 'plugins/ionslider/ion.rangeSlider.skinHTML5.css';
			$this->load_template('reclamos/encuestas/encuestas_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function get_image($ruta = NULL)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos) && $ruta !== NULL)
		{
			if (preg_match('^[A-Za-z0-9\_\-]{2,32}+[.]{1}[A-Za-z]{3,4}$^', $ruta)) // validation
			{
				$file = 'uploads/reclamos/documentos/' . $ruta;
				$this->load->helper('file');
				if (file_exists($file)) // check the file is existing 
				{
					header('Content-Type: ' . get_mime_by_extension($file));
					readfile($file);
					return;
				}
			}
			show_404();
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Encuestas.php */
/* Location: ./application/modules/reclamos/controllers/Encuestas.php */