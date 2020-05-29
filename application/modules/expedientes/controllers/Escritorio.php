<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Escritorio extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->modulo = 'expedientes';
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
	}

	public function index()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			$data['error'] = 'No tiene oficinas asociadas. Comuníquese con un administrador.';
		}
		else
		{
			$data['error'] = $this->session->flashdata('error');
		}
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Escritorio';
		$data['accesos'] = load_permisos_escritorio_expedientes($this->grupos);
		$this->load_template('expedientes/template/expedientes_content', $data);
	}

	public function cambiar_oficina()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/oficinas_model');

		$this->array_oficina_control = $data['oficina_opt'] = $this->get_array('oficinas', 'nombre', 'id', array(
			'join' => array(
				array(
					'table' => "$this->sigmu_schema.usuario_oficina",
					'where' => 'usuario_oficina.ID_OFICINA = oficina.id'
				)),
			'where' => array(array('column' => 'usuario_oficina.ID_USUARIO', 'value' => $this->session->userdata('CodiUsua')),
			array('column' => 'oficina.organigrama', 'value' => $this->session->userdata('organigrama'))),
                        'sort_by' => 'ORDEN'
		));
		$data['oficina_opt_selected'] = $this->session->userdata('oficina_actual_id');
                //var_dump($data['oficina_opt_selected']);die();

		$this->form_validation->set_rules('oficina', 'Oficina', 'required|integer|callback_control_combo[oficina]');
		if ($this->form_validation->run() === TRUE)
		{
			$oficina = $this->oficinas_model->get(array('id' => $this->input->post('oficina')));
                        //var_dump($oficina);die();
			if (!empty($oficina))
			{
				$this->session->set_userdata('oficina_actual', $oficina->nombre);
				$this->session->set_userdata('oficina_actual_id', $oficina->id);
                                $this->session->set_userdata('inicia_expediente', $oficina->inicia_expediente);
				$this->session->set_flashdata('message', 'OK');
								$this->session->unset_userdata('carrito');
				
				/*$alertas = array();
				$this->load->model('alertas_model');
				foreach($this->alertas_model->get() as $alerta){
					array_push($alertas, [
						'url' => $alerta->url,
						'label' => $alerta->label,
						'value' => $alerta->value,
						'icon' => $alerta->icon,
						'class_name' => $alerta->class_name
					]);
				}
				$this->session->set_userdata('alertas', $alertas);*/

				redirect('expedientes/escritorio/cambiar_oficina', 'refresh');
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($this->oficinas_model->get_error() ? $this->oficinas_model->get_error() : $this->session->flashdata('error')));
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Cambiar Oficina'; 
		$data['accesos'] = load_permisos_escritorio_expedientes($this->grupos);
		$this->load_template('expedientes/template/expedientes_cambiar_oficina', $data);
	}
}
/* End of file Escritorio.php */
/* Location: ./application/modules/expedientes/controllers/Escritorio.php */