<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Revisor_firmante extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('revisor_firmante_model');
		$this->grupos_permitidos = array('admin');
		$this->grupos_solo_consulta = array('expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
	}

	public function listar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$tableData = array(
			'columns' => array(
				array('label' => 'Firmante', 'data' => 'firmante', 'sort' => 'users_revisor.username', 'width' => 15),
				array('label' => '', 'data' => 'firmante_nombre', 'sort' => 'users_revisor.firmante_nombre', 'width' => 30),
				array('label' => 'Revisor', 'data' => 'revisor', 'sort' => 'users_firmante.username', 'width' => 15),
				array('label' => '', 'data' => 'revisor_nombre', 'sort' => 'users_revisor.revisor_nombre', 'width' => 30),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
			'table_id' => 'revisor_firmante_table',
			'source_url' => 'revisor_firmante/listar_data',
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Revisor_firmante - Listar';
		$this->load_template('revisor_firmante/revisor_firmante_listar', $data);
	}

	public function listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
		$this->datatables
			->select('revisor_firmante.id, users_firmante.username AS firmante,
			CONCAT(users_firmante.last_name, " ", users_firmante.first_name) AS firmante_nombre,
			users_revisor.username AS revisor, 
			CONCAT(users_revisor.last_name, " ", users_revisor.first_name) AS revisor_nombre')
            ->from("revisor_firmante")
            ->join('users AS users_firmante', "revisor_firmante.id_firmante = users_firmante.id", 'inner')
            ->join('users AS users_revisor', "revisor_firmante.id_revisor = users_revisor.id", 'inner')
			->add_column('edit', '<a href="revisor_firmante/editar/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

		echo $this->datatables->generate();
	}

	public function agregar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("/", 'refresh');
		}
		$this->set_model_validation_rules($this->revisor_firmante_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$trans_ok&= $this->revisor_firmante_model->create(array(
				'id_firmante' => $this->input->post('firmantes'),
				'id_revisor' => $this->input->post('revisores'),
			));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->revisor_firmante_model->get_msg());
				redirect('revisor_firmante/listar', 'refresh');
			} else {
				$this->session->set_flashdata('error', $this->revisor_firmante_model->get_msg());
				redirect('revisor_firmante/agregar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->revisor_firmante_model->get_error() ? $this->revisor_firmante_model->get_error() : $this->session->flashdata('error')));

		$data['firmantes'] = $this->revisor_firmante_model->get_firmantes();
		$data['txt_btn'] = 'Agregar';
		$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
		$data['title'] = 'Requerimientos - Agregar';
		$this->load_template('revisor_firmante/revisor_firmante_abm', $data);
	}

	public function get_revisores(){
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("/", 'refresh');
		}
		$id_firmante = $this->input->post('id_firmante');
		$firmante_username = $this->revisor_firmante_model->get_firmante_username($id_firmante);
		$revisores_username = $this->revisor_firmante_model->get_revisores_username($firmante_username);
		$revisores = array();
		foreach($revisores_username as $username){
			if($username['ID_USUARIO'] != $firmante_username){
				$user = $this->revisor_firmante_model->get_revisor($username['ID_USUARIO']);
				array_push($revisores, ['id' => $user[0]['id'], 'nombre' => $user[0]['nombre']]);
			}
		}
		echo json_encode($revisores);
	}

	public function editar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("/", 'refresh');
		}
		$revisor_firmante = $this->revisor_firmante_model->get(array('id' => $id));
		if (empty($revisor_firmante))
		{
			show_404();
		}
		$this->set_model_validation_rules($this->revisor_firmante_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}
			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->revisor_firmante_model->update(array(
					'id' => $this->input->post('id'),
					'id_firmante' => $this->input->post('firmantes'),
					'id_revisor' => $this->input->post('revisores'),
				));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->revisor_firmante_model->get_msg());
					redirect('revisor_firmante/listar', 'refresh');
				}
			}
		}

		$data['id'] = $id;
		$data['error'] = (validation_errors() ? validation_errors() : ($this->revisor_firmante_model->get_error() ? $this->revisor_firmante_model->get_error() : $this->session->flashdata('error')));
		$data['editar'] = TRUE;
		$data['firmantes'] = $this->revisor_firmante_model->get_firmantes($id);
		$data['txt_btn'] = 'Guardar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['title'] = 'Revisor_firmante - Editar';
		$this->load_template('revisor_firmante/revisor_firmante_abm', $data);
	}

	public function eliminar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("revisor_firmante/ver/$id", 'refresh');
		}
		$revisor_firmante = $this->revisor_firmante_model->get(array('id' => $id));
		if (empty($revisor_firmante))
		{
			show_404();
		}

		$this->load->model('expedientes/oficinas_model');
		$this->array_importancia_control = $array_importancia = array('0' => 'Baja', '1' => 'Moderada', '2' => 'Alta');
		$this->array_estado_control = $array_estado = array('0' => 'Pendiente', '1' => 'En proceso', '2' => 'Resuelto', '3' => 'Rechazado');
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			$trans_ok = TRUE;
			$trans_ok&= $this->revisor_firmante_model->delete(array('id' => $this->input->post('id')));
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', $this->revisor_firmante_model->get_msg());
				redirect('revisor_firmante/listar', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->revisor_firmante_model->get_error() ? $this->revisor_firmante_model->get_error() : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->revisor_firmante_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $revisor_firmante->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $revisor_firmante->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['revisor_firmante'] = $revisor_firmante;
		$data['txt_btn'] = 'Eliminar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
		$data['title'] = 'Requerimientos - Eliminar';
		$this->load_template('revisor_firmante/revisor_firmante_abm', $data);
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$revisor_firmante = $this->revisor_firmante_model->get(array('id' => $id));
		if (empty($revisor_firmante))
		{
			show_404();
		}

		$this->load->model('expedientes/oficinas_model');
		$this->array_importancia_control = $array_importancia = array('0' => 'Baja', '1' => 'Moderada', '2' => 'Alta');
		$this->array_estado_control = $array_estado = array('0' => 'Pendiente', '1' => 'En proceso', '2' => 'Resuelto', '3' => 'Rechazado');
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->revisor_firmante_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $revisor_firmante->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $revisor_firmante->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$data['revisor_firmante'] = $revisor_firmante;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Requerimientos - Ver';
		$this->load_template('revisor_firmante/revisor_firmante_abm', $data);
	}
}
/* End of file Avisos.php */
/* Location: ./application/modules/expedientes/controllers/Avisos.php */