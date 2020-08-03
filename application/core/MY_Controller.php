<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/' . str_replace('/', '%20', uri_string()));
		}
		$this->grupos = groups_names($this->ion_auth->get_users_groups()->result_array());
	}

	public function index()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			redirect(uri_string() . '/listar', 'refresh');
		}
		else
		{
			show_404();
		}
	}

	protected function set_filtro_datos_listar($post_name, $all_string, $column_name, $user_data, &$where_array)
	{
		if (!empty($_POST[$post_name]) && $this->input->post($post_name) != $all_string)
		{
			$where['column'] = $column_name;
			$where['value'] = $this->input->post($post_name);
			$where_array[] = $where;
			$this->session->set_userdata($user_data, $this->input->post($post_name));
		}
		else if (empty($_POST[$post_name]) && $this->session->userdata($user_data) !== FALSE)
		{
			$where['column'] = $column_name;
			$where['value'] = $this->session->userdata($user_data);
			$where_array[] = $where;
		}
		else
		{
			$this->session->unset_userdata($user_data);
		}
	}

	protected function set_filtro_datos_listar_nosession($post_name, $all_string, $column_name, &$where_array)
	{
		if (!empty($_POST[$post_name]) && $this->input->post($post_name) != $all_string)
		{
			$where['column'] = $column_name;
			$where['value'] = $this->input->post($post_name);
			$where_array[] = $where;
		}
	}

	public function control_combo($opt, $type)
	{
		if (empty($opt))
			return TRUE;
		$array_name = 'array_' . $type . '_control';
		if (array_key_exists($opt, $this->$array_name))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_array($model, $desc = 'descripcion', $id = 'id', $options = array(), $array_registros = array())
	{
		if (empty($options))
		{
			$options['sort_by'] = $desc;
		}

		$registros = $this->{"{$model}_model"}->get($options);
		if (!empty($registros))
		{
			foreach ($registros as $Registro)
			{
				$array_registros[$Registro->{$id}] = $Registro->{$desc};
			}
		}
		return $array_registros;
	}

	public function set_model_validation_rules($model)
	{
		foreach ($model->fields as $field)
		{
			if (empty($field['input_type']))
			{
				$this->add_input_validation_rules($field);
			}
			elseif ($field['input_type'] === 'combo')
			{
				$this->add_combo_validation_rules($field);
			}
		}
	}

	public function add_input_validation_rules($field_opts)
	{
		$name = $field_opts['name'];
		if (!isset($field_opts['label']))
		{
			$label = ucfirst($name);
		}
		else
		{
			$label = $field_opts['label'];
		}
		$rules = ''; // xss_clean no se controla mas aca

		if (isset($field_opts['required']) && $field_opts['required'])
		{
			$rules.= '|required';
		}
		if (isset($field_opts['minlength']))
		{
			$rules.= '|min_length[' . $field_opts['minlength'] . ']';
		}
		if (isset($field_opts['maxlength']))
		{
			$rules.= '|max_length[' . $field_opts['maxlength'] . ']';
		}
		if (isset($field_opts['matches']))
		{
			$rules.= '|matches[' . $field_opts['matches'] . ']';
		}

		if (isset($field_opts['type']))
		{
			switch ($field_opts['type'])
			{
				case 'integer':
					$rules.= '|integer';
					break;
				case 'numeric':
					$rules.= '|numeric';
					break;
				case 'decimal':
					$rules.= '|decimal';
					break;
				case 'money':
					$rules.= '|money';
					break;
				case 'date':
					$rules.= '|validate_date';
					break;
				case 'datetime':
					$rules.= '|validate_datetime';
					break;
				case 'cbu':
					$rules.= '|validate_cbu';
					break;
				case 'email':
					$rules.= '|valid_email';
					break;
				default:
					break;
			}
		}

		if (empty($rules))
		{
			$rules = 'trim';
		}
		$this->form_validation->set_rules($name, $label, trim($rules, '|'));
	}

	public function add_combo_validation_rules($field_opts)
	{
		$name = $field_opts['name'];
		if (!isset($field_opts['arr_name']))
		{
			$arr_name = $field_opts['name'];
		}
		else
		{
			$arr_name = $field_opts['arr_name'];
		}

		if (!isset($field_opts['label']))
		{
			$label = ucfirst($name);
		}
		else
		{
			$label = $field_opts['label'];
		}

		$rules = "callback_control_combo[$arr_name]";
		if (isset($field_opts['type']) && $field_opts['type'] === 'multiple')
		{
			$this->form_validation->set_rules($name . '[]', $label, $rules);
		}
		else
		{
			$this->form_validation->set_rules($name, $label, $rules);
		}
	}

	public function add_input_field(&$field_array, $field_opts, $def_value = NULL)
	{
		if ($def_value === NULL)
		{
			$field['value'] = $this->form_validation->set_value($field_opts['name']);
		}
		else
		{
			$field['value'] = $this->form_validation->set_value($field_opts['name'], $def_value);
		}

		foreach ($field_opts as $key => $field_opt)
		{
			$field[$key] = $field_opt;
		}

		$field['id'] = $field_opts['name'];
		$field['class'] = "form-control" . (empty($field_opts['class']) ? "" : " {$field_opts['class']}");
		if (isset($field_opts['type']))
		{
			switch ($field_opts['type'])
			{
				case 'cbu':
					$field['pattern'] = '[0-9]*';
					$field['title'] = 'Debe ingresar sólo números';
					$field['type'] = 'text';
					break;
				case 'integer':
					$field['pattern'] = '^(0|[1-9][0-9]*)$';
					$field['title'] = 'Debe ingresar sólo números';
					$field['type'] = 'text';
					break;
				case 'numeric':
					$field['pattern'] = '[0-9]*[.,]?[0-9]+';
					$field['title'] = 'Debe ingresar sólo números decimales';
					$field['type'] = 'text';
					break;
				case 'money':
					$field['pattern'] = '[-]?[0-9]+([,\.][0-9]{1,2})?';
					$field['title'] = 'Debe ingresar un importe';
					$field['type'] = 'text';
					if ($def_value !== NULL)
					{
						$field['value'] = $this->form_validation->set_value($field_opts['name'], str_replace('.', ',', $def_value));
					}
					break;
				case 'date':
					if (empty($field_opts['class']))
					{
						$field['class'] .= ' dateFormat';
					}
					$field['type'] = 'text';
					if ($def_value !== NULL)
					{
						$field['value'] = $this->form_validation->set_value($field_opts['name'], date_format(new DateTime($def_value), 'd-m-Y'));
					}
					break;
				case 'datetime':
					if (empty($field_opts['class']))
					{
						$field['class'] .= ' dateTimeFormat';
					}
					$field['type'] = 'text';
					if ($def_value !== NULL)
					{
						$field['value'] = $this->form_validation->set_value($field_opts['name'], date_format(new DateTime($def_value), 'd-m-Y H:i'));
					}
					break;
				case 'password':
					$field['type'] = 'password';
					break;
				default:
					break;
			}
		}

		if (!empty($field_opts['required']) && $field_opts['required'])
		{
			$field_opts['label'] .= '*';
		}
		$field['label'] = form_label($field_opts['label'], $field_opts['name']) . '<div style="float:right;" class="help-block with-errors"></div>';
		$field_array[$field_opts['name']] = $field;
		$form_type = empty($field['form_type']) ? 'input' : $field['form_type'];
		unset($field['disabled']);
		unset($field['form_type']);
		unset($field['label']);
		unset($field['required']);
		unset($field['minlength']);
		unset($field['matches']);

		if (!empty($field_opts['disabled']) && $field_opts['disabled'])
		{
			$field['disabled'] = '';
		}

		if (!empty($field_opts['required']) && $field_opts['required'])
		{
			$field['required'] = '';
		}

		if (!empty($field_opts['error_text']))
		{
			$field['data-error'] = $field_opts['error_text'];
		}

		if (!empty($field_opts['minlength']))
		{
			$field['data-minlength'] = $field_opts['minlength'];
		}

		if (!empty($field_opts['val_match']))
		{
			if (!empty($field_opts['val_match_text']))
			{
				$field['data-match-error'] = $field_opts['val_match_text'];
			}
			$field['data-match'] = "#" . $field_opts['val_match'];
		}

		if (isset($field_opts['onblur']))
		{
			$field['onblur'] = $field_opts['onblur'];
		}

		if ($form_type === 'input')
		{
			$form = form_input($field);
		}
		elseif ($form_type === 'textarea')
		{
			$form = form_textarea($field);
		}

//		if (!empty($field_opts['required']) && $field_opts['required'])
//		{
//			if (isset($field_opts['type']) && $field_opts['type'] === 'money')
//			{
//				$form = '<div class="input-group"><span class="input-group-addon"><i class="fa fa-dollar"></i></span>' . $form . '<span title="Requerido" class="input-group-addon"><i class="fa fa-exclamation"></i></span></div>';
//			}
//			else
//			{
//				$form = '<div class="input-group">' . $form . '<span title="Requerido" class="input-group-addon"><i class="fa fa-exclamation"></i></span></div>';
//			}
//		}
//		else
//		{
		if (isset($field_opts['type']) && $field_opts['type'] === 'money')
		{
			$form = '<div class="input-group"><span class="input-group-addon"><i class="fa fa-dollar"></i></span>' . $form . '</div>';
		}
//		}
		$field_array[$field_opts['name']]['form'] = $form;
	}

	public function add_combo_field(&$field_array, $field_opts, $values, $def_value = NULL)
	{
		if ($def_value == NULL)
		{
			$field['value'] = $this->form_validation->set_value($field_opts['name']);
		}
		else
		{
			$field['value'] = $this->form_validation->set_value($field_opts['name'], $def_value);
		}

		$field_array[$field_opts['name']]['required'] = empty($field_opts['required']) ? FALSE : $field_opts['required'];
		if (!isset($field_opts['label']))
		{
			$field_opts['label'] = ucfirst($field_opts['name']);
		}

		unset($field['disabled']);

		if (!empty($field_opts['required']) && $field_opts['required'])
		{
			$field_opts['label'] .= '*';
		}
		$label = form_label($field_opts['label'] . '<span style="float:left;" class="help-block with-errors"></span>', $field_opts['name']);

		$extras = "";
		if (!empty($field_opts['disabled']) && $field_opts['disabled'])
		{
			$extras .= " disabled";
		}

		if (!empty($field_opts['required']) && $field_opts['required'])
		{
			$extras .= " required";
		}

		if (!empty($field_opts['error_text']))
		{
			$extras .= ' data-error="' . $field_opts['error_text'] . '"';
		}

		if (isset($field_opts['onchange']))
		{
			$extras .= ' onchange="' . $field_opts['onchange'] . '"';
		}

		if (isset($field_opts['type']) && $field_opts['type'] === 'multiple')
		{
			if (isset($field_opts['plugin']) && $field_opts['plugin'] !== 'select2')
			{
				if (!isset($field_opts['disabled']))
				{
					$script = '';
					$form = form_dropdown($field_opts['name'] . '[]', $values, $field['value'], 'class="form-control duallistbox" id="' . $field_opts['name'] . '" multiple="" tabindex="-1" aria-hidden="true"' . $extras);
				}
				else
				{
					$script = '<script>
							$(document).ready(function() {
								$("#' . $field_opts['name'] . '").find("option:not(:selected)").remove().end();
							});
						</script>';
					$form = form_dropdown($field_opts['name'] . '[]', $values, $field['value'], 'class="form-control" id="' . $field_opts['name'] . '" multiple="" tabindex="-1" aria-hidden="true"' . $extras);
				}
			}
			else
			{
				if (!isset($field_opts['disabled']))
				{
					$script = '<script>
							$(document).ready(function() {
								$("#' . $field_opts['name'] . '").select2({
									placeholder: "Seleccione ' . $field_opts['label'] . '"
								});
							});
						</script>';
					$form = form_dropdown($field_opts['name'] . '[]', $values, $field['value'], 'class="form-control select2" id="' . $field_opts['name'] . '" multiple="" tabindex="-1" aria-hidden="true"' . $extras);
				}
				else
				{
					$script = '<script>
							$(document).ready(function() {
								$("#' . $field_opts['name'] . '").find("option:not(:selected)").remove().end();
							});
						</script>';
					$form = form_dropdown($field_opts['name'] . '[]', $values, $field['value'], 'class="form-control" id="' . $field_opts['name'] . '" multiple="" tabindex="-1" aria-hidden="true"' . $extras);
				}
			}
		}
		else
		{
			$script = '';
			$form = form_dropdown($field_opts['name'], $values, $field['value'], 'class="form-control" id="' . $field_opts['name'] . '"' . $extras);
		}

		$field_array[$field_opts['name']]['label'] = $script . $label;
		$field_array[$field_opts['name']]['form'] = $form;
	}

	protected function load_template($view = 'general_content', $view_data = NULL, $data = array())
	{
		$view_data['modulo'] = isset($this->modulo) ? $this->modulo : '';
		$view_data['controlador'] = $this->router->fetch_class();
		$view_data['metodo'] = $this->router->fetch_method();
		$this->load->model('alertas_model');
		$alerta_firma = $this->alertas_model->TempAlertFirma();
		$alerta_exp = $this->alertas_model->TempAlertExp();
		$alerta_rev = $this->alertas_model->TempAlertRevision();
		$alertas = array(
			array(
				'url' => 'expedientes/expedientes/listar',
				'label' => 'Busqueda de expedientes',
				'value' => '',
				'icon' => 'fa-search',
				'class_name' => ''
			),
			array(
				'url' => 'expedientes/pases/listar_pendientes_ee',
				'label' => 'Expedientes Electronico pendientes de emisión',
				'value' => $alerta_exp,
				'icon' => 'fa-sign-out',
				'class_name' => 'label-success'
			),
			array(
				'url' => 'expedientes/firmas/bandeja',
				'label' => 'Firmas pendientes',
				'value' => $alerta_firma,
				'icon' => 'fa-pencil',
				'class_name' => 'label-info'
			),
			array(
				'url' => 'expedientes/firmas/revision_archivos',
				'label' => 'Archivos pendientes de revisión',
				'value' => $alerta_rev,
				'icon' => 'fa fa-file',
				'class_name' => 'label-info'
			),
			array(
				'url' => 'expedientes/pases/listar_pendientes_r',
				'label' => 'Pases pendientes de recepción',
				'value' => '&#8226;',
				'icon' => 'fa-sign-in',
				'class_name' => 'label-danger'
			),
			array(
				'url' => 'expedientes/pases/listar_pendientes_e',
				'label' => 'Pases pendientes de emisión',
				'value' => '&#8226;',
				'icon' => 'fa-sign-out',
				'class_name' => 'label-danger'
			),
		);
		$this->session->set_userdata('alertas', $alertas);
		$usuario = array(
			'nombre' => $this->session->userdata('first_name'),
			'apellido' => $this->session->userdata('last_name'),
			'ultimo_login' => $this->session->userdata('old_last_login'),
			'login_actual' => $this->session->userdata('last_login'),
			'alertas' => $this->session->userdata('alertas')
		);
		$data['menu_collapse'] = $this->session->userdata('menu_collapse');
		$data['header'] = $this->load->view('general_header', $usuario, TRUE);
		$data['sidebar'] = $this->load->view('general_sidebar', array('permisos' => load_permisos_nav($this->grupos, $view_data['modulo'], $view_data['controlador'], $view_data['metodo'])), TRUE);
		$data['content'] = $this->load->view($view, $view_data, TRUE);
		$data['footer'] = $this->load->view('general_footer', '', TRUE);
		$this->load->view('general_template', $data);
	}
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */