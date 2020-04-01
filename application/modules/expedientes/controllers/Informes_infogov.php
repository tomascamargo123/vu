<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Informes_infogov extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
		$this->informes_infogov = array(1, 2);
		$this->informes = array(
			1 => (object) array('id' => 1, 'nombre' => 'Orden de Pago'),
			2 => (object) array('id' => 2, 'nombre' => 'Constancia Retención')
		);
	}

	public function listar()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Informes Infogov';
		$this->load_template('expedientes/informes_infogov/informes_infogov_listar', $data);
	}

	public function circuito_firmas($informe_infogov_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $informe_infogov_id == NULL || !ctype_digit($informe_infogov_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!in_array($informe_infogov_id, $this->informes_infogov))
		{
			show_404();
		}
		$informe_infogov = $this->informes[$informe_infogov_id];
		$tableData = array(
			'columns' => array(
				array('label' => 'Cargo', 'data' => 'descripcion', 'width' => 20, 'sortable' => 'false'),
				array('label' => 'Usuario', 'data' => 'username', 'width' => 20, 'sortable' => 'false'),
				array('label' => 'Nombre', 'data' => 'first_name', 'width' => 20, 'sortable' => 'false'),
				array('label' => 'Apellido', 'data' => 'last_name', 'width' => 20, 'sortable' => 'false'),
				array('label' => 'Orden', 'data' => 'orden', 'width' => 15, 'sortable' => 'false'),
				array('label' => '', 'data' => 'remove', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'informes_infogov_table',
			'source_url' => 'expedientes/informes_infogov/circuito_firmas_data/' . $informe_infogov_id,
			'order' => array(array(4, 'asc')),
			'disableSearching' => TRUE,
			'paging' => 'false'
		);
		$data['fields'] = array();

		$this->add_input_field($data['fields'], array(
			'name' => 'nombre', 'label' => 'Nombre', 'maxlength' => '45', 'disabled' => TRUE
			), $informe_infogov->nombre);
		$this->load->model('expedientes/cargos_model');
		$array_cargo = $this->get_array('cargos', 'descripcion', 'id', array(
			'sort_by' => 'id',
			'where' => array("id NOT IN (SELECT cargo_id FROM firmas_circuitos fc JOIN circuitos c ON fc.circuito_id=c.id WHERE c.informe_infogov=$informe_infogov_id)")
			), array(0 => '-- Seleccionar cargo --'));

		$data['array_cargo'] = $array_cargo;
		$data['informe_infogov'] = $informe_infogov;
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Expedientes - Informes Infogov';
		$this->load_template('expedientes/informes_infogov/informes_infogov_circuito_firmas', $data);
	}

	public function circuito_firmas_data($informe_infogov_id)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('cargos.descripcion, users.first_name, users.last_name, users.username, firmas_circuitos.orden, firmas_circuitos.id')
			->from('firmas_circuitos')
			->join('circuitos', 'circuitos.id=firmas_circuitos.circuito_id')
			->join('cargos', 'cargos.id=firmas_circuitos.cargo_id')
			->join('cargos_usuarios', 'cargos_usuarios.cargo_id=cargos.id', 'left')
			->join('users', 'cargos_usuarios.user_id=users.id', 'left')
			->where('informe_infogov', $informe_infogov_id)
			->where('cargos_usuarios.hasta IS NULL')
			->add_column('remove', '<a href="expedientes/informes_infogov/circuito_firmas_op/$1/del" title="Quitar"><i class="fa fa-ban"></i></a> <a href="expedientes/informes_infogov/circuito_firmas_op/$1/up" title="Subir"><i class="fa fa-arrow-up"></i></a><a href="expedientes/informes_infogov/circuito_firmas_op/$1/down" title="Bajar"><i class="fa fa-arrow-down"></i></a>', 'id');

		echo $this->datatables->generate();
	}

	public function circuito_firmas_add($informe_infogov_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $informe_infogov_id == NULL || !ctype_digit($informe_infogov_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		if (!in_array($informe_infogov_id, $this->informes_infogov))
		{
			show_404();
		}
		$cargo = $this->input->post('cargo');
		if ($cargo == 0)
		{
			$this->session->set_flashdata('error', 'Debe seleccionar un cargo');
			redirect("expedientes/informes_infogov/circuito_firmas/$informe_infogov_id", 'refresh');
		}
		$this->load->model('expedientes/cargos_model');
		$array_cargo = $this->get_array('cargos', 'descripcion', 'id', array(
			'sort_by' => 'id',
			'where' => array("id NOT IN (SELECT cargo_id FROM firmas_circuitos fc JOIN circuitos c ON fc.circuito_id=c.id WHERE c.informe_infogov=$informe_infogov_id)")
		));
		if (!array_key_exists($cargo, $array_cargo))
		{
			$this->session->set_flashdata('error', 'Cargo seleccionado no válido');
			redirect("expedientes/informes_infogov/circuito_firmas/$informe_infogov_id", 'refresh');
		}
		$this->load->model('expedientes/circuitos_model');
		$this->load->model('expedientes/firmas_circuitos_model');
		$circuito = $this->circuitos_model->get_circuito_ii($informe_infogov_id);
		$this->db->trans_begin();
		$trans_ok = TRUE;
		if ($circuito === FALSE)
		{
			$trans_ok&= $this->circuitos_model->create(array('informe_infogov' => $informe_infogov_id), FALSE);
			$circuito_id = $this->circuitos_model->get_row_id();
			$orden = 1;
		}
		else
		{
			$circuito_id = $circuito->id;
			$orden = $circuito->orden;
		}
		$trans_ok&= $this->firmas_circuitos_model->create(array(
			'circuito_id' => $circuito_id,
			'orden' => $orden,
			'cargo_id' => $cargo
			), FALSE);
		if ($this->db->trans_status() && $trans_ok)
		{
			$this->db->trans_commit();
			$this->session->set_flashdata('message', 'Se agregó la firma al circuito exitosamente');
		}
		else
		{
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Ocurrió un error al agregar firma a circuito' . '<br/>' . $this->firmas_circuitos_model->get_error());
		}
		redirect("expedientes/informes_infogov/circuito_firmas/$informe_infogov_id", 'refresh');
	}

	public function circuito_firmas_op($firma_circuito_id = NULL, $accion = '')
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $firma_circuito_id == NULL || !ctype_digit($firma_circuito_id) || !in_array($accion, array('del', 'up', 'down')))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/firmas_circuitos_model');
		$firma_circuito = $this->firmas_circuitos_model->get(array('id' => $firma_circuito_id, 'join' => array(array('table' => 'circuitos', 'where' => 'circuitos.id=firmas_circuitos.circuito_id', 'columnas' => array('circuitos.informe_infogov')))));
		if (empty($firma_circuito))
		{
			show_404();
		}
		if ($this->firmas_circuitos_model->operacion($firma_circuito, $accion))
		{
			$this->session->set_flashdata('message', 'Se modificó el circuito exitosamente');
		}
		else
		{
			$this->session->set_flashdata('error', 'Ocurrió un error al modificar el circuito');
		}
		redirect("expedientes/informes_infogov/circuito_firmas/$firma_circuito->informe_infogov", 'refresh');
	}

	protected function load_template($view = 'general_content', $view_data = NULL, $data = array())
	{
		$view_data['js'][] = 'plugins/ckeditor/ckeditor.js';
		$view_data['js'][] = 'plugins/ckeditor/adapters/jquery.js';
		$view_data['js'][] = 'plugins/ckeditor/config.js';
		$view_data['js'][] = 'plugins/ckeditor/lang/es.js';
		$view_data['css'][] = 'plugins/ckeditor/skins/bootstrapck/editor.css';
		return parent::load_template($view, $view_data, $data);
	}
}
/* End of file Informes_infogov.php */
/* Location: ./application/modules/expedientes/controllers/Informes_infogov.php */