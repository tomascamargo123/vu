<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Escritorio extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['accesos'] = load_permisos_escritorio($this->grupos);
		$this->load_template('general_content', $data);
	}
}
/* End of file Escritorio.php */
/* Location: ./application/controllers/Escritorio.php */