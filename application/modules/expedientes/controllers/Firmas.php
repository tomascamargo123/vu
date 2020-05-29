<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Firmas extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('oficina_actual_id')))
		{
			redirect('expedientes/escritorio');
		}
		$this->sigmu_schema = $this->config->item('sigmu_schema');
		$this->load->model('expedientes/pases_model');
		$this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
	}

	public function bandeja()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY (HH:mm)") : "";
					}
				}
				return data;
			}';
		$tableData = array(
			'columns' => array(
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'aa.nombre', 'width' => 20),
				array('label' => 'Fecha', 'data' => 'fecha', 'sort' => 'aa.fecha', 'width' => 10, 'class' => 'dt-body-right', 'render' => $fecha_render),
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'e.ano', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'N°', 'data' => 'numero', 'sort' => 'e.numero', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'e.anexo', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'e.fojas', 'width' => 5, 'class' => 'dt-body-right'),
				array('label' => 'Carátula Exp.', 'data' => 'caratula', 'sort' => 'e.caratula', 'width' => 15),
				array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'e.objeto', 'width' => 10, 'responsive_class' => 'none'),
				array('label' => 'Solicitante', 'data' => 'CodiUsua', 'sort' => 'u.CodiUsua', 'width' => 10),
				array('label' => 'Fecha solicitud', 'data' => 'fecha_solicitud', 'sort' => 'faa.fecha_solicitud', 'width' => 10, 'class' => 'dt-body-right', 'render' => $fecha_render),
                                array('label' => 'Firmar','data' => 'seleccion','width' => 3, 'class' => 'dt-body-center','responsive_class' => 'all','sortable' => 'false','searchable' => 'false'),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'firmas_table',
			'order' => array(array(1, 'asc')),
			'source_url' => 'expedientes/firmas/bandeja_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#firmas_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#firmas_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['metodo_visual'] = 'Bandeja de Entrada';
		$data['box_title'] = 'Bandeja de Entrada';
		$data['title'] = 'Expedientes - Firmas - Bandeja de Entrada';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$this->load_template('expedientes/firmas/firmas_bandeja', $data);
	}

	public function bandeja_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('faa.id, faa.archivo_adjunto_id, faa.solicitante_id, faa.fecha_solicitud, aa.nombre, aa.tamanio, aa.tipodecontenido, aa.id_expediente, aa.descripcion, aa.fecha, e.ano, e.numero, e.anexo, e.fojas, e.caratula as caratula, e.objeto as objeto, u.CodiUsua')
			->unset_column('faa.id')
			->from('firmas_archivos_adjuntos faa')
			->join("$this->sigmu_schema.archivoadjunto aa", 'faa.archivo_adjunto_id=aa.id')
			->join("$this->sigmu_schema.expediente e", 'aa.id_expediente=e.id')
			->join("users u", 'faa.solicitante_id=u.id')
			->where('faa.usuario_id', $this->session->userdata('user_id'))
			->where("faa.firma is null")
			->where('faa.estado', 'Solicitada')
			->add_column('opciones', '<a href="expedientes/expedientes/ver/$2" title="Ver Expediente" class="btn btn-xs btn-primary" style="width: 100px;">Ver Expediente</a><br />'
                                . '<a href="expedientes/archivos_adjuntos/ver/$1" title="Ver Archivo" class="btn btn-xs btn-success" style="width: 100px;">Ver Archivo</a><br />'
                                . '<a class="btn btn-xs btn-danger" onclick="rechazar_firma($1,$2, $3);" style="width: 100px;">Rechazar Firma</a>', 'archivo_adjunto_id, id_expediente, id')
                        ->add_column('seleccion','<input type="checkbox" onclick="agregar_solicitud_firma($1,$2)">','archivo_adjunto_id, id');
		echo $this->datatables->generate();
	}

	public function bandeja_realizadas()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY (HH:mm)") : "";
					}
				}
				return data;
			}';
		$tableData = array(
			'columns' => array(
				array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'aa.nombre', 'width' => 18),
				array('label' => 'Fecha', 'data' => 'fecha', 'sort' => 'aa.fecha', 'width' => 10, 'class' => 'dt-body-right', 'render' => $fecha_render),
				array('label' => 'Firmante', 'data' => 'CodiUsua', 'sort' => 'u.CodiUsua', 'width' => 10),
				array('label' => 'Año', 'data' => 'ano', 'sort' => 'e.ano', 'width' => 4, 'class' => 'dt-body-right'),
				array('label' => 'N°', 'data' => 'numero', 'sort' => 'e.numero', 'width' => 4, 'class' => 'dt-body-right'),
				array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'e.anexo', 'width' => 4, 'class' => 'dt-body-right'),
				array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'e.fojas', 'width' => 4, 'class' => 'dt-body-right'),
				array('label' => 'Carátula Exp.', 'data' => 'caratula', 'sort' => 'e.caratula', 'width' => 15),
				array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'e.objeto', 'width' => 16),
				array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
			),
			'table_id' => 'firmas_table',
			'order' => array(array(1, 'asc')),
			'source_url' => 'expedientes/firmas/bandeja_realizadas_data',
			'reuse_var' => TRUE,
			'initComplete' => "function (){var r = $('#firmas_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#firmas_table thead').append(r);$('#search_0').css('text-align', 'center');}",
			'footer' => TRUE,
			'dom' => 'rtip'
		);
		$data['html_table'] = buildHTML($tableData);
		$data['js_table'] = buildJS($tableData);
		$data['error'] = $this->session->flashdata('error');
		$data['message'] = $this->session->flashdata('message');
		$data['metodo_visual'] = 'Realizadas sin leer';
		$data['box_title'] = 'Realizadas sin leer';
		$data['title'] = 'Expedientes - Firmas - Realizadas sin leer';
		$data['js'][] = 'js/expedientes/expedientes-varios.js';
		$this->load_template('expedientes/firmas/firmas_bandeja_realizadas', $data);
	}

	public function bandeja_realizadas_data()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->datatables
			->select('faa.id, faa.archivo_adjunto_id, faa.usuario_id, aa.nombre, aa.tamanio, aa.tipodecontenido, aa.id_expediente, aa.descripcion, aa.fecha, e.ano, e.numero, e.anexo, e.fojas, e.caratula as caratula, e.objeto as objeto, u.CodiUsua')
			->unset_column('faa.id')
			->from('firmas_archivos_adjuntos faa')
			->join("$this->sigmu_schema.archivoadjunto aa", 'faa.archivo_adjunto_id=aa.id')
			->join("$this->sigmu_schema.expediente e", 'aa.id_expediente=e.id')
			->join("users u", 'faa.usuario_id=u.id')
			->where('faa.solicitante_id', $this->session->userdata('user_id'))
			->where('faa.estado', 'Realizada')
			->where('faa.estado_lectura', 1)
			->add_column('opciones', '<a href="expedientes/expedientes/ver/$2" title="Ver Expediente" class="btn btn-xs btn-primary" style="width: 100px;">Ver Expediente</a><br /><a style="width: 100px;" href="expedientes/archivos_adjuntos/ver/$1" title="Ver Archivo" class="btn btn-xs btn-success">Ver Archivo</a><br /><a class="btn btn-xs btn-danger" onclick="marcar_leida($3);" style="width: 100px;">Marcar Leída</a>', 'archivo_adjunto_id, id_expediente, id');

		echo $this->datatables->generate();
	}

	public function marcar_leida()
	{
		if (!in_groups($this->grupos_permitidos, $this->grupos))
		{
			show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
		}
		$this->form_validation->set_rules('id', 'Firma', 'integer|required');
		$trans_ok = TRUE;
		if ($this->form_validation->run() === TRUE)
		{
			$this->load->model('expedientes/firmas_archivos_adjuntos_model');
			$trans_ok&= $this->firmas_archivos_adjuntos_model->update(array('id' => $this->input->post('id'), 'estado_lectura' => 2));

			if ($trans_ok)
			{
				echo json_encode('OK');
				return;
			}
		}
		echo json_encode('ERROR');
	}
        
        private function generar_jnlp_total(){
            $this->load->model(['perfil_model','archivos_adjuntos_model']);
            $usuario = $this->perfil_model->get(array('id' => $this->session->userdata('user_id')));
            if (empty($usuario))
            {
                    show_404();
            }
            
            $post = $this->input->post();
            $afirmar = json_decode($post['afirmar'])->id_files;
            
            $ids_str = "";
            foreach ($afirmar as $firma){
                $archivo_adjunto = $this->archivos_adjuntos_model->get(array('id' => $firma->pdf_id));
                if(empty($archivo_adjunto)){
                    continue;
                }
                $ids_str .= $firma->pdf_id;
                if($afirmar[count($afirmar)-1]->pdf_id != $firma->pdf_id){ 
                    $ids_str .= ";";
                }
                
                //REGISTRARMOS EL UN NUEVO EVENTO DE FIRMA
                $array = array(
                    'pdf_id'=>$firma->pdf_id,
                    'firm_id' => $firma->firma_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'estado' => false);
                $this->load->model('registro_firma_model');
                $this->registro_firma_model->create($array);
            }
            
            $momento = date('_Ymd_His');
            $jnlp_string = '<?xml version="1.0" encoding="utf-8"?>'
                                .'<jnlp spec="1.0+" codebase="'.  base_url().'jnlp_temp/" href="launch'.$momento.'.jnlp">'
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
                                      .'<jar href="'.  base_url().'jars/JPDFSigner-0.1.jar" main="true" />'
                                      .'<jar href="'.  base_url().'jars/iText-5.0.6.jar" />'
                                      .'<jar href="'.  base_url().'jars/log4j-1.2.15.jar" />'
                                      .'<jar href="'.  base_url().'jars/bcprov-jdk14-138.jar" />'
                                      .'<jar href="'.  base_url().'jars/axis.jar" />'
                                      .'<jar href="'.  base_url().'jars/javax.wsdl_1.6.2.v201005080631.jar" />'
                                      .'<jar href="'.  base_url().'jars/jaxrpc.jar" />'
                                      .'<jar href="'.  base_url().'jars/org.apache.commons.logging_1.0.4.v201005080501.jar" />'
                                      .'<jar href="'.  base_url().'jars/saaj.jar" />'
                                    .'</resources>'
                                    .'<applet-desc documentBase="'.  base_url().'" name="Firm.ar.J" main-class="com.jpdf.signer.FormMain" width="1" height="1">'
                                    .'<param name="posX" value="100" />'
                                    .'<param name="posY" value="100" />'
                                    .'<param name="pagina" value="ultima" />'
                                    .'<param name="urlWs" value="'.  base_url().'expedientes/service/" />'
                                    .'<param name="OthersParamsValue" value="id;'.$ids_str.'" />'
                                    .'<param name="certHash" value="" />'
                                    .'<param name="reasonOptions" value="Firma en conformidad;Firma con protesto;Revisión del documento;Aprobación del documento;Desaprobación del documento" />'
                                    .'<param name="URLVirtualToken" value="" />'
                                    .'<param name="minpasswordlength" value="" />'
                                    .'<param name="Permissions" value="all-permissions" />'
                                    .'<param name="JNLPname" value="launch'.$momento.'.jnlp" />'
                                  .'</applet-desc>'
                                .'</jnlp>';
            //file_put_contents('data_temp/firma_'.$id.'.json', json_encode($array));
            file_put_contents('jnlp_temp/launch'.$momento.'.jnlp', $jnlp_string);
            $data = ["xml_str"=>$jnlp_string,"fichero_name"=>"launch$momento.jnlp" ];
            return json_encode($data);
            
		}
		
	public function confirmar_firma(){
		if($this->input->post('password') !== NULL){
			$password = $this->input->post('password');
			$this->load->model('expedientes/usuarios_model');
			$resp = $this->usuarios_model->comprobar_usuario($password, $this->session->userdata('CodiUsua'));
			if($resp){
				echo $this->generar_jnlp_total();
			} else {
				echo '';
			}
		}
	}
}
/* End of file Firmas.php */
/* Location: ./application/modules/expedientes/controllers/Firmas.php */