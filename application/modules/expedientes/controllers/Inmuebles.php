<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inmuebles extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/inmuebles_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
	}

	public function listar_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('inmueble.CodiInmu, inmueble.CucuPers, persona.DetaPers, inmueble.NomeInmu, inmueble.DecpInmu, inmueble.NupoInmu, inmueble.DelpInmu, persona.DetaPers')
			->unset_column('id')
			->from("$this->sigmu_schema.inmueble")
			->join("$this->sigmu_schema.persona", 'inmueble.CucuPers=persona.CucuPers', 'left')
			->add_column('select', '<a data-dismiss="modal" href="" onclick="$(\'#inmueble_id\').val(\'$1\');$(\'#inmueble\').val(\'$2\');" title="Seleccionar"><i class="fa fa-check"></i></a>', 'CodiInmu,NomeInmu');

		echo $this->datatables->generate();
	}
}
/* End of file Inmuebles.php */
/* Location: ./application/modules/expedientes/controllers/Inmuebles.php */