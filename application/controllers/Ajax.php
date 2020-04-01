<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

	public function set_menu_collapse()
	{
		$this->form_validation->set_rules('value', 'Valor', 'integer|required');
		if ($this->form_validation->run() === TRUE)
		{
			$this->session->set_userdata('menu_collapse', $this->input->post('value'));
			echo json_encode(array('ok' => 'ok'));
			return;
		}
		echo json_encode(array('error' => 'error'));
		return;
	}
}
/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */