<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/usuarios_model');
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
			->select('CodiUsua, id')
			->from("users")
			->where('CodiUsua IS NOT NULL')
			->add_column('select', '<a data-dismiss="modal" href="$1" onclick="solicitar_firma($1);" title="Solicitar Firma"><i class="fa fa-check"></i></a>', 'id');

		echo $this->datatables->generate();
	}
        
        
	public function listar_users_signers_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('CodiUsua, CONCAT(first_name, " " , last_name) AS DetaUsua, id')
			->from("users")
			->where('CodiUsua IS NOT NULL')
			->where('firma_digital',true)
			->where('organigrama', $this->session->userdata('organigrama'))
			->add_column('select', '<a data-dismiss="modal" href="$1" onclick="solicitar_firma($1);" title="Solicitar Firma"><i class="fa fa-check"></i></a>', 'id');

		echo $this->datatables->generate();
	}
}
/* End of file Usuarios.php */
/* Location: ./application/modules/expedientes/controllers/Usuarios.php */