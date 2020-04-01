<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reclamos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/reclamos_model');
		$this->load->model('reclamos/observaciones_reclamos_model');
		$this->load->model('reclamos/grupos_model');
		$this->load->model('reclamos/asignaciones_distritos_model');
		$this->load->model('reclamos/asignaciones_grupos_model');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_coordinador', 'reclamos_usuario', 'reclamos_distrito', 'reclamos_consulta_general');
		$this->grupos_usuario = array('reclamos_usuario');
		$this->grupos_distrito = array('reclamos_distrito');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
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
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$options_distritos = array('where' => array('id IN (' . implode(',', $this->usuario_distritos) . ')'));
			}

			$options_grupos = array();
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$options_grupos = array('where' => array('id IN (' . implode(',', $this->usuario_grupos) . ')'));
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
					array('label' => 'N°', 'data' => 'id', 'sort' => 'rc_incidentes.id', 'width' => 5, 'responsive_class' => 'all', 'class' => 'dt-body-right'),
					array('label' => 'Inicio', 'data' => 'fecha_inicio', 'sort' => 'rc_incidentes.fecha_inicio', 'width' => 10, 'responsive_class' => 'all', 'class' => 'dt-body-right', 'render' => $fecha_render),
					array('label' => 'Tarea', 'data' => 'tarea', 'sort' => 'rc_incidentes.tarea', 'width' => 30, 'responsive_class' => 'all'),
					array('label' => 'Motivo', 'data' => 'motivo', 'sort' => 'rc_motivos_reclamos.descripcion', 'width' => 10, 'priority' => 3),
					array('label' => 'Sector', 'data' => 'sector', 'sort' => 'rc_sectores.descripcion', 'width' => 10, 'priority' => 4, 'filter_name' => 'sector'),
					array('label' => 'Vencimiento', 'data' => 'vencimiento', 'sort' => 'rc_incidentes.vencimiento', 'width' => 10, 'priority' => 2, 'class' => 'dt-body-right', 'render' => $fecha_render),
					array('label' => 'Estado', 'data' => 'estado', 'sort' => 'rc_incidentes.estado', 'width' => 10, 'responsive_class' => 'all', 'filter_name' => 'estado'),
					array('label' => 'Grupo', 'data' => 'grupo', 'sort' => 'rc_grupos.nombre', 'width' => 10, 'priority' => 1, 'filter_name' => 'grupo'),
					array('label' => 'Distrito', 'data' => 'distrito', 'sort' => 'distritos.nombre', 'width' => 10, 'priority' => 5, 'filter_name' => 'distrito'),
					array('label' => 'Pri', 'data' => 'prioridad', 'sort' => 'rc_prioridades.nombre', 'width' => 5, 'responsive_class' => 'all'),
					array('label' => 'Descripción', 'data' => 'descripcion', 'sort' => 'rc_incidentes.descripcion', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Finalización', 'data' => 'fecha_finalizacion', 'sort' => 'rc_incidentes.fecha_finalizacion', 'width' => 10, 'priority' => 6, 'class' => 'dt-body-right', 'render' => $fecha_render),
					array('label' => 'Resolución', 'data' => 'resolucion', 'sort' => 'rc_incidentes.resolucion', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Tipo Solicitante', 'data' => 'tipo_solicitante', 'sort' => 'rc_incidentes.tipo_solicitante', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Solicitante', 'data' => 'dni', 'sort' => 'rc_solicitantes.dni', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Apellido', 'data' => 'apellido', 'sort' => 'rc_incidentes.apellido', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_incidentes.nombre', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Mail', 'data' => 'mail', 'sort' => 'rc_incidentes.mail', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Teléfono', 'data' => 'telefono', 'sort' => 'rc_incidentes.telefono', 'width' => 10, 'responsive_class' => 'none', 'class' => 'dt-body-right'),
					array('label' => 'Calle', 'data' => 'calle', 'sort' => 'rc_incidentes.calle', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Número', 'data' => 'numero', 'sort' => 'rc_incidentes.numero', 'width' => 10, 'responsive_class' => 'none', 'class' => 'dt-body-right'),
					array('label' => 'Manzana', 'data' => 'manzana', 'sort' => 'rc_incidentes.manzana', 'width' => 10, 'responsive_class' => 'none'),
					array('label' => 'Casa', 'data' => 'casa', 'sort' => 'rc_incidentes.casa', 'width' => 10, 'responsive_class' => 'none', 'class' => 'dt-body-right'),
					array('label' => 'Número Luminaria', 'data' => 'numero_luminaria', 'sort' => 'rc_incidentes.numero', 'width' => 10, 'responsive_class' => 'none', 'class' => 'dt-body-right'),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false'),
				),
				'table_id' => 'reclamos_table',
				'source_url' => 'reclamos/reclamos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);

			$this->load->model('reclamos/sectores_model');
			$this->load->model('distritos_model');
			$data['sector_opt'] = $this->get_array('sectores', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$data['sector_opt_selected'] = 'Todos';
			$data['estado_opt'] = array('Todos' => 'Todos', 'Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'Anulado' => 'Anulado');
			$data['estado_opt_selected'] = 'Todos';
			$data['grupo_opt'] = $this->get_array('grupos', 'nombre', 'id', $options_grupos, array('Todos' => 'Todos'));
			$data['grupo_opt_selected'] = 'Todos';
			$data['distrito_opt'] = $this->get_array('distritos', 'nombre', 'id', $options_distritos, array('Todos' => 'Todos'));
			$data['distrito_opt_selected'] = 'Todos';

			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Reclamos';
			$this->load_template('reclamos/reclamos/reclamos_listar', $data);
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
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$where_distritos = 'rc_incidentes.distrito_id IN (' . implode(',', $this->usuario_distritos) . ')';
			}

			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$where_grupos = 'rc_incidentes.grupo_id IN (' . implode(',', $this->usuario_grupos) . ')';
			}

			$this->datatables
				->select('rc_incidentes.id, rc_incidentes.fecha_inicio, rc_incidentes.tarea, rc_motivos_reclamos.descripcion as motivo, rc_sectores.descripcion as sector, rc_incidentes.vencimiento, rc_incidentes.estado, rc_grupos.nombre as grupo, distritos.nombre as distrito, rc_prioridades.icono as icono_prioridad, rc_incidentes.descripcion, rc_incidentes.fecha_finalizacion, rc_incidentes.resolucion, rc_incidentes.tipo_solicitante, rc_solicitantes.dni, rc_incidentes.apellido, rc_incidentes.nombre, rc_incidentes.mail, rc_incidentes.telefono, rc_incidentes.calle, rc_incidentes.numero, rc_incidentes.manzana, rc_incidentes.casa, rc_incidentes.numero_luminaria, rc_prioridades.nombre as prioridad')
				->unset_column('id')
				->from('rc_incidentes')
				->join('distritos', 'distritos.id = rc_incidentes.distrito_id', 'left')
				->join('rc_grupos', 'rc_grupos.id = rc_incidentes.grupo_id', 'left')
				->join('rc_motivos_reclamos', 'rc_motivos_reclamos.id = rc_incidentes.motivo_id', 'left')
				->join('rc_prioridades', 'rc_prioridades.id = rc_incidentes.prioridad_id', 'left')
				->join('rc_sectores', 'rc_sectores.id = rc_incidentes.sector_id', 'left')
				->join('rc_solicitantes', 'rc_solicitantes.id = rc_incidentes.solicitante_id', 'left')
				->add_column('prioridad', '<img width=16px src="img/reclamos/prioridades/$1.png" alter="Prioridad $2" title="Prioridad $2"/>', 'icono_prioridad,prioridad')
				->add_column('edit', '<a href="reclamos/reclamos/editar/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

			if (isset($where_distritos))
			{
				$this->datatables->where($where_distritos);
			}
			if (isset($where_grupos))
			{
				$this->datatables->where($where_grupos);
			}

			echo $this->datatables->generate();
		}
		else
		{
			show_404();
		}
	}

	public function agregar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			if (in_groups($this->grupos_solo_consulta, $this->grupos))
			{
				$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect("reclamos/reclamos/listar", 'refresh');
			}
			$this->load->model('distritos_model');
			$this->load->model('reclamos/motivos_reclamos_model');
			$this->load->model('reclamos/prioridades_model');
			$this->load->model('reclamos/sectores_model');
			$this->load->model('reclamos/solicitantes_model');
			$this->array_distrito_control = $array_distrito = $this->get_array('distritos', 'nombre', 'id', null, array(0 => '-- Seleccionar distrito --'));
			unset($this->array_distrito_control[0]);
			$this->array_grupo_control = $array_grupo = $this->get_array('grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			unset($this->array_grupo_control[0]);
			if (isset($_POST['sector']))
			{
				$array_motivo = $this->get_array('motivos_reclamos', 'descripcion', 'id', array('sector_id' => $_POST['sector'], 'sort_by' => 'descripcion'), array(0 => '-- Seleccionar motivo --'));
			}
			else
			{
				$array_motivo = array(0 => '-- Seleccionar sector --');
			}
			$this->array_motivo_control = $this->get_array('motivos_reclamos');
			$this->array_prioridad_control = $array_prioridad = $this->get_array('prioridades', 'nombre', 'id', array('sort_by' => 'dias DESC'), array(0 => '-- Seleccionar prioridad --'));
			unset($this->array_prioridad_control[0]);
			$this->array_sector_control = $array_sector = $this->get_array('sectores', 'descripcion', 'id', null, array(0 => '-- Seleccionar sector --'));
			unset($this->array_sector_control[0]);
			$this->array_solicitante_control = $array_solicitante = $this->get_array('solicitantes', 'solicitante', 'id', array('select' => array('id', "CONCAT(apellido, ', ', nombre) as solicitante"), 'sort_by' => 'apellido'), array(0 => '-- Seleccionar solicitante --'));
			$this->array_estado_control = $array_estado = array('Pendiente' => 'Pendiente');
			$this->array_tipo_solicitante_control = $array_tipo_solicitante = array('Vecino' => 'Vecino', 'Interno' => 'Interno');

			$this->set_model_validation_rules($this->reclamos_model);
			if ($this->form_validation->run() === TRUE)
			{
				$archivos = $_FILES['archivos'];
				if (empty($archivos['name'][0]))
				{
					$cant_archivos = 0;
				}
				else
				{
					$cant_archivos = count($archivos['name']);
				}
				if ($cant_archivos != 0)
				{
					$this->load->library('upload');
					$upload_files = new stdClass();
					$upload_files->status = TRUE;
					for ($i = 0; $i < $cant_archivos; $i++)
					{
						$_FILES['archivos']['name'] = $archivos['name'][$i];
						$_FILES['archivos']['type'] = $archivos['type'][$i];
						$_FILES['archivos']['tmp_name'] = $archivos['tmp_name'][$i];
						$_FILES['archivos']['error'] = $archivos['error'][$i];
						$_FILES['archivos']['size'] = $archivos['size'][$i];
						$config = array(
							'file_name' => 'documento_000' . $i,
							'allowed_types' => 'jpg|jpeg|png|gif',
							'max_size' => 3000,
							'overwrite' => FALSE,
							'upload_path' => './uploads/reclamos/documentos/'
						);
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('archivos'))
						{
							$upload_files->status = FALSE;
							$upload_files->error_msg[] = $this->upload->display_errors();
						}
						else
						{
							$upload_files->file_info[] = $this->upload->data();
						}
					}
				}
				if ($cant_archivos == 0 || $upload_files->status == TRUE)
				{
					$this->db->trans_begin();
					$trans_ok = TRUE;
					$dni = $this->input->post('solicitante');
					if (empty($dni))
					{
						$solicitante_id = 'NULL';
					}
					else
					{
						$solicitante = $this->solicitantes_model->get(array('dni' => $dni));
						if (empty($solicitante))
						{
							$trans_ok&= $this->solicitantes_model->create(array(
								'dni' => $dni,
								'apellido' => $this->input->post('apellido'),
								'nombre' => $this->input->post('nombre'),
								'mail' => $this->input->post('mail'),
								'telefono' => $this->input->post('telefono')
								), FALSE);
							$solicitante_id = $this->solicitantes_model->get_row_id();
						}
						else
						{
							$solicitante_id = $solicitante[0]->id;
						}
					}
					$fecha_actual = date_format(new DateTime(), 'Y-m-d H:i:s');
					$trans_ok&= $this->reclamos_model->create(array(
						'fecha_inicio' => $this->input->post('fecha_inicio') === '' ? 'NULL' : date_format(new DateTime($this->input->post('fecha_inicio')), 'Y-m-d'),
						'prioridad_id' => $this->input->post('prioridad'),
						'vencimiento' => $this->input->post('vencimiento') === '' ? 'NULL' : date_format(new DateTime($this->input->post('vencimiento')), 'Y-m-d'),
						'sector_id' => $this->input->post('sector'),
						'motivo_id' => $this->input->post('motivo'),
						'grupo_id' => $this->input->post('grupo'),
						'tipo_solicitante' => $this->input->post('tipo_solicitante'),
						'solicitante_id' => $solicitante_id,
						'apellido' => $this->input->post('apellido'),
						'nombre' => $this->input->post('nombre'),
						'mail' => $this->input->post('mail'),
						'telefono' => $this->input->post('telefono'),
						'tarea' => $this->input->post('tarea'),
						'descripcion' => $this->input->post('descripcion'),
						'calle' => $this->input->post('calle'),
						'numero' => $this->input->post('numero'),
						'manzana' => $this->input->post('manzana'),
						'casa' => $this->input->post('casa'),
						'distrito_id' => $this->input->post('distrito'),
						'lat_mapa' => $this->input->post('lat_mapa'),
						'long_mapa' => $this->input->post('long_mapa'),
						'numero_luminaria' => $this->input->post('numero_luminaria'),
						'estado' => $this->input->post('estado'),
						'user_id' => $this->session->userdata('user_id')
						), FALSE);

					$reclamo_id = $this->reclamos_model->get_row_id();
					$grupo_observacion = $this->asignaciones_grupos_model->get(array('user_id' => $this->session->userdata('user_id')));
					$trans_ok &= $this->observaciones_reclamos_model->create(array(
						'fecha' => $fecha_actual,
						'incidente_id' => $reclamo_id,
						'observacion' => "Alta por telefono o mail",
						'icono' => "fa fa-envelope bg-blue",
						'grupo_id' => $grupo_observacion[0]->grupo_id,
						'user_id' => $this->session->userdata('user_id')
						), FALSE);
					if ($this->input->post('observaciones'))
					{
						$trans_ok &= $this->observaciones_reclamos_model->create(array(
							'fecha' => $fecha_actual,
							'incidente_id' => $reclamo_id,
							'observacion' => $this->input->post('observaciones'),
							'icono' => "fa fa-comments bg-maroon",
							'grupo_id' => $grupo_observacion[0]->grupo_id,
							'user_id' => $this->session->userdata('user_id')
							), FALSE);
					}
					$grupo = $this->grupos_model->get(array('id' => $this->input->post('grupo')));
					$trans_ok &= $this->observaciones_reclamos_model->create(array(
						'fecha' => $fecha_actual,
						'incidente_id' => $reclamo_id,
						'observacion' => "Derivado a: $grupo->nombre",
						'icono' => "fa fa-exchange bg-teal",
						'grupo_id' => $grupo_observacion[0]->grupo_id,
						'user_id' => $this->session->userdata('user_id')
						), FALSE);
					if ($cant_archivos != 0)
					{
						$rutas = array();
						foreach ($upload_files->file_info as $file_info)
						{
							$rutas[] = $file_info['file_name'];
						}

						$this->load->model('reclamos/documentos_model');
						for ($i = 0; $i < $cant_archivos; $i++)
						{
							$trans_ok &= $this->documentos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $reclamo_id,
								'ruta' => $rutas[$i],
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
					}
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->reclamos_model->get_msg());
						redirect('reclamos/reclamos/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->reclamos_model->get_error())
						{
							$error_msg .='<br>' . $this->reclamos_model->get_error();
						}
						if ($this->observaciones_reclamos_model->get_error())
						{
							$error_msg .='<br>' . $this->observaciones_reclamos_model->get_error();
						}
					}
				}
				else
				{
					$error_msg = 'Ocurrió un error al intentar subir los archivos';
					foreach ($upload_files->error_msg as $error_msgs)
					{
						$error_msg.='<br/>' . $error_msgs;
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			$values['fecha_inicio'] = date_format(new DateTime(), 'Y-m-d');
			foreach ($this->reclamos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, isset($values[$field['name']]) ? $values[$field['name']] : NULL);
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
			$this->add_input_field($data['fields'], array('name' => 'observaciones', 'label' => 'Observaciones', 'form_type' => 'textarea', 'rows' => '2'));
			unset($data['fields']['fecha_finalizacion']);
			unset($data['fields']['resolucion']);

			$tableData_solicitantes = array(
				'columns' => array(
					array('label' => 'DNI', 'data' => 'dni', 'sort' => 'rc_solicitantes.dni', 'width' => 11, 'class' => 'dt-body-right', 'responsive_class' => 'all'),
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_solicitantes.nombre', 'width' => 22),
					array('label' => 'Apellido', 'data' => 'apellido', 'sort' => 'rc_solicitantes.apellido', 'width' => 22),
					array('label' => 'Mail', 'data' => 'mail', 'sort' => 'rc_solicitantes.mail', 'width' => 15),
					array('label' => 'Teléfono', 'data' => 'telefono', 'sort' => 'rc_solicitantes.telefono', 'width' => 15, 'class' => 'dt-body-right'),
					array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'solicitantes_table',
				'source_url' => 'reclamos/solicitantes/listar_data',
				'reuse_var' => TRUE
			);
			$data['html_table_solicitantes'] = buildHTML($tableData_solicitantes);
			$data['js_table_solicitantes'] = buildJS($tableData_solicitantes);
			$data['txt_btn'] = 'Agregar';
			$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
			$data['title'] = 'Reclamos - Agregar reclamo';
			$data['css'][] = 'plugins/bootstrap-fileinput/css/fileinput.min.css';
			$data['js'][] = 'plugins/bootstrap-fileinput/js/fileinput.min.js';
			$data['js'][] = 'plugins/bootstrap-fileinput/js/fileinput_locale_es.js';
			$data['js'][] = 'js/reclamos/reclamos-varios.js';
			$data['js'][] = 'https://maps.google.com/maps/api/js?key=AIzaSyAUWE6x_ZRqLgOTpqSZxPUzRzZkRaBv17U&language=es';
			$data['js'][] = 'js/reclamos/map.js';
			$this->load_template('reclamos/reclamos/reclamos_add', $data);
		}
		else
		{
			show_404();
		}
	}

	public function editar($id = NULL)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			if (in_groups($this->grupos_solo_consulta, $this->grupos))
			{
				$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect("reclamos/reclamos/ver/$id", 'refresh');
			}
			$reclamo = $this->reclamos_model->get(array('id' => $id,
				'join' => array(array(
						'type' => 'left', 'table' => 'rc_solicitantes',
						'where' => 'rc_incidentes.solicitante_id=rc_solicitantes.id',
						'columnas' => array('rc_solicitantes.dni as solicitante')
					))
			));
			if (empty($reclamo))
			{
				show_404();
			}
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				if (!in_array($reclamo->distrito_id, $this->usuario_distritos))
				{
					$this->session->set_flashdata('error', 'No puede ver reclamos de un distrito no asignado. Contacte al administrador.');
					redirect("reclamos/reclamos/listar", 'refresh');
				}
			}

			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				if (!in_array($reclamo->grupo_id, $this->usuario_grupos))
				{
					$this->session->set_flashdata('error', 'No puede ver reclamos de un grupo no asignado. Contacte al administrador.');
					redirect("reclamos/reclamos/listar", 'refresh');
				}
			}

			if ($reclamo->estado === 'Finalizado')
			{
				$this->session->set_flashdata('error', 'No se puede editar un reclamo finalizado');
				redirect("reclamos/reclamos/ver/$id", 'refresh');
			}
			$this->load->model('distritos_model');
			$this->load->model('reclamos/documentos_model');
			$this->load->model('reclamos/motivos_reclamos_model');
			$this->load->model('reclamos/prioridades_model');
			$this->load->model('reclamos/sectores_model');
			$this->load->model('reclamos/solicitantes_model');
			$this->array_distrito_control = $array_distrito = $this->get_array('distritos', 'nombre');
			$this->array_grupo_control = $array_grupo = $this->get_array('grupos', 'nombre');
			if (isset($_POST['sector']))
			{
				$array_motivo = $this->get_array('motivos_reclamos', 'descripcion', 'id', array('sector_id' => $_POST['sector'], 'sort_by' => 'descripcion'), array(0 => '-- Seleccionar motivo --'));
			}
			else
			{
				$array_motivo = $this->get_array('motivos_reclamos', 'descripcion', 'id', array('sector_id' => $reclamo->sector_id, 'sort_by' => 'descripcion'), array(0 => '-- Seleccionar motivo --'));
			}
			$this->array_motivo_control = $this->get_array('motivos_reclamos');
			$this->array_prioridad_control = $array_prioridad = $this->get_array('prioridades', 'nombre', 'id', array('sort_by' => 'dias DESC'));
			$this->array_sector_control = $array_sector = $this->get_array('sectores');
