<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitantes extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/solicitantes_model');
		$this->grupos_ajax = array('admin', 'reclamos_admin', 'reclamos_coordinador', 'reclamos_distrito', 'reclamos_usuario', 'reclamos_consulta_general');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'DNI', 'data' => 'dni', 'sort' => 'rc_solicitantes.dni', 'width' => 11, 'class' => 'dt-body-right'),
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_solicitantes.nombre', 'width' => 22),
					array('label' => 'Apellido', 'data' => 'apellido', 'sort' => 'rc_solicitantes.apellido', 'width' => 22),
					array('label' => 'Mail', 'data' => 'mail', 'sort' => 'rc_solicitantes.mail', 'width' => 15),
					array('label' => 'Teléfono', 'data' => 'telefono', 'sort' => 'rc_solicitantes.telefono', 'width' => 15, 'class' => 'dt-body-right'),
					array('label' => 'Usuario e-Trámites', 'data' => 'et_user_id', 'sort' => 'rc_solicitantes.et_user_id', 'width' => 10),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'solicitantes_table',
				'source_url' => 'reclamos/solicitantes/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Solicitantes';
			$this->load_template('reclamos/solicitantes/solicitantes_listar', $data);
		}
		else
		{
			show_404();
		}
	}

	public function listar_data()
	{
		if (in_groups($this->grupos_ajax, $this->grupos))
		{
			$this->datatables
					->select('rc_solicitantes.id, rc_solicitantes.dni, rc_solicitantes.nombre, rc_solicitantes.apellido, rc_solicitantes.mail, rc_solicitantes.telefono, rc_solicitantes.et_user_id')
					->unset_column('id')
					->from('rc_solicitantes')
					->add_column('edit', '<a href="reclamos/solicitantes/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id')
					->add_column('select', '<a data-dismiss="modal" href="" onclick="$(\'#solicitante\').val(\'$1\');actualizar_solicitante();"title="Seleccionar"><i class="fa fa-check"></i></a>', 'dni');

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
				redirect("reclamos/solicitantes/listar", 'refresh');
			}
			$this->set_model_validation_rules($this->solicitantes_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->solicitantes_model->create(array(
					'dni' => $this->input->post('dni'),
					'nombre' => $this->input->post('nombre'),
					'apellido' => $this->input->post('apellido'),
					'mail' => $this->input->post('mail'),
					'telefono' => $this->input->post('telefono'),
					'et_user_id' => $this->input->post('et_user')
						), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->solicitantes_model->get_msg());
					redirect('reclamos/solicitantes/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->solicitantes_model->get_error())
					{
						$error_msg .='<br>' . $this->solicitantes_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->solicitantes_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar solicitante';
			$this->load_template('reclamos/solicitantes/solicitantes_abm', $data);
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
				redirect("reclamos/solicitantes/ver/$id", 'refresh');
			}
			$solicitante = $this->solicitantes_model->get(array('id' => $id));
			if (empty($solicitante))
			{
				show_404();
			}
			$this->set_model_validation_rules($this->solicitantes_model);
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
					$trans_ok&= $this->solicitantes_model->update(array(
						'id' => $this->input->post('id'),
						'dni' => $this->input->post('dni'),
						'nombre' => $this->input->post('nombre'),
						'apellido' => $this->input->post('apellido'),
						'mail' => $this->input->post('mail'),
						'telefono' => $this->input->post('telefono'),
						'et_user_id' => $this->input->post('et_user')
							), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->solicitantes_model->get_msg());
						redirect('reclamos/solicitantes/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->solicitantes_model->get_error())
						{
							$error_msg .='<br>' . $this->solicitantes_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->solicitantes_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $solicitante->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $solicitante->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['solicitante'] = $solicitante;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar solicitante';
			$this->load_template('reclamos/solicitantes/solicitantes_abm', $data);
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
				redirect("reclamos/solicitantes/ver/$id", 'refresh');
			}
			$solicitante = $this->solicitantes_model->get(array('id' => $id));
			if (empty($solicitante))
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
				$trans_ok&= $this->solicitantes_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->solicitantes_model->get_msg());
					redirect('reclamos/solicitantes/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->solicitantes_model->get_error())
					{
						$error_msg .='<br>' . $this->solicitantes_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->solicitantes_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $solicitante->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $solicitante->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['solicitante'] = $solicitante;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar solicitante';
			$this->load_template('reclamos/solicitantes/solicitantes_abm', $data);
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
			$solicitante = $this->solicitantes_model->get(array('id' => $id));
			if (empty($solicitante))
			{
				show_404();
			}
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->solicitantes_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $solicitante->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $solicitante->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['solicitante'] = $solicitante;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver solicitante';
			$this->load_template('reclamos/solicitantes/solicitantes_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function get_solicitante()
	{
		if (in_groups($this->grupos_ajax, $this->grupos))
		{
			$this->form_validation->set_rules('dni', 'DNI', 'required|integer');

			if ($this->form_validation->run() == TRUE)
			{
				$dias = 0;
				$solicitante = $this->solicitantes_model->get(array('dni' => $this->input->post('dni')));
				if (!empty($solicitante))
				{
					echo json_encode($solicitante[0]);
				}
				else
				{
					echo json_encode('error');
				}
			}
		}
	}
}
/* End of file Solicitantes.php */
/* Location: ./application/modules/reclamos/controllers/Solicitantes.php */