<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Archivos_adjuntos extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/archivos_adjuntos_model');
		$this->load->model('expedientes/expedientes_model');
		$this->load->model('expedientes/pases_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
		$this->grupos_admin = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_consulta_general');
		$this->grupos_solo_consulta = array('expedientes_consulta_general');
	}

	public function listar_data($expediente_id)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $expediente_id == NULL || !ctype_digit($expediente_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array('id' => $expediente_id));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($expediente_id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('archivoadjunto.id, archivoadjunto.nombre, archivoadjunto.tamanio, archivoadjunto.tipodecontenido, archivoadjunto.id_expediente, archivoadjunto.descripcion, archivoadjunto.fecha, expediente.caratula as id_expediente')
			->unset_column('id')
			->from("$this->sigmu_schema.archivoadjunto")
			->join("$this->sigmu_schema.expediente", 'expediente.id = archivoadjunto.id_expediente', 'left')
			->where('expediente.id', $expediente->id)
			->add_column('edit', '<a href="expedientes/archivos_adjuntos/ver/$1" title="Administrar"><i class="fa fa-cogs"></i></a>', 'id');

		echo $this->datatables->generate();
	}

	public function nuevo($expediente_id)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $expediente_id == NULL || !ctype_digit($expediente_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$expediente = $this->expedientes_model->get(array('id' => $expediente_id));
		if (empty($expediente))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($expediente_id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede agregar adjuntos de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$expediente_id");
		}
		$archivos = $_FILES['archivos'];
		if (empty($archivos['name'][0]))
		{
			$cant_archivos = 0;
		}
		else
		{
			$cant_archivos = count($archivos['name']);
		}
		if ($cant_archivos != 0)
		{
			$this->load->library('upload');
			$this->load->model('expedientes/archivos_adjuntos_model');
			$pase_id = $this->archivos_adjuntos_model->get_paseId($expediente_id);
			$this->db->trans_begin();
			$trans_ok = TRUE;
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			require_once _MPDF_PATH . 'vendor/setasign/fpdi/fpdi_pdf_parser.php';
			$pdf->SetImportUse();
			for ($i = 0; $i < $cant_archivos; $i++)
			{
				if ($archivos['size'][$i] > 0)
				{
					$tmpName = $archivos['tmp_name'][$i];
					$fp = fopen($tmpName, 'r');
					$file_content = fread($fp, filesize($tmpName));
					if ($archivos['type'][$i] !== 'application/pdf')
					{
						$file_content = addslashes($file_content);
					}
					fclose($fp);
					$pase_id = $this->archivos_adjuntos_model->get_paseId($expediente_id);
					#var_dump($pase_id[0]['id']);die();
					$trans_ok&= $this->archivos_adjuntos_model->create(array(
						'nombre' => $archivos['name'][$i],
						'pase_id' => $pase_id[0]['id'],
						'tamanio' => $archivos['size'][$i],
						'tipodecontenido' => $archivos['type'][$i],
						'contenido' => $file_content,
						'id_expediente' => $expediente_id,
						'descripcion' => 'NULL',
						'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
						), FALSE);
					if ($archivos['type'][$i] === 'application/pdf')
					{
						$pagecount = $pdf->SetSourceFile($tmpName);
						$archivo_adjunto_id = $this->archivos_adjuntos_model->get_row_id();
						$query_fojas = $this->archivos_adjuntos_model->get(array('select' => 'COALESCE(MAX(foja_hasta),0)+1 as foja_desde',
							'join' => array(array('table' => 'fojas_archivos_adjuntos', 'where' => 'fojas_archivos_adjuntos.archivo_adjunto_id=archivoadjunto.id')),
							'id_expediente' => $expediente_id));
						$foja_desde = $query_fojas[0]->foja_desde;
						$this->load->model('expedientes/fojas_archivos_adjuntos_model');
						$trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
							'archivo_adjunto_id' => $archivo_adjunto_id,
							'foja_desde' => $foja_desde,
							'foja_hasta' => $foja_desde + $pagecount - 1
							), FALSE);
						if (FOJA_AUTOMATICA || $this->expedientes_model->is_digital($expediente_id))
						{
                                                        $idLastPase = $this->pases_model->getIdUltimoPase($expediente_id);
							$this->load->model('expedientes/expedientes_model');
							$trans_ok&= $this->expedientes_model->update(array(
								'id' => $expediente_id,
								'fojas' => $foja_desde + $pagecount - 1
								), FALSE);
                                                        $trans_ok &= $this->pases_model->update([
                                                            'id' => $idLastPase,
                                                            'fojas' => $foja_desde + $pagecount - 1
                                                        ],TRUE);
						}
					}
				}
			}
			if ($this->db->trans_status() && $trans_ok)
			{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', 'Archivos adjuntados');
				redirect("expedientes/expedientes/ver/$expediente_id", 'refresh');
			}
			else
			{
				$this->db->trans_rollback();
				$error_msg = 'Se ha producido un error con la base de datos.';
				if ($this->archivos_adjuntos_model->get_error())
				{
					$error_msg .='<br>' . $this->archivos_adjuntos_model->get_error();
				}
				if ($this->fojas_archivos_adjuntos_model->get_error())
				{
					$error_msg .='<br>' . $this->fojas_archivos_adjuntos_model->get_error();
				}
				$this->session->set_flashdata('error', $error_msg);
				redirect("expedientes/expedientes/ver/$expediente_id", 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'No se seleccionó ningún archivo para adjuntar');
			redirect("expedientes/expedientes/ver/$expediente_id", 'refresh');
		}
	}

	public function ver($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $id));
		if (empty($archivo_adjunto))
		{
			show_404();
		}
		$expediente = $this->expedientes_model->get(array('id' => $archivo_adjunto->id_expediente));
		if (empty($expediente))
		{
			show_404();
		}
		/* //Si el expediente no esta en su oficina no lo podra ver
                $oficina = $this->expedientes_model->get_oficina($expediente->id);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede ver adjuntos de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$expediente->id");
		}*/
		$data['message'] = $this->session->flashdata('message');
		$data['error'] = $this->session->flashdata('error');

		$data['fields'] = array();
		foreach ($this->archivos_adjuntos_model->fields as $field)
		{
			$field['disabled'] = TRUE;
			if (empty($field['input_type']))
			{
				$this->add_input_field($data['fields'], $field, $archivo_adjunto->{$field['name']});
			}
			elseif ($field['input_type'] == 'combo')
			{
				if (isset($field['type']) && $field['type'] === 'multiple')
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
				}
				else
				{
					$this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $archivo_adjunto->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
				}
			}
		}

		$this->load->model('expedientes/firmas_archivos_adjuntos_model');
		$firmas = $this->firmas_archivos_adjuntos_model->get(array('archivo_adjunto_id' => $archivo_adjunto->id,
			'join' => array(
				array(
					'table' => 'users',
					'where' => 'users.id=firmas_archivos_adjuntos.usuario_id',
					'columnas' => array('users.CodiUsua as username', 'users.first_name', 'users.last_name')
				),
				array(
					'type' => 'left', 'table' => 'users s',
					'where' => 's.id=firmas_archivos_adjuntos.solicitante_id',
					'columnas' => array('s.CodiUsua as username_s', 's.first_name as first_name_s', 's.last_name as last_name_s')
				),
//				array(
//					'type' => 'left', 'table' => 'users_keys',
//					'where' => 'users_keys.user_id=firmas_archivos_adjuntos.usuario_id'
//					. ' AND firmas_archivos_adjuntos.fecha_firma >= users_keys.created_on AND firmas_archivos_adjuntos.fecha_firma <= COALESCE(users_keys.disabled_on, \'2100-01-01\')',
//					'columnas' => array('users_keys.public_key', 'users_keys.created_on', 'users_keys.disabled_on')
//				)
			)
		));
		if (!empty($firmas))
		{
			foreach ($firmas as $firma)
			{
				if (isset($firma->firma) && isset($firma->public_key))
				{
					$firma->valida = openssl_verify($archivo_adjunto->contenido, base64_decode($firma->firma), $firma->public_key, OPENSSL_ALGO_SHA256);
				}
				else
				{
					$firma->valida = FALSE;
				}
			}
		}
		$data['archivo_adjunto'] = $archivo_adjunto;
		$data['expediente'] = $expediente;
		$data['firmas'] = $firmas;
		$data['txt_btn'] = NULL;
		$data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
		$data['title'] = 'Expedientes - Ver archivo adjunto';
		$this->load_template('expedientes/archivos_adjuntos/archivos_adjuntos_abm', $data);
	}

	public function descargar_firma($id)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/firmas_archivos_adjuntos_model');
		$firma = $this->firmas_archivos_adjuntos_model->get(array('id' => $id, 'join' => array(array('table' => 'users', 'where' => 'users.id=firmas_archivos_adjuntos.usuario_id', 'columnas' => array('users.username')))));
		header('Content-type: application/x-download');
		header('Content-Disposition: attachment; filename="firma-' . $firma->username . '.dat"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($firma->firma));
		set_time_limit(0);
		echo $firma->firma;
		exit;
	}

	public function descargar_clave_publica($id)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->load->model('expedientes/firmas_archivos_adjuntos_model');
		$firma = $this->firmas_archivos_adjuntos_model->get(array('id' => $id,
			'join' => array(
				array(
					'table' => 'users',
					'where' => 'users.id=firmas_archivos_adjuntos.usuario_id',
					'columnas' => array('users.username', 'users.first_name', 'users.last_name')
				),
				array(
					'type' => 'left',
					'table' => 'users_keys',
					'where' => 'users_keys.user_id=firmas_archivos_adjuntos.usuario_id'
					. ' AND firmas_archivos_adjuntos.fecha_firma >= users_keys.created_on AND firmas_archivos_adjuntos.fecha_firma <= COALESCE(users_keys.disabled_on, \'2100-01-01\')',
					'columnas' => array('users_keys.public_key', 'users_keys.created_on', 'users_keys.disabled_on')
				)
			)
		));
		header('Content-type: application/x-download');
		header('Content-Disposition: attachment; filename="clave-publica-' . $firma->username . '.key"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($firma->public_key));
		set_time_limit(0);
		echo $firma->firma;
		exit;
	}

        public function confirmar_firma(){
			$this->session->set_userdata('firma_valida', FALSE);
			$this->load->model('perfil_model');
            $usuario = $this->perfil_model->get(array('id' => $this->session->userdata('user_id')));
            if (empty($usuario))
            {
				show_404();
			}
			if($this->input->post('password') !== NULL){
				$password = $this->input->post('password');
				$this->load->model('expedientes/usuarios_model');
				$resp = $this->usuarios_model->comprobar_usuario($password, $this->session->userdata('CodiUsua'));
				if($resp){
					$this->session->set_userdata('firma_valida', TRUE);
					echo 'Valido';
				} else {
					echo 'Error';
				}
			}
		}
		
	public function download_jnlp($id = null, $id_firma = null){
		if($this->session->userdata('firma_valida')){
			if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
			{
					show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
			}
			$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $id));
			if (empty($archivo_adjunto))
			{
					show_404();
			}
			//Impide firmar un documento que no este en la oficina
			/*$oficina = $this->expedientes_model->get_oficina($archivo_adjunto->id_expediente);
			if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
			{
					$this->session->set_flashdata('error', 'No puede firmar adjuntos de expedientes que no estén en su oficina');
					redirect("expedientes/expedientes/ver/$archivo_adjunto->id_expediente");
			}*/
			$this->load->model('perfil_model');
			$usuario = $this->perfil_model->get(array('id' => $this->session->userdata('user_id')));
			if (empty($usuario))
			{
					show_404();
			}
			$this->load->model('firmas_archivos_adjuntos_model');
			$cant = $this->firmas_archivos_adjuntos_model->get_cant_pendientes($id);
			$posX = 100;
			switch ($cant){
				case 1:
					$posX = 10;
					break;
				case 2:
					$posX = 200;
					break;
				case 3:
					$posX = 400;
					break;
				default :
					$posX = 50;
					break;
			}
			$momento = date('_Ymd_His');
			$jnlp_string = '<?xml version="1.0" encoding="utf-8"?>'
								.'<jnlp spec="1.0+" codebase="'.  base_url().'/jnlp_temp/" href="launch'.$momento.'.jnlp">'
									.'<information>'
										.'<title>Firma Online Java</title>'
										.'<vendor>Encode S.A.</vendor>'
										.'<homepage href="'.  base_url().'" />'
									.'</information>'
									.'<update check="always" policy="always"/>'
									.'<security>'
									  .'<all-permissions/>'
									.'</security>'
									.'<resources>'
									  .'<!-- Application Resources -->'
									  .'<j2se version="1.7+" href="http://java.sun.com/products/autodl/j2se"/>'
									  .'<jar href="'.  base_url().'/jars/JPDFSigner-0.1.jar" main="true" />'
									  .'<jar href="'.  base_url().'/jars/iText-5.0.6.jar" />'
									  .'<jar href="'.  base_url().'/jars/log4j-1.2.15.jar" />'
									  .'<jar href="'.  base_url().'/jars/bcprov-jdk14-138.jar" />'
									  .'<jar href="'.  base_url().'/jars/axis.jar" />'
									  .'<jar href="'.  base_url().'/jars/javax.wsdl_1.6.2.v201005080631.jar" />'
									  .'<jar href="'.  base_url().'/jars/jaxrpc.jar" />'
									  .'<jar href="'.  base_url().'/jars/org.apache.commons.logging_1.0.4.v201005080501.jar" />'
									  .'<jar href="'.  base_url().'/jars/saaj.jar" />'
									.'</resources>'
									.'<applet-desc documentBase="'.  base_url().'" name="Firm.ar.J" main-class="com.jpdf.signer.FormMain" width="1" height="1">'
									.'<param name="posX" value="'.$posX.'" />'
									.'<param name="posY" value="100" />'
									.'<param name="pagina" value="ultima" />'
									.'<param name="urlWs" value="'.  base_url().'/expedientes/service/" />'
									.'<param name="OthersParamsValue" value="id;'.$id.'" />'
									.'<param name="certHash" value="" />'
									.'<param name="reasonOptions" value="Firma en conformidad;Firma con protesto" />'//Revisión del documento;Aprobación del documento;Desaprobación del documento
									.'<param name="URLVirtualToken" value="" />'
									.'<param name="minpasswordlength" value="" />'
									.'<param name="Permissions" value="all-permissions" />'
									.'<param name="JNLPname" value="launch'.$momento.'.jnlp" />'
								  .'</applet-desc>'
								.'</jnlp>';
			$array = array(
				'pdf_id'=>$id,
				'firm_id' => $id_firma,
				'user_id' => $this->session->userdata('user_id'),
				'estado' => false);
			$this->load->model('registro_firma_model');
			$this->registro_firma_model->create($array);
			//file_put_contents('data_temp/firma_'.$id.'.json', json_encode($array));
			file_put_contents('jnlp_temp/launch'.$momento.'.jnlp', $jnlp_string);
	
			header("Content-Type: text/plain");
			header('Content-Disposition: attachment; filename="launch'.$momento.'.jnlp"');
			echo $jnlp_string;
			$this->session->set_userdata('firma_valida', FALSE);

		} else {
			show_404();
		}	
	}

	public function firmar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $id));
		if (empty($archivo_adjunto))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($archivo_adjunto->id_expediente);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede firmar adjuntos de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$archivo_adjunto->id_expediente");
		}
		$this->load->model('perfil_model');
		$usuario = $this->perfil_model->get(array('id' => $this->session->userdata('user_id')));
		/* validación con certificado al firmar deshabilitada momentaneamente * /
		  $datos_certificado_cliente = array('user' => $this->input->server('SSL_CLIENT_S_DN_CN'), 'email' => $this->input->server('SSL_CLIENT_S_DN_Email'));
		  if ($datos_certificado_cliente['user'] != "$usuario->first_name $usuario->last_name" || $datos_certificado_cliente['email'] != $usuario->email)
		  {
		  lm($datos_certificado_cliente);
		  lm($usuario);
		  $this->session->set_flashdata('error', 'El certificado de cliente no coincide con el usuario logueado.');
		  redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
		  }
		  /* */
		if (empty($usuario))
		{
			show_404();
		}
		$this->db->where('user_id', $usuario->id);
		$this->db->where('disabled_on IS NULL');
		$key = $this->db->get('users_keys')->row();
		if (empty($key))
		{
			$this->session->set_flashdata('error', 'No tiene una clave asociada, por favor cree una desde el menú de Perfil de Usuario para poder realizar firmas.');
			redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
		}

		$firma_model = new stdClass();
		$firma_model->fields = array(
			array('name' => 'clave_firma', 'label' => 'Contraseña de firma', 'minlength' => '8', 'maxlength' => '32', 'type' => 'password', 'required' => TRUE, 'error_text' => 'Completa este campo. Mínimo 8 caracteres'),
			array('name' => 'firma_id', 'label' => 'Id Firma', 'type' => 'integer', 'required' => TRUE)
		);
		$this->set_model_validation_rules($firma_model);
		if ($this->form_validation->run() === TRUE)
		{
			$private_key = openssl_get_privatekey($key->private_key, $this->input->post('clave_firma'));
			if ($private_key === FALSE)
			{
				$this->session->set_flashdata('error', 'La contraseña introducida no coincide con la clave asociada, por favor intente nuevamente.');
				redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
			}
			$signature = '';
			if (openssl_sign($archivo_adjunto->contenido, $signature, $private_key, OPENSSL_ALGO_SHA256))
			{
				$trans_ok = TRUE;
				$this->load->model('expedientes/firmas_archivos_adjuntos_model');
				if ($this->input->post('firma_id'))
				{
					$firma = $this->firmas_archivos_adjuntos_model->get(array('id' => $this->input->post('firma_id')));
					if (empty($firma))
					{
						show_404();
					}
					elseif ($usuario->id !== $firma->usuario_id)
					{
						$this->session->set_flashdata('error', 'El usuario de la solicitud no coincide con el usuario logueado.');
						redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
					}
					$trans_ok&= $this->firmas_archivos_adjuntos_model->update(array(
						'id' => $firma->id,
						'estado' => 'Realizada',
						'estado_lectura' => 1,
						'fecha_firma' => (new DateTime())->format('Y-m-d H:i:s'),
						'firma' => base64_encode($signature)));
				}
				else
				{
					$trans_ok&= $this->firmas_archivos_adjuntos_model->create(array(
						'archivo_adjunto_id' => $id,
						'estado' => 'Realizada',
						'estado_lectura' => 2,
						'usuario_id' => $usuario->id,
						'fecha_firma' => (new DateTime())->format('Y-m-d H:i:s'),
						'firma' => base64_encode($signature)));
				}
				if ($trans_ok)
				{
					$this->session->set_flashdata('message', 'El documento se firmó exitosamente.');
					redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
				}
			}
		}
		$this->session->set_flashdata('error', 'Ocurrió un error al intentar firmar el documento, por favor intente nuevamente.');
		redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
	}

	public function rechazar_firma($id = NULL, $bandeja = NULL,$idexp)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $id));
		if (empty($archivo_adjunto))
		{
			show_404();
		}
		$this->load->model('perfil_model');
		$usuario = $this->perfil_model->get(array('id' => $this->session->userdata('user_id')));
		if (empty($usuario))
		{
			show_404();
		}
		$firma_model = new stdClass();
		$firma_model->fields = array(
			array('name' => 'motivo_rechazo', 'label' => 'Motivo rechazo', 'maxlength' => '255', 'required' => TRUE, 'error_text' => 'Completa este campo.'),
			array('name' => 'rechazar_firma_id', 'label' => 'Id Firma', 'type' => 'integer', 'required' => TRUE)
		);
		$this->set_model_validation_rules($firma_model);
		if ($this->form_validation->run() === TRUE)
		{
			$trans_ok = TRUE;
			$this->load->model('expedientes/firmas_archivos_adjuntos_model');
			$firma_id = $this->input->post('rechazar_firma_id');
			$firma = $this->firmas_archivos_adjuntos_model->get(array('id' => $firma_id));
			if (empty($firma))
			{
				show_404();
			}
			elseif ($usuario->id !== $firma->usuario_id)
			{
				$this->session->set_flashdata('error', 'El usuario de la solicitud no coincide con el usuario logueado.');
				redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
			}
			$trans_ok &= $this->firmas_archivos_adjuntos_model->update(array(
				'id' => $firma->id,
				'estado' => 'Rechazada',
				'estado_lectura' => 1,
				'fecha_rechazo' => (new DateTime())->format('Y-m-d H:i:s'),
				'motivo_rechazo' => $this->input->post('motivo_rechazo')
			)); 
			if(!$this->firmas_archivos_adjuntos_model->tieneFirmaPendiente($idexp)){
				$this->load->model('expedientes_model');
				$trans_ok &= $this->expedientes_model->firma_pendiente($idexp,false);
			}
			if ($trans_ok)
			{
				$this->session->set_flashdata('message', 'Se rechazó la solicitud de firma exitosamente.');
				if (!empty($bandeja))
				{
					redirect("expedientes/firmas/bandeja", 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', 'Ocurrió un error al intentar rechazar la firma del documento, por favor intente nuevamente.');
					redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');
				}
			}
		}
		redirect("expedientes/archivos_adjuntos/ver/$id", 'refresh');

	}

	public function solicitar_firma($archivo_id = NULL, $usuario_id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $archivo_id == NULL || !ctype_digit($archivo_id) || $usuario_id == NULL || !ctype_digit($usuario_id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $archivo_id));
		if (empty($archivo_adjunto))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($archivo_adjunto->id_expediente);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede solicitar firmas de adjuntos de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$archivo_adjunto->id_expediente");
		}
		$this->load->model('perfil_model');
		$usuario = $this->perfil_model->get(array('id' => $usuario_id));
		if (empty($usuario))
		{
			show_404();
		}
		$trans_ok = TRUE;
                
                $this->load->model('expedientes/expedientes_model');
                $trans_ok &= $this->expedientes_model->firma_pendiente($archivo_adjunto->id_expediente,true);
                
		$this->load->model('expedientes/firmas_archivos_adjuntos_model');                
		$trans_ok&= $this->firmas_archivos_adjuntos_model->create(array(
			'estado' => 'Solicitada',
			'estado_lectura' => '0', // Como entero lo toma como NULL y da error
			'fecha_solicitud' => date_format(new DateTime(), 'Y-m-d H:i:s'),
			'solicitante_id' => $this->session->userdata('user_id'),
			'archivo_adjunto_id' => $archivo_adjunto->id,
			'usuario_id' => $usuario->id
		));
		if ($trans_ok)
		{
			$this->session->set_flashdata('message', 'Se solicitó la firma del documento exitosamente.');
			redirect("expedientes/expedientes/ver/$archivo_adjunto->id_expediente", 'refresh');
		}
		else
		{
			$this->session->set_flashdata('error', 'Ocurrió un error al solicitar la firma del documento, por favor intente nuevamente.');
			redirect("expedientes/expedientes/ver/$archivo_adjunto->id_expediente", 'refresh');
		}
	}

	public function vista_preliminar($id = NULL)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $id));
		if (empty($archivo_adjunto))
		{
			show_404();
		}
		header('Content-Disposition: inline; filename="' . $archivo_adjunto->nombre . '"');
		header('Content-Type: ' . (empty($archivo_adjunto->tipodecontenido) ?
				$this->mimetype($archivo_adjunto->contenido) :
				$archivo_adjunto->tipodecontenido));
