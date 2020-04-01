<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Perfil_model');
	}

	public function ver()
	{
		$usuario = $this->Perfil_model->get(array('id' => $this->ion_auth->user()->row()->id));
		if (empty($usuario))
		{
			show_404();
		}
		$this->db->where('user_id', $usuario->id);
		$this->db->where('disabled_on IS NULL');
		$last_key = $this->db->get('users_keys')->row();

		$data['usuario'] = $usuario;
		if (!empty($last_key))
		{
			$data['key'] = $last_key;
		}
		$query = $this->db->query("SELECT usuario_oficina.ID_OFICINA, oficina.nombre, usuario_oficina.ORDEN FROM sigmu.usuario_oficina JOIN sigmu.oficina ON usuario_oficina.ID_OFICINA = oficina.id WHERE usuario_oficina.ID_USUARIO = '$usuario->username' ORDER BY ORDEN ");
		$data['oficina'] = $query->result_array();
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = TITLE . ' - Ver perfil';
		//var_dump($data['oficina']);die();
		$this->load_template('perfil/perfil_ver', $data);
	}

//	function editar()
//	{
//		$usuario = $this->Perfil_model->get(array('id' => $this->ion_auth->user()->row()->id));
//		if (empty($usuario))
//		{
//			show_404();
//		}
//
//		$this->set_model_validation_rules($this->Perfil_model);
//		if ($this->form_validation->run() === TRUE)
//		{
//			$change = $this->ion_auth->change_password(
//				$this->session->userdata('identity'), $this->input->post('old'), $this->input->post('new')
//			);
//			if ($change)
//			{
//				$this->session->set_flashdata('message', $this->ion_auth->messages());
//				redirect('perfil/ver', 'refresh');
//			}
//			else
//			{
//				$this->session->set_flashdata('error', $this->ion_auth->errors());
//				redirect('perfil/editar', 'refresh');
//			}
//		}
//		$data['error'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('error')));
//
//		$data['fields'] = array();
//		foreach ($this->Perfil_model->fields as $field)
//		{
//			if (empty($field['input_type']))
//			{
//				if ($field['name'] === 'old' || $field['name'] === 'new' || $field['name'] === 'new_confirm')
//				{
//					$this->add_input_field($data['fields'], $field);
//				}
//				else
//				{
//					$this->add_input_field($data['fields'], $field, $usuario->{$field['name']});
//				}
//			}
//			elseif ($field['input_type'] == 'combo')
//			{
//				$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $usuario->{isset($field['id_name']) ? $field['id_name'] : $field['name'] . '_id'});
//			}
//		}
//
//		$data['usuario'] = $usuario;
//		$data['txt_btn'] = 'Editar';
//		$data['title'] = TITLE . ' - Editar perfil';
//		$this->load_template('perfil/perfil_editar', $data);
//	}

	function firma()
	{
		$usuario = $this->Perfil_model->get(array('id' => $this->session->userdata('user_id')));
		if (empty($usuario))
		{
			show_404();
		}
		$this->db->where('user_id', $usuario->id);
		$this->db->where('disabled_on IS NULL');
		$last_key = $this->db->get('users_keys')->row();
		$this->load->model('claves_usuarios_model');
		$this->set_model_validation_rules($this->claves_usuarios_model);
		$error_msg = FALSE;
		if ($this->form_validation->run() === TRUE)
		{

			$old = $this->input->post('old');
			$password = $this->input->post('new');
			$fecha = (new DateTime())->format('Y-m-d H:i:s');
			$this->db->trans_begin();
			$trans_ok = TRUE;
			if ($this->config->item('login_infogov'))
			{
				$query = $this->db->select('CodiUsua, CucuPers, InhaUsua')
					->where('CodiUsua', $this->session->userdata('CodiUsua'))
					->where('ClavUsua', md5($old))
					->limit(1)
					->get($this->config->item('sigmu_schema') . ".usuario");
				$clave_usuario_ok = $query->num_rows() === 1;
			}
			else
			{
				$clave_usuario_ok = $this->ion_auth->hash_password_db($usuario->id, $old);
			}
			if (!$clave_usuario_ok)
			{
				$error_msg = 'Contraseña de usuario incorrecta';
			}
			else
			{
				$key = openssl_pkey_new(array(
					"private_key_bits" => 2048,
					"private_key_type" => OPENSSL_KEYTYPE_RSA,
				));
				$private_key = '';
				if (!openssl_pkey_export($key, $private_key, $password))
				{
					$error_msg = 'Error al generar clave, contacte al administrador';
				}
				else
				{
					$key_details = openssl_pkey_get_details($key);
					$public_key = $key_details ['key'];
					$dn = array(
						"countryName" => "AR",
						"stateOrProvinceName" => "Mendoza",
						"localityName" => "Lavalle",
						"organizationName" => "Municipalidad de Lavalle",
						"organizationalUnitName" => "Oficina",
						"commonName" => "$usuario->first_name $usuario->last_name",
						"emailAddress" => "$usuario->email"
					);
					$cacert = 'file:///etc/apache2/ssl/CA/cacert.pem';
					$cakey = array('file:///etc/apache2/ssl/CA/private/cakey.pem', '8RKrl>b[uBNz+oB');
					$pr_key = openssl_pkey_get_private($key, $password);
					$csr = openssl_csr_new($dn, $key);
					$cert = openssl_csr_sign($csr, $cacert, $cakey, 365);
					if ($cert === FALSE)
					{
						$error_msg = 'Error al generar certificado';
					}
					else
					{
						$export_crt = openssl_x509_export_to_file($cert, FCPATH . "uploads/certs/$usuario->CodiUsua.expedientes.lavalle.gob.ar.crt");
						$export_p12 = openssl_pkcs12_export_to_file($cert, FCPATH . "uploads/certs/$usuario->CodiUsua.expedientes.lavalle.gob.ar.p12", $pr_key, $password);
						if ($export_crt && $export_p12)
						{
							if (!empty($last_key))
							{
								$trans_ok&= $this->claves_usuarios_model->update(array('id' => $last_key->id, 'disabled_on' => $fecha), FALSE);
							}
							$trans_ok&= $this->claves_usuarios_model->create(array(
								'user_id' => $usuario->id,
								'private_key' => $private_key,
								'public_key' => $public_key,
								'created_on' => $fecha
								), FALSE);
							$this->load->library('email');
							$this->email->initialize(array('mailtype' => 'html'));
							$message = $this->load->view('auth/email/firma.php', array('usuario' => $usuario), true);
							$this->email->clear();
							$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
							$this->email->to($usuario->email);
							$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - Certificado Firma Digital');
							$this->email->message($message);
							$this->email->attach(FCPATH . "uploads/certs/$usuario->CodiUsua.expedientes.lavalle.gob.ar.p12");
							if (!$this->email->send())
							{
								$trans_ok = FALSE;
								$error_msg = 'Error al enviar correo electrónico';
							}
						}
						else
						{
							$error_msg = 'Error al exportar certificados';
						}
					}
				}
			}
			if ($this->db->trans_status() && $trans_ok && $error_msg === FALSE)
			{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', 'Se generó la nueva clave exitosamente');
				redirect('perfil/ver', 'refresh');
			}
			else
			{
				$this->db->trans_rollback();
				if ($error_msg === FALSE)
					$error_msg = 'Error al generar clave, contacte al administrador';
			}
		}
		$data['error'] = (validation_errors() ? validation_errors() : ($error_msg ? $error_msg : $this->session->flashdata('error')));

		$data['fields'] = array();
		foreach ($this->claves_usuarios_model->fields as $field)
		{
			$this->add_input_field($data['fields'], $field);
		}

		if (!empty($last_key))
		{
			$data['key'] = $last_key;
		}
		$data['usuario'] = $usuario;
		$data['txt_btn'] = 'Editar';
		$data['title'] = TITLE . ' - Generar firma';
		$this->load_template('perfil/perfil_firma', $data);
	}

	public function primeraOficina(){
		$respuesta = explode('#', $this->input->get('nueva_primera'));
		$oficina = $respuesta[0];
		$orden = $respuesta[1];
		if($oficina == ''){
			$this->session->set_flashdata('error', 'Seleccione una oficina');
			redirect("perfil/ver", 'refresh');
		} else {
			if($this->Perfil_model->primeraOficina($this->session->userdata('username'), $oficina, $orden)){
				$this->session->set_flashdata('message', 'Oficina principal modificada correctamente');
				redirect("perfil/ver", 'refresh');
			} else {
				$this->session->set_flashdata('error', 'No se pudo cambiar la oficina principal');
				redirect("perfil/ver", 'refresh');
			}
		}
	}
}