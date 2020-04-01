<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notas_pases extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/notas_pases_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
	}

	public function agregar($pase_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $pase_id == NULL || !ctype_digit($pase_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/pases/listar_pendientes_e", 'refresh');
		}
		$this->load->model('expedientes/pases_model');
		$pase = $this->pases_model->get(array('id' => $pase_id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.oficina oo",
					'where' => 'oo.id=pase.origen',
					'columnas' => array('CONCAT(oo.id, " - ", oo.nombre) as oficina_origen')
				),
		)));
		if (empty($pase) || $pase->origen !== $this->session->userdata('oficina_actual_id'))
		{
			show_404();
		}
		$this->set_model_validation_rules($this->notas_pases_model);
		$error_msg = FALSE;
		if ($this->form_validation->run() === TRUE)
		{
			$this->db->trans_begin();
			$trans_ok = TRUE;
			$trans_ok&= $this->notas_pases_model->create(array(
				'contenido' => $this->input->post('contenido'),
				'fecha' => date_format(new DateTime($this->input->post('fecha')), 'Y-m-d')
				), FALSE);
			$nota_pase_id = $this->notas_pases_model->get_row_id();
			$trans_ok&= $this->pases_model->update(array(
				'id' => $pase_id,
				'nota_pase_id' => $nota_pase_id
				), FALSE);
			if ($this->db->trans_status() && $trans_ok)
			{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', $this->notas_pases_model->get_msg());
				redirect("expedientes/pases/listar_pendientes_e", 'refresh');
			}
			else
			{
				$this->db->trans_rollback();
				$error_msg = 'Se ha producido un error con la base de datos.';
				if ($this->notas_pases_model->get_error())
				{
					$error_msg .='<br>' . $this->notas_pases_model->get_error();
				}
				if ($this->pases_model->get_error())
				{
					$error_msg .='<br>' . $this->pases_model->get_error();
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($error_msg ? $error_msg : $this->session->flashdata('error')));
		$pase->fecha = date_format(new DateTime(), 'd-m-Y H:i:s');
		$pase->contenido = '';
		$data['fields'] = array();
		foreach ($this->notas_pases_model->fields as $field)
		{
			$this->add_input_field($data['fields'], $field, $pase->{$field['name']});
		}

		$data['txt_btn'] = 'Agregar';
		$data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => 'disabled', 'editar' => 'disabled', 'eliminar' => 'disabled');
		$data['title'] = 'Expedientes - Notas de pases - Adjuntar';
		$this->load_template('expedientes/notas_pases/notas_pases_abm', $data);
	}

	public function editar($pase_id = NULL, $id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $pase_id == NULL || !ctype_digit($pase_id) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (in_groups($this->grupos_solo_consulta, $this->grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin permisos de edición');
			redirect("expedientes/pases/listar_pendientes_e", 'refresh');
		}
		$this->load->model('expedientes/pases_model');
		$nota_pase = $this->notas_pases_model->get(array('id' => $id));
		if (empty($nota_pase))
		{
			show_404();
		}
		$pase = $this->pases_model->get(array('id' => $pase_id,
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.oficina oo",
					'where' => 'oo.id=pase.origen',
					'columnas' => array('CONCAT(oo.id, " - ", oo.nombre) as oficina_origen')
				),
		)));
		if (empty($pase) || $pase->origen !== $this->session->userdata('oficina_actual_id'))
		{
			show_404();
		}
		$this->set_model_validation_rules($this->notas_pases_model);
		if (isset($_POST) && !empty($_POST))
		{
			if ($id !== $this->input->post('id'))
			{
				show_error('Esta solicitud no pasó el control de seguridad.');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$trans_ok = TRUE;
				$trans_ok&= $this->notas_pases_model->update(array(
					'id' => $id,
					'contenido' => $this->input->post('contenido'),
//					'fecha' => date_format(new DateTime($this->input->post('fecha')), 'Y-m-d')
				));
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', $this->notas_pases_model->get_msg());
					redirect("expedientes/pases/listar_pendientes_e", 'refresh');
				}
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->notas_pases_model->get_error() ? $this->notas_pases_model->get_error() : $this->session->flashdata('error')));
		$pase->fecha = $nota_pase->fecha;
		$pase->contenido = $nota_pase->contenido;
		$data['fields'] = array();
		foreach ($this->notas_pases_model->fields as $field)
		{
			$this->add_input_field($data['fields'], $field, $pase->{$field['name']});
		}

		$data['nota_pase'] = $nota_pase;
		$data['txt_btn'] = 'Editar';
		$data['class'] = array('agregar' => '', 'ver' => '', 'editar' => 'active btn-app-zetta-active', 'eliminar' => '');
		$data['title'] = 'Expedientes - Notas de pases - Modificar';
		$this->load_template('expedientes/notas_pases/notas_pases_abm', $data);
	}

	public function get_nota()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->form_validation->set_rules('id', 'ID', 'required|integer');
		if ($this->form_validation->run() === TRUE)
		{
			$nota_pase = $this->notas_pases_model->get(array('id' => $this->input->post('id')));
			echo json_encode($nota_pase);
		}
		else
		{
			echo json_encode('error');
		}
	}
}
/* End of file Notas_pases.php */
/* Location: ./application/modules/expedientes/controllers/Notas_pases.php */