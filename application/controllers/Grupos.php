<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Grupos_model');
		$this->grupos_permitidos = array('admin');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Grupo', 'data' => 'name', 'width' => 30, 'responsive_class' => 'all'),
					array('label' => 'Descripción', 'data' => 'description', 'width' => 65),
					array('label' => '', 'data' => 'view', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'grupos_table',
				'source_url' => 'grupos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = TITLE . ' - Grupos';
			$this->load_template('grupos/grupos_listar', $data);
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
				->select('id, name, description')
				->unset_column('id')
				->from('groups')
				->add_column('view', '<a href="grupos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
			$this->set_model_validation_rules($this->Grupos_model);
			if ($this->form_validation->run() === TRUE)
			{
				if ($this->Grupos_model->create(
						array(
							'name' => $this->input->post('name'),
							'description' => $this->input->post('description')
					)))
				{
					$this->session->set_flashdata('message', $this->Grupos_model->get_msg());
					redirect('grupos/listar', 'refresh');
				}
			}

			$data['error'] = (validation_errors()) ? validation_errors() : $this->Grupos_model->get_error();
			$data['fields'] = array();
			foreach ($this->Grupos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field);
				}
				elseif ($field['input_type'] == 'combo')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']});
				}
			}

			$data['txt_btn'] = 'Agregar';
			$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
			$data['title'] = TITLE . ' - Agregar grupo';
			$this->load_template('grupos/grupos_abm', $data);
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
			$this->set_model_validation_rules($this->Grupos_model);
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if ($this->form_validation->run() === TRUE)
				{
					if ($this->Grupos_model->update(array(
							'id' => $this->input->post('id'),
							'name' => $this->input->post('name'),
							'description' => $this->input->post('description')
						)))
					{
						$this->session->set_flashdata('message', $this->Grupos_model->get_msg());
						redirect('grupos/listar', 'refresh');
					}
				}
			}
			$data['error'] = (validation_errors()) ? validation_errors() : $this->Grupos_model->get_error();
			$grupo = $this->Grupos_model->get(array('id' => $id));
			if (empty($grupo))
			{
				show_404();
			}

			$data['fields'] = array();
			foreach ($this->Grupos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $grupo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $grupo->{isset($field['id_name']) ? $field['id_name'] : $field['name'] . '_id'});
				}
			}

			$data['grupo'] = $grupo;
			$data['txt_btn'] = 'Guardar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = TITLE . ' - Editar grupo';
			$this->load_template('grupos/grupos_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function eliminar($id = NULL)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if ($this->Grupos_model->delete(array('id' => $this->input->post('id'))))
				{
					$this->session->set_flashdata('message', $this->Grupos_model->get_msg());
					redirect('grupos/listar', 'refresh');
				}
			}
			$data['error'] = (validation_errors()) ? validation_errors() : $this->Grupos_model->get_error();
			$grupo = $this->Grupos_model->get(array('id' => $id));
			if (empty($grupo))
			{
				show_404();
			}

			$data['fields'] = array();
			foreach ($this->Grupos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $grupo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $grupo->{isset($field['id_name']) ? $field['id_name'] : $field['name'] . '_id'});
				}
			}

			$data['grupo'] = $grupo;
			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = TITLE . ' - Eliminar grupo';
			$this->load_template('grupos/grupos_abm', $data);
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
			$grupo = $this->Grupos_model->get(array('id' => $id));
			if (empty($grupo))
			{
				show_404();
			}

			$data['fields'] = array();
			foreach ($this->Grupos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $grupo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $grupo->{isset($field['id_name']) ? $field['id_name'] : $field['name'] . '_id'});
				}
			}

			$data['grupo'] = $grupo;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = TITLE . ' - Ver grupo';
			$this->load_template('grupos/grupos_abm', $data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Grupos.php */
/* Location: ./application/controllers/Grupos.php */