<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sectores extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/sectores_model');
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
					array('label' => 'Sector', 'data' => 'descripcion', 'sort' => 'rc_sectores.descripcion', 'width' => 40, 'responsive_class' => 'all'),
					array('label' => 'Grupo Predeterminado', 'data' => 'grupo', 'sort' => 'rc_grupos.nombre', 'width' => 40),
					array('label' => 'Estado', 'data' => 'estado', 'sort' => 'rc_sectores.activo', 'width' => 10),
					array('label' => 'Icono', 'data' => 'icono', 'sort' => 'rc_sectores.icono', 'width' => 5, 'class' => 'dt-body-center'),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'sectores_table',
				'source_url' => 'reclamos/sectores/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Sectores';
			$this->load_template('reclamos/sectores/sectores_listar', $data);
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
				->select('rc_sectores.id, rc_sectores.descripcion, rc_grupos.nombre as grupo, (CASE rc_sectores.activo WHEN 1 THEN "Activo" WHEN 0 THEN "Inactivo" END) as estado, rc_sectores.icono')
				->unset_column('id')
				->from('rc_sectores')
				->join('rc_grupos', 'rc_grupos.id = rc_sectores.grupo_id', 'left')
				->add_column('icono', '<img src="img/reclamos/sectores/$1.png" alt="$2" title="$2" class="icono-datatable"></img>', 'icono,descripcion')
				->add_column('edit', '<a href="reclamos/sectores/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/sectores/listar", 'refresh');
			}
			$this->load->model('reclamos/Grupos_model');
			$this->array_grupo_control = $array_grupo = $this->get_array('Grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			unset($this->array_grupo_control[0]);
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$array_icono = array(0 => '-- Seleccionar ícono --');
			$iconos = glob("./img/reclamos/sectores/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/sectores/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			$this->array_icono_control = $array_icono;
			unset($this->array_icono_control[0]);
			$this->set_model_validation_rules($this->sectores_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->sectores_model->create(array(
					'descripcion' => $this->input->post('descripcion'),
					'grupo_id' => $this->input->post('grupo'),
					'activo' => $this->input->post('activo'),
					'icono' => $this->input->post('icono')
					), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->sectores_model->get_msg());
					redirect('reclamos/sectores/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->sectores_model->get_error())
					{
						$error_msg .='<br>' . $this->sectores_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->sectores_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar sector';
			$this->load_template('reclamos/sectores/sectores_abm', $data);
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
				redirect("reclamos/sectores/ver/$id", 'refresh');
			}
			$sector = $this->sectores_model->get(array('id' => $id));
			if (empty($sector))
			{
				show_404();
			}
			$this->load->model('reclamos/Grupos_model');
			$this->array_grupo_control = $array_grupo = $this->get_array('Grupos', 'nombre', 'id', null, array(0 => '-- Seleccionar grupo --'));
			unset($this->array_grupo_control[0]);
			$this->array_activo_control = $array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$array_icono = array(0 => '-- Seleccionar ícono --');
			$iconos = glob("./img/reclamos/sectores/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/sectores/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			$this->array_icono_control = $array_icono;
			unset($this->array_icono_control[0]);
			$this->set_model_validation_rules($this->sectores_model);
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
					$trans_ok&= $this->sectores_model->update(array(
						'id' => $this->input->post('id'),
						'descripcion' => $this->input->post('descripcion'),
						'grupo_id' => $this->input->post('grupo'),
						'activo' => $this->input->post('activo'),
						'icono' => $this->input->post('icono')
						), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->sectores_model->get_msg());
						redirect('reclamos/sectores/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->sectores_model->get_error())
						{
							$error_msg .='<br>' . $this->sectores_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->sectores_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $sector->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $sector->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['sector'] = $sector;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar sector';
			$this->load_template('reclamos/sectores/sectores_abm', $data);
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
				redirect("reclamos/sectores/ver/$id", 'refresh');
			}
			$sector = $this->sectores_model->get(array('id' => $id));
			if (empty($sector))
			{
				show_404();
			}

			$this->load->model('reclamos/Grupos_model');
			$array_grupo = $this->get_array('Grupos', 'nombre');
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$array_icono = array();
			$iconos = glob("./img/reclamos/sectores/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/sectores/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			if (isset($_POST) && !empty($_POST))
			{
				if ($id !== $this->input->post('id'))
				{
					show_error('Esta solicitud no pasó el control de seguridad.');
				}

				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->sectores_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->sectores_model->get_msg());
					redirect('reclamos/sectores/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->sectores_model->get_error())
					{
						$error_msg .='<br>' . $this->sectores_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->sectores_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $sector->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $sector->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['sector'] = $sector;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar sector';
			$this->load_template('reclamos/sectores/sectores_abm', $data);
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
			$sector = $this->sectores_model->get(array('id' => $id));
			if (empty($sector))
			{
				show_404();
			}

			$this->load->model('reclamos/Grupos_model');
			$array_grupo = $this->get_array('Grupos', 'nombre');
			$array_activo = array('1' => 'Activo', '0' => 'Inactivo');
			$array_icono = array();
			$iconos = glob("./img/reclamos/sectores/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/sectores/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->sectores_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $sector->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $sector->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['sector'] = $sector;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver sector';
			$this->load_template('reclamos/sectores/sectores_abm', $data);
		}
		else
			show_404();
	}

	public function get_grupo()
	{
		if (in_groups($this->grupos_ajax, $this->grupos))
		{
			$this->form_validation->set_rules('sector', 'Sector', 'required|integer');

			if ($this->form_validation->run() == TRUE)
			{
				$sector = $this->sectores_model->get(array('id' => $this->input->post('sector')));
				if (!empty($sector))
					echo json_encode($sector->grupo_id);
				else
					echo json_encode("error");
			}
		}
	}
}
/* End of file Sectores.php */
/* Location: ./application/modules/reclamos/controllers/Sectores.php */