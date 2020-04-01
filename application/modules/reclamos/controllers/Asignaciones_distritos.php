<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciones_distritos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/asignaciones_distritos_model');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Usuario', 'data' => 'usuario', 'sort' => 'users.username', 'width' => 45, 'responsive_class' => 'all'),
					array('label' => 'Distrito', 'data' => 'distrito', 'sort' => 'distritos.nombre', 'width' => 50),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'asignaciones_distritos_table',
				'source_url' => 'reclamos/asignaciones_distritos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Asignaciones de distritos';
			$this->load_template('reclamos/asignaciones_distritos/asignaciones_distritos_listar', $data);
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
					->select('rc_users_distritos.id, rc_users_distritos.user_id, rc_users_distritos.distrito_id, distritos.nombre as distrito, users.username as usuario')
					->unset_column('id')
					->from('rc_users_distritos')
					->join('distritos', 'distritos.id = rc_users_distritos.distrito_id', 'left')
					->join('users', 'users.id = rc_users_distritos.user_id', 'left')
					->add_column('edit', '<a href="reclamos/asignaciones_distritos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/asignaciones_distritos/listar", 'refresh');
			}
			$this->load->model('distritos_model');
			$this->load->model('usuarios_model');
			$this->array_distrito_control = $array_distrito = $this->get_array('distritos', 'nombre', 'id', null, array(0 => '-- Seleccionar distrito --'));
			unset($this->array_distrito_control[0]);
			$usuarios_options = array(
				'join' => array(
					array(
						'type' => 'left',
						'table' => 'users_groups',
						'where' => 'users_groups.user_id = users.id'
					),
					array(
						'type' => 'left',
						'table' => 'groups',
						'where' => "groups.id = users_groups.group_id"
					)
				),
				'where' => array("groups.name IN ('reclamos_distrito')")
			);
			$this->array_user_control = $array_user = $this->get_array('usuarios', 'username', 'id', $usuarios_options, array(0 => '-- Seleccionar usuario --'));
			unset($this->array_user_control[0]);
			$this->set_model_validation_rules($this->asignaciones_distritos_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->asignaciones_distritos_model->create(array(
					'user_id' => $this->input->post('user'),
					'distrito_id' => $this->input->post('distrito')
						), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->asignaciones_distritos_model->get_msg());
					redirect('reclamos/asignaciones_distritos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->asignaciones_distritos_model->get_error())
					{
						$error_msg .='<br>' . $this->asignaciones_distritos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->asignaciones_distritos_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar asignación de distrito';
			$this->load_template('reclamos/asignaciones_distritos/asignaciones_distritos_abm', $data);
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
				redirect("reclamos/asignaciones_distritos/ver/$id", 'refresh');
			}
			$asignacion_distrito = $this->asignaciones_distritos_model->get(array('id' => $id));
			if (empty($asignacion_distrito))
			{
				show_404();
			}
			$this->load->model('distritos_model');
			$this->load->model('usuarios_model');
			$this->array_distrito_control = $array_distrito = $this->get_array('distritos', 'nombre', 'id', null, array(0 => '-- Seleccionar distrito --'));
			unset($this->array_distrito_control[0]);
			$usuarios_options = array(
				'join' => array(
					array(
						'type' => 'left',
						'table' => 'users_groups',
						'where' => 'users_groups.user_id = users.id'
					),
					array(
						'type' => 'left',
						'table' => 'groups',
						'where' => "groups.id = users_groups.group_id"
					)
				),
				'where' => array("groups.name IN ('reclamos_distrito')")
			);
			$this->array_user_control = $array_user = $this->get_array('usuarios', 'username', 'id', $usuarios_options, array(0 => '-- Seleccionar usuario --'));
			unset($this->array_user_control[0]);
			$this->set_model_validation_rules($this->asignaciones_distritos_model);
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
					$trans_ok&= $this->asignaciones_distritos_model->update(array(
						'id' => $this->input->post('id'),
						'user_id' => $this->input->post('user'),
						'distrito_id' => $this->input->post('distrito')
							), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->asignaciones_distritos_model->get_msg());
						redirect('reclamos/asignaciones_distritos/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->asignaciones_distritos_model->get_error())
						{
							$error_msg .='<br>' . $this->asignaciones_distritos_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->asignaciones_distritos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $asignacion_distrito->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $asignacion_distrito->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['asignacion_distrito'] = $asignacion_distrito;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar asignación de distrito';
			$this->load_template('reclamos/asignaciones_distritos/asignaciones_distritos_abm', $data);
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
				redirect("reclamos/asignaciones_distritos/ver/$id", 'refresh');
			}
			$asignacion_distrito = $this->asignaciones_distritos_model->get(array('id' => $id));
			if (empty($asignacion_distrito))
			{
				show_404();
			}

			$this->load->model('distritos_model');
			$this->load->model('usuarios_model');
			$array_distrito = $this->get_array('distritos', 'nombre', 'id', null, array(0 => '-- Seleccionar distrito --'));
			$array_user = $this->get_array('usuarios', 'username', 'id', null, array(0 => '-- Seleccionar usuario --'));
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->asignaciones_distritos_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->asignaciones_distritos_model->get_msg());
					redirect('reclamos/asignaciones_distritos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->asignaciones_distritos_model->get_error())
					{
						$error_msg .='<br>' . $this->asignaciones_distritos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->asignaciones_distritos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $asignacion_distrito->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $asignacion_distrito->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['asignacion_distrito'] = $asignacion_distrito;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar asignación de distrito';
			$this->load_template('reclamos/asignaciones_distritos/asignaciones_distritos_abm', $data);
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
			$asignacion_distrito = $this->asignaciones_distritos_model->get(array('id' => $id));
			if (empty($asignacion_distrito))
			{
				show_404();
			}

			$this->load->model('distritos_model');
			$this->load->model('usuarios_model');
			$array_distrito = $this->get_array('distritos', 'nombre', 'id', null, array(0 => '-- Seleccionar distrito --'));
			$array_user = $this->get_array('usuarios', 'username', 'id', null, array(0 => '-- Seleccionar usuario --'));
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->asignaciones_distritos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $asignacion_distrito->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $asignacion_distrito->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['asignacion_distrito'] = $asignacion_distrito;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver asignación de distrito';
			$this->load_template('reclamos/asignaciones_distritos/asignaciones_distritos_abm', $data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Asignaciones_distritos.php */
/* Location: ./application/modules/reclamos/controllers/Asignaciones_distritos.php */
