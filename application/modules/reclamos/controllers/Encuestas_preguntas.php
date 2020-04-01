<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas_preguntas extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/encuestas_preguntas_model');
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_consulta_general');
		$this->grupos_solo_consulta = array('reclamos_consulta_general');
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$tableData = array(
				'columns' => array(
					array('label' => 'Pregunta', 'data' => 'pregunta', 'sort' => 'rc_encuestas_preguntas.pregunta', 'width' => 50, 'responsive_class' => 'all'),
					array('label' => 'Descripción', 'data' => 'descripcion_corta', 'sort' => 'rc_encuestas_preguntas.descripcion_corta', 'width' => 15),
					array('label' => 'Estado', 'data' => 'estado', 'sort' => 'rc_encuestas_preguntas.activo', 'width' => 15),
					array('label' => 'Tipo', 'data' => 'tipo', 'sort' => 'rc_encuestas_preguntas.web', 'width' => 15),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'encuestas_preguntas_table',
				'source_url' => 'reclamos/encuestas_preguntas/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Preguntas de Encuesta';
			$this->load_template('reclamos/encuestas_preguntas/encuestas_preguntas_listar', $data);
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
					->select('rc_encuestas_preguntas.id, rc_encuestas_preguntas.pregunta, rc_encuestas_preguntas.descripcion_corta, (CASE rc_encuestas_preguntas.activo  WHEN 1 THEN "Activo" WHEN 0 THEN "Inactivo" END) as estado, (CASE rc_encuestas_preguntas.web  WHEN "T" THEN "Todos" WHEN "S" THEN "Sistema"  WHEN "E" THEN "e-Trámites" END) as tipo')
					->unset_column('id')
					->from('rc_encuestas_preguntas')
					->add_column('edit', '<a href="reclamos/encuestas_preguntas/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/encuestas_preguntas/listar", 'refresh');
			}
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$this->array_web_control = $array_web = array('T' => 'Todos', 'S' => 'Sistema', 'E' => 'e-Trámites');
			$this->set_model_validation_rules($this->encuestas_preguntas_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->encuestas_preguntas_model->create(array(
					'pregunta' => $this->input->post('pregunta'),
					'descripcion_corta' => $this->input->post('descripcion_corta'),
					'activo' => $this->input->post('activo'),
					'web' => $this->input->post('web')
						), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->encuestas_preguntas_model->get_msg());
					redirect('reclamos/encuestas_preguntas/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->encuestas_preguntas_model->get_error())
					{
						$error_msg .='<br>' . $this->encuestas_preguntas_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->encuestas_preguntas_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar preguntas de encuestas';
			$this->load_template('reclamos/encuestas_preguntas/encuestas_preguntas_abm', $data);
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
				redirect("reclamos/encuestas_preguntas/ver/$id", 'refresh');
			}
			$encuestas_pregunta = $this->encuestas_preguntas_model->get(array('id' => $id));
			if (empty($encuestas_pregunta))
			{
				show_404();
			}
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$this->array_web_control = $array_web = array('T' => 'Todos', 'S' => 'Sistema', 'E' => 'e-Trámites');
			$this->set_model_validation_rules($this->encuestas_preguntas_model);
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
					$trans_ok&= $this->encuestas_preguntas_model->update(array(
						'id' => $this->input->post('id'),
						'pregunta' => $this->input->post('pregunta'),
						'descripcion_corta' => $this->input->post('descripcion_corta'),
						'activo' => $this->input->post('activo'),
						'web' => $this->input->post('web')
							), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->encuestas_preguntas_model->get_msg());
						redirect('reclamos/encuestas_preguntas/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->encuestas_preguntas_model->get_error())
						{
							$error_msg .='<br>' . $this->encuestas_preguntas_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->encuestas_preguntas_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $encuestas_pregunta->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $encuestas_pregunta->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['encuestas_pregunta'] = $encuestas_pregunta;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar preguntas de encuestas';
			$this->load_template('reclamos/encuestas_preguntas/encuestas_preguntas_abm', $data);
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
				redirect("reclamos/encuestas_preguntas/ver/$id", 'refresh');
			}
			$encuestas_pregunta = $this->encuestas_preguntas_model->get(array('id' => $id));
			if (empty($encuestas_pregunta))
			{
				show_404();
			}
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$array_web = array('T' => 'Todos', 'S' => 'Sistema', 'E' => 'e-Trámites');
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->encuestas_preguntas_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->encuestas_preguntas_model->get_msg());
					redirect('reclamos/encuestas_preguntas/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->encuestas_preguntas_model->get_error())
					{
						$error_msg .='<br>' . $this->encuestas_preguntas_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->encuestas_preguntas_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $encuestas_pregunta->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $encuestas_pregunta->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['encuestas_pregunta'] = $encuestas_pregunta;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar preguntas de encuestas';
			$this->load_template('reclamos/encuestas_preguntas/encuestas_preguntas_abm', $data);
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
			$encuestas_pregunta = $this->encuestas_preguntas_model->get(array('id' => $id));
			if (empty($encuestas_pregunta))
			{
				show_404();
			}
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$array_web = array('T' => 'Todos', 'S' => 'Sistema', 'E' => 'e-Trámites');
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->encuestas_preguntas_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $encuestas_pregunta->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $encuestas_pregunta->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['encuestas_pregunta'] = $encuestas_pregunta;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver preguntas de encuestas';
			$this->load_template('reclamos/encuestas_preguntas/encuestas_preguntas_abm', $data);
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Encuestas_preguntas.php */
/* Location: ./application/modules/reclamos/controllers/Encuestas_preguntas.php */