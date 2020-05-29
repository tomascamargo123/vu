<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oficinas extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->load->model('expedientes/oficinas_model');
		$this->ventanillas = $this->oficinas_model->get_ventanillas();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->grupos_admin = array('admin');
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
				array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 10),
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'oficina.nombre', 'width' => 45),
				#array('label' => 'Emisora de pases', 'data' => 'emisora_pase', 'sort' => 'oficina.emisora_pase', 'width' => 10),
				#array('label' => 'Receptora de pases', 'data' => 'receptora_pase', 'sort' => 'oficina.receptora_pase', 'width' => 10),
				array('label' => 'Inicia expediente', 'data' => 'inicia_expediente', 'sort' => 'oficina.inicia_expediente', 'width' => 10),
				array('label' => 'Estado', 'data' => 'proceso_usuario', 'sort' => 'oficina.proceso_usuario', 'width' => 10),
				array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'oficinas_table',
			'source_url' => 'expedientes/oficinas/listar_data',
			'order' => array(array(1, 'asc')),
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Oficinas';
		$this->load_template('expedientes/oficinas/oficinas_listar', $data);
	}

	public function listar_data($solo_habilitados = FALSE)
	{
		$data = $this->input->post('data');
		if (!in_groups($this->grupos_ajax, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('oficina.id, oficina.nombre, (CASE oficina.emisora_pase WHEN 1 THEN \'Si\' ELSE \'No\' END) 
			AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN \'Si\' ELSE \'No\' END) AS receptora_pase, 
			(CASE oficina.proceso_usuario WHEN \'A\' THEN \'Habilitada\' ELSE \'Deshabilitada\' END) AS proceso_usuario, 
			(CASE oficina.inicia_expediente WHEN 1 THEN \'Si\' ELSE \'No\' END) as inicia_expediente')
			->unset_column('id')
			->from("$this->sigmu_schema.oficina");
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
			->add_column('edit', '<a href="expedientes/oficinas/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id')
			->add_column('select_solicitante', '<a data-dismiss="modal" href="" onclick="$(\'#persona_id\').val(\'$1\');$(\'#caratula\').val(\'$2\');$(\'#caratula\').focus();$(\'#btn_buscar_oficina_solicitante\').focus();"title="Seleccionar"><i class="fa fa-check"></i></a>', 'id, nombre')
			->add_column('select_destino', '<a data-dismiss="modal" href="" onclick="$(\'#oficina_id\').val(\'$1\');$(\'#oficina\').val(\'$2\');$(\'#oficina\').focus();$(\'#btn_buscar_oficina_destino\').focus();"title="Seleccionar"><i class="fa fa-check"></i></a>', 'id, nombre')
			->where('id>0')
			->where('organigrama', $this->session->userdata('organigrama'));
			if($solo_habilitados){
				$this->datatables
				->where('proceso_usuario','A');
			}

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
			redirect("expedientes/oficinas/listar", 'refresh');
		}
		$this->set_model_validation_rules($this->oficinas_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->oficinas_model->create(array(
				'id' => $this->input->post('id'),
				'nombre' => $this->input->post('nombre'),
				'emisora_pase' => ($this->input->post('emisora_pase') == 'on' ? 1 : NULL),
				'receptora_pase' => ($this->input->post('receptora_pase') == 'on' ? 1 : NULL),
				'inicia_expediente' => ($this->input->post('inicia_expediente') == 'on' ? 1 : NULL),
				'organigrama' => $this->session->userdata('organigrama'),
			));

			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->oficinas_model->get_msg());
				redirect('expedientes/oficinas/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->oficinas_model->get_error() ? $this->oficinas_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->oficinas_model->fields as $field)
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
		$data['title'] = 'Expedientes - Oficinas - Agregar';
		$this->load_template('expedientes/oficinas/oficinas_abm', $data);
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$oficina = $this->oficinas_model->get(array('id' => $id));
		if (empty($oficina))
		{
			show_404();
		}
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->oficinas_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $oficina->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $oficina->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['oficina'] = $oficina;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Expedientes - Oficinas - Ver';
		$this->load_template('expedientes/oficinas/oficinas_abm', $data);
	}

	public function editar($id = NULL)
	{
		if (!in_groups($this->grupos_admin, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$oficina = $this->oficinas_model->get(array('id' => $id));
		if (empty($oficina))
		{
			show_404();
		}
		$data['error'] = $this->session->flashdata('error');
		$this->set_model_validation_rules($this->oficinas_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}
			#var_dump($this->form_validation->run());die();
			
			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->oficinas_model->update(array(
					'id' => $this->input->post('id'),
					'nombre' => $this->input->post('nombre'),
					'emisora_pase' => ($this->input->post('emisora_pase') == 'on' ? 1 : 0),
					'receptora_pase' => ($this->input->post('receptora_pase') == 'on' ? 1 : 0),
					'inicia_expediente' => ($this->input->post('inicia_expediente') == 'on' ? 1 : 0),
				));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->oficinas_model->get_msg());
					redirect('expedientes/oficinas/listar', 'refresh');
				}
			}
		}
		$data['fields'] = array();
		foreach ($this->oficinas_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $oficina->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $oficina->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['editar'] = $oficina->inicia_expediente;
		$data['oficina'] = $oficina;
		$data['txt_btn'] = 'Guardar';
		$data['class'] = array('agregar' => '', 'editar' => 'active btn-app-zetta-active', 'ver' => '', 'eliminar' => '');
		$data['title'] = 'Expedientes - Oficinas - Editar';
		$this->load_template('expedientes/oficinas/oficinas_abm', $data);
	}

	public function deshabilitar($id = NULL){
		if (!in_groups($this->grupos_admin, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$oficina = $this->oficinas_model->get(array('id' => $id));
		if (empty($oficina))
		{
			show_404();
		}
		$data['error'] = $this->session->flashdata('error');
		$this->set_model_validation_rules($this->oficinas_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}
			
			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->oficinas_model->update(array(
					'id' => $this->input->post('id'),
					'proceso_usuario' => $this->input->post('estado'),
				));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->oficinas_model->get_msg());
					redirect('expedientes/oficinas/listar', 'refresh');
				}
			}
		}
		$data['oficina'] = $oficina;
		$data['txt_btn'] = 'Aceptar';
		$data['class'] = array('agregar' => '', 'editar' => '', 'ver' => '', 'deshabilitar' => 'active btn-app-zetta-active');
		$data['title'] = 'Expedientes - Oficinas - Deshabilitar';
		$this->load_template('expedientes/oficinas/oficinas_abm', $data);
	}

	public function get_oficina()
	{
		if (!in_groups($this->grupos_ajax, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->form_validation->set_rules('oficina_id', 'Número oficina', 'integer|required');
		$desde_ventanilla = FALSE;
		$a_ventanilla = FALSE;
		foreach($this->ventanillas as $val){
			if($this->session->userdata('oficina_actual_id') == $val['id']){
				$desde_ventanilla = TRUE;
			}
			if($this->input->post('oficina_id') == $val['id']){
				$a_ventanilla = TRUE;
			}
		}
		if ($this->form_validation->run() === TRUE)
		{
			
			$options = array();
			if($desde_ventanilla && $a_ventanilla){
				$options['id'] = $this->input->post('oficina_id');
				$options['proceso_usuario'] = 'A';
			} else {
				$options['id'] = $this->input->post('oficina_id');
				$options['proceso_usuario'] = 'A';
				$options['organigrama'] = $this->session->userdata('organigrama');
			}

			$oficinas = $this->oficinas_model->get($options);
			if (!empty($oficinas))
			{
				echo json_encode($oficinas);
			}
			else
			{
				echo json_encode(array());
			}
		}
		else
		{
			echo json_encode(array());
		}
	}
}
/* End of file Oficinas.php */
/* Location: ./application/modules/expedientes/controllers/Oficinas.php */