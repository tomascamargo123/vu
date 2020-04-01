<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciones_grupos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/asignaciones_grupos_model');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Usuario', 'data' => 'usuario', 'sort' => 'users.username', 'width' => 50, 'responsive_class' => 'all'),
					array('label' => 'Grupo', 'data' => 'grupo', 'sort' => 'rc_grupos.nombre', 'width' => 45),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'asignaciones_grupos_table',
				'source_url' => 'reclamos/asignaciones_grupos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Asignaciones de grupos';
			$this->load_template('reclamos/asignaciones_grupos/asignaciones_grupos_listar', $data);
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
				->select('rc_users_grupos.id, rc_users_grupos.user_id, rc_users_grupos.grupo_id, rc_grupos.nombre as grupo, users.username as usuario')
				->unset_column('id')
				->from('rc_users_grupos')
				->join('rc_grupos', 'rc_grupos.id = rc_users_grupos.grupo_id', 'left')
				->join('users', 'users.id = rc_users_grupos.user_id', 'left')
				->add_column('edit', '<a href="reclamos/asignaciones_grupos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/asignaciones_grupos/listar", 'refresh');
			}
			$this->load->model('reclamos/grupos_model');
			$this->load->model('usuarios_model');
			$this->array_grupo_control = $array_grupo = $this->get_array('grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			unset($this->array_grupo_control[0]);
			$this->array_user_control = $array_user = $this->get_array('usuarios', 'username', 'id', null, array(0 => '-- Seleccionar usuario --'));
			unset($this->array_user_control[0]);
			$this->set_model_validation_rules($this->asignaciones_grupos_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->asignaciones_grupos_model->create(array(
					'user_id' => $this->input->post('user'),
					'grupo_id' => $this->input->post('grupo')
					), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->asignaciones_grupos_model->get_msg());
					redirect('reclamos/asignaciones_grupos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->asignaciones_grupos_model->get_error())
					{
						$error_msg .='<br>' . $this->asignaciones_grupos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->asignaciones_grupos_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar asignación de grupo';
			$this->load_template('reclamos/asignaciones_grupos/asignaciones_grupos_abm', $data);
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
				redirect("reclamos/asignaciones_grupos/ver/$id", 'refresh');
			}
			$asignacion_usuario = $this->asignaciones_grupos_model->get(array('id' => $id));
			if (empty($asignacion_usuario))
			{
				show_404();
			}
			$this->load->model('reclamos/grupos_model');
			$this->load->model('usuarios_model');
			$this->array_grupo_control = $array_grupo = $this->get_array('grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			unset($this->array_grupo_control[0]);
			$this->array_user_control = $array_user = $this->get_array('usuarios', 'username', 'id', null, array(0 => '-- Seleccionar usuario --'));
			unset($this->array_user_control[0]);
			$this->set_model_validation_rules($this->asignaciones_grupos_model);
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
					$trans_ok&= $this->asignaciones_grupos_model->update(array(
						'id' => $this->input->post('id'),
						'user_id' => $this->input->post('user'),
						'grupo_id' => $this->input->post('grupo')
						), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->asignaciones_grupos_model->get_msg());
						redirect('reclamos/asignaciones_grupos/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->asignaciones_grupos_model->get_error())
						{
							$error_msg .='<br>' . $this->asignaciones_grupos_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->asignaciones_grupos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $asignacion_usuario->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $asignacion_usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['asignacion_usuario'] = $asignacion_usuario;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar asignación de grupo';
			$this->load_template('reclamos/asignaciones_grupos/asignaciones_grupos_abm', $data);
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
				redirect("reclamos/asignaciones_grupos/ver/$id", 'refresh');
			}
			$asignacion_usuario = $this->asignaciones_grupos_model->get(array('id' => $id));
			if (empty($asignacion_usuario))
			{
				show_404();
			}

			$this->load->model('reclamos/grupos_model');
			$this->load->model('usuarios_model');
			$array_grupo = $this->get_array('grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			$array_user = $this->get_array('usuarios', 'username', 'id', null, array(0 => '-- Seleccionar usuario --'));
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->asignaciones_grupos_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->asignaciones_grupos_model->get_msg());
					redirect('reclamos/asignaciones_grupos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->asignaciones_grupos_model->get_error())
					{
						$error_msg .='<br>' . $this->asignaciones_grupos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->asignaciones_grupos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $asignacion_usuario->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $asignacion_usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['asignacion_usuario'] = $asignacion_usuario;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar asignación de grupo';
			$this->load_template('reclamos/asignaciones_grupos/asignaciones_grupos_abm', $data);
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
			$asignacion_usuario = $this->asignaciones_grupos_model->get(array('id' => $id));
			if (empty($asignacion_usuario))
			{
				show_404();
			}

			$this->load->model('reclamos/grupos_model');
			$this->load->model('usuarios_model');
			$array_grupo = $this->get_array('grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			$array_user = $this->get_array('usuarios', 'username', 'id', null, array(0 => '-- Seleccionar usuario --'));
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->asignaciones_grupos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $asignacion_usuario->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $asignacion_usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['asignacion_usuario'] = $asignacion_usuario;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver asignación de grupo';
			$this->load_template('reclamos/asignaciones_grupos/asignaciones_grupos_abm', $data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Asignaciones_grupos.php */
/* Location: ./application/modules/reclamos/controllers/Asignaciones_grupos.php */