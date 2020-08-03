<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->load->model('expedientes/cargos_model');
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
				array('label' => 'Cargo', 'data' => 'descripcion', 'sort' => 'cargos.descripcion', 'width' => 30),
				array('label' => 'Usuario', 'data' => 'username', 'width' => 20, 'sortable' => 'false'),
				array('label' => 'Nombre', 'data' => 'first_name', 'width' => 20, 'sortable' => 'false'),
				array('label' => 'Apellido', 'data' => 'last_name', 'width' => 20, 'sortable' => 'false'),
				array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false'),
				array('label' => '', 'data' => 'asignar_usuario', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'cargos_table',
			'source_url' => 'expedientes/cargos/listar_data'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);

		$tableData_usuarios = array(
			'columns' => array(
				array('label' => 'Usuario', 'data' => 'CodiUsua', 'sort' => 'CodiUsua', 'width' => 95),
				array('label' => '', 'data' => 'select', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'usuarios_table',
			'source_url' => 'expedientes/cargos/usuarios_listar_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#usuarios_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#usuarios_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table_usuarios'] = buildHTML($tableData_usuarios);
		$data['js_table_usuarios'] = buildJS($tableData_usuarios);

		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Cargos';
		$this->load_template('expedientes/cargos/cargos_listar', $data);
	}

	public function listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('cargos.id, cargos.descripcion, users.first_name, users.last_name, users.username')
			->unset_column('id')
			->from("cargos")
			->join('cargos_usuarios', 'cargos_usuarios.cargo_id=cargos.id', 'left')
			->join('users', 'cargos_usuarios.user_id=users.id', 'left')
			->where('cargos_usuarios.hasta IS NULL')
			->add_column('edit', '<a href="expedientes/cargos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id')
			->add_column('asignar_usuario', '<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#buscar_usuario_modal" onclick="cargo_id =$1;">Asignar usuario</button>', 'id');

		echo $this->datatables->generate();
	}

	public function usuarios_listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('CodiUsua, id')
			->from("users")
			->where('CodiUsua IS NOT NULL')
			->where('id NOT IN (SELECT user_id FROM cargos_usuarios WHERE hasta IS NULL)')
			->add_column('select', '<a data-dismiss="modal" href="" onclick="asignar_usuario($1);" title="Asignar usuario"><i class="fa fa-check"></i></a>', 'id');

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
			redirect("expedientes/cargos/listar", 'refresh');
		}
		$this->set_model_validation_rules($this->cargos_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->cargos_model->create(array(
				'descripcion' => $this->input->post('descripcion')));

			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->cargos_model->get_msg());
				redirect('expedientes/cargos/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->cargos_model->get_error() ? $this->cargos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->cargos_model->fields as $field)
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
		$data['title'] = 'Expedientes - Agregar cargo';
		$this->load_template('expedientes/cargos/cargos_abm', $data);
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
			redirect("expedientes/cargos/ver/$id", 'refresh');
		}
		$cargo = $this->cargos_model->get(array('id' => $id));
		if (empty($cargo))
		{
			show_404();
		}
		$this->set_model_validation_rules($this->cargos_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->cargos_model->update(array(
					'id' => $this->input->post('id'),
					'descripcion' => $this->input->post('descripcion')));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->cargos_model->get_msg());
					redirect('expedientes/cargos/listar', 'refresh');
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->cargos_model->get_error() ? $this->cargos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->cargos_model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $cargo->{$field['name']});
			}
			elseif ($field['input_type'] === 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $cargo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}
		$data['cargo'] = $cargo;

		$data['txt_btn'] = 'Editar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['title'] = 'Expedientes - Editar cargo';
		$this->load_template('expedientes/cargos/cargos_abm', $data);
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
			redirect("expedientes/cargos/ver/$id", 'refresh');
		}
		$cargo = $this->cargos_model->get(array('id' => $id));
		if (empty($cargo))
		{
			show_404();
		}
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			$trans_ok = TRUE;
			$trans_ok&= $this->cargos_model->delete(array('id' => $this->input->post('id')));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->cargos_model->get_msg());
				redirect('expedientes/cargos/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->cargos_model->get_error() ? $this->cargos_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->cargos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $cargo->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $cargo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['cargo'] = $cargo;
		$data['txt_btn'] = 'Eliminar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
		$data['title'] = 'Expedientes - Eliminar cargo';
		$this->load_template('expedientes/cargos/cargos_abm', $data);
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$cargo = $this->cargos_model->get(array('id' => $id));
		if (empty($cargo))
		{
			show_404();
		}
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->cargos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $cargo->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $cargo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['cargo'] = $cargo;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Expedientes - Ver cargo';
		$this->load_template('expedientes/cargos/cargos_abm', $data);
	}

	public function asignar_usuario($cargo_id = NULL, $usuario_id = NULl)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $cargo_id == NULL || !ctype_digit($cargo_id) || $usuario_id == NULL || !ctype_digit($usuario_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/cargos/ver/$cargo_id", 'refresh');
		}
		$cargo = $this->cargos_model->get(array('id' => $cargo_id));
		if (empty($cargo))
		{
			show_404();
		}
		$this->load->model('perfil_model');
		$usuario = $this->perfil_model->get(array('id' => $usuario_id,
			'where' => array(
				'CodiUsua IS NOT NULL',
				'id NOT IN (SELECT user_id FROM cargos_usuarios WHERE hasta IS NULL)'
			)
		));
		if (empty($usuario))
		{
			show_404();
		}
		$this->load->model('expedientes/cargos_usuarios_model');
		$usuario_anterior = $this->cargos_usuarios_model->get(array('cargo_id' => $cargo_id, 'where' => array('hasta IS NULL'), 'single' => TRUE));

		$this->db->trans_begin();
		$trans_ok = TRUE;
		if ($usuario_anterior)
		{
			$trans_ok&= $this->cargos_usuarios_model->update(array(
				'id' => $usuario_anterior->id,
				'hasta' => (new DateTime())->format('Y-m-d H:i:s')
				), FALSE);
		}
		$trans_ok&= $this->cargos_usuarios_model->create(array(
			'cargo_id' => $cargo->id,
			'user_id' => $usuario->id,
			'desde' => (new DateTime())->format('Y-m-d H:i:s')
			), FALSE);
		if ($this->db->trans_status() && $trans_ok)
		{
			$this->db->trans_commit();
			$this->session->set_flashdata('message', $this->cargos_usuarios_model->get_msg());
			redirect('expedientes/cargos/listar', 'refresh');
		}
		else
		{
			$this->db->trans_rollback();
			$error_msg = 'Se ha producido un error con la base de datos.';
			if ($this->cargos_usuarios_model->get_error())
			{
				$error_msg .='<br>' . $this->cargos_usuarios_model->get_error();
			}
			$this->session->set_flashdata('error', $error_msg);
			redirect('expedientes/cargos/listar', 'refresh');
		}
	}
}
/* End of file Cargos.php */
/* Location: ./application/modules/expedientes/controllers/Cargos.php */