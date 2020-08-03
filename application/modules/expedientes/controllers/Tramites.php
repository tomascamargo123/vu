<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tramites extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/tramites_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
		$this->grupos_ajax = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
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
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'tramite.nombre', 'width' => 45),
				array('label' => 'Estado', 'data' => 'estado', 'sort' => 'tramite.estado', 'width' => 15),
				array('label' => 'Tipo', 'data' => 'tipo', 'sort' => 'tramite.tipo', 'width' => 15),
                                array('label' => 'Plantillas', 'data' => 'add', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false'),
				array('label' => 'Opciones', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'tramites_table',
			'source_url' => 'expedientes/tramites/listar_data'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Trámites';
		$this->load_template('expedientes/tramites/tramites_listar', $data);
	}

	public function listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('tramite.id, (CASE tramite.estado WHEN 0 THEN \'Deshabilitado\' ELSE \'Habilitado\' END) as estado, tramite.nombre, (CASE tramite.tipo WHEN 0 THEN \'Externo\' ELSE \'Interno\' END) as tipo, IF(tramite.digital = TRUE, \'\',\'display: none\') as show_circuito')
			->unset_column('id')
			->from("$this->sigmu_schema.tramite")
			->where("tramite.organigrama", $this->session->userdata('organigrama'))
			->add_column('add', '<a href="expedientes/circuitos/listar/$1" title="Circuito ($2)" style="$3"><i class="fa fa-sitemap"></i></a>', 'id,nombre,show_circuito')
			->add_column('edit', '<a href="expedientes/tramites/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

		echo $this->datatables->generate();
	}

	public function agregar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/tramites/listar", 'refresh');
		}
		$this->load->model('expedientes/plantillas_model');
		$this->array_plantilla_control = $array_plantilla = $this->get_array('plantillas', 'nombre', 'id', null, array('NULL' => '-- Sin plantilla --'));
		$this->array_estado_control = $array_estado = array('-1' => '-- Seleccionar estado --', '0' => 'Deshabilitado', '1' => 'Habilitado');
		unset($this->array_estado_control['-1']);
		$this->array_tipo_control = $array_tipo = array('-1' => '-- Seleccionar tipo --', '0' => 'Externo', '1' => 'Interno');
		unset($this->array_tipo_control['-1']);
		$this->set_model_validation_rules($this->tramites_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->tramites_model->create(array(
				'estado' => $this->input->post('estado'),
				'nombre' => $this->input->post('nombre'),
				'tipo' => $this->input->post('tipo'),
				'digital' => ($this->input->post('digital') == 'on' ? '1' : '0'),
				'organigrama' => $this->session->userdata('organigrama')
			));

			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->tramites_model->get_msg());
				redirect('expedientes/tramites/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->tramites_model->get_error() ? $this->tramites_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->tramites_model->fields as $field)
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

		$data['txt_btn'] = 'Agregar';
		$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
		$data['habilitar_check'] = 1;
		$data['title'] = 'Expedientes - Trámites - Agregar';
		$this->load_template('expedientes/tramites/tramites_abm', $data);
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
			redirect("expedientes/tramites/ver/$id", 'refresh');
		}
		$tramite = $this->tramites_model->get(array('id' => $id));
		if (empty($tramite))
		{
			$this->session->set_flashdata('error', 'No se puede editar, el trámite no existe');
			redirect("expedientes/tramites/listar", 'refresh');
		}
		$this->load->model('expedientes/plantillas_model');
		$this->array_plantilla_control = $array_plantilla = $this->get_array('plantillas', 'nombre', 'id', null, array('NULL' => '-- Sin plantilla --'));
		$this->array_estado_control = $array_estado = array('0' => 'Deshabilitado', '1' => 'Habilitado');
		$this->array_tipo_control = $array_tipo = array('0' => 'Externo', '1' => 'Interno');
		$this->set_model_validation_rules($this->tramites_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->tramites_model->update(array(
					'id' => $this->input->post('id'),
					'estado' => $this->input->post('estado'),
					'nombre' => $this->input->post('nombre'),
					'tipo' => $this->input->post('tipo'),
					'digital' => ($this->input->post('digital') == 'on' ? '1' : '0'),
				));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->tramites_model->get_msg());
					redirect('expedientes/tramites/listar', 'refresh');
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->tramites_model->get_error() ? $this->tramites_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->tramites_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $tramite->{$field['name']});
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $tramite->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['tramite'] = $tramite;

		$data['txt_btn'] = 'Guardar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['habilitar_check'] = 1;
		$data['title'] = 'Expedientes - Trámites - Editar';
		$this->load_template('expedientes/tramites/tramites_abm', $data);
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
			redirect("expedientes/tramites/ver/$id", 'refresh');
		}
		$tramite = $this->tramites_model->get(array('id' => $id));
		if (empty($tramite))
		{
			$this->session->set_flashdata('error', 'No se puede eliminar, el trámite no existe');
			redirect("expedientes/tramites/listar", 'refresh');
		}

		$this->load->model('expedientes/plantillas_model');
		$array_plantilla = $this->get_array('plantillas', 'nombre', 'id', null, array('NULL' => '-- Sin plantilla --'));
		$array_estado = array('0' => 'Deshabilitado', '1' => 'Habilitado');
		$array_tipo = array('0' => 'Externo', '1' => 'Interno');
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			$trans_ok = TRUE;
			$trans_ok&= $this->tramites_model->delete(array('id' => $this->input->post('id')));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->tramites_model->get_msg());
				redirect('expedientes/tramites/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->tramites_model->get_error() ? $this->tramites_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->tramites_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $tramite->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $tramite->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['tramite'] = $tramite;

		$data['txt_btn'] = 'Eliminar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
		$data['habilitar_check'] = 0;
		$data['title'] = 'Expedientes - Trámites - Eliminar';
		$this->load_template('expedientes/tramites/tramites_abm', $data);
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$tramite = $this->tramites_model->get(array('id' => $id));
		if (empty($tramite))
		{
			$this->session->set_flashdata('error', 'El trámite no existe');
			redirect("expedientes/tramites/listar", 'refresh');
		}

		$this->load->model('expedientes/plantillas_model');
		$array_plantilla = $this->get_array('plantillas', 'nombre', 'id', null, array('NULL' => '-- Sin plantilla --'));
		$array_estado = array('0' => 'Deshabilitado', '1' => 'Habilitado');
		$array_tipo = array('0' => 'Externo', '1' => 'Interno');
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->tramites_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $tramite->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $tramite->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['tramite'] = $tramite;
		$data['txt_btn'] = NULL;
		$data['habilitar_check'] = 0;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Expedientes - Trámites - Ver';
		$this->load_template('expedientes/tramites/tramites_abm', $data);
	}

	public function get_tramites()
	{
		if (!in_groups($this->grupos_ajax, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->form_validation->set_rules('tipo_tramite', 'Tipo trámite', 'required');
		if ($this->form_validation->run() === TRUE && $this->input->post('tipo_tramite') !== '0')
		{
			$options = array();
			$options['estado'] = 1;
			$tipo_tramite = $this->input->post('tipo_tramite');
			if ($tipo_tramite === 'I')
			{
				$options['tipo'] = 1;
				$options['digital'] = 0;
			}
			else if ($tipo_tramite === 'E')
			{
				$options['tipo'] = 0;
				$options['digital'] = 0;
			} 
			else if ($tipo_tramite === 'ID'){
				$options['tipo'] = 1;
				$options['digital'] = 1;
			 } 
			else {
				$options['tipo'] = 0;
				$options['digital'] = 1;
			} 
			$options['organigrama'] = $this->session->userdata('organigrama');
			$options['sort_by'] = 'nombre';
			$tramites = $this->tramites_model->get($options);
			$array_tramites = array();
			if (!empty($tramites))
			{
				foreach ($tramites as $Tramite)
				{
					$array_tramites[$Tramite->nombre] = $Tramite->id;
				}
			}
			echo json_encode($array_tramites);
		}
		else
		{
			echo json_encode(array());
		}
	}

	public function verificarTipo($id = NULL){
		if($id != NULL){
			$this->load->model('expedientes/tramites_model');
			$tipo = $this->tramites_model->get(array('id' => $id));
			echo $tipo->tipo;
		}
	}
}
/* End of file Tramites.php */
/* Location: ./application/modules/expedientes/controllers/Tramites.php */