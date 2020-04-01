<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Avisos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/avisos_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
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
				array('label' => 'Mensaje', 'data' => 'mensaje', 'sort' => 'aviso.mensaje', 'width' => 60),
				array('label' => 'Activo', 'data' => 'activo', 'sort' => 'activo', 'width' => 10),
				array('label' => 'Oficina', 'data' => 'oficina', 'sort' => 'oficina.nombre', 'width' => 25),
				array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'avisos_table',
			'source_url' => 'expedientes/avisos/listar_data'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Avisos';
		$this->load_template('expedientes/avisos/avisos_listar', $data);
	}

	public function listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('aviso.id, aviso.mensaje, (CASE aviso.activo WHEN 0 THEN \'Inactivo\' ELSE \'Activo\' END) as activo, aviso.oficina_id, (COALESCE(oficina.nombre, \'Todas las oficinas\')) as oficina')
			->unset_column('id')
			->from("$this->sigmu_schema.aviso")
			->join("$this->sigmu_schema.oficina", 'oficina.id = aviso.oficina_id', 'left')
			->add_column('edit', '<a href="expedientes/avisos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
			redirect("expedientes/avisos/listar", 'refresh');
		}
		$this->load->model('expedientes/oficinas_model');
		$this->array_oficina_control = $array_oficina = $this->get_array('oficinas', 'nombre', 'id', array('where' => array(array('column' => 'id >', 'value' => '0'))), array('NULL' => '-- Todas las oficinas --'));
		$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$this->set_model_validation_rules($this->avisos_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->avisos_model->create(array(
				'mensaje' => $this->input->post('mensaje'),
				'activo' => $this->input->post('activo'),
				'oficina_id' => $this->input->post('oficina')));

			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->avisos_model->get_msg());
				redirect('expedientes/avisos/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->avisos_model->get_error() ? $this->avisos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->avisos_model->fields as $field)
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
		$data['title'] = 'Expedientes - Avisos - Agregar';
		$this->load_template('expedientes/avisos/avisos_abm', $data);
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
			redirect("expedientes/avisos/ver/$id", 'refresh');
		}
		$aviso = $this->avisos_model->get(array('id' => $id));
		if (empty($aviso))
		{
			show_404();
		}
		$this->load->model('expedientes/oficinas_model');
		$this->array_oficina_control = $array_oficina = $this->get_array('oficinas', 'nombre', 'id', array('where' => array(array('column' => 'id >', 'value' => '0'))), array('NULL' => '-- Todas las oficinas --'));
		$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$this->set_model_validation_rules($this->avisos_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->avisos_model->update(array(
					'id' => $this->input->post('id'),
					'mensaje' => $this->input->post('mensaje'),
					'activo' => $this->input->post('activo'),
					'oficina_id' => $this->input->post('oficina')));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->avisos_model->get_msg());
					redirect('expedientes/avisos/listar', 'refresh');
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->avisos_model->get_error() ? $this->avisos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->avisos_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $aviso->{$field['name']});
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $aviso->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['aviso'] = $aviso;

		$data['txt_btn'] = 'Editar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['title'] = 'Expedientes - Avisos - Editar';
		$this->load_template('expedientes/avisos/avisos_abm', $data);
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
			redirect("expedientes/avisos/ver/$id", 'refresh');
		}
		$aviso = $this->avisos_model->get(array('id' => $id));
		if (empty($aviso))
		{
			show_404();
		}

		$this->load->model('expedientes/oficinas_model');
		$array_oficina = $this->get_array('oficinas', 'nombre', 'id', array('where' => array(array('column' => 'id >', 'value' => '0'))), array('NULL' => '-- Todas las oficinas --'));
		$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			$trans_ok = TRUE;
			$trans_ok&= $this->avisos_model->delete(array('id' => $this->input->post('id')));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->avisos_model->get_msg());
				redirect('expedientes/avisos/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->avisos_model->get_error() ? $this->avisos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->avisos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $aviso->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $aviso->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['aviso'] = $aviso;
		$data['txt_btn'] = 'Eliminar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
		$data['title'] = 'Expedientes - Avisos - Eliminar';
		$this->load_template('expedientes/avisos/avisos_abm', $data);
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$aviso = $this->avisos_model->get(array('id' => $id));
		if (empty($aviso))
		{
			show_404();
		}

		$this->load->model('expedientes/oficinas_model');
		$array_oficina = $this->get_array('oficinas', 'nombre', 'id', array('where' => array(array('column' => 'id >', 'value' => '0'))), array('NULL' => '-- Todas las oficinas --'));
		$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->avisos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $aviso->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $aviso->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['aviso'] = $aviso;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Expedientes - Avisos - Ver';
		$this->load_template('expedientes/avisos/avisos_abm', $data);
	}
}
/* End of file Avisos.php */
/* Location: ./application/modules/expedientes/controllers/Avisos.php */