//			unset($this->array_solicitante_control[0]);
			$this->array_estado_control = $array_estado = array('Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'Anulado' => 'Anulado');
			$this->array_tipo_solicitante_control = $array_tipo_solicitante = array('Vecino' => 'Vecino', 'Interno' => 'Interno');

			$this->set_model_validation_rules($this->reclamos_model);
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if ($this->form_validation->run() === TRUE)
				{
					$archivos = $_FILES['archivos'];
					if (empty($archivos['name'][0]))
					{
						$cant_archivos = 0;
					}
					else
					{
						$cant_archivos = count($archivos['name']);
					}
					if ($cant_archivos != 0)
					{
						$this->load->library('upload');
						$upload_files = new stdClass();
						$upload_files->status = TRUE;
						for ($i = 0; $i < $cant_archivos; $i++)
						{
							$_FILES['archivos']['name'] = $archivos['name'][$i];
							$_FILES['archivos']['type'] = $archivos['type'][$i];
							$_FILES['archivos']['tmp_name'] = $archivos['tmp_name'][$i];
							$_FILES['archivos']['error'] = $archivos['error'][$i];
							$_FILES['archivos']['size'] = $archivos['size'][$i];
							$config = array(
								'file_name' => 'documento_000' . $i,
								'allowed_types' => 'jpg|jpeg|png|gif',
								'max_size' => 3000,
								'overwrite' => FALSE,
								'upload_path' => './uploads/reclamos/documentos/'
							);
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('archivos'))
							{
								$upload_files->status = FALSE;
								$upload_files->error_msg[] = $this->upload->display_errors();
							}
							else
							{
								$upload_files->file_info[] = $this->upload->data();
							}
						}
					}
					if ($cant_archivos == 0 || $upload_files->status == TRUE)
					{
						$this->db->trans_begin();
						$trans_ok = TRUE;
						$dni = $this->input->post('solicitante');
						if (empty($dni))
						{
							$solicitante_id = 'NULL';
						}
						else
						{
							$solicitante = $this->solicitantes_model->get(array('dni' => $dni));
							if (empty($solicitante))
							{
								$trans_ok&= $this->solicitantes_model->create(array(
									'dni' => $dni,
									'apellido' => $this->input->post('apellido'),
									'nombre' => $this->input->post('nombre'),
									'mail' => $this->input->post('mail'),
									'telefono' => $this->input->post('telefono')
									), FALSE);
								$solicitante_id = $this->solicitantes_model->get_row_id();
							}
							else
							{
								$solicitante_id = $solicitante[0]->id;
							}
						}
						$fecha_actual = date_format(new DateTime(), 'Y-m-d H:i:s');
						$trans_ok&= $this->reclamos_model->update(array(
							'id' => $this->input->post('id'),
							'fecha_inicio' => $reclamo->fecha_inicio,
							'prioridad_id' => $this->input->post('prioridad'),
							'vencimiento' => $this->input->post('vencimiento') === '' ? 'NULL' : date_format(new DateTime($this->input->post('vencimiento')), 'Y-m-d'),
							'sector_id' => $this->input->post('sector'),
							'motivo_id' => $this->input->post('motivo'),
							'grupo_id' => $this->input->post('grupo'),
							'tipo_solicitante' => $this->input->post('tipo_solicitante'),
							'solicitante_id' => $solicitante_id,
							'apellido' => $this->input->post('apellido'),
							'nombre' => $this->input->post('nombre'),
							'mail' => $this->input->post('mail'),
							'telefono' => $this->input->post('telefono'),
							'tarea' => $reclamo->tarea,
							'descripcion' => $reclamo->descripcion,
							'calle' => $this->input->post('calle'),
							'numero' => $this->input->post('numero'),
							'manzana' => $this->input->post('manzana'),
							'casa' => $this->input->post('casa'),
							'distrito_id' => $this->input->post('distrito'),
							'lat_mapa' => $this->input->post('lat_mapa'),
							'long_mapa' => $this->input->post('long_mapa'),
							'numero_luminaria' => $this->input->post('numero_luminaria'),
							'estado' => $this->input->post('estado'),
							'fecha_finalizacion' => $this->input->post('fecha_finalizacion') === '' ? 'NULL' : date_format(new DateTime($this->input->post('fecha_finalizacion')), 'Y-m-d'),
							'resolucion' => $this->input->post('resolucion')
							), FALSE);
						$grupo_observacion = $this->asignaciones_grupos_model->get(array('user_id' => $this->session->userdata('user_id')));
						if ($this->input->post('observaciones'))
						{
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => $this->input->post('observaciones'),
								'icono' => "fa fa-comments bg-maroon",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('tarea') != $reclamo->tarea)
						{
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Tarea cambiada de: " . $reclamo->tarea . " a: " . $this->input->post('tarea'),
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('sector') != $reclamo->sector_id)
						{
							$sector = $this->sectores_model->get(array('id' => $this->input->post('sector')));
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Nuevo sector: $sector->descripcion",
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('motivo') != $reclamo->motivo_id)
						{
							$motivo = $this->motivos_reclamos_model->get(array('id' => $this->input->post('motivo')));
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Nuevo motivo: $motivo->descripcion",
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('grupo') != $reclamo->grupo_id)
						{
							$grupo = $this->grupos_model->get(array('id' => $this->input->post('grupo')));
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Derivado a: $grupo->nombre",
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('tipo_solicitante') != $reclamo->tipo_solicitante)
						{
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Nuevo tipo de solicitante: " . $this->input->post('tipo_solicitante'),
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('estado') != $reclamo->estado && $this->input->post('estado') != 'Finalizado')
						{
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Nuevo estado: " . $this->input->post('estado'),
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('prioridad') != $reclamo->prioridad_id)
						{
							$prioridad_nueva = $this->prioridades_model->get(array('id' => $this->input->post('prioridad')));
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Nueva prioridad: " . $prioridad_nueva->nombre,
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if (($this->input->post('distrito') != $reclamo->distrito_id) || ($this->input->post('calle') != $reclamo->calle) || ($this->input->post('numero') != $reclamo->numero) || ($this->input->post('manzana') != $reclamo->manzana) || ($this->input->post('casa') != $reclamo->casa))
						{
							$nuevo_distrito = $this->distritos_model->get(array('id' => $this->input->post('distrito')));
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Nueva dirección: " . $nuevo_distrito->nombre . " - Calle: " . $this->input->post('calle') . " Nº " . $this->input->post('numero') . " Mzana " . $this->input->post('manzana') . " Casa " . $this->input->post('casa'),
								'icono' => "fa fa-exchange bg-teal",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('resolucion') !== '' && $this->input->post('estado') === 'Finalizado')
						{
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => 'Resolución: ' . $this->input->post('resolucion'),
								'icono' => "fa fa-check bg-green",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($this->input->post('estado') === 'Finalizado')
						{
							$trans_ok &= $this->observaciones_reclamos_model->create(array(
								'fecha' => $fecha_actual,
								'incidente_id' => $id,
								'observacion' => "Reclamo Finalizado",
								'icono' => "fa fa-check bg-green",
								'grupo_id' => $grupo_observacion[0]->grupo_id,
								'user_id' => $this->session->userdata('user_id')
								), FALSE);
						}
						if ($cant_archivos != 0)
						{
							$rutas = array();
							foreach ($upload_files->file_info as $file_info)
							{
								$rutas[] = $file_info['file_name'];
							}

							for ($i = 0; $i < $cant_archivos; $i++)
							{
								$trans_ok &= $this->documentos_model->create(array(
									'fecha' => $fecha_actual,
									'incidente_id' => $id,
									'ruta' => $rutas[$i],
									'grupo_id' => $grupo_observacion[0]->grupo_id,
									'user_id' => $this->session->userdata('user_id')
									), FALSE);
							}
						}
						if ($this->db->trans_status() && $trans_ok)
						{
							$this->db->trans_commit();
							$this->session->set_flashdata('message', $this->reclamos_model->get_msg());
							redirect('reclamos/reclamos/listar', 'refresh');
						}
						else
						{
							$this->db->trans_rollback();
							$error_msg = 'Se ha producido un error con la base de datos.';
							if ($this->reclamos_model->get_error())
							{
								$error_msg .='<br>' . $this->reclamos_model->get_error();
							}
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			if (empty($reclamo->solicitante_id))
			{
				$readonly_fields = array('fecha_finalizacion', 'tarea', 'descripcion', 'resolucion');
			}
			else
			{
				$readonly_fields = array('solicitante', 'apellido', 'nombre', 'mail', 'telefono', 'fecha_finalizacion', 'tarea', 'descripcion', 'resolucion');
			}
			foreach ($this->reclamos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					if (in_array($field['name'], $readonly_fields))
					{
						$field['readonly'] = 'readonly';
					}
					$this->add_input_field($data['fields'], $field, $reclamo->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$this->add_input_field($data['fields'], array('name' => 'observaciones', 'label' => 'Observaciones', 'form_type' => 'textarea', 'rows' => '2'));
			$data['reclamo'] = $reclamo;
			$observaciones = $this->observaciones_reclamos_model->get(array('incidente_id' => $reclamo->id,
				'join' => array(
					array('type' => 'left', 'table' => 'users', 'where' => 'rc_observaciones_incidentes.user_id=users.id', 'columnas' => array('users.username', 'users.first_name', 'users.last_name')),
					array('type' => 'left', 'table' => 'rc_grupos', 'where' => 'rc_observaciones_incidentes.grupo_id=rc_grupos.id', 'columnas' => array('rc_grupos.nombre as grupo')),
				),
				'sort_by' => 'rc_observaciones_incidentes.fecha DESC, rc_observaciones_incidentes.id DESC'
			));
			$archivos_timeline = $this->documentos_model->get(array('incidente_id' => $reclamo->id,
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
			$tableData_solicitantes = array(
				'columns' => array(
					array('label' => 'DNI', 'data' => 'dni', 'sort' => 'rc_solicitantes.dni', 'width' => 11, 'class' => 'dt-body-right', 'responsive_class' => 'all'),
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_solicitantes.nombre', 'width' => 22),
					array('label' => 'Apellido', 'data' => 'apellido', 'sort' => 'rc_solicitantes.apellido', 'width' => 22),
					array('label' => 'Mail', 'data' => 'mail', 'sort' => 'rc_solicitantes.mail', 'width' => 15),
					array('label' => 'Teléfono', 'data' => 'telefono', 'sort' => 'rc_solicitantes.telefono', 'width' => 15, 'class' => 'dt-body-right'),
					array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'solicitantes_table',
				'source_url' => 'reclamos/solicitantes/listar_data',
				'reuse_var' => TRUE
			);
			$data['html_table_solicitantes'] = buildHTML($tableData_solicitantes);
			$data['js_table_solicitantes'] = buildJS($tableData_solicitantes);
			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar reclamo';
			$data['css'][] = 'plugins/bootstrap-fileinput/css/fileinput.min.css';
			$data['js'][] = 'plugins/bootstrap-fileinput/js/fileinput.min.js';
			$data['js'][] = 'plugins/bootstrap-fileinput/js/fileinput_locale_es.js';
			$data['js'][] = 'plugins/lightbox/js/ekko-lightbox.min.js';
			$data['js'][] = 'js/reclamos/reclamos-varios.js';
			$data['js'][] = 'https://maps.google.com/maps/api/js?key=AIzaSyAUWE6x_ZRqLgOTpqSZxPUzRzZkRaBv17U&language=es';
			$data['js'][] = 'js/reclamos/map.js';
			$this->load_template('reclamos/reclamos/reclamos_abm', $data);
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
			$reclamo = $this->reclamos_model->get(array('id' => $id,
				'join' => array(array(
						'type' => 'left', 'table' => 'rc_solicitantes',
						'where' => 'rc_incidentes.solicitante_id=rc_solicitantes.id',
						'columnas' => array('rc_solicitantes.dni as solicitante')
					))
			));
			if (empty($reclamo))
			{
				show_404();
			}

			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				if (!in_array($reclamo->distrito_id, $this->usuario_distritos))
				{
					$this->session->set_flashdata('error', 'No puede ver reclamos de un distrito no asignado. Contacte al administrador.');
					redirect("reclamos/reclamos/listar", 'refresh');
				}
			}

			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				if (!in_array($reclamo->grupo_id, $this->usuario_grupos))
				{
					$this->session->set_flashdata('error', 'No puede ver reclamos de un grupo no asignado. Contacte al administrador.');
					redirect("reclamos/reclamos/listar", 'refresh');
				}
			}

			$this->load->model('distritos_model');
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
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->reclamos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $reclamo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['reclamo'] = $reclamo;
			$observaciones = $this->observaciones_reclamos_model->get(array('incidente_id' => $reclamo->id,
				'join' => array(
					array('type' => 'left', 'table' => 'users', 'where' => 'rc_observaciones_incidentes.user_id=users.id', 'columnas' => array('users.username', 'users.first_name', 'users.last_name')),
					array('type' => 'left', 'table' => 'rc_grupos', 'where' => 'rc_observaciones_incidentes.grupo_id=rc_grupos.id', 'columnas' => array('rc_grupos.nombre as grupo')),
				),
				'sort_by' => 'rc_observaciones_incidentes.fecha DESC, rc_observaciones_incidentes.id DESC'
			));
			$this->load->model('reclamos/documentos_model');
			$archivos_timeline = $this->documentos_model->get(array('incidente_id' => $reclamo->id,
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
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver reclamo';
			$data['js'][] = 'js/reclamos/reclamos-varios.js';
			$data['js'][] = 'https://maps.google.com/maps/api/js?key=AIzaSyAUWE6x_ZRqLgOTpqSZxPUzRzZkRaBv17U&language=es';
			$data['js'][] = 'plugins/lightbox/js/ekko-lightbox.min.js';
			$data['js'][] = 'js/reclamos/map.js';
			$this->load_template('reclamos/reclamos/reclamos_abm', $data);
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
/* End of file Reclamos.php */
/* Location: ./application/modules/reclamos/controllers/Reclamos.php */
