<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Distritos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('distritos_model');
		$this->grupos_permitidos = array('admin');
		$this->grupos_solo_consulta = array('general_consulta_general');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'distritos.nombre', 'width' => 70),
					array('label' => 'Cód Postal', 'data' => 'codigo_postal', 'sort' => 'distritos.codigo_postal', 'width' => 25),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'distritos_table',
				'source_url' => 'distritos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = TITLE . ' - Distritos';
			$this->load_template('distritos/distritos_listar', $data);
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
				->select('distritos.id, distritos.nombre, distritos.codigo_postal')
				->unset_column('id')
				->from('distritos')
				->add_column('edit', '<a href="distritos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("distritos/listar", 'refresh');
			}
			$this->set_model_validation_rules($this->distritos_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->distritos_model->create(array(
					'nombre' => $this->input->post('nombre'),
					'codigo_postal' => $this->input->post('codigo_postal')
					), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->distritos_model->get_msg());
					redirect('distritos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->distritos_model->get_error())
					{
						$error_msg .='<br>' . $this->distritos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->distritos_model->fields as $field)
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
			$data['title'] = TITLE . ' - Agregar distrito';
			$this->load_template('distritos/distritos_abm', $data);
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
				redirect("distritos/ver/$id", 'refresh');
			}
			$distrito = $this->distritos_model->get(array('id' => $id));
			if (empty($distrito))
			{
				show_404();
			}
			$this->set_model_validation_rules($this->distritos_model);
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if ($this->form_validation->run() === TRUE)
				{
					$this->db->trans_begin();
					$trans_ok = TRUE;
					$trans_ok&= $this->distritos_model->update(array(
						'id' => $this->input->post('id'),
						'nombre' => $this->input->post('nombre'),
						'codigo_postal' => $this->input->post('codigo_postal')
						), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->distritos_model->get_msg());
						redirect('distritos/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->distritos_model->get_error())
						{
							$error_msg .='<br>' . $this->distritos_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->distritos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $distrito->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $distrito->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['distrito'] = $distrito;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = TITLE . ' - Editar distrito';
			$this->load_template('distritos/distritos_abm', $data);
		}
		else
			show_404();
	}

	public function eliminar($id = NULL)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			if (in_groups($this->grupos_solo_consulta, $this->grupos))
			{
				$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
				redirect("distritos/ver/$id", 'refresh');
			}
			$distrito = $this->distritos_model->get(array('id' => $id));
			if (empty($distrito))
			{
				show_404();
			}
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->distritos_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->distritos_model->get_msg());
					redirect('distritos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->distritos_model->get_error())
					{
						$error_msg .='<br>' . $this->distritos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->distritos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $distrito->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $distrito->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['distrito'] = $distrito;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = TITLE . ' - Eliminar distrito';
			$this->load_template('distritos/distritos_abm', $data);
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
			$distrito = $this->distritos_model->get(array('id' => $id));
			if (empty($distrito))
			{
				show_404();
			}
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->distritos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $distrito->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $distrito->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['distrito'] = $distrito;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = TITLE . ' - Ver distrito';
			$this->load_template('distritos/distritos_abm', $data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Distritos.php */
/* Location: ./application/controllers/Distritos.php */