//			header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
//			header('Pragma: public');
//			header('Expires: ' . date_format(new DateTime('-1 day'), 'D, d M Y H:i:s') . ' GMT');
//			header('Last-Modified: ' . date_format(new DateTime($archivo_adjunto->fecha), 'D, d M Y H:i:s') . ' GMT');
//			header('Content-Length: ' . strlen($archivo_adjunto->contenido));
//			header('Content-Disposition: inline; filename="' . basename($archivo_adjunto->nombre) . '";');
//			ob_clean();
//			flush();
		echo $archivo_adjunto->contenido;
		/*
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		require_once _MPDF_PATH . 'vendor/setasign/fpdi/fpdi_pdf_parser.php';
		$pdf->SetImportUse();

		$ContenidoSalida = $archivo_adjunto->contenido;
		$directorioFichero = sys_get_temp_dir();
		$tempFile = tempnam($directorioFichero, "INF").".pdf";
		$gestor = fopen($tempFile, "w");
		
		fwrite($gestor, $ContenidoSalida);
		fclose($gestor);

		$pagecount = $pdf->SetSourceFile($tempFile);

		$tplId = $pdf->ImportPage($pagecount);
		$pdf->UseTemplate($tplId);

		$pdf->setTitle($archivo_adjunto->nombre);
		$pdf->Output();*/
	}

	private function vista_img($id = NULL) //testing
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $id));
		if (empty($archivo_adjunto))
		{
			show_404();
		}
		$oficina = $this->expedientes_model->get_oficina($archivo_adjunto->id_expediente);
		if ($oficina !== $this->session->userdata('oficina_actual_id') && !in_groups($this->grupos_admin, $this->grupos))
		{
			$this->session->set_flashdata('error', 'No puede ver adjuntos de expedientes que no estén en su oficina');
			redirect("expedientes/expedientes/ver/$archivo_adjunto->id_expediente");
		}
		$tmp = tempnam(sys_get_temp_dir(), 'pdf');
		file_put_contents($tmp, $archivo_adjunto->contenido);
		$im = new Imagick($tmp);
		$im->setImageFormat('jpg');
		header('Content-Type: image/jpeg');
		echo $im;
	}
	
	private function mimetype($data)
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		//File signatures with their associated mime type
		$Types = array(
			"474946383761" => "image/gif", //GIF87a type gif
			"474946383961" => "image/gif", //GIF89a type gif
			"89504E470D0A1A0A" => "image/png",
			"FFD8FFE0" => "image/jpeg", //JFIF jpeg
			"FFD8FFE1" => "image/jpeg", //EXIF jpeg
			"FFD8FFE8" => "image/jpeg", //SPIFF jpeg
			"25504446" => "application/pdf",
			"377ABCAF271C" => "application/zip", //7-Zip zip file
			"504B0304" => "application/zip", //PK Zip file ( could also match other file types like docx, jar, etc )
		);

		$Signature = substr($data, 0, 60); //get first 60 bytes shouldnt need more then that to determine signature
		$unpack = unpack("H*", $Signature);
		$Signature = array_shift($unpack); //String representation of the hex values

		foreach ($Types as $MagicNumber => $Mime)
		{
			if (stripos($Signature, $MagicNumber) === 0)
				return $Mime;
		}

		//Return octet-stream (binary content type) if no signature is found
		return "application/octet-stream";
	}

	public function eliminar(){
		$id = $this->input->post('id');
		$id_expediente = $this->input->post('id_expediente');
		if($id != NULL){
			$this->load->model('expedientes/archivos_adjuntos_model');
			$this->load->model('expedientes/expedientes_model');
			$this->load->model('expedientes/pases_model');
			$adjunto_pdf = $this->archivos_adjuntos_model->get(array('id' => $id, 'tipodecontenido' => 'application/pdf', 'sort_by' => 'id'));
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			require_once _MPDF_PATH . 'vendor/setasign/fpdi/fpdi_pdf_parser.php';
			$pdf->SetImportUse();

			$tmp_file = tempnam('tmp', 'tmp');
			file_put_contents($tmp_file, $adjunto_pdf->contenido);
			$pagecount = $pdf->SetSourceFile($tmp_file);

			$ultimo_pase = $this->pases_model->get(array(
				'select' => 'id, fojas',
				'where' => array('id_expediente = ' . $id_expediente),
				'sort_by' => array('id DESC'),
				'limit' => 1
			));			

			$this->archivos_adjuntos_model->delete(array('id' => $id), FALSE);

			$this->pases_model->update(array(
				'id' => $ultimo_pase[0]->id,
				'fojas' => (intval($ultimo_pase[0]->fojas) - intval($pagecount))
			));

			$this->expedientes_model->update(array(
				'id' => $id_expediente,
				'fojas' => (intval($ultimo_pase[0]->fojas) - intval($pagecount))
			));
		}
	}
}
/* End of file Archivos_adjuntos.php */
/* Location: ./application/modules/expedientes/controllers/Archivos_adjuntos.php */