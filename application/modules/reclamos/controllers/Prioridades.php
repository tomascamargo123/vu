<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prioridades extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/prioridades_model');
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
					array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'rc_prioridades.nombre', 'width' => 80),
					array('label' => 'Días', 'data' => 'dias', 'sort' => 'rc_prioridades.dias', 'class' => 'dt-body-right', 'width' => 10),
					array('label' => 'Icono', 'data' => 'icono', 'sort' => 'rc_prioridades.icono', 'width' => 5, 'class' => 'dt-body-center'),
					array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
				),
				'table_id' => 'prioridades_table',
				'source_url' => 'reclamos/prioridades/listar_data'
			);
			$data['html_table'] = buildHTML($tableData);
			$data['js_table'] = buildJS($tableData);
			$data['error'] = $this->session->flashdata('error');
			$data['message'] = $this->session->flashdata('message');
			$data['title'] = 'Reclamos - Prioridades';
			$this->load_template('reclamos/prioridades/prioridades_listar', $data);
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
					->select('rc_prioridades.id, rc_prioridades.nombre, rc_prioridades.dias, rc_prioridades.icono')
					->unset_column('id')
					->from('rc_prioridades')
					->add_column('icono', '<img src="img/reclamos/prioridades/$1.png" alt="$2" title="$2" class="icono-datatable"></img>', 'icono,nombre')
					->add_column('edit', '<a href="reclamos/prioridades/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

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
				redirect("reclamos/prioridades/listar", 'refresh');
			}
			$array_icono = array(0 => '-- Seleccionar ícono --');
			$iconos = glob("./img/reclamos/prioridades/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/prioridades/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			$this->array_icono_control = $array_icono;
			unset($this->array_icono_control[0]);
			$this->set_model_validation_rules($this->prioridades_model);
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
				$trans_ok = TRUE;
				$trans_ok&= $this->prioridades_model->create(array(
					'nombre' => $this->input->post('nombre'),
					'dias' => $this->input->post('dias'),
					'icono' => $this->input->post('icono')
						), FALSE);

				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->prioridades_model->get_msg());
					redirect('reclamos/prioridades/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->prioridades_model->get_error())
					{
						$error_msg .='<br>' . $this->prioridades_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->prioridades_model->fields as $field)
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
			$data['title'] = 'Reclamos - Agregar prioridad';
			$this->load_template('reclamos/prioridades/prioridades_abm', $data);
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
				redirect("reclamos/prioridades/ver/$id", 'refresh');
			}
			$prioridad = $this->prioridades_model->get(array('id' => $id));
			if (empty($prioridad))
			{
				show_404();
			}
			$array_icono = array(0 => '-- Seleccionar ícono --');
			$iconos = glob("./img/reclamos/prioridades/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/prioridades/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			$this->array_icono_control = $array_icono;
			unset($this->array_icono_control[0]);
			$this->set_model_validation_rules($this->prioridades_model);
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
					$trans_ok&= $this->prioridades_model->update(array(
						'id' => $this->input->post('id'),
						'nombre' => $this->input->post('nombre'),
						'dias' => $this->input->post('dias'),
						'icono' => $this->input->post('icono')
							), FALSE);
					if ($this->db->trans_status() && $trans_ok)
					{
						$this->db->trans_commit();
						$this->session->set_flashdata('message', $this->prioridades_model->get_msg());
						redirect('reclamos/prioridades/listar', 'refresh');
					}
					else
					{
						$this->db->trans_rollback();
						$error_msg = 'Se ha producido un error con la base de datos.';
						if ($this->prioridades_model->get_error())
						{
							$error_msg .='<br>' . $this->prioridades_model->get_error();
						}
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->prioridades_model->fields as $field)
			{
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $prioridad->{$field['name']});
				}
				elseif ($field['input_type'] === 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $prioridad->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}
			$data['prioridad'] = $prioridad;

			$data['txt_btn'] = 'Editar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
			$data['title'] = 'Reclamos - Editar prioridad';
			$this->load_template('reclamos/prioridades/prioridades_abm', $data);
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
				redirect("reclamos/prioridades/ver/$id", 'refresh');
			}
			$prioridad = $this->prioridades_model->get(array('id' => $id));
			if (empty($prioridad))
			{
				show_404();
			}
			$array_icono = array();
			$iconos = glob("./img/reclamos/prioridades/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/prioridades/", ".png"), "", $Icono);
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
				$trans_ok&= $this->prioridades_model->delete(array('id' => $this->input->post('id')), FALSE);
				if ($this->db->trans_status() && $trans_ok)
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('message', $this->prioridades_model->get_msg());
					redirect('reclamos/prioridades/listar', 'refresh');
				}
				else
				{
					$this->db->trans_rollback();
					$error_msg = 'Se ha producido un error con la base de datos.';
					if ($this->prioridades_model->get_error())
					{
						$error_msg .='<br>' . $this->prioridades_model->get_error();
					}
				}
			}
			$data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

			$data['fields'] = array();
			foreach ($this->prioridades_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $prioridad->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $prioridad->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['prioridad'] = $prioridad;

			$data['txt_btn'] = 'Eliminar';
			$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => '', 'eliminar' => 'active btn-app-zetta-active');
			$data['title'] = 'Reclamos - Eliminar prioridad';
			$this->load_template('reclamos/prioridades/prioridades_abm', $data);
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
			$prioridad = $this->prioridades_model->get(array('id' => $id));
			if (empty($prioridad))
			{
				show_404();
			}
			$array_icono = array();
			$iconos = glob("./img/reclamos/prioridades/*[!0-9].png");
			foreach ($iconos as $Icono)
			{
				$nombreIcono = str_replace(array("./img/reclamos/prioridades/", ".png"), "", $Icono);
				$array_icono[$nombreIcono] = $nombreIcono;
			}
			$data['error'] = $this->session->flashdata('error');

			$data['fields'] = array();
			foreach ($this->prioridades_model->fields as $field)
			{
				$field['disabled'] = TRUE;
				if (empty($field['input_type']))
				{
					$this->add_input_field($data['fields'], $field, $prioridad->{$field['name']});
				}
				elseif ($field['input_type'] == 'combo')
				{
					if (isset($field['type']) && $field['type'] === 'multiple')
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
					}
					else
					{
						$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $prioridad->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
					}
				}
			}

			$data['prioridad'] = $prioridad;
			$data['txt_btn'] = NULL;
			$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
			$data['title'] = 'Reclamos - Ver prioridad';
			$this->load_template('reclamos/prioridades/prioridades_abm', $data);
		}
		else
		{
			show_404();
		}
	}

	public function get_vencimiento()
	{
		if (in_groups($this->grupos_ajax, $this->grupos))
		{
			$this->form_validation->set_rules('id', 'ID', 'required|integer');
			$this->form_validation->set_rules('fecha_inicio', 'Fecha Inicio', 'required|validate_date');

			if ($this->form_validation->run() == TRUE)
			{
				$dias = 0;
				$prioridades = $this->prioridades_model->get(array('id' => $this->input->post('id')));
				if (!empty($prioridades))
					$dias = $prioridades->dias;
				$fecha_inicio = $this->input->post('fecha_inicio');
				$vencimiento = date('d-m-Y', strtotime("$fecha_inicio + $dias days"));
				echo json_encode($vencimiento);
			}
			else
			{
				echo json_encode('error');
			}
		}
	}
}
/* End of file Prioridades.php */
/* Location: ./application/modules/reclamos/controllers/Prioridades.php */