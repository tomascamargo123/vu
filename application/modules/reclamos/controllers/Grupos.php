<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->modulo = 'reclamos';
		$this->load->model('reclamos/grupos_model');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_grupos.nombre', 'width' => 80, 'responsive_class' => 'all'),
					array('label' => 'Activo', 'data' => 'activo', 'sort' => 'activo', 'width' => 15),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'grupos_table',
				'source_url' => 'reclamos/grupos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Grupos';
			$this->load_template('reclamos/grupos/grupos_listar', $data);
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
				->select('rc_grupos.id, rc_grupos.nombre, (CASE rc_grupos.activo WHEN 1 THEN "Activo" WHEN 0 THEN "Inactivo" END) as activo')
				->unset_column('id')
				->from('rc_grupos')
				->add_column('edit', '<a href="reclamos/grupos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/grupos/listar", 'refresh');
			}
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$this->set_model_validation_rules($this->grupos_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->grupos_model->create(array(
					'nombre' => $this->input->post('nombre'),
					'activo' => $this->input->post('activo')
					), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->grupos_model->get_msg());
					redirect('reclamos/grupos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->grupos_model->get_error())
					{
						$error_msg .='<br>' . $this->grupos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->grupos_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar grupo';
			$this->load_template('reclamos/grupos/grupos_abm', $data);
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
				redirect("reclamos/grupos/ver/$id", 'refresh');
			}
			$grupo = $this->grupos_model->get(array('id' => $id));
			if (empty($grupo))
			{
				show_404();
			}
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$this->set_model_validation_rules($this->grupos_model);
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
					$trans_ok&= $this->grupos_model->update(array(
						'id' => $this->input->post('id'),
						'nombre' => $this->input->post('nombre'),
						'activo' => $this->input->post('activo')
						), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->grupos_model->get_msg());
						redirect('reclamos/grupos/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->grupos_model->get_error())
						{
							$error_msg .='<br>' . $this->grupos_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->grupos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $grupo->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $grupo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['grupo'] = $grupo;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar grupo';
			$this->load_template('reclamos/grupos/grupos_abm', $data);
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
				redirect("reclamos/grupos/ver/$id", 'refresh');
			}
			$grupo = $this->grupos_model->get(array('id' => $id));
			if (empty($grupo))
			{
				show_404();
			}
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->grupos_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->grupos_model->get_msg());
					redirect('reclamos/grupos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->grupos_model->get_error())
					{
						$error_msg .='<br>' . $this->grupos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->grupos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $grupo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $grupo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['grupo'] = $grupo;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar grupo';
			$this->load_template('reclamos/grupos/grupos_abm', $data);
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
			$grupo = $this->grupos_model->get(array('id' => $id));
			if (empty($grupo))
			{
				show_404();
			}
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->grupos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $grupo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $grupo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['grupo'] = $grupo;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver grupo';
			$this->load_template('reclamos/grupos/grupos_abm', $data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Grupos.php */
/* Location: ./application/modules/reclamos/controllers/Grupos.php */