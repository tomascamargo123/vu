<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Planillas extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('reclamos/reclamos_model');
		$this->load->model('reclamos/encuestas_respuestas_model');
		$this->load->model('reclamos/sectores_model');
		$this->load->model('reclamos/grupos_model');
		$this->load->model('distritos_model');
		$this->load->model('reclamos/asignaciones_distritos_model');
		$this->load->model('reclamos/asignaciones_grupos_model');
		$this->grupos = groups_names($this->ion_auth->get_users_groups()->result_array());
		$this->grupos_permitidos = array('admin', 'reclamos_admin', 'reclamos_coordinador', 'reclamos_usuario', 'reclamos_distrito', 'reclamos_consulta_general');
		$this->grupos_usuario = array('reclamos_usuario');
		$this->grupos_distrito = array('reclamos_distrito');
		if (in_groups($this->grupos_distrito, $this->grupos))
		{
			$this->usuario_distritos = $this->get_array('asignaciones_distritos', 'distrito_id', 'distrito_id', array('user_id' => $this->session->userdata('user_id')));
			if (empty($this->usuario_distritos))
			{
				$this->session->set_flashdata('error', 'Usuario sin asignación de distrito en módulo de reclamos. Contacte al administrador.');
				redirect("escritorio", 'refresh');
			}
		}
		$this->usuario_grupos = $this->get_array('asignaciones_grupos', 'grupo_id', 'grupo_id', array('user_id' => $this->session->userdata('user_id')));
		if (empty($this->usuario_grupos))
		{
			$this->session->set_flashdata('error', 'Usuario sin asignación de grupo en módulo de reclamos. Contacte al administrador.');
			redirect("escritorio", 'refresh');
		}
	}

	public function listar()
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$options_distritos = array();
			$where_distritos = '';
			if (in_groups($this->grupos_distrito, $this->grupos))
			{
				$where_distritos = '(' . implode(',', $this->usuario_distritos) . ')';
				$options_distritos = array('where' => array('id IN ' . $where_distritos));
			}

			$options_grupos = array();
			$where_grupos = '';
			if (in_groups($this->grupos_usuario, $this->grupos))
			{
				$where_grupos = '(' . implode(',', $this->usuario_grupos) . ')';
				$options_grupos = array('where' => array('id IN ' . $where_grupos));
			}

			$desde = new DateTime('- 1 week');
			$hasta = new DateTime();
			$data['desde'] = date_format($desde, 'd/m/Y');
			$data['hasta'] = date_format($hasta, 'd/m/Y');

			$data['inicio_reclamos'] = array(
				'name' => 'inicio_reclamos',
				'id' => 'inicio_reclamos',
				'class' => 'form-control pull-right daterange',
				'type' => 'text'
			);
			$data['sector_opt'] = $this->array_sector_control = $this->get_array('sectores', 'descripcion', 'id', array(), array('Todos' => 'Todos'));
			$data['sector_opt_selected'] = 'Todos';
			$data['grupo_opt'] = $this->array_grupo_control = $this->get_array('grupos', 'nombre', 'id', $options_grupos, array('Todos' => 'Todos'));
			$data['grupo_opt_selected'] = 'Todos';
			$data['distrito_opt'] = $this->array_distrito_control = $this->get_array('distritos', 'nombre', 'id', $options_distritos, array('Todos' => 'Todos'));
			$data['distrito_opt_selected'] = 'Todos';
			$data['estado_opt'] = $this->array_estado_control = array('Todos' => 'Todos', 'Pendiente' => 'Pendiente', 'En Proceso' => 'En Proceso', 'Finalizado' => 'Finalizado', 'Anulado' => 'Anulado');
			$data['estado_opt_selected'] = 'Todos';
			$data['tipo_reporte_opt'] = $this->array_tipo_reporte_control = array('Listado' => 'Listado', 'Planilla' => 'Planilla');
			$data['tipo_reporte_opt_selected'] = 'Listado';

			$this->form_validation->set_rules('distrito', 'Distrito', 'required|callback_control_combo[distrito]');
			$this->form_validation->set_rules('grupo', 'Grupo', 'required|callback_control_combo[grupo]');
			$this->form_validation->set_rules('sector', 'Sector', 'required|callback_control_combo[sector]');
			$this->form_validation->set_rules('estado', 'Estado', 'required|callback_control_combo[estado]');
			$this->form_validation->set_rules('tipo_reporte', 'Tipo Repore', 'required|callback_control_combo[tipo_reporte]');
			if ($this->form_validation->run() === TRUE)
			{
				if ($this->input->post('tipo_reporte') === 'Listado')
				{
					$reclamos_options = array(
						'select' => array(
							'rc_incidentes.id',
							'rc_incidentes.fecha_inicio',
							'rc_incidentes.tarea',
							'rc_motivos_reclamos.descripcion as motivo',
							'rc_sectores.descripcion as sector',
							'rc_incidentes.vencimiento',
							'rc_incidentes.estado',
							'rc_grupos.nombre as grupo',
							'distritos.nombre as distrito',
							'rc_prioridades.nombre as prioridad',
							'rc_incidentes.descripcion',
							'rc_incidentes.fecha_finalizacion',
							'rc_incidentes.apellido',
							'rc_incidentes.nombre',
							'rc_incidentes.mail',
							'rc_incidentes.telefono',
							'rc_incidentes.calle',
							'rc_incidentes.numero',
							'rc_incidentes.manzana',
							'rc_incidentes.casa',
							'rc_incidentes.numero_luminaria',
						),
						'join' => array(
							array(
								'table' => 'rc_sectores',
								'where' => 'rc_incidentes.sector_id = rc_sectores.id'
							),
							array(
								'table' => 'rc_grupos',
								'where' => 'rc_incidentes.grupo_id = rc_grupos.id'
							),
							array(
								'table' => 'rc_motivos_reclamos',
								'where' => 'rc_incidentes.motivo_id = rc_motivos_reclamos.id'
							),
							array(
								'table' => 'rc_prioridades',
								'where' => 'rc_incidentes.prioridad_id = rc_prioridades.id'
							),
							array(
								'table' => 'distritos',
								'where' => 'rc_incidentes.distrito_id = distritos.id'
							)
						),
						'where' => array(),
						'return_array' => TRUE
					);
				}
				else
				{
					$reclamos_options = array(
						'select' => array(
							'rc_incidentes.fecha_inicio',
							'rc_incidentes.id',
							'rc_incidentes.numero_luminaria',
							'CONCAT(distritos.nombre, " - ", rc_incidentes.calle, " N°:", rc_incidentes.numero, " M:", rc_incidentes.manzana, " C:", rc_incidentes.casa) as direccion',
							'rc_incidentes.tarea'
						),
						'join' => array(
							array(
								'table' => 'distritos',
								'where' => 'rc_incidentes.distrito_id = distritos.id'
							)
						),
						'where' => array(),
						'return_array' => TRUE
					);
				}
				if ($this->input->post('distrito') !== 'Todos')
				{
					$reclamos_options['where'][] = array(
						'column' => 'rc_incidentes.distrito_id',
						'value' => $this->input->post('distrito')
					);
				}
				if ($this->input->post('grupo') !== 'Todos')
				{
					$reclamos_options['where'][] = array(
						'column' => 'rc_incidentes.grupo_id',
						'value' => $this->input->post('grupo')
					);
				}
				if ($this->input->post('sector') !== 'Todos')
				{
					$reclamos_options['where'][] = array(
						'column' => 'rc_incidentes.sector_id',
						'value' => $this->input->post('sector')
					);
				}
				if ($this->input->post('estado') !== 'Todos')
				{
					$reclamos_options['where'][] = array(
						'column' => 'rc_incidentes.estado',
						'value' => $this->input->post('estado')
					);
				}
				if (!empty($this->input->post('inicio_reclamos')))
				{
					$desde_sql = new DateTime(str_replace('/', '-', substr($this->input->post('inicio_reclamos'), 0, 10)));
					$hasta_sql = new DateTime(str_replace('/', '-', substr($this->input->post('inicio_reclamos'), 13, 10)));
					$hasta_sql->add(new DateInterval('P1D'));
					$reclamos_options['where'][] = array(
						'column' => 'rc_incidentes.fecha_inicio >=',
						'value' => date_format($desde_sql, 'Y-m-d')
					);
					$reclamos_options['where'][] = array(
						'column' => 'rc_incidentes.fecha_inicio <',
						'value' => date_format($hasta_sql, 'Y-m-d')
					);
				}
				if (!empty($options_grupos))
				{
					$reclamos_options['where'][] = 'rc_incidentes.grupo_' . $options_grupos['where'][0];
				}
				if (!empty($options_distritos))
				{
					$reclamos_options['where'][] = 'rc_incidentes.distrito_' . $options_distritos['where'][0];
				}
				$print_data = $this->reclamos_model->get($reclamos_options);
				if (!empty($print_data))
				{
					foreach ($print_data as $i => $reclamos)
					{
						$print_data[$i]['fecha_inicio'] = date_format(new DateTime($reclamos['fecha_inicio']), 'd/m/Y');
						if ($this->input->post('tipo_reporte') === 'Listado')
						{
							$print_data[$i]['vencimiento'] = date_format(new DateTime($reclamos['vencimiento']), 'd/m/Y');
							$print_data[$i]['fecha_finalizacion'] = date_format(new DateTime($reclamos['fecha_finalizacion']), 'd/m/Y');
						}
					}
					if ($this->input->post('tipo_reporte') === 'Listado')
					{
						$this->listados_excel($print_data);
					}
					else
					{
						$this->planillas_excel($print_data, $this->input->post('sector'));
					}
				}
				else
				{
					$error = 'Sin datos para el reporte seleccionado';
				}
			}
			$data['error'] = (!empty($error)) ? $error : ((validation_errors()) ? validation_errors() : $this->session->flashdata('error'));
			$data['title'] = 'Reclamos - Planillas';
			$this->load_template('reclamos/planillas/planillas_content', $data);
		}
		else
		{
			show_404();
		}
	}

	public function listados_excel($print_data)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$this->load->library('PHPExcel');
			$this->phpexcel->getProperties()->setTitle("Reclamos")->setDescription("");
			$this->phpexcel->setActiveSheetIndex(0);
			$sheet = $this->phpexcel->getActiveSheet();
			$sheet->setTitle("Reclamos");
			$sheet->getColumnDimension('A')->setWidth(8);
			$sheet->getColumnDimension('B')->setWidth(16);
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(22);
			$sheet->getColumnDimension('E')->setWidth(22);
			$sheet->getColumnDimension('F')->setWidth(16);
			$sheet->getColumnDimension('G')->setWidth(12);
			$sheet->getColumnDimension('H')->setWidth(22);
			$sheet->getColumnDimension('I')->setWidth(22);
			$sheet->getColumnDimension('J')->setWidth(12);
			$sheet->getColumnDimension('K')->setWidth(35);
			$sheet->getColumnDimension('L')->setWidth(16);
			$sheet->getColumnDimension('M')->setWidth(16);
			$sheet->getColumnDimension('N')->setWidth(16);
			$sheet->getColumnDimension('O')->setWidth(22);
			$sheet->getColumnDimension('P')->setWidth(16);
			$sheet->getColumnDimension('Q')->setWidth(16);
			$sheet->getColumnDimension('R')->setWidth(12);
			$sheet->getColumnDimension('S')->setWidth(12);
			$sheet->getColumnDimension('T')->setWidth(12);
			$sheet->getColumnDimension('U')->setWidth(12);

			$sheet->getStyle('A1:U1')->getFont()->setBold(TRUE);
			$sheet->fromArray(array(array('N°', 'Inicio', 'Tarea', 'Motivo', 'Sector', 'Vencimiento', 'Estado', 'Grupo', 'Distrito', 'Prioridad', 'Descripción', 'Finalización', 'Apellido', 'Nombre', 'Mail', 'Teléfono', 'Calle', 'Número', 'Manzana', 'Casa', 'N° Luminaria')), NULL, 'A1');
			$sheet->fromArray($print_data, NULL, 'A2');
			$sheet->setAutoFilter($sheet->calculateWorksheetDimension());

			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"listado_reclamos.xls\"");
			header("Cache-Control: max-age=0");
			$writer = PHPExcel_IOFactory::createWriter($this->phpexcel, "Excel5");
			$writer->save('php://output');
		}
		else
		{
			show_404();
		}
	}

	public function planillas_excel($print_data, $sector_id = -1)
	{
		if (in_groups($this->grupos_permitidos, $this->grupos))
		{
			$lineas = sizeof($print_data);
			$this->load->library('PHPExcel');
			$this->phpexcel->getProperties()->setTitle("Reclamos")->setDescription("");
			$this->phpexcel->setActiveSheetIndex(0);
			$sheet = $this->phpexcel->getActiveSheet();
			$sheet->setTitle("Reclamos");
			$sheet->getColumnDimension('A')->setWidth(11);
			$sheet->getColumnDimension('B')->setWidth(6);
			$sheet->getColumnDimension('C')->setWidth(6);
			$sheet->getColumnDimension('D')->setWidth(20);
			$sheet->getColumnDimension('E')->setWidth(25);
			$sheet->getColumnDimension('F')->setWidth(6);
			$sheet->getColumnDimension('G')->setWidth(6);
			$sheet->getColumnDimension('H')->setWidth(6);
			$sheet->getColumnDimension('I')->setWidth(6);
			$sheet->getColumnDimension('J')->setWidth(6);
			$sheet->getColumnDimension('K')->setWidth(6);
			$sheet->getColumnDimension('L')->setWidth(6);
			$sheet->getColumnDimension('M')->setWidth(6);
			$sheet->getColumnDimension('N')->setWidth(6);
			$sheet->getColumnDimension('O')->setWidth(20);

			$sheet->getRowDimension('4')->setRowHeight(60);

			$sheet->getStyle('A1:O4')->getFont()->setBold(TRUE);
			$sector = $this->sectores_model->get(array('id' => $sector_id));
			if (!empty($sector) && $sector->descripcion === 'Alumbrado Público')
			{
				$sheet->fromArray(array(array('PLANILLA TIPO-MANTENIMIENTO ALUMBRADO')), NULL, 'A1');
				$sheet->fromArray(array(array('Fecha', 'N° de Reclamo', 'N° de Luminaria', 'Ubicación/Dirección', 'Descripción Trabajo', 'Materiales Utilizados', '', '', '', '', '', '', '', '', 'Observaciones Adicionales')), NULL, 'A2');
				$sheet->fromArray(array(array('', '', '', '', '', 'Fotocontrol', 'Morceto', 'Balastro', '', '', '', 'Lámparas', '', '', '')), NULL, 'A3');
				$sheet->fromArray(array(array('', '', '', '', '', '', '', 'Para Sodio 400 Exterior', 'Para Sodio 400 Interior', 'Para Sodio 250 Exterior', 'Para Sodio 250 Interior', '400 w Sodio', '250 w Sodio', '45 w Bajo Consumo', '')), NULL, 'A4');
			}
			else
			{
				$sheet->fromArray(array(array('PLANILLA TIPO-MANTENIMIENTO')), NULL, 'A1');
				$sheet->fromArray(array(array('Fecha', 'N° de Reclamo', '', 'Ubicación/Dirección', 'Descripción Trabajo', 'Materiales Utilizados', '', '', '', '', '', '', '', '', 'Observaciones Adicionales')), NULL, 'A2');
				$sheet->fromArray(array(array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '')), NULL, 'A3');
				$sheet->fromArray(array(array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '')), NULL, 'A4');
			}
			$sheet->fromArray($print_data, NULL, 'A5');
			$sheet->mergeCells('A1:O1'); //PLANILLA TIPO-MANTENIMIENTO ALUMBRADO
			$sheet->mergeCells('A2:A4'); //Fecha
			$sheet->mergeCells('B2:B4'); //N° de Reclamo 
			$sheet->mergeCells('C2:C4'); //N° de Luminaria
			$sheet->mergeCells('D2:D4'); //Ubicación/Dirección
			$sheet->mergeCells('E2:E4'); //Descripción Trabajo
			$sheet->mergeCells('F2:N2'); //Materiales Utilizados
			$sheet->mergeCells('F3:F4'); //Fotocontrol
			$sheet->mergeCells('G3:G4'); //Morceto
			$sheet->mergeCells('H3:K3'); //Balastro
			$sheet->mergeCells('L3:N3'); //Lámparas
			$sheet->mergeCells('O2:O4'); //Observaciones Adicionales
			$sheet->getStyle('A2:C2')->getAlignment()->setTextRotation(90);
			$sheet->getStyle('F3:G3')->getAlignment()->setTextRotation(90);

			$sheet->getStyle('A1:O4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
			$sheet->getStyle('H4:N4')->getAlignment()->setWrapText(true);
			$sheet->getStyle('O2')->getAlignment()->setWrapText(true);
			$sheet->getStyle('A1:O' . ($lineas + 4))->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN))));
			$sheet->getStyle('H4:N4')->getFont()->setSize(8);
			$sheet->getStyle('A1')->getFont()->setSize(22);

			header("Content-Type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=\"planilla_reclamos.xls\"");
			header("Cache-Control: max-age=0");
			$writer = PHPExcel_IOFactory::createWriter($this->phpexcel, "Excel5");
			$writer->save('php://output');
		}
		else
		{
			show_404();
		}
	}
}
/* End of file Planillas.php */
/* Location: ./application/modules/reclamos/controllers/Planillas.php */
