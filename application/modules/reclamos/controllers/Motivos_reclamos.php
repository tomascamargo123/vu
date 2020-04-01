<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Motivos_reclamos extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/motivos_reclamos_model');
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
					array('label' => 'Motivo', 'data' => 'descripcion', 'sort' => 'rc_motivos_reclamos.descripcion', 'width' => 45, 'responsive_class' => 'all'),
					array('label' => 'Sector', 'data' => 'sector', 'sort' => 'rc_sectores.descripcion', 'width' => 40),
					array('label' => 'Estado', 'data' => 'estado', 'sort' => 'rc_motivos_reclamos.activo', 'width' => 10),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'motivos_reclamos_table',
				'source_url' => 'reclamos/motivos_reclamos/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Motivos de reclamos';
			$this->load_template('reclamos/motivos_reclamos/motivos_reclamos_listar', $data);
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
				->select('rc_motivos_reclamos.id, rc_motivos_reclamos.descripcion, rc_sectores.descripcion as sector, (CASE rc_motivos_reclamos.activo WHEN 1 THEN "Activo" WHEN 0 THEN "Inactivo" END) as estado')
				->unset_column('id')
				->from('rc_motivos_reclamos')
				->join('rc_sectores', 'rc_sectores.id = rc_motivos_reclamos.sector_id', 'left')
				->add_column('edit', '<a href="reclamos/motivos_reclamos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/motivos_reclamos/listar", 'refresh');
			}
			$this->load->model('reclamos/sectores_model');
			$this->array_sector_control = $array_sector = $this->get_array('sectores', 'descripcion', 'id', null, array(0 => '-- Seleccionar sector --'));
			unset($this->array_sector_control[0]);
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$this->set_model_validation_rules($this->motivos_reclamos_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->motivos_reclamos_model->create(array(
					'descripcion' => $this->input->post('descripcion'),
					'sector_id' => $this->input->post('sector'),
					'activo' => $this->input->post('activo')
					), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->motivos_reclamos_model->get_msg());
					redirect('reclamos/motivos_reclamos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->motivos_reclamos_model->get_error())
					{
						$error_msg .='<br>' . $this->motivos_reclamos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->motivos_reclamos_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar motivo de reclamo';
			$this->load_template('reclamos/motivos_reclamos/motivos_reclamos_abm', $data);
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
				redirect("reclamos/motivos_reclamos/ver/$id", 'refresh');
			}
			$motivo_reclamo = $this->motivos_reclamos_model->get(array('id' => $id));
			if (empty($motivo_reclamo))
			{
				show_404();
			}
			$this->load->model('reclamos/sectores_model');
			$this->array_sector_control = $array_sector = $this->get_array('sectores', 'descripcion', 'id', null, array(0 => '-- Seleccionar sector --'));
			unset($this->array_sector_control[0]);
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$this->set_model_validation_rules($this->motivos_reclamos_model);
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
					$trans_ok&= $this->motivos_reclamos_model->update(array(
						'id' => $this->input->post('id'),
						'descripcion' => $this->input->post('descripcion'),
						'sector_id' => $this->input->post('sector'),
						'activo' => $this->input->post('activo')
						), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->motivos_reclamos_model->get_msg());
						redirect('reclamos/motivos_reclamos/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->motivos_reclamos_model->get_error())
						{
							$error_msg .='<br>' . $this->motivos_reclamos_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->motivos_reclamos_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $motivo_reclamo->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $motivo_reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['motivo_reclamo'] = $motivo_reclamo;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar motivo de reclamo';
			$this->load_template('reclamos/motivos_reclamos/motivos_reclamos_abm', $data);
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
				redirect("reclamos/motivos_reclamos/ver/$id", 'refresh');
			}
			$motivo_reclamo = $this->motivos_reclamos_model->get(array('id' => $id));
			if (empty($motivo_reclamo))
			{
				show_404();
			}

			$this->load->model('reclamos/sectores_model');
			$array_sector = $this->get_array('sectores');
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->motivos_reclamos_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->motivos_reclamos_model->get_msg());
					redirect('reclamos/motivos_reclamos/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->motivos_reclamos_model->get_error())
					{
						$error_msg .='<br>' . $this->motivos_reclamos_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->motivos_reclamos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $motivo_reclamo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $motivo_reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['motivo_reclamo'] = $motivo_reclamo;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar motivo de reclamo';
			$this->load_template('reclamos/motivos_reclamos/motivos_reclamos_abm', $data);
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
			$motivo_reclamo = $this->motivos_reclamos_model->get(array('id' => $id));
			if (empty($motivo_reclamo))
			{
				show_404();
			}

			$this->load->model('reclamos/sectores_model');
			$array_sector = $this->get_array('sectores');
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->motivos_reclamos_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $motivo_reclamo->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $motivo_reclamo->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['motivo_reclamo'] = $motivo_reclamo;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver motivo de reclamo';
			$this->load_template('reclamos/motivos_reclamos/motivos_reclamos_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function get_motivos_por_sector()
	{
		if (in_groups($this->grupos_ajax, $this->grupos))
		{
			$this->form_validation->set_rules('sector', 'Sector', 'required');

			if ($this->form_validation->run() === TRUE)
			{
				$options = array();
				$options['estado'] = 1;
				if ($this->input->post('sector') !== 'Todos')
				{
					$options['sector_id'] = $this->input->post('sector');
				}

				$options['sort_by'] = 'descripcion';
				$motivos = $this->motivos_reclamos_model->get($options);

				$array_motivos = array();
				if (!empty($motivos))
				{
					foreach ($motivos as $Motivo)
					{
						$array_motivos[$Motivo->descripcion] = $Motivo->id;
					}
				}

				echo json_encode($array_motivos);
			}
		}
	}
}
/* End of file Motivos_reclamos.php */
/* Location: ./application/modules/reclamos/controllers/Motivos_reclamos.php */