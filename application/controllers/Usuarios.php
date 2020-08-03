<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('Usuarios_model');
		$this->load->model('Grupos_model');
		$this->grupos_permitidos = array('admin');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Usuario', 'data' => 'CodiUsua', 'width' => 15, 'responsive_class' => 'all'),
					array('label' => 'Nombre', 'data' => 'first_name', 'width' => 15),
					array('label' => 'Apellido', 'data' => 'last_name', 'width' => 15),
					array('label' => 'Email', 'data' => 'email', 'width' => 15),
					array('label' => 'Grupos', 'data' => 'grupos', 'width' => 15, 'sortable' => 'false', 'searchable' => 'false'),
					array('label' => 'Último login', 'data' => 'last_login', 'sort' => 'users.last_login', 'width' => 12),
					array('label' => 'Estado', 'data' => 'active', 'width' => 8),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'users_table',
				'source_url' => 'usuarios/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = TITLE . ' - Usuarios';
			$this->load_template('usuarios/usuarios_listar', $data);
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
				->select($this->sigmu_schema . '.usuario.CodiUsua, username, first_name, last_name, email, group_concat(groups.name separator \' - \') as grupos, (CASE active WHEN 1 THEN "Activo" WHEN 2 THEN "Inactivo" END) as active, FROM_UNIXTIME(last_login, "%d/%m/%Y %H:%i") as last_login')
				->unset_column('id')
				->from("$this->sigmu_schema.usuario")
				->join('users', "$this->sigmu_schema.usuario.CodiUsua = users.CodiUsua", 'left')
				->join('users_groups', 'users_groups.user_id = users.id', 'left')
				->join('groups', 'groups.id = users_groups.group_id', 'left')
				//->where('users.organigrama', $this->session->userdata('organigrama'))
				->group_by('usuario.CodiUsua')
				->add_column('edit', '<a href="usuarios/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'CodiUsua');

			echo $this->datatables->generate();
		}
		else
		{
			show_404();
		}
	}

	public function agregar()
	{
		if ($this->config->item('login_infogov'))
			redirect('usuarios/listar', 'refresh');
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$this->array_groups_control = $array_groups = $this->get_array('Grupos', 'name');
			$this->array_active_control = $array_active = array('1' => 'Activo', '0' => 'Inactivo');
			$this->set_model_validation_rules($this->Usuarios_model);
			$this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Confirmar contraseña', 'required');
			$group_data = $this->input->post('groups');
			if ($this->form_validation->run() === TRUE)
			{
				$username = $this->input->post('username');
				$email = strtolower($this->input->post('email'));
				$password = $this->input->post('password');
				$additional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name')
				);

				if ($this->ion_auth->register($username, $password, $email, $additional_data, $group_data))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('usuarios/listar', 'refresh');
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

			$current_groups = '';
			for ($i = 0; $i < sizeof($group_data); $i++)
			{
				$current_groups .= '"' . $group_data[$i] . '"';
				if ($i < sizeof($group_data) - 1)
				{
					$current_groups .= ', ';
				}
			}

			$data['fields'] = array();
			foreach ($this->Usuarios_model->fields as $field)
			{
				if ($field['name'] !== 'last_login')
				{
					if (empty($field['input_type']))
					{
						if ($field['name'] === 'password' || $field['name'] === 'password_confirm')
						{
							$field['required'] = TRUE;
						}
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
			}

			$data['txt_btn'] = 'Agregar';
			$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
			$data['title'] = TITLE . ' - Agregar usuario';
			$this->load_template('usuarios/usuarios_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function editar($id = NULL)
	{
		if ($this->config->item('login_infogov'))
			redirect('usuarios/listar', 'refresh');
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			$usuario = $this->Usuarios_model->get(array('id' => $id));
			if (empty($usuario))
			{
				show_404();
			}
			$users_groups = $this->ion_auth->get_users_groups($id)->result();
			$this->array_groups_control = $array_groups = $this->get_array('Grupos', 'name');
			$this->array_active_control = $array_active = array('1' => 'Activo', '0' => 'Inactivo');
			$this->set_model_validation_rules($this->Usuarios_model);
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if ($this->input->post('password'))
				{
					$this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
					$this->form_validation->set_rules('password_confirm', 'Confirmar contraseña', 'required');
				}
				$group_data = $this->input->post('groups');
				if ($this->form_validation->run() === TRUE)
				{
					$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'email' => $this->input->post('email')
					);

					if ($this->input->post('password'))
					{
						$data['password'] = $this->input->post('password');
					}

					if (isset($group_data) && !empty($group_data))
					{
						$this->ion_auth->remove_from_group('', $id);
						foreach ($group_data as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}
					}

					if ($this->ion_auth->update($usuario->id, $data))
					{
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect('usuarios/listar', 'refresh');
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));

			$current_groups = '';
			if (isset($group_data))
			{
				for ($i = 0; $i < sizeof($group_data); $i++)
				{
					$current_groups .= '"' . $group_data[$i] . '"';
					if ($i < sizeof($group_data) - 1)
					{
						$current_groups .= ', ';
					}
				}
			}
			else
			{
				for ($i = 0; $i < sizeof($users_groups); $i++)
				{
					$current_groups .= '"' . $users_groups[$i]->id . '"';
					if ($i < sizeof($users_groups) - 1)
					{
						$current_groups .= ', ';
					}
				}
			}

			$data['fields'] = array();
			foreach ($this->Usuarios_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					if ($field['name'] === 'username' || $field['name'] === 'last_login')
					{
						$field['readonly'] = 'readonly';
					}

					if ($field['name'] === 'password' || $field['name'] === 'password_confirm')
					{
						$field['label'] .= ' (si desea cambiarla)';
						$this->add_input_field($data['fields'], $field);
					}
					elseif ($field['name'] === 'last_login')
					{
						$this->add_input_field($data['fields'], $field, !empty($usuario->last_login) ? date('d/m/Y H:i', $usuario->last_login) : '');
					}
					else
					{
						$this->add_input_field($data['fields'], $field, $usuario->{$field['name']});
					}
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['usuario'] = $usuario;
			$data['txt_btn'] = 'Guardar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = TITLE . ' - Editar usuario';
			$this->load_template('usuarios/usuarios_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function eliminar($id = NULL)
	{
		if ($this->config->item('login_infogov'))
			redirect('usuarios/listar', 'refresh');
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			$usuario = $this->Usuarios_model->get(array('id' => $id));
			if (empty($usuario))
			{
				show_404();
			}
			$users_groups = $this->ion_auth->get_users_groups($id)->result();
			$array_active = array('1' => 'Activo', '0' => 'Inactivo');
			$array_groups = $this->get_array('Grupos', 'name');
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				if ($this->Usuarios_model->delete(array('id' => $this->input->post('id'))))
				{
					$this->session->set_flashdata('message', $this->Usuarios_model->get_msg());
					redirect('usuarios/listar', 'refresh');
				}
			}
			$data['error'] = (validation_errors()) ? validation_errors() : $this->Usuarios_model->get_error();

			$current_groups = '';
			for ($i = 0; $i < sizeof($users_groups); $i++)
			{
				$current_groups .= '"' . $users_groups[$i]->id . '"';
				if ($i < sizeof($users_groups) - 1)
				{
					$current_groups .= ', ';
				}
			}

			$data['fields'] = array();
			foreach ($this->Usuarios_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if ($field['name'] !== 'password' && $field['name'] !== 'password_confirm')
				{
					if (empty($field['input_type']))
					{
						if ($field['name'] === 'last_login')
						{
							$this->add_input_field($data['fields'], $field, !empty($usuario->last_login) ? date('d/m/Y H:i', $usuario->last_login) : '');
						}
						else
						{
							$this->add_input_field($data['fields'], $field, $usuario->{$field['name']});
						}
					}
					elseif ($field['input_type'] == 'combo')
					{
						if (isset($field['type']) && $field['type'] === 'multiple')
						{
							$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
						}
						else
						{
							$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
						}
					}
				}
			}

			$data['usuario'] = $usuario;
			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = TITLE . ' - Eliminar usuario';
			$this->load_template('usuarios/usuarios_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function ver($id = NULL)
	{
		if ($this->config->item('login_infogov'))
		{
			redirect("usuarios/verig/$id");
		}
		if (in_groups($this->grupos_permitidos, $this->grupos) && $id !== NULL && ctype_digit($id))
		{
			$usuario = $this->Usuarios_model->get(array('id' => $id));
			if (empty($usuario))
			{
				show_404();
			}

			$users_groups = $this->ion_auth->get_users_groups($id)->result();
			$current_groups = '';
			for ($i = 0; $i < sizeof($users_groups); $i++)
			{
				$current_groups .= '"' . $users_groups[$i]->id . '"';
				if ($i < sizeof($users_groups) - 1)
				{
					$current_groups .= ', ';
				}
			}

			$array_active = array('1' => 'Activo', '0' => 'Inactivo');
			$array_groups = $this->get_array('Grupos', 'name');
			$data['fields'] = array();
			foreach ($this->Usuarios_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if ($field['name'] !== 'password' && $field['name'] !== 'password_confirm')
				{
					if (empty($field['input_type']))
					{
						if ($field['name'] === 'last_login')
						{
							$this->add_input_field($data['fields'], $field, !empty($usuario->last_login) ? date('d/m/Y H:i', $usuario->last_login) : '');
						}
						else
						{
							$this->add_input_field($data['fields'], $field, $usuario->{$field['name']});
						}
					}
					elseif ($field['input_type'] == 'combo')
					{
						if (isset($field['type']) && $field['type'] === 'multiple')
						{
							$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
						}
						else
						{
							$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
						}
					}
				}
			}

			$data['usuario'] = $usuario;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = TITLE . ' - Ver usuario';
			$this->load_template('usuarios/usuarios_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function verig($CodiUsua = NULL)
	{
		if (!$this->config->item('login_infogov'))
		{
			redirect("usuarios/ver/$CodiUsua");
		}
		if (in_groups($this->grupos_permitidos, $this->grupos) && $CodiUsua !== NULL)
		{
			$usuarios = $this->Usuarios_model->get(array('CodiUsua' => $CodiUsua));
			$current_groups = array();
			$current_rec_grupos = array();
			$current_exp_oficinas = array();
			$array_active = array('1' => 'Activo', '0' => 'Inactivo');
			$array_groups = $this->get_array('Grupos', 'name');
			$array_organigrama = array('10000' => 'Ejecutivo', '20000' => 'HCD');
			$this->load->model('reclamos/grupos_r_model');
			$array_rec_grupos = $this->get_array('grupos_r', 'nombre');
			$this->load->model('expedientes/oficinas_model');
			$array_exp_oficinas = $this->get_array('oficinas', 'nombre');
			if (empty($usuarios))
			{
				$usuario = new stdClass();
				$usuario->username = $CodiUsua;
				$usuario->first_name = '';
				$usuario->last_name = '';
				$usuario->email = '';
				$usuario->CodiUsua = $CodiUsua;
			}
			else
			{
				$usuario = $usuarios[0];
				$users_groups = $this->ion_auth->get_users_groups($usuario->id)->result();
				for ($i = 0; $i < sizeof($users_groups); $i++)
				{
					$current_groups[] = $users_groups[$i]->id;
				}
				$this->load->model('reclamos/asignaciones_grupos_model');
				$rec_grupos = $this->asignaciones_grupos_model->get(array('user_id' => $usuario->id));
				if (!empty($rec_grupos))
				{
					for ($i = 0; $i < sizeof($rec_grupos); $i++)
					{
						$current_rec_grupos[] = $rec_grupos[$i]->grupo_id;
					}
				}
				$this->load->model('expedientes/oficinas_usuarios_model');
				$exp_oficinas = $this->oficinas_usuarios_model->get(array(
                                    'where'=>array(
                                        array('column'=>'ID_USUARIO', 'value' => $usuario->CodiUsua)
                                        ),
                                    'sort_by'=>'ORDEN')
                                    );
				if (!empty($exp_oficinas))
				{
					for ($i = 0; $i < sizeof($exp_oficinas); $i++)
					{
						$current_exp_oficinas[] = $exp_oficinas[$i]->ID_OFICINA;
					}
				}
			}

			$data['fields'] = array();
			foreach ($this->Usuarios_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if ($field['name'] !== 'password' && $field['name'] !== 'password_confirm')
				{
					if (empty($field['input_type']))
					{
						if ($field['name'] === 'last_login')
						{
							$this->add_input_field($data['fields'], $field, !empty($usuario->last_login) ? date('d/m/Y H:i', $usuario->last_login) : '');
						}
						else
						{
							$this->add_input_field($data['fields'], $field, $usuario->{$field['name']});
						}
					}
					elseif ($field['input_type'] == 'combo')
					{
						if (isset($field['type']) && $field['type'] === 'multiple')
						{
							$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
						}
						else
						{
							$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
						}
					}
				}
			}

			#Código agregado para Ticket Nro 30
			$data['firma_digital'] = $this->Usuarios_model->es_firmante($this->session->userdata('CodiUsua'));
			$data['check_firma'] = FALSE;
			#Fin Ticket Nro 30

			$data['usuario'] = $usuario;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = TITLE . ' - Ver usuario';
			$data['css'][] = 'plugins/kartik-v-bootstrap-tabs-x/css/bootstrap-tabs-x.min.css';
			$data['js'][] = 'plugins/kartik-v-bootstrap-tabs-x/js/bootstrap-tabs-x.min.js';
			$data['css'][] = 'plugins/bootstrap-duallistbox/bootstrap-duallistbox.min.css';
			$data['js'][] = 'plugins/bootstrap-duallistbox/jquery.bootstrap-duallistbox.min.js';
			$this->load_template('usuarios/usuarios_abm_infogov', $data);
		}
		else
		{
			show_404();
		}
	}

	public function editarig($CodiUsua = NULL)
	{
		if (!$this->config->item('login_infogov'))
			redirect("usuarios/editar/$CodiUsua", 'refresh');
		if (in_groups($this->grupos_permitidos, $this->grupos) && $CodiUsua !== NULL)
		{
			$usuarios = $this->Usuarios_model->get(array('CodiUsua' => $CodiUsua));
			if (empty($usuarios))
			{
				$ip_address = $this->input->ip_address();
				$this->db->insert('users', array(
					'CodiUsua' => $CodiUsua,
					'ip_address' => $ip_address,
					'username' => $CodiUsua,
					'password' => '',
					'email' => '',
					'active' => 1,
					'created_on' => time(),
					'audi_user' => $this->session->userdata('user_id'),
					'audi_fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
					'audi_accion' => 'I'));
				redirect("usuarios/editarig/$CodiUsua");
			}
			$usuario = $usuarios[0];
			$users_groups = $this->ion_auth->get_users_groups($usuario->id)->result();
			$this->array_groups_control = $array_groups = $this->get_array('Grupos', 'name');
			$this->load->model('reclamos/asignaciones_grupos_model');
			$rec_grupos = $this->asignaciones_grupos_model->get(array('user_id' => $usuario->id));
			$this->load->model('reclamos/grupos_r_model');
			$this->array_rec_grupos_control = $array_rec_grupos = $this->get_array('grupos_r', 'nombre');
			$this->load->model('expedientes/oficinas_usuarios_model');
			//$exp_oficinas = $this->oficinas_usuarios_model->get(array('where' => array("ID_USUARIO ='".$usuario->CodiUsua."'"),'sort_by' => 'usuario_oficina.ORDEN'));
				$exp_oficinas = $this->oficinas_usuarios_model->get(array(
					'where'=>array(
						array('column'=>'ID_USUARIO', 'value' => $usuario->CodiUsua)
						),
					'sort_by'=>'ORDEN')
					);
			$this->load->model('expedientes/oficinas_model');
			$this->array_exp_oficinas_control = $array_exp_oficinas = $this->oficinas_model->get_oficinas($this->session->userdata('organigrama'));
			$this->array_active_control = $array_active = array('1' => 'Activo', '0' => 'Inactivo');
			$this->array_organigrama_control = $array_organigrama = array('10000' => 'Ejecutivo', '20000' => 'HCD');
			$this->set_model_validation_rules($this->Usuarios_model);
			$error_msg = FALSE;
			$primer_oficina = $this->oficinas_usuarios_model->get_primer_oficina($CodiUsua);
			if (isset($_POST) && !empty($_POST))
			{
				if ($usuario->id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$group_data = $this->input->post('groups');
				$rec_grupos_data = $this->input->post('rec_grupos');
				$oficinas_data = $this->input->post('exp_oficinas');
				if ($this->form_validation->run() === TRUE)
				{
					$this->db->trans_begin();
					$trans_ok = TRUE;

					$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'email' => $this->input->post('email'),
						'firma_digital' => ($this->input->post('firma_digital') == 'on' ? 1 : 0),
						'organigrama' => $this->input->post('organigrama'),
						'id' => $usuario->id
					);
                                        
					$this->Usuarios_model->update_data($data);

					$this->ion_auth->remove_from_group('', $usuario->id);
					if (isset($group_data) && !empty($group_data))
					{
						foreach ($group_data as $grp)
						{
							$this->ion_auth->add_to_group($grp, $usuario->id);
						}
					}

					if (!empty($rec_grupos))
					{
						foreach ($rec_grupos as $grupo_anterior)
						{
							$trans_ok&= $this->asignaciones_grupos_model->delete(array('id' => $grupo_anterior->id), FALSE);
						}
					}
					if (isset($rec_grupos_data) && !empty($rec_grupos_data))
					{
						foreach ($rec_grupos_data as $grp)
						{
							$trans_ok&= $this->asignaciones_grupos_model->create(array('grupo_id' => $grp, 'user_id' => $usuario->id), FALSE);
						}
					}

					if (!empty($exp_oficinas))
					{
						foreach ($exp_oficinas as $oficina_anterior)
						{
							$trans_ok&= $this->oficinas_usuarios_model->delete_rela(array('ID' => $oficina_anterior->ID), FALSE);
						}
					}
					if (isset($oficinas_data) && !empty($oficinas_data))
					{	
						$posicion = 1;
						foreach ($oficinas_data as $val) {
							if($val == $primer_oficina[0]['ID_OFICINA']){
								$this->oficinas_usuarios_model->create_rela(array('ID_OFICINA' => $val, 'ID_USUARIO' => $CodiUsua,'ORDEN' => $posicion), FALSE);
								$posicion = $posicion + 1;
							}
						}
						foreach ($oficinas_data as $ofi)
						{
							$trans_ok&= $this->oficinas_usuarios_model->create_rela(array('ID_OFICINA' => $ofi, 'ID_USUARIO' => $CodiUsua,'ORDEN' => $posicion), FALSE);
                                                        $posicion++;
						}
					}
					if ($this->db->trans_status()/* && $trans_ok*/)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', "Usuario modificado exitosamente!");
						redirect('usuarios/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->ion_auth->errors())
						{
							$error_msg .='<br>' . $this->ion_auth->errors();
						}
						if ($this->asignaciones_grupos_model->get_error())
						{
							$error_msg .='<br>' . $this->asignaciones_grupos_model->get_error();
						}
						if ($this->oficinas_usuarios_model->get_error())
						{
							$error_msg .='<br>' . $this->oficinas_usuarios_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : ($error_msg ? $error_msg : $this->session->flashdata('error')));

			$current_groups = array();
			if (isset($group_data))
			{
				$current_groups = $group_data;
			}
			else
			{
				for ($i = 0; $i < sizeof($users_groups); $i++)
				{
					$current_groups[] = $users_groups[$i]->id;
				}
			}
			$current_exp_oficinas = array();
			if (isset($oficinas_data))
			{
				$current_exp_oficinas = $oficinas_data;
			}
			else
			{
				if (!empty($exp_oficinas))
				{
					for ($i = 0; $i < sizeof($exp_oficinas); $i++)
					{
						$current_exp_oficinas[] = $exp_oficinas[$i]->ID_OFICINA;
					}
				}
			}

			$current_rec_grupos = array();
			if (isset($rec_grupos_data))
			{
				$current_rec_grupos = $rec_grupos_data;
			}
			else
			{
				if (!empty($rec_grupos))
				{
					for ($i = 0; $i < sizeof($rec_grupos); $i++)
					{
						$current_rec_grupos[] = $rec_grupos[$i]->grupo_id;
					}
				}
			}

			$data['fields'] = array();
			foreach ($this->Usuarios_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					if ($field['name'] === 'username' || $field['name'] === 'last_login')
					{
						$field['readonly'] = 'readonly';
					}

					if ($field['name'] === 'password' || $field['name'] === 'password_confirm')
					{
						
					}
					elseif ($field['name'] === 'last_login')
					{
						$this->add_input_field($data['fields'], $field, !empty($usuario->last_login) ? date('d/m/Y H:i', $usuario->last_login) : '');
					}
					else
					{
						$this->add_input_field($data['fields'], $field, $usuario->{$field['name']});
					}
				}
				elseif ($field['input_type'] === 'combo')
				{
//					if ($field['name'] === 'exp_oficinas')
//						$field['disabled'] = FALSE;

					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			#Código agregado para Ticket Nro 30
			$data['firma_digital'] = $this->Usuarios_model->es_firmante($this->session->userdata('CodiUsua'));
			$data['check_firma'] = TRUE;
			#Fin Ticket Nro 30

			$data['usuario'] = $usuario;
			$data['txt_btn'] = 'Guardar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = TITLE . ' - Editar usuario';
			$data['css'][] = 'plugins/kartik-v-bootstrap-tabs-x/css/bootstrap-tabs-x.min.css';
			$data['js'][] = 'plugins/kartik-v-bootstrap-tabs-x/js/bootstrap-tabs-x.min.js';
			$data['css'][] = 'plugins/bootstrap-duallistbox/bootstrap-duallistbox.min.css';
			$data['js'][] = 'plugins/bootstrap-duallistbox/jquery.bootstrap-duallistbox.min.js';
			$this->load_template('usuarios/usuarios_abm_infogov', $data);
		}
		else
		{
			show_404();
		}
	}

	function desbloquear()
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		if ($this->ion_auth->desbloquear())
		{
			$this->session->set_flashdata('message', 'Usuarios desbloqueados');
		}
		else
		{
			$this->session->set_flashdata('error', 'Ocurrió un error al desbloquear usuarios');
		}
		redirect('usuarios/listar', 'refresh');
	}
}
/* End of file Usuarios.php */
/* Location: ./application/controllers/Usuarios.php */