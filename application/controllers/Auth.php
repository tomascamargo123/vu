<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	// log the user in
	function login($last_url = NULL)
	{
		$this->data['title'] = "Municipalidad de Lavalle";

		//validate form input
		$this->form_validation->set_rules('identity', 'Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if (!empty($last_url))
				{
					redirect(str_replace('%20', '/', $last_url));
				}
				else
				{
					redirect('/', 'refresh');
				}
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			if ($this->ion_auth->logged_in())
			{
				if (!empty($last_url))
				{
					redirect(str_replace('%20', '/', $last_url));
				}
				else
				{
					redirect('/', 'refresh');
				}
			}

			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = $this->session->flashdata('message');
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'class' => 'form-control',
				'placeholder' => 'Usuario',
				'value' => $this->form_validation->set_value('identity')
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'class' => 'form-control',
				'placeholder' => 'Contraseña'
			);

			$this->_render_page('auth/login', $this->data);
		}
	}

	// log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	// forgot password
//	function forgot_password()
//	{
//		// setting validation rules by checking wheather identity is username or email
//		if ($this->config->item('identity', 'ion_auth') != 'email')
//		{
//			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_username_identity_label'), 'required');
//		}
//		else
//		{
//			$this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
//		}
//
//
//		if ($this->form_validation->run() == false)
//		{
//			// setup the input
//			$this->data['identity'] = array(
//				'name' => 'identity',
//				'id' => 'identity',
//				'class' => 'form-control',
//				'placeholder' => 'Usuario'
//			);
//
//			if ($this->config->item('identity', 'ion_auth') != 'email')
//			{
//				$this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
//			}
//			else
//			{
//				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
//			}
//
//			// set any errors and display the form
//			$this->data['message'] = $this->session->flashdata('message');
//			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
//			$this->_render_page('auth/forgot_password', $this->data);
//		}
//		else
//		{
//			$identity_column = $this->config->item('identity', 'ion_auth');
//			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
//
//			if (empty($identity))
//			{
//
//				if ($this->config->item('identity', 'ion_auth') != 'email')
//				{
//					$this->ion_auth->set_error('forgot_password_identity_not_found');
//				}
//				else
//				{
//					$this->ion_auth->set_error('forgot_password_email_not_found');
//				}
//
//				$this->session->set_flashdata('error', $this->ion_auth->errors());
//				redirect("auth/forgot_password", 'refresh');
//			}
//
//			// run the forgotten password method to email an activation code to the user
//			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
//
//			if ($forgotten)
//			{
//				// if there were no errors
//				$this->session->set_flashdata('message', $this->ion_auth->messages());
//				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
//			}
//			else
//			{
//				$this->session->set_flashdata('error', $this->ion_auth->errors());
//				redirect("auth/forgot_password", 'refresh');
//			}
//		}
//	}

	// reset password - final step for forgotten password
//	public function reset_password($code = NULL)
//	{
//		if (!$code)
//		{
//			show_404();
//		}
//
//		$user = $this->ion_auth->forgotten_password_check($code);
//
//		if ($user)
//		{
//			// if the code is valid then display the password reset form
//
//			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
//			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');
//
//			if ($this->form_validation->run() == false)
//			{
//				// display the form
//				// set the flash data error message if there is one
//				$this->data['message'] = $this->session->flashdata('message');
//				$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
//
//				$this->data['min_password_length'] = $min_password_length = $this->config->item('min_password_length', 'ion_auth');
//				$this->data['new_password'] = array(
//					'name' => 'new',
//					'id' => 'new',
//					'class' => 'form-control',
//					'type' => 'password',
//					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
//					'placeholder' => sprintf(lang('reset_password_new_password_label'), $min_password_length)
//				);
//				$this->data['new_password_confirm'] = array(
//					'name' => 'new_confirm',
//					'id' => 'new_confirm',
//					'class' => 'form-control',
//					'type' => 'password',
//					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
//					'placeholder' => lang('reset_password_new_password_confirm_label')
//				);
//				$this->data['user_id'] = array(
//					'name' => 'user_id',
//					'id' => 'user_id',
//					'type' => 'hidden',
//					'value' => $user->id,
//				);
//				$this->data['csrf'] = $this->_get_csrf_nonce();
//				$this->data['code'] = $code;
//
//				// render
//				$this->_render_page('auth/reset_password', $this->data);
//			}
//			else
//			{
//				// do we have a valid request?
//				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
//				{
//
//					// something fishy might be up
//					$this->ion_auth->clear_forgotten_password_code($code);
//
//					show_error($this->lang->line('error_csrf'));
//				}
//				else
//				{
//					// finally change the password
//					$identity = $user->{$this->config->item('identity', 'ion_auth')};
//
//					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
//
//					if ($change)
//					{
//						// if the password was successfully changed
//						$this->session->set_flashdata('message', $this->ion_auth->messages());
//						redirect("auth/login", 'refresh');
//					}
//					else
//					{
//						$this->session->set_flashdata('error', $this->ion_auth->errors());
//						redirect('auth/reset_password/' . $code, 'refresh');
//					}
//				}
//			}
//		}
//		else
//		{
//			// if the code is invalid then send them back to the forgot password page
//			$this->session->set_flashdata('error', $this->ion_auth->errors());
//			redirect("auth/forgot_password", 'refresh');
//		}
//	}

	// activate the user
	function activate($id, $code = false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data = null, $returnhtml = false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml)
			return $view_html; //This will return html on 3rd argument being true
	}
}
/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */