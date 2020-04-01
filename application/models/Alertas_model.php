<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alertas_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get()
	{
		$alertas = array();
		$this->sigmu_schema = $this->config->item('sigmu_schema');
                
                
                $alertas[] = new Alerta('Busqueda de expedientes','','expedientes/expedientes/listar','fa-search', '');

		$pend_emision_e = $this->db->select('COUNT(pase.id) as cantidad')
				->from("$this->sigmu_schema.pase")
				->join("$this->sigmu_schema.oficina", 'oficina.id = pase.origen', 'left')
				->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente', 'left')
                                ->join("$this->sigmu_schema.tramite", "tramite.id = expediente.tramite_id")
				->where('pase.origen', $this->session->userdata('oficina_actual_id'))
				->where("(pase.respuesta = 'pendiente' OR pase.respuesta = 'rechazado' OR pase.respuesta = 'firma pendiente')")
				->where("(pase.destino = -1 OR pase.destino = -2)")
                                ->where("(expediente.digital = 1 OR expediente.digital = 2)")
				->get()->row();
		if ($pend_emision_e->cantidad > 0)
		{
			$alertas[] = new Alerta('Expedientes Electronico pendientes de emisión', $pend_emision_e->cantidad, 'expedientes/pases/listar_pendientes_ee', 'fa-sign-out','label-success');
		}

                $firmas_pend = $this->db->select('COUNT(1) as cantidad')
				->from('firmas_archivos_adjuntos faa')
				->where('faa.usuario_id', $this->session->userdata('user_id'))
				->where("faa.firma is null")
				->where('faa.estado', 'Solicitada')
				->get()->row();
		if ($firmas_pend->cantidad > 0)
		{
			$alertas[] = new Alerta('Firmas pendientes', $firmas_pend->cantidad, 'expedientes/firmas/bandeja', 'fa-pencil','label-info');
		}

		$pend_recepcion = $this->db->select('COUNT(1) as cantidad')
				->from("$this->sigmu_schema.pase")
				->where('pase.respuesta', 'pendiente')
				->where('pase.destino', $this->session->userdata('oficina_actual_id'))
				->get()->row();
		if ($pend_recepcion->cantidad > 0)
		{
			$alertas[] = new Alerta('Pases pendientes de recepción', $pend_recepcion->cantidad, 'expedientes/pases/listar_pendientes_r', 'fa-sign-in');
		}

		$pend_emision = $this->db->select('COUNT(1) as cantidad')
				->from("$this->sigmu_schema.pase")
				->join("$this->sigmu_schema.oficina", 'oficina.id = pase.origen', 'left')
				->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente', 'left')
				->join("$this->sigmu_schema.tramite", "tramite.id = expediente.tramite_id")
                                ->where('pase.origen', $this->session->userdata('oficina_actual_id'))
				->where("(pase.respuesta = 'pendiente' OR pase.respuesta = 'rechazado')")
				->where("(pase.destino = -1 OR pase.destino = -2)")
                                ->where("expediente.digital = 0")
				->get()->row();
		if ($pend_emision->cantidad > 0)
		{
			$alertas[] = new Alerta('Pases pendientes de emisión', $pend_emision->cantidad, 'expedientes/pases/listar_pendientes_e', 'fa-sign-out');
		}
                
		$firmas = $this->db->select('COUNT(1) as cantidad')
				->from('firmas_archivos_adjuntos faa')
				->where('faa.solicitante_id', $this->session->userdata('user_id'))
				->where('faa.estado', 'Realizada')
				->where('faa.estado_lectura', 1)
				->get()->row();
		if ($firmas->cantidad > 0)
		{
			$alertas[] = new Alerta('Firmas realizadas', $firmas->cantidad, 'expedientes/firmas/bandeja_realizadas', 'fa-pencil-square-o', 'label-success');
		}
                
		return $alertas;
	}
}

class Alerta
{

	public $url;
	public $label;
	public $value;
	public $icon;
	public $class_name;

	public function __construct($label, $value, $url, $icon, $class_name = 'label-danger')
	{
		$this->label = $label;
		$this->value = $value;
		$this->url = $url;
		$this->icon = $icon;
		$this->class_name = $class_name;
	}
}