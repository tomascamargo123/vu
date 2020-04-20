<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requerimientos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('requerimientos_model');
		$this->grupos_permitidos = array('admin');
		$this->grupos_solo_consulta = array('expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
	}

	public function listar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$tableData = array(
			'columns' => array(
				array('label' => 'Mensaje', 'data' => 'mensaje', 'sort' => 'aviso.mensaje', 'width' => 40),
				array('label' => 'Estado', 'data' => 'estado', 'sort' => 'aviso.estado', 'width' => 10),
				array('label' => 'Importancia', 'data' => 'importancia', 'sort' => 'aviso.importancia', 'width' => 10),
				array('label' => 'Usuario', 'data' => 'usuario', 'sort' => 'usuario.DetaUsua', 'width' => 10),
				array('label' => 'Fecha', 'data' => 'audi_fecha', 'sort' => 'audi_fecha', 'width' => 15),
				array('label' => 'Solicitante', 'data' => 'solicitante', 'sort' => 'solicitante', 'width' => 10),
				array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'requerimientos_table',
			'source_url' => 'requerimientos/listar_data',
			'order' => array(array(4, 'desc')),
			'initComplete' => 'function () { changeStyles(); }'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Requerimientos - Listar';
		$data['admin'] = TRUE;
		$this->load_template('requerimientos/requerimientos_listar', $data);
	}

	public function listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('aviso.id, aviso.mensaje, aviso.usuario, 
			(CASE aviso.estado 
			WHEN 0 THEN \'Pendiente\' 
			WHEN 1 THEN \'En proceso\' 
			WHEN 2 THEN \'Resuelto\' 
			ELSE \'Rechazado\' END) as estado, 
			(CASE aviso.importancia 
			WHEN 0 THEN \'Baja\' 
			WHEN 1 THEN \'Moderada\' 
			ELSE \'Alta\' END) as importancia,
			aviso.audi_fecha, aviso.solicitante')
			->unset_column('id')
			->from("$this->sigmu_schema.aviso")
			->add_column('edit', '<a href="requerimientos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
			redirect("requerimientos/listar", 'refresh');
		}
		$this->load->model('expedientes/oficinas_model');
		$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$this->array_importancia_control = $array_importancia = array('0' => 'Baja', '1' => 'Moderada', '2' => 'Alta');
		$this->array_estado_control = $array_estado = array('0' => 'Pendiente', '1' => 'En proceso', '2' => 'Resuelto', '3' => 'Rechazado');
		$this->set_model_validation_rules($this->requerimientos_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->requerimientos_model->create(array(
				'mensaje' => $this->input->post('mensaje'),
				'detalle' => $this->input->post('detalle'),
				'activo' => $this->input->post('activo'),
				'estado' => $this->input->post('estado'),
				'importancia' => $this->input->post('importancia'),
				'usuario' => $this->session->userdata('CodiUsua'),
				'solicitante' => $this->session->userdata('CodiUsua')
			));
				
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->requerimientos_model->get_msg());
				redirect('requerimientos/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->requerimientos_model->get_error() ? $this->requerimientos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->requerimientos_model->fields as $field)
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
		$data['title'] = 'Requerimientos - Agregar';
		$this->load_template('requerimientos/requerimientos_abm', $data);
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
			redirect("requerimientos/ver/$id", 'refresh');
		}
		$requerimientos = $this->requerimientos_model->get(array('id' => $id));
		if (empty($requerimientos))
		{
			show_404();
		}
		$this->load->model('expedientes/oficinas_model');
		$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$this->array_importancia_control = $array_importancia = array('0' => 'Baja', '1' => 'Moderada', '2' => 'Alta');
		$this->array_estado_control = $array_estado = array('0' => 'Pendiente', '1' => 'En proceso', '2' => 'Resuelto', '3' => 'Rechazado');
		$this->set_model_validation_rules($this->requerimientos_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->requerimientos_model->update(array(
					'id' => $this->input->post('id'),
					'mensaje' => $this->input->post('mensaje'),
					'detalle' => $this->input->post('detalle'),
					'activo' => $this->input->post('activo'),
					'estado' => $this->input->post('estado'),
					'importancia' => $this->input->post('importancia'),
					'usuario' => $this->session->userdata('CodiUsua'),
				));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->requerimientos_model->get_msg());
					redirect('requerimientos/listar', 'refresh');
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->requerimientos_model->get_error() ? $this->requerimientos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->requerimientos_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $requerimientos->{$field['name']});
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $requerimientos->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['requerimientos'] = $requerimientos;

		$data['txt_btn'] = 'Editar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['title'] = 'Requerimientos - Editar';
		$this->load_template('requerimientos/requerimientos_abm', $data);
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
			redirect("requerimientos/ver/$id", 'refresh');
		}
		$requerimientos = $this->requerimientos_model->get(array('id' => $id));
		if (empty($requerimientos))
		{
			show_404();
		}

		$this->load->model('expedientes/oficinas_model');
		$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$this->array_importancia_control = $array_importancia = array('0' => 'Baja', '1' => 'Moderada', '2' => 'Alta');
		$this->array_estado_control = $array_estado = array('0' => 'Pendiente', '1' => 'En proceso', '2' => 'Resuelto', '3' => 'Rechazado');
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			$trans_ok = TRUE;
			$trans_ok&= $this->requerimientos_model->delete(array('id' => $this->input->post('id')));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->requerimientos_model->get_msg());
				redirect('requerimientos/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->requerimientos_model->get_error() ? $this->requerimientos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->requerimientos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $requerimientos->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $requerimientos->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['requerimientos'] = $requerimientos;
		$data['txt_btn'] = 'Eliminar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
		$data['title'] = 'Requerimientos - Eliminar';
		$this->load_template('requerimientos/requerimientos_abm', $data);
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$requerimientos = $this->requerimientos_model->get(array('id' => $id));
		if (empty($requerimientos))
		{
			show_404();
		}

		$this->load->model('expedientes/oficinas_model');
		$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$this->array_importancia_control = $array_importancia = array('0' => 'Baja', '1' => 'Moderada', '2' => 'Alta');
		$this->array_estado_control = $array_estado = array('0' => 'Pendiente', '1' => 'En proceso', '2' => 'Resuelto', '3' => 'Rechazado');
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->requerimientos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $requerimientos->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $requerimientos->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['requerimientos'] = $requerimientos;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Requerimientos - Ver';
		$this->load_template('requerimientos/requerimientos_abm', $data);
	}

	public function listar_personales(){
		if (!in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$tableData = array(
			'columns' => array(
				array('label' => 'Mensaje', 'data' => 'mensaje', 'sort' => 'aviso.mensaje', 'width' => 40),
				array('label' => 'Fecha', 'data' => 'audi_fecha', 'sort' => 'audi_fecha', 'width' => 15),
				array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'requerimientos_table',
			'source_url' => 'requerimientos/listar_data_personales',
			'initComplete' => 'function () { changeStyles(); }'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Requerimientos - Listar';
		$data['admin'] = FALSE;
		$this->load_template('requerimientos/requerimientos_listar', $data);
	}

	public function listar_data_personales()
	{
		if (!in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('aviso.id, aviso.mensaje, aviso.audi_fecha')
			->unset_column('id')
			->from("$this->sigmu_schema.aviso")
			->where('aviso.solicitante', $this->session->userdata('CodiUsua'))
			->add_column('edit', '<a href="requerimientos/editar_personales/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

		echo $this->datatables->generate();
	}

	public function agregar_personales()
	{
		if (!in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->set_model_validation_rules($this->requerimientos_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->requerimientos_model->create(array(
				'mensaje' => $this->input->post('mensaje'),
				'usuario' => $this->session->userdata('CodiUsua'),
				'solicitante' => $this->session->userdata('CodiUsua')
			));
				
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->requerimientos_model->get_msg());
				redirect('requerimientos/listar_personales', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->requerimientos_model->get_error() ? $this->requerimientos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		$requerimientos_fields = $this->requerimientos_model->fields;
		
		for($x = 1; $x < 5; $x++){
			unset($requerimientos_fields[$x]);
		}
		foreach ($requerimientos_fields as $field)
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
		$data['admin'] = FALSE;
		$data['txt_btn'] = 'Agregar';
		$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
		$data['title'] = 'Requerimientos - Agregar';
		$this->load_template('requerimientos/requerimientos_abm', $data);
	}

	public function editar_personales($id = NULL)
	{
		if (!in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$requerimientos = $this->requerimientos_model->get(array('id' => $id));
		
		if (empty($requerimientos))
		{
			show_404();
		}
		$this->set_model_validation_rules($this->requerimientos_model);

		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->requerimientos_model->update(array(
					'id' => $this->input->post('id'),
					'mensaje' => $this->input->post('mensaje'),
					'usuario' => $this->session->userdata('CodiUsua'),
				));

				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->requerimientos_model->get_msg());
					redirect('requerimientos/listar_personales', 'refresh');
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->requerimientos_model->get_error() ? $this->requerimientos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		$requerimientos_fields = $this->requerimientos_model->fields;
		
		for($x = 1; $x < 5; $x++){
			unset($requerimientos_fields[$x]);
		}
		foreach ($requerimientos_fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $requerimientos->{$field['name']});
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $requerimientos->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['requerimientos'] = $requerimientos;
		$data['admin'] = FALSE;
		$data['txt_btn'] = 'Editar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['title'] = 'Requerimientos - Editar';
		$this->load_template('requerimientos/requerimientos_abm', $data);
	}

	public function eliminar_personales($id = NULL)
	{
		if (!in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$requerimientos = $this->requerimientos_model->get(array('id' => $id));
		if (empty($requerimientos))
		{
			show_404();
		}

		$this->set_model_validation_rules($this->requerimientos_model);

		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			$trans_ok = TRUE;
			$trans_ok&= $this->requerimientos_model->delete(array('id' => $this->input->post('id')));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->requerimientos_model->get_msg());
				redirect('requerimientos/listar_personales', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->requerimientos_model->get_error() ? $this->requerimientos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		$requerimientos_fields = $this->requerimientos_model->fields;
		
		for($x = 1; $x < 5; $x++){
			unset($requerimientos_fields[$x]);
		}
		foreach ($requerimientos_fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $requerimientos->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $requerimientos->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['admin'] = TRUE;
		$data['requerimientos'] = $requerimientos;
		$data['txt_btn'] = 'Eliminar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
		$data['title'] = 'Requerimientos - Eliminar';
		$this->load_template('requerimientos/requerimientos_abm', $data);
	}
}
/* End of file Avisos.php */
/* Location: ./application/modules/expedientes/controllers/Avisos.php */