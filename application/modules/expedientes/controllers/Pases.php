<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pases extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('oficina_actual_id'))) {
            redirect('expedientes/escritorio');
        }
        $this->sigmu_schema = $this->config->item('sigmu_schema');
        $this->load->model('expedientes/pases_model');
        $this->grupos_permitidos = array('admin', 'expedientes_admin', 'expedientes_supervision', 'expedientes_usuario', 'expedientes_consulta_general');
        $this->grupos_solo_consulta = array('expedientes_consulta_general');
    }

    public function listar_pendientes_r() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }

        $this->load->model('pases_model');
        /* 
        $cant_rollback = $this->pases_model->roollback_pases($this->session->userdata('oficina_actual_id'));
        if ($cant_rollback > 0)
            $data['alert_message'] = 'Se han enctontrado ' . $cant_rollback . ' pases vencidos en recepcion. Han sido vueltos a la oficina de origen.';
        */
        //// <editor-fold defaultstate="collapsed" desc="ORIGINAL">
        $nota_render = 'function (data, type, full, meta) {
				if(type === "display") {
					if(data) {
						data = \'<a href="javascript:ver_nota_pase(\' + data + \');" title="Ver" class="btn btn-xs btn-primary">Ver</a>\';
					}
				}
				return data;
			}';
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
                array('label' => 'Cód.Barra', 'data' => 'codigo', 'sort' => 'expediente.id', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
                array('label' => 'Año', 'data' => 'ano', 'sort' => 'pase.ano', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
                array('label' => 'Número', 'data' => 'numero', 'sort' => 'pase.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'pase.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'pase.fojas', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Origen', 'data' => 'oficina_origen', 'sort' => 'oficina.nombre', 'width' => 10, 'query' => 'like'),
                array('label' => 'Fecha recepción', 'data' => 'fecha_usuario', 'sort' => 'pase.fecha_usuario', 'width' => 11, 'class' => 'dt-body-right', 'render' => $fecha_render, 'query' => 'like'),
                array('label' => 'Trámite', 'data' => 'tramite_nombre', 'sort' => 'tramite.nombre', 'width' => 13, 'query' => 'like'),
                array('label' => 'Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 13, 'query' => 'like'),
                array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 13, 'query' => 'like'),
                array('label' => 'Emisor', 'data' => 'usuario_emisor', 'sort' => 'pase.usuario_emisor', 'width' => 10, 'query' => 'like'),
                array('label' => 'Nota', 'data' => 'nota_pase_id', 'sort' => 'notapase.id', 'width' => 5, 'class' => 'dt-body-center', 'render' => $nota_render),
                array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false'),
            ),
            'table_id' => 'pases_recepcion_table',
            'order' => array(array(6, 'desc')),
            'source_url' => 'expedientes/pases/listar_pendientes_r_data',
            'reuse_var' => TRUE,
            'initComplete' => "function (){var r = $('#pases_recepcion_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#pases_recepcion_table thead').append(r);$('#search_0').css('text-align', 'center');}",
            'footer' => TRUE,
            'fnRowCallback' => 'function (row, data, index){if(moment(data.fecha_usuario).diff(moment(),\'days\')<=-10){$(row).addClass(\'pase-atrasado\');}else if(moment(data.fecha_usuario).diff(moment(),\'days\')<=-3){$(row).addClass(\'pase-pase-demorado\');}}',
            'dom' => 'rtip'
        );

        if (empty($this->session->userdata('carrito'))) {
            $this->session->set_userdata('carrito', array());
        }
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['ticket_id'] = $this->session->flashdata('ticket_id');
        $data['metodo_visual'] = 'Pendientes de recepción';
        $data['box_title'] = 'Pendientes de recepción en ' . $this->session->userdata('oficina_actual');
        $data['title'] = 'Expedientes - Pases - Pendientes de recepción';
        $data['js'][] = 'js/expedientes/expedientes-varios.js';
        $this->load_template('expedientes/pases/pases_listar', $data);
        // </editor-fold>
        
    }

    public function listar_pendientes_r_data() {
        $data = $this->input->post('data');
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }

        $carrito = $this->session->userdata('carrito');
        $array_idexp_c = "(0";
        foreach ($carrito as $pase) {
            $array_idexp_c .= "," . $pase['id_expediente'];
        }
        $array_idexp_c .= ")";


        $this->datatables
                ->select('pase.id, expediente.id as codigo, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, pase.fecha_usuario, tramite.nombre as tramite_nombre, expediente.caratula as caratula, expediente.objeto as objeto, pase.usuario_emisor, pase.nota_pase_id, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn')
                ->unset_column('pase.id')
                ->exact_where_column('ano,numero,anexo')
                ->from("$this->sigmu_schema.pase")
                ->join("$this->sigmu_schema.oficina", 'oficina.id = pase.origen', 'inner')
                ->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente', 'inner')
                ->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'inner')
                ->where('pase.respuesta', 'pendiente')
                ->where("pase.id_expediente NOT IN ", $array_idexp_c, false)
                ->where('pase.destino', $this->session->userdata('oficina_actual_id'));
                if($data != ""){
                    $query = json_decode($data, TRUE);
                    foreach($query as $q){
                        if($q['query'] == 'like'){
                            $this->datatables->like($q['name'], $q['value']);
                        } else {
                            $this->datatables->where($q['name'], $q['value']);
                        }
                    }
                }
                $this->datatables
                ->add_column('opciones', '<button onclick="recibir($1)" id="button_rec_$1" title="Recibir Pase" class="btn btn-xs btn-success btn-recibir" style="width: 100px;display: $3">Recibir Pase</button><br />'
                        . '<button title="Rechazar Pase" class="btn btn-xs btn-danger" style="width: 100px;display: $3" onclick="setIdPase($1)" data-toggle="modal" data-target="#confirmacion_rechazo_modal">Rechazar Pase</button>'
                        . '<button title="Enviar a carrito" class="btn btn-xs btn-warning" onclick="f_enviar_a_carrito($2,this)" style="width: 100px;display: $3">Enviar a Carrito</button>', 'id,codigo,show_btn');
                        if($data == ""){
                            $this->datatables->set_limit(10);
                        }
        echo $this->datatables->generate();
    }

    public function listar_pendientes_e() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $nota_render = 'function (data, type, full, meta) {
				if(type === "display") {
					if(data) {
						data = \'<a href="expedientes/notas_pases/editar/\'+full.id+\'/\'+data+\'" title="Modificar" class="btn btn-xs btn-primary">Modificar</a>\';
					}else{
						data = \'<a href="expedientes/notas_pases/agregar/\'+full.id+\'" title="Agregar" class="btn btn-xs btn-primary">+</a>\';
					}
				}
				return data;
			}';
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
                array('label' => 'Cód.Barra', 'data' => 'codigo', 'sort' => 'expediente.id', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
                array('label' => 'Año', 'data' => 'ano', 'sort' => 'pase.ano', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Número', 'data' => 'numero', 'sort' => 'pase.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'pase.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'pase.fojas', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Origen', 'data' => 'oficina_origen', 'sort' => 'oficina.nombre', 'width' => 12, 'query' => 'like'),
                array('label' => 'Solicitante / Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 15, 'query' => 'like'),
                array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 13, 'query' => 'like'),
                array('label' => 'Nota', 'data' => 'nota_pase_id', 'sort' => 'nota_pase_id', 'width' => 6, 'class' => 'dt-body-center', 'render' => $nota_render),
                array('label' => 'Receptor', 'data' => 'usuario_emisor', 'sort' => 'pase.usuario_emisor', 'width' => 12, 'query' => 'like'),
                array('label' => 'Fecha recepción', 'data' => 'fecha_usuario', 'sort' => 'pase.fecha_usuario', 'width' => 12, 'class' => 'dt-body-right', 'render' => $fecha_render, 'query' => 'like'),
                array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'pases_emision_table',
            'order' => array(array(1, 'desc'), array(2, 'desc')),
            'source_url' => 'expedientes/pases/listar_pendientes_e_data',
            'reuse_var' => TRUE,
            'initComplete' => "function (){var r = $('#pases_emision_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#pases_emision_table thead').append(r);$('#search_0').css('text-align', 'center');}",
            'footer' => TRUE,
            'dom' => 'rtip'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['metodo_visual'] = 'Pendientes de emisión';
        $data['box_title'] = 'Pendientes de emisión';
        $data['title'] = 'Expedientes - Pases - Pendientes de emisión';
        $data['js'][] = 'js/expedientes/expedientes-varios.js';
        $this->load_template('expedientes/pases/pases_listar', $data);
    }

    public function listar_pendientes_e_data() {
        $data = $this->input->post('data');
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
            ->select('pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;","") as btn_disabled, IF(pase.etapa_circuito > 0,"","") as btn_salir_circuito', FALSE)
            ->unset_column('pase.id')
            ->exact_where_column('ano,numero,anexo')
            ->from("$this->sigmu_schema.pase")
            ->join("$this->sigmu_schema.oficina", 'oficina.id = pase.origen', 'inner')
            ->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente', 'inner')
            ->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'inner')
            ->where('pase.origen', $this->session->userdata('oficina_actual_id'))
            ->where("(pase.respuesta = 'pendiente' OR pase.respuesta = 'rechazado' OR (pase.origen = 1 AND pase.respuesta = 'finalizado'))")
            ->where("(pase.destino = -1 OR pase.destino = -2)")
            ->where("(expediente.digital = 0)");
        if($data != ""){
            $query = json_decode($data, TRUE);
			foreach($query as $q){
				if($q['query'] == 'like'){
					$this->datatables->like($q['name'], $q['value']);
				} else {
					$this->datatables->where($q['name'], $q['value']);
				}
			}
        }
        $this->datatables
                ->add_column('opciones', '<a href="expedientes/expedientes/ver/$2" title="Ver" class="btn btn-sm btn-primary" style="width: 100px;">Ver</a><br />'
                        . '<a href="expedientes/pases/enviar/$1/enviar/$2" title="Enviar Pase" class="btn btn-sm btn-success" style="width: 100px;$3">Enviar Pase</a><br />'
                        . '<a href="javascript:confirmar_accion($1, \'archivar\');" title="Archivar" class="btn btn-sm btn-danger" style="width: 100px;$3">Archivar</a>', 'id, idexpediente, btn_disabled, btn_salir_circuito');
                        if($data == ""){
                            $this->datatables->set_limit(10);
                        }
        echo $this->datatables->generate();
    }

    
    public function listar_pendientes_ee() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $nota_render = 'function (data, type, full, meta) {
				if(type === "display") {
					if(data) {
						data = \'<a href="expedientes/notas_pases/editar/\'+full.id+\'/\'+data+\'" title="Modificar" class="btn btn-xs btn-primary">Modificar</a>\';
					}else{
						data = \'<a href="expedientes/notas_pases/agregar/\'+full.id+\'" title="Agregar" class="btn btn-xs btn-primary">+</a>\';
					}
				}
				return data;
			}';
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
                array('label' => 'Cód.Barra', 'data' => 'codigo', 'sort' => 'pase.id', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
                array('label' => 'Año', 'data' => 'ano', 'sort' => 'pase.ano', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Número', 'data' => 'numero', 'sort' => 'pase.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'pase.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'pase.fojas', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Origen', 'data' => 'oficina_origen', 'sort' => 'oficina.nombre', 'width' => 12, 'query' => 'like'),
                array('label' => 'Solicitante / Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 15, 'query' => 'like'),
                array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 13, 'query' => 'like'),
                array('label' => 'Nota', 'data' => 'nota_pase_id', 'sort' => 'nota_pase_id', 'width' => 6, 'class' => 'dt-body-center', 'render' => $nota_render),
                array('label' => 'Emisor', 'data' => 'usuario_emisor', 'sort' => 'pase.usuario_emisor', 'width' => 12, 'query' => 'like'),
                array('label' => 'Fecha recepción', 'data' => 'fecha_usuario', 'sort' => 'pase.fecha_usuario', 'width' => 12, 'class' => 'dt-body-right', 'render' => $fecha_render),
                array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'pases_table',
            'order' => array(array(1, 'desc'), array(2, 'desc')),
            'source_url' => 'expedientes/pases/listar_pendientes_ee_data',
            'reuse_var' => TRUE,
            'initComplete' => "function (){var r = $('#pases_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#pases_table thead').append(r);$('#search_0').css('text-align', 'center');}",
            'footer' => TRUE,
            'dom' => 'rtip'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['metodo_visual'] = 'Pendientes de emisión';
        $data['box_title'] = 'Pendientes de emisión';
        $data['title'] = 'Expedientes - Pases - Pendientes de emisión';
        $data['js'][] = 'js/expedientes/expedientes-varios.js';
        $this->load_template('expedientes/pases/pases_listar', $data);
    }

    public function listar_pendientes_ee_data() {
        $data = $this->input->post('data');
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;","") as btn_disabled, IF(pase.etapa_circuito > 0,"","") as btn_salir_circuito, IF(pase.revision_id > 0 AND pase.respuesta <> "firma pendiente","display:none;","") as btn_hide_btn_others, IF(pase.revision_id > 0,"","display:none;") as btn_show_button, revision_id', FALSE)
                ->unset_column('pase.id')
                ->exact_where_column('ano,numero,anexo')
                ->from("$this->sigmu_schema.pase")
                ->join("$this->sigmu_schema.oficina", 'oficina.id = pase.origen', 'inner')
                ->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente', 'inner')
                ->join("$this->sigmu_schema.tramite", 'tramite.id = expediente.tramite_id', 'inner')
                ->where('pase.origen', $this->session->userdata('oficina_actual_id'))
                ->where("(pase.respuesta = 'pendiente' OR pase.respuesta = 'rechazado' OR pase.respuesta = 'firma pendiente' OR (pase.origen = 1 AND pase.respuesta = 'finalizado'))")
                ->where("(pase.destino = -1 OR pase.destino = -2)")
                ->where("expediente.digital = 1");
                if($data != ""){
                    $query = json_decode($data, TRUE);
                    foreach($query as $q){
                        if($q['query'] == 'like'){
                            $this->datatables->like($q['name'], $q['value']);
                        } else {
                            $this->datatables->where($q['name'], $q['value']);
                        }
                    }
                }
                $this->datatables
                ->add_column('opciones', '<a href="expedientes/expedientes/ver/$2" title="Ver" class="btn btn-sm btn-primary" style="width: 100px;$4">Ver</a>'
                        . '<a href="expedientes/pases/enviar/$1/enviar/$2" title="Enviar Pase" class="btn btn-sm btn-success" style="width: 100px;$3$4">Enviar Pase</a>'
                        . '<a href="expedientes/pases/revision/view/$1/$6" title="Ver Revision" class="btn btn-sm btn-info" style="width: 100px;$3$5">Ver Revisión</a>', 
                        'id, idexpediente, btn_disabled, btn_hide_btn_others, btn_show_button, revision_id');
                        if($data == ""){
                            $this->datatables->set_limit(10);
                        }
        echo $this->datatables->generate();
    }

    
    public function listar_archivados() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
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
        $nota_render = 'function (data, type, full, meta) {
				if(type === "display") {
					if(data) {
						data = \'<a href="javascript:ver_nota_pase(\' + data + \');" title="Ver" class="btn btn-xs btn-primary">Ver</a>\';
					}
				}
				return data;
			}';
        $tableData = array(
            'columns' => array(
                array('label' => 'Cód.Barra', 'data' => 'codigo', 'sort' => 'pase.id_expediente', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
                array('label' => 'Año', 'data' => 'ano', 'sort' => 'pase.ano', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Número', 'data' => 'numero', 'sort' => 'pase.numero', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'pase.anexo', 'width' => 5, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 14, 'query' => 'like'),
                array('label' => 'Origen', 'data' => 'oficina_origen', 'sort' => 'oficina.nombre', 'width' => 10, 'query' => 'like'),
                array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'pase.fojas', 'width' => 6, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Fecha recepción', 'data' => 'fecha', 'sort' => 'pase.fecha', 'width' => 11, 'class' => 'dt-body-right', 'render' => $fecha_render, 'query' => 'like'),
                array('label' => 'Nota', 'data' => 'nota_pase_id', 'sort' => 'nota_pase_id', 'width' => 6, 'class' => 'dt-body-center', 'render' => $nota_render),
                array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'pases_table',
            'order' => array(array(1, 'desc'), array(2, 'desc')),
            'source_url' => 'expedientes/pases/listar_archivados_data',
            'reuse_var' => TRUE,
            'initComplete' => "function (){var r = $('#pases_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#pases_table thead').append(r);$('#search_0').css('text-align', 'center');}",
            'footer' => TRUE,
            'dom' => 'rtip'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['metodo_visual'] = 'Archivados';
        $data['box_title'] = 'Archivados en ' . $this->session->userdata('oficina_actual');
        $data['title'] = 'Expedientes - Pases - Archivados';
        $data['js'][] = 'js/expedientes/expedientes-varios.js';
        $this->load_template('expedientes/pases/pases_listar', $data);
    }

    public function listar_archivados_data() {
        $data = $this->input->post('data');
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('pase.id,expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, expediente.caratula as caratula, oficina.nombre as oficina_origen, pase.fojas, pase.fecha, pase.nota_pase_id')
                ->unset_column('pase.id')
                ->exact_where_column('ano,numero,anexo')
                ->from("$this->sigmu_schema.pase")
                ->join("$this->sigmu_schema.oficina", 'oficina.id = pase.origen', 'inner')
                ->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente', 'inner')
                ->where('(pase.destino = ' . $this->session->userdata('oficina_actual_id') . ' OR (pase.destino = -1 AND pase.origen = ' . $this->session->userdata('oficina_actual_id') . '))')
                ->where('(pase.respuesta = "archivado" OR pase.respuesta = "finalizado")')
                ->where('pase.marca IS NULL');
                if($data != ""){
                    $query = json_decode($data, TRUE);
                    foreach($query as $q){
                        if($q['query'] == 'like'){
                            $this->datatables->like($q['name'], $q['value']);
                        } else {
                            $this->datatables->where($q['name'], $q['value']);
                        }
                    }
                }
                $this->datatables
                ->add_column('opciones', '<a href="expedientes/expedientes/ver/$2" title="Ver" class="btn btn-xs btn-primary" style="width: 100px;">Ver</a><br /><a href="javascript:confirmar_accion($1, \'desarchivar\');" title="Desarchivar" class="btn btn-xs btn-danger" style="width: 100px;">Desarchivar</a>', 'id, idexpediente');
                if($data == ""){
                    $this->datatables->set_limit(10);
                }
                echo $this->datatables->generate();
    }

    public function listar_enviados_sinr() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $nota_render = 'function (data, type, full, meta) {
				if(type === "display") {
					if(data) {
						data = \'<a href="javascript:ver_nota_pase(\' + data + \');" title="Ver" class="btn btn-xs btn-primary">Ver</a>\';
					}
				}
				return data;
			}';
        $fecha_render = 'function (data, type, full, meta) {
				if(type === "display"){
					if(data){
						var mDate = moment(data);
						data = (mDate && mDate.isValid()) ? mDate.format("DD/MM/YYYY HH:mm") : "";
					}
				}
				return data;
			}';
        $tableData = array(
            'columns' => array(
                array('label' => 'Cód.Barra', 'data' => 'codigo', 'sort' => 'expediente.id', 'width' => 5, 'class' => 'dt-body-right dt-body-middle', 'query' => 'where'),
                array('label' => 'Año', 'data' => 'ano', 'sort' => 'pase.ano', 'width' => 6, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Número', 'data' => 'numero', 'sort' => 'pase.numero', 'width' => 6, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'pase.anexo', 'width' => 6, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Carátula', 'data' => 'caratula', 'sort' => 'expediente.caratula', 'width' => 14, 'query' => 'like'),
                array('label' => 'Objeto', 'data' => 'objeto', 'sort' => 'expediente.objeto', 'width' => 14, 'query' => 'like'),
                array('label' => 'Fojas', 'data' => 'fojas', 'sort' => 'pase.fojas', 'width' => 6, 'class' => 'dt-body-right', 'query' => 'where'),
                array('label' => 'Emisor', 'data' => 'usuario_emisor', 'sort' => 'pase.usuario_receptor', 'width' => 11, 'query' => 'like'),
                array('label' => 'Destino', 'data' => 'oficina_destino', 'sort' => 'oficina.nombre', 'width' => 14, 'query' => 'like'),
                array('label' => 'Fecha envío', 'data' => 'fecha_usuario', 'sort' => 'pase.fecha_usuario', 'width' => 12, 'class' => 'dt-body-right', 'render' => $fecha_render),
                array('label' => 'Nota', 'data' => 'nota_pase_id', 'sort' => 'nota_pase_id', 'width' => 6, 'class' => 'dt-body-center', 'render' => $nota_render),
                array('label' => '', 'data' => 'opciones', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'pases_table',
            'order' => array(array(0, 'desc'), array(1, 'desc'), array(2, 'desc')),
            'source_url' => 'expedientes/pases/listar_enviados_sinr_data',
            'reuse_var' => TRUE,
            'initComplete' => "function (){var r = $('#pases_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#pases_table thead').append(r);$('#search_0').css('text-align', 'center');}",
            'footer' => TRUE,
            'dom' => 'rtip'
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['metodo_visual'] = 'Enviados sin recepción';
        $data['box_title'] = 'Enviados sin recepción';
        $data['title'] = 'Expedientes - Pases - Enviados sin recepción';
        $data['js'][] = 'js/expedientes/expedientes-varios.js';
        $this->load_template('expedientes/pases/pases_listar', $data);
    }

    public function listar_enviados_sinr_data() {
        $data = $this->input->post('data');
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('pase.id, expediente.id as codigo, pase.ano, pase.numero, pase.anexo, expediente.caratula as caratula, expediente.objeto as objeto, pase.fojas, pase.usuario_emisor, oficina.nombre as oficina_destino, pase.fecha_usuario, pase.nota_pase_id')
                ->unset_column('pase.id')
                ->exact_where_column('ano,numero,anexo')
                ->from("$this->sigmu_schema.pase")
                ->join("$this->sigmu_schema.oficina", 'oficina.id = pase.destino', 'inner')
                ->join("$this->sigmu_schema.expediente", 'expediente.id = pase.id_expediente AND expediente.digital = 0', 'inner')
                ->where('pase.origen', $this->session->userdata('oficina_actual_id'))
                ->where('pase.respuesta', 'pendiente')
                ->where('pase.destino !=', '-1');
                if($data != ""){
                    $query = json_decode($data, TRUE);
                    foreach($query as $q){
                        if($q['query'] == 'like'){
                            $this->datatables->like($q['name'], $q['value']);
                        } else {
                            $this->datatables->where($q['name'], $q['value']);
                        }
                    }
                }
                $this->datatables
                ->add_column('opciones', '<a href="expedientes/pases/ver/$1" title="Ver Pase" class="btn btn-xs btn-primary" style="width: 100px;">Ver Pase</a><br /><a href="expedientes/pases/enviar/$1/editar" title="Modificar envío" class="btn btn-xs btn-danger" style="width: 100px;">Modificar envío</a>', 'id');
                $this->datatables->set_limit(10);
        echo $this->datatables->generate();
    }

    public function ver($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $pase = $this->pases_model->get(array(
            'id' => $id,
            'join' => array(
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.expediente",
                    'where' => 'expediente.id=pase.id_expediente',
                    'columnas' => array('expediente.caratula as caratula', 'expediente.ano as ano', 'expediente.numero as numero', 'expediente.anexo as anexo', 'expediente.inicio as inicio', 'expediente.fojas as fojas_e', 'expediente.objeto as objeto')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.persona",
                    'where' => 'expediente.persona_id=persona.CucuPers',
                    'columnas' => array('persona.DetaPers as solicitante')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.tramite",
                    'where' => 'tramite.id=expediente.tramite_id',
                    'columnas' => array('tramite.nombre as tramite')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.notapase",
                    'where' => 'notapase.id=pase.nota_pase_id',
                    'columnas' => array('notapase.contenido as nota_pase')
                ))
        ));
        if (empty($pase)) {
            show_404();
        }
        $data['error'] = $this->session->flashdata('error');
        $fake_model_pase = array(
            array('name' => 'fecha_usuario', 'label' => 'Fecha de pase', 'type' => 'datetime'),
            array('name' => 'nota_pase', 'label' => 'Nota / Motivo'),
            array('name' => 'respuesta', 'label' => 'Estado'),
            array('name' => 'fojas', 'label' => 'Fojas', 'type' => 'integer', 'maxlength' => '9'),
            array('name' => 'solicitante', 'label' => 'Solicitante'),
            array('name' => 'tramite', 'label' => 'Trámite / Asunto'),
            array('name' => 'caratula', 'label' => 'Carátula'),
            array('name' => 'ano', 'label' => 'Año', 'type' => 'integer'),
            array('name' => 'numero', 'label' => 'Número', 'type' => 'integer'),
            array('name' => 'anexo', 'label' => 'Anexo', 'type' => 'integer'),
            array('name' => 'inicio', 'label' => 'Fecha', 'type' => 'datetime'),
            array('name' => 'fojas_e', 'label' => 'Fojas', 'type' => 'integer'),
            array('name' => 'objeto', 'label' => 'Objeto')
        );
        $data['fields'] = array();
        foreach ($fake_model_pase as $field) {
            $field['disabled'] = TRUE;
            if (empty($field['input_type'])) {
                if ($field['name'] === 'respuesta') {
                    $this->add_input_field($data['fields'], $field, strtoupper($pase->{$field['name']}));
                } else {
                    $this->add_input_field($data['fields'], $field, $pase->{$field['name']});
                }
            } elseif ($field['input_type'] == 'combo') {
                if (isset($field['type']) && $field['type'] === 'multiple') {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
                } else {
                    $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $pase->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
                }
            }
        }
        $data['pase'] = $pase;
        $data['txt_btn'] = NULL;
        $data['class'] = array('agregar' => '', 'ver' => 'active btn-app-zetta-active', 'editar' => '', 'eliminar' => '');
        $data['box_title'] = 'Pase de Expediente';
        $data['title'] = 'Expedientes - Pases - Ver';
        $this->load_template('expedientes/pases/pases_ver', $data);
    }

    public function recibir($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/pases/listar_pendientes_r", 'refresh');
        }

        $pase = $this->pases_model->get(array(
            'id' => $id,
            'join' => array(
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.expediente",
                    'where' => 'expediente.id=pase.id_expediente',
                    'columnas' => array('expediente.caratula as caratula', 'expediente.ano as ano', 'expediente.numero as numero', 'expediente.anexo as anexo', 'expediente.inicio as inicio', 'expediente.fojas as fojas_e', 'expediente.objeto as objeto')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.oficina o",
                    'where' => 'pase.origen=o.id',
                    'columnas' => array('o.nombre as origen_of')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.oficina d",
                    'where' => 'pase.destino=d.id',
                    'columnas' => array('d.nombre as destino_of')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.persona",
                    'where' => 'expediente.persona_id=persona.CucuPers',
                    'columnas' => array('persona.DetaPers as solicitante')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.tramite",
                    'where' => 'tramite.id=expediente.tramite_id',
                    'columnas' => array('tramite.nombre as tramite')
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.notapase",
                    'where' => 'notapase.id=pase.nota_pase_id',
                    'columnas' => array('notapase.contenido as nota_pase')
                )
            )
                )
        );
        if (empty($pase) || $pase->destino != $this->session->userdata('oficina_actual_id') || $pase->respuesta != 'pendiente') {
            show_404();
        }
        $data['pase'] = $pase;
        $this->load->library('pdf');
        $pase->fecha = date_format(new DateTime(), 'Y-m-d H:i:s');
        $pase->usuario_receptor = $this->session->userdata('CodiUsua');
        //creacion del pdf del pase
        $this->load->model('expedientes/expedientes_model');
        $generate_pdf = $this->expedientes_model->is_digital($pase->id_expediente);
        if ($generate_pdf) {
            $pdf = $this->pdf->load();
            $html = $this->load->view('expedientes/pases/pases_pdf', $data, TRUE);
            $pdf->WriteHTML($html);
            $pdf_content = $pdf->Output('', 'S');
        }
        $this->db->trans_begin(); ///no deja funcionar el trigger
        $trans_ok = TRUE;
        //guardamos el pdf en base de datos
        if ($generate_pdf) {
            $this->load->model('expedientes/archivos_adjuntos_model');
            $trans_ok&= $this->archivos_adjuntos_model->create(array(
                'nombre' => "Pase_{$pase->origen}-{$pase->destino}_{$pase->id}.pdf",
                'tamanio' => strlen($pdf_content),
                'tipodecontenido' => "application/pdf",
                'contenido' => $pdf_content,
                'id_expediente' => $pase->id_expediente,
                'descripcion' => 'NULL',
                'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s')
                    ), FALSE);
        }
        //registramos un nuevo ticket

        $this->load->model('ticket_model');
        $ticket_id = $this->ticket_model->registerTicket(array(
            'cantexpe' => 1,
            'usuario' => $this->session->userdata('CodiUsua'),
            'ip' => $this->input->ip_address(),
            'oficina_receptora' => $this->session->userdata('oficina_actual_id'),
            'oficina_emisora' => $pase->origen
        ));
        if ($ticket_id == 0) {
            $trans_ok = false;
        } else {
            //registramos la recepcion del pase
            //                var_dump($trans_ok);
            $respuesta_u = 'pendiente';
            $fecha_pase = null;
            if ($this->session->userdata('oficina_actual_id') == 1) {
                $respuesta_u = 'finalizado';
                $fecha_pase = date_format(new DateTime(), 'Y-m-d  H:i:s');
            }
            $num_fojas = $pase->fojas + ($generate_pdf ? numeroPaginasPdf($pdf_content) : 0);

            $trans_ok&= $this->pases_model->update(array(
                'id' => $id,
                'fecha' => $pase->fecha,
                'respuesta' => 'aceptado',
                'usuario_receptor' => $this->session->userdata('CodiUsua'),
                'ticket_id' => $ticket_id
                    ), FALSE);
            $trans_ok&= $this->pases_model->create(array(
                'id_expediente' => $pase->id_expediente,
                'ano' => $pase->ano,
                'numero' => $pase->numero,
                'anexo' => $pase->anexo,
                'origen' => $this->session->userdata('oficina_actual_id'),
                'destino' => -1,
                'respuesta' => $respuesta_u,
                'fojas' => $num_fojas,
                'fecha' => $fecha_pase,
                'usuario_emisor' => $this->session->userdata('CodiUsua'),
                'terminal' => $this->input->ip_address(),
                'fecha_usuario' => date_format(new DateTime(), 'Y-m-d  H:i:s')
                    ), FALSE);

            //aumentamos la foja automaticamente por cada pase debido al comprobante que se genera en la recepcion
            if ($generate_pdf) {
                $archivo_adjunto_id = $this->archivos_adjuntos_model->get_row_id();
                $foja_desde = $this->pases_model->getFojas($pase->id_expediente);
                $this->load->model('expedientes/fojas_archivos_adjuntos_model');
                $trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
                    'archivo_adjunto_id' => $archivo_adjunto_id,
                    'foja_desde' => $foja_desde,
                    'foja_hasta' => $foja_desde + count($pdf->pages) - 1
                        ), FALSE);
                $this->load->model('expedientes/expedientes_model');
                $trans_ok&= $this->expedientes_model->update(array(
                    'id' => $pase->id_expediente,
                    'fojas' => $foja_desde + count($pdf->pages) - 1
                        ), FALSE);
            }
        }
        if ($this->db->trans_status() && $trans_ok) {
            $this->db->trans_commit();
            $this->session->set_flashdata(array(
                'message' => 'Se aceptó el pase correctamente',
                'ticket_id' => $ticket_id
            ));
            redirect('expedientes/pases/listar_pendientes_r', 'refresh');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error al aceptar el pase');
            redirect("expedientes/pases/listar_pendientes_r", 'refresh');
        }
    }

    public function rechazar($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/pases/listar_pendientes_r", 'refresh');
        }
        $pase = $this->pases_model->get(array('id' => $id));
        if (empty($pase) || $pase->destino !== $this->session->userdata('oficina_actual_id')) {
            show_404();
        }
        $this->db->trans_begin();
        $trans_ok = TRUE;
        $trans_ok&= $this->pases_model->update(array(
            'id' => $id,
            'destino' => -2,
            'respuesta' => 'rechazado',
            'usuario_receptor' => $this->session->userdata('CodiUsua')
                ), FALSE);
        if ($this->db->trans_status() && $trans_ok) {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', 'Se rechazó el pase correctamente');
            redirect('expedientes/pases/listar_pendientes_r', 'refresh');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error al rechazar el pase');
            redirect("expedientes/pases/listar_pendientes_r", 'refresh');
        }
    }

    public function enviar($id = NULL, $tipo = 'enviar', $id_exp = 0, $salir_circuito = false) {

        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            if ($tipo === 'enviar') {
                redirect("expedientes/pases/listar_pendientes_e", 'refresh');
            } else {
                redirect("expedientes/pases/listar_enviados_sinr", 'refresh');
            }
        }
        $pase = $this->pases_model->get(array(
            'id' => $id,
            'join' => array(
                array(
                    'type' => 'LEFT',
                    'table' => "$this->sigmu_schema.expediente e",
                    'where' => 'e.id=pase.id_expediente',
                    'columnas' => array('e.fojas as fojas_expediente', 'e.ano as ano_expediente', 'e.numero as numero_expediente', 'e.anexo as anexo_expediente')
                ),
                array(
                    'table' => "$this->sigmu_schema.oficina oo",
                    'where' => 'oo.id=pase.origen',
                    'columnas' => array('CONCAT(oo.id, " - ", oo.nombre) as oficina_origen')
                ),
                array(
                    'table' => "$this->sigmu_schema.oficina od",
                    'where' => 'od.id=pase.destino',
                    'columnas' => array('od.id as oficina_id', 'od.nombre as oficina')
                ),
                array(
                    'type' => 'left', 'table' => "$this->sigmu_schema.notapase np",
                    'where' => 'np.id=pase.nota_pase_id',
                    'columnas' => array('np.contenido as observaciones')
                ))
        ));
        if (empty($pase) || $pase->origen !== $this->session->userdata('oficina_actual_id')) {
            show_404();
        }
        $this->load->model('expedientes/expedientes_model');
        $this->set_model_validation_rules($this->pases_model);
        $is_digital = $this->expedientes_model->is_digital($id_exp);
        if (isset($_POST) && !empty($_POST)) {
            if ($id !== $this->input->post('id')) {
                show_error('Esta solicitud no pasó el control de seguridad.');
            }
            $error_msg = FALSE;
            //if ($pase->fojas_expediente > $this->input->post('fojas')) {
            //    $error_msg = "El número de fojas no puede ser menor al anterior ($pase->fojas_expediente).";
            //}
            $resp = $this->db->query("select pase.destino, pase. respuesta from sigmu.pase where pase.id = ".$this->input->post('id'))->result_array();
            if($tipo == 'enviar' && (($resp[0]['respuesta'] !== 'pendiente' && $resp[0]['respuesta'] !== 'rechazado') || $resp[0]['destino'] > 0) ){
                $this->session->set_flashdata('error', 'El pase ya fue enviado');
                redirect("expedientes/pases/listar_pendientes_e", "refresh");
            } else {
                if ($this->form_validation->run() === TRUE && !$error_msg) {
                    $this->db->trans_begin();
                    $trans_ok = TRUE;
                    $contenido_nota = $this->input->post('observaciones');
                    $this->load->model('expedientes/notas_pases_model');
                    if (!empty($contenido_nota)) {
                        if (empty($pase->nota_pase_id)) {
                            $trans_ok&= $this->notas_pases_model->create(array(
                                'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
                                'contenido' => $contenido_nota
                                    ), FALSE);
                            $nota_pase_id = $this->notas_pases_model->get_row_id();
                        } else {
                            $trans_ok&= $this->notas_pases_model->update(array(
                                'id' => $pase->nota_pase_id,
                                'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
                                'contenido' => $contenido_nota
                                    ), FALSE);
                            $nota_pase_id = $pase->nota_pase_id;
                        }
                    } else {
                        if (!empty($pase->nota_pase_id)) {
                            $trans_ok&= $this->pases_model->update(array('id' => $pase->id, 'nota_pase_id' => 'NULL'), FALSE);
                            $trans_ok&= $this->notas_pases_model->delete(array('id' => $pase->nota_pase_id), FALSE);
                        }
                        $nota_pase_id = 'NULL';
                    }
                    
                    $num_fojas = $this->input->post('fojas');
                    
                    if ($tipo === 'enviar') {

                        if (!$is_digital) {
                            $trans_ok&= $this->pases_model->update(array(
                            'id' => $this->input->post('id'),
                            'origen' => $this->session->userdata('oficina_actual_id'),
                            'destino' => $this->input->post('oficina_id'),
                            'respuesta' => 'pendiente',
                            'fojas' => $num_fojas,
                            'nota_pase_id' => $nota_pase_id,
                            'usuario_emisor' => $this->session->userdata('CodiUsua'),
                            'usuario' => $this->session->userdata('CodiUsua'),
                            'fecha_usuario' => date_format(new DateTime(), 'Y-m-d H:i:s')
                                ), FALSE);
                        }else{
                            //si es pase digital pasa directamente al pendiente de emicion
                            
                            //modificamose el pase simulando la recepcion
                            $trans_ok&= $this->pases_model->update(array(
                                'id' => $this->input->post('id'),
                                'destino' => $this->input->post('oficina_id'),
                                'nota_pase_id' => $nota_pase_id,
                                'fecha' =>  date_format(new DateTime(), 'Y-m-d H:i:s'),
                                'fojas' => $this->input->post('fojas'),
                                'respuesta' => 'aceptado',
                                'usuario' => $this->session->userdata('CodiUsua'),
                                'usuario_receptor' => 'EXP. DIGITAL',
                                'fecha_usuario' => date_format(new DateTime(), 'Y-m-d H:i:s')), FALSE);
                            
                            //creamos el archivo adjunto
                            $pase = $this->pases_model->get(array(
                                    'id' => $id,
                                    'join' => array(
                                        array(
                                            'type' => 'left',
                                            'table' => "$this->sigmu_schema.expediente",
                                            'where' => 'expediente.id=pase.id_expediente',
                                            'columnas' => array('expediente.caratula as caratula', 'expediente.ano as ano', 'expediente.numero as numero', 'expediente.anexo as anexo', 'expediente.inicio as inicio', 'expediente.fojas as fojas_e', 'expediente.objeto as objeto')
                                        ),array(
                                            'type' => 'left',
                                            'table' => "$this->sigmu_schema.oficina o",
                                            'where' => 'pase.origen=o.id',
                                            'columnas' => array('o.nombre as origen_of')
                                        ),array(
                                            'type' => 'left',
                                            'table' => "$this->sigmu_schema.oficina d",
                                            'where' => 'pase.destino=d.id',
                                            'columnas' => array('d.nombre as destino_of')
                                        ),array(
                                            'type' => 'left',
                                            'table' => "$this->sigmu_schema.persona",
                                            'where' => 'expediente.persona_id=persona.CucuPers',
                                            'columnas' => array('persona.DetaPers as solicitante')
                                        ),array(
                                            'type' => 'left',
                                            'table' => "$this->sigmu_schema.tramite",
                                            'where' => 'tramite.id=expediente.tramite_id',
                                            'columnas' => array('tramite.nombre as tramite')
                                        ),array(
                                            'type' => 'left',
                                            'table' => "$this->sigmu_schema.notapase",
                                            'where' => 'notapase.id=pase.nota_pase_id',
                                            'columnas' => array('notapase.contenido as nota_pase')
                                        )
                                    )
                                )
                            );
                            $this->load->library('pdf');
                            $data['pase'] = $pase;
                            $pdf = $this->pdf->load();
                            $html = $this->load->view('expedientes/pases/pases_pdf', $data, TRUE);
                            $pdf->WriteHTML($html);
                            $pdf_content = $pdf->Output('', 'S');
                            $this->load->model('expedientes/archivos_adjuntos_model');
                            $trans_ok&= $this->archivos_adjuntos_model->create(array(
                                'nombre' => "Pase_{$pase->origen}-{$pase->destino}_{$pase->id}.pdf",
                                'tamanio' => strlen($pdf_content),
                                'tipodecontenido' => "application/pdf",
                                'contenido' => $pdf_content,
                                'id_expediente' => $pase->id_expediente,
                                'descripcion' => 'NULL',
                                'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s')
                                    ), FALSE);
                                
                            $num_fojas = $pase->fojas + numeroPaginasPdf($pdf_content);
                            //actualizamos el nro de fojas del ultimo pase
                            //$trans_ok&= $this->pases_model->update(array(
                            //    'id' => $this->input->post('id'),
                            //    'fojas' => $num_fojas), FALSE);
                            //creamos un pase nuevo
                            $trans_ok&= $this->pases_model->create(array(
                                'id_expediente' => $id_exp,
                                'ano' => $pase->ano,
                                'numero' => $pase->numero,
                                'anexo' => $pase->anexo,
                                'origen' => $this->input->post('oficina_id'),
                                'destino' => -1,
                                'respuesta' => 'pendiente',
                                'fojas' => $num_fojas,
                                'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
                                'usuario_emisor' => $this->session->userdata('CodiUsua'),
                                'terminal' => $this->input->ip_address(),
                                'fecha_usuario' => date_format(new DateTime(), 'Y-m-d  H:i:s')
                                    ), FALSE);
                            //actualizamos las fojas de los archivos adjuntos
                            $archivo_adjunto_id = $this->archivos_adjuntos_model->get_row_id();
                            $foja_desde = $this->pases_model->getFojas($pase->id_expediente);
                            $this->load->model('expedientes/fojas_archivos_adjuntos_model');
                            $trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
                                'archivo_adjunto_id' => $archivo_adjunto_id, 
                                'foja_desde' => $foja_desde,
                                'foja_hasta' => $foja_desde + count($pdf->pages) - 1
                                    ), FALSE);
                            //actualizamos las fojas del expediente
                            $trans_ok&= $this->expedientes_model->update(array(
                                'id' => $pase->id_expediente,
                                'fojas' => $num_fojas), FALSE);
                            
                        }
                    } else {
                        $trans_ok&= $this->pases_model->update(array(
                            'id' => $this->input->post('id'),
                            'destino' => $this->input->post('oficina_id'),
                            'fojas' => $this->input->post('fojas'),
                            'nota_pase_id' => $nota_pase_id
                                ), FALSE);
                    }
                    if (!FOJA_AUTOMATICA) {
                        $trans_ok&= $this->expedientes_model->update(array(
                            'id' => $pase->id_expediente,
                            'ano' => $pase->ano_expediente,
                            'numero' => $pase->numero_expediente,
                            'anexo' => $pase->anexo_expediente,
                            'fojas' => $num_fojas
                                ), FALSE);
                    }
                    if ($this->db->trans_status() && $trans_ok) {
                        $this->db->trans_commit();
                        $this->session->set_flashdata('message', $this->pases_model->get_msg());
                        if ($tipo === 'enviar') {
                            redirect("expedientes/pases/listar_pendientes_e", 'refresh');
                        } else {
                            redirect("expedientes/pases/listar_enviados_sinr", 'refresh');
                        }
                    } else {
                        $this->db->trans_rollback();
                        $error_msg = 'Se ha producido un error con la base de datos.';
                        if ($this->pases_model->get_error()) {
                            $error_msg .='<br>' . $this->pases_model->get_error();
                        }
                    }
                }
            }
        }
        /* carga la plantilla */
        $this->load->model('circuito_model');
        //busco la utlima plantilla realizada
        $plant_circuito = $this->circuito_model->findByExpediente($id_exp);
        if (!empty($plant_circuito) && sizeof(count($plant_circuito) > 0)) {
            //buscamos la siguiente plantilla del circuito
            $plantilla = $this->circuito_model->getSigCircuito($id_exp, $this->session->userdata('oficina_actual_id'), $plant_circuito['orden']);
        } else {
            //comenzamos con la primer plantilla del circuito
            $plantilla = $this->circuito_model->getSigCircuito($id_exp, $this->session->userdata('oficina_actual_id'));
        }
        //var_dump($plant_circuito);die();
        if ($is_digital && !$salir_circuito && !empty($plantilla['plantilla_id'])) {
            //echo "Aqui cargaremos el formulario";
            redirect(base_url('/expedientes/pases/completar_plantilla/' . $id_exp));
        } else {

            /* carga el formulario de envio de pases */
            $data['error'] = (validation_errors() ? validation_errors() : (isset($error_msg) ? $error_msg : $this->session->flashdata('error')));

            $data['fields'] = array();

            foreach ($this->pases_model->fields as $field) {
                if (empty($field['input_type'])) {
                    if (($field['name'] === 'oficina_id' && $pase->oficina_id === '-1')) {
                        $this->add_input_field($data['fields'], $field);
                    } else if ($field['name'] === 'respuesta') {
                        $this->add_input_field($data['fields'], $field, strtoupper($pase->{$field['name']}));
                    } else {
                        $this->add_input_field($data['fields'], $field, $pase->{$field['name']});
                    }
                } elseif ($field['input_type'] === 'combo') {
                    if (isset($field['type']) && $field['type'] === 'multiple') {
                        $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, ${'current_' . $field['name']});
                    } else {
                        $this->add_combo_field($data['fields'], $field, ${'array_' . $field['name']}, $pase->{isset($field['id_name']) ? $field['id_name'] : $field['name']});
                    }
                }
            }

            /*             * ************* BUSCAMOS EL SIGUIENTE PASE DEL CIRCUITO CORRESPONDIENTE ***************** */
            //primero comparare los pases realizados hasta el moemento con los pases que determina el circuito para saber cual el la siguiente  oficina destino

            $sig_dest = $this->circuito_model->siguienteOficina($id_exp);
            if ($is_digital && !empty($sig_dest)) {
                $data['destino'] = $sig_dest;
            }
            /*             * *************************************************** */
            $data['pase'] = $pase;
            $data['digital'] = $is_digital;

            $tableData_oficinas_destino = array(
                'columns' => array(
                    array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 15, 'class' => 'dt-body-right', 'responsive_class' => 'all', 'query' => 'where'),
                    array('label' => 'Nombre', 'data' => 'nombre', 'sort' => 'oficina.nombre', 'width' => 80, 'query' => 'like'),
                    array('label' => '', 'data' => 'select_destino', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
                ),
                'table_id' => 'oficinas_destino_table',
                'source_url' => 'expedientes/oficinas/listar_data/TRUE',
                'order' => array(array(1, 'asc')),
                'reuse_var' => TRUE,
                'initComplete' => "function (){var r = $('#oficinas_destino_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#oficinas_destino_table thead').append(r);$('#search_0').css('text-align', 'center');}",
                'footer' => TRUE,
                'dom' => 'rtip'
            );
            $data['html_table_oficinas_destino'] = buildHTML($tableData_oficinas_destino);
            $data['js_table_oficinas_destino'] = buildJS($tableData_oficinas_destino);

            if ($tipo === 'enviar') {
                $data['txt_btn'] = 'Enviar';
                if (empty($sig_dest)) {
                    $data['destino'] = $plantilla['oficina_destino_id'];
                }
                $data['box_title'] = "Enviar Expediente $pase->numero / $pase->ano, Anexo $pase->anexo";
                $data['title'] = 'Expedientes - Pases - Enviar';
            } else {
                $data['txt_btn'] = 'Guardar';
                $data['box_title'] = "Editar Pase de Expediente $pase->numero / $pase->ano, Anexo $pase->anexo";
                $data['title'] = 'Expedientes - Pases - Modificar';
            }
            $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => 'disabled', 'eliminar' => 'disabled');
            $data['js'][] = 'js/expedientes/expedientes-varios.js';
            $this->load_template('expedientes/pases/pases_abm', $data);
        }
    }

    public function archivar($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/pases/listar_pendientes_e", 'refresh');
        }
        $pase = $this->pases_model->get(array('id' => $id));
        if (empty($pase) || $pase->origen !== $this->session->userdata('oficina_actual_id')) {
            show_404();
        }
        $this->db->trans_begin();
        $trans_ok = TRUE;
        $trans_ok&= $this->pases_model->update(array(
            'id' => $id,
            'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s'),
            'respuesta' => 'archivado',
            'destino' => $pase->origen,
            'usuario_receptor' => $this->session->userdata('CodiUsua')
                ), FALSE);
        if ($this->db->trans_status() && $trans_ok) {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', 'Se archivó el pase correctamente');
            redirect('expedientes/pases/listar_pendientes_e', 'refresh');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error al archivar el pase');
            redirect("expedientes/pases/listar_pendientes_e", 'refresh');
        }
    }

    public function desarchivar($id = NULL) {
        if (!in_groups($this->grupos_permitidos, $this->grupos) || $id == NULL || !ctype_digit($id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/pases/listar_archivados", 'refresh');
        }
        $pase = $this->pases_model->get(array('id' => $id));
        if (empty($pase) || $pase->origen !== $this->session->userdata('oficina_actual_id') || $pase->respuesta !== 'archivado') {
            show_404();
        }
        $this->db->trans_begin();
        $trans_ok = TRUE;
        $trans_ok&= $this->pases_model->update(array(
            'id' => $id,
            'respuesta' => 'pendiente',
            'fecha_usuario' => date_format(new DateTime(), 'Y-m-d H:i:s'),
            'origen' => $this->session->userdata('oficina_actual_id'),
            'destino' => -1
                ), FALSE);
        if ($this->db->trans_status() && $trans_ok) {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', 'Se desarchivó el pase correctamente');
            redirect('expedientes/pases/listar_archivados', 'refresh');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error al desarchivar el pase');
            redirect("expedientes/pases/listar_archivados", 'refresh');
        }
    }

    public function completar_plantilla($id_exp) {
        /* carga la plantilla */

        $this->load->model('circuito_model');

        $a_circuito = $this->circuito_model->findByExpediente($id_exp);

        if (!empty($a_circuito) && sizeof(count($a_circuito) > 0)) {
            //buscamos el siguiente circuito
            $circuito = $this->circuito_model->getSigCircuito($id_exp, $this->session->userdata('oficina_actual_id'), $a_circuito['orden']);
            //var_dump($circuito);die();
        } else {
            //comenzamos con el primer paso del circuito
            $circuito = $this->circuito_model->getSigCircuito($id_exp, $this->session->userdata('oficina_actual_id'));
        }
        if (empty($circuito) || $circuito['plantilla_id'] == '0') {
            //si el pase ya se ha realizado y se quiere volver a completar el formulario
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }

        $this->load->model('formularios_model');
        $this->load->model('expedientes/plantillas_model');

        $data['titulo_pagina'] = $circuito['plantilla_nombre'];
        $data['idplan'] = $circuito['plantilla_id'];
        $data['firma_pad'] = $this->plantillas_model->getCantFirmasPad($data['idplan']);
        $data['idpase'] = $this->pases_model->getIdUltimoPase($id_exp);
        $data['idexp'] = $id_exp;
        $data['origen_oficina'] = $circuito['origen'];
        $data['destino_oficina'] = $circuito['destino'];
        $data['idtram'] = $circuito['tramite_id'];
        $data['error'] = $this->session->flashdata('error');
        $data['class'] = array('agregar' => 'active btn-app-zetta-active', 'ver' => '', 'editar' => '', 'eliminar' => '', 'formulario' => '');
        $data['title'] = 'Expedientes - Plantillas - Ver';
        $data['css'][] = 'css/expedientes/formularios_dinamicos.css';
        $data['js'][] = 'js/expedientes/vue/formularios_jquery.js';
        
		$data['js'][] = 'plugins/ckeditor/ckeditor.js';
		$data['js'][] = 'plugins/ckeditor/adapters/jquery.js';
		$data['js'][] = 'plugins/ckeditor/config.js';
		$data['js'][] = 'plugins/ckeditor/lang/es.js';
        $data['css'][] = 'plugins/ckeditor/skins/bootstrapck/editor.css';
        
        if ($this->plantillas_model->getCantFirmasPad($data['idplan']) > 0)
            $data['js'][] = 'js/expedientes/SigWebTablet.js';
        $this->load_template('expedientes/pases/completar_form', $data);
    }

    public function revision($action = "view",$idpase = 0,$idrev = 0) {
        
        $post = $this->input->post();
        
        if (!empty($post)) {
            $this->load->model(array('consulta_model', 'plantillas_model'));
            $plant = $this->plantillas_model->getPlantilla($post['idplant']);
            $html = $plant->texto;

            if (strpos($html, "#{fecha_hoy}")) {
                $fecha_str = date("d F Y", strtotime(date("Y-m-d")));
                $html = str_replace("#{fecha_hoy}", $this->parsearFecha($fecha_str), $html);
            }

            //pongo nombre de usuario sistema
            if (strpos($html, "#{usuario_sistema}")) {
                $html = str_replace("#{usuario_sistema}", $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'), $html);
            }
            if ($plant->firmapad > 0) {
                $firmas_array = explode('<separator>', $post['firmapad']);
                if (sizeof($firmas_array) - 1 < $plant->firmapad || empty($post['firmapad'])) {
                    $this->session->set_flashdata('error', 'Error, faltan firmas en el formulario.');
                    redirect("expedientes/pases/completar_plantilla/" . $post['idexp'], 'refresh');
                }
                //var_dump($firmas_array);die();
                for ($i = 1; $i <= $plant->firmapad; $i++) {
                    if (strpos($html, "#{firma_pad_" . $i . "}")) {
                        $firma_b64 = '<img src="data:image/png;base64,' . $firmas_array[$i - 1] . '" height="110" width="220">';
                        $html = str_replace("#{firma_pad_" . $i . "}", $firma_b64, $html);
                    }
                }
            }
            //var_dump($post);die();
            foreach ($post as $key => $value) {
                if ($key != 'idplant') {
                    if ($value == "") {
                        $html = str_replace("#{" . $key . "}", " -- ", $html);
                    } else {
                        if (strpos($key, "fecha")) {//contiene la palabra fecha en la key entonces hay que parsear
                            $fecha_str = date("d F Y", strtotime($value));

                            $html = str_replace("#{" . $key . "}", $this->parsearFecha($fecha_str), $html);
                        } else {
                            $html = str_replace("#{" . $key . "}", $value, $html);
                        }
                    }
                } else {
                    $html = str_replace("#{" . $key . "}", "", $html);
                }
            }
            
            //guardar revicion 
            $this->load->model('expedientes/revision_model');
            $rdata = array(
                'id_expediente' => $post['idexp'],
                'id_plantilla' => $post['idplant'],
                'contenido' => $html,
                'usuario' => $this->session->userdata('CodiUsua')
                    );
            $data['idrev'] = $this->revision_model->insertar($rdata);
            
            $revision = $this->revision_model->find($data['idrev']);
            $data['idpase'] = $revision->id_pase;
            if($data['idrev'] <= 0){
                show_error('Error al guardar el registro', 500, 'Error');
            }
            if($idrev == 0) $this->plantillas_model->guardarHistoricoPlantilla($this->pases_model->getIdUltimoPase($post['idexp']), $post['idplant'], $post);
        }else{
            if ($idpase == 0 || $idrev == 0) {
                show_404();
            }
            $this->load->model('expedientes/revision_model');
            $revision = $this->revision_model->find($idrev);
            if(empty($revision)){
                show_404();
            }
            $data['idpase'] = $idpase;
            $data['idrev'] = $revision->id;
            $html = $revision->contenido;
            $data['usuarev'] = $revision->usuario_revisor;
            $data['observacion'] = $revision->observacion;
        }
        //traemos los posibles revisores
        $tableData_revisor = array(
                'columns' => array(
                        array('label' => 'Nombre', 'data' => 'ID_USUARIO', 'sort' => 'ID_USUARIO', 'width' => 50,'class' => 'dt-body-left'),
                        array('label' => '', 'data' => 'select_user', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
                ),
                'table_id' => 'solicitantes_table',
                'order' => array(array(0, 'asc')),
                'source_url' => 'expedientes/pases/usuarios_data/'.$revision->id,
                'reuse_var' => TRUE,
                'initComplete' => "function (){var r = $('#solicitantes_table tfoot tr');r.find('th').each(function(){\$(this).css('padding', 8);});$('#solicitantes_table thead').append(r);$('#search_0').css('text-align', 'center');}",
                'footer' => TRUE,
                'dom' => 'rtip'
        );
        $data['html_table_revisor'] = buildHTML($tableData_revisor);
        $data['js_table_revisor'] = buildJS($tableData_revisor);

        //cargamos la vista
        switch ($action){
            case "view":
                $data['class'] = array(
                    'ver' => 'active btn-app-zetta-active',
                    'editar' => ''
                    );
                break;
            case "edit":
                $data['class'] = array(
                    'ver' => '',
                    'editar' => 'active btn-app-zetta-active'
                    );
                break;
        }
        $data['contenidopdf'] = $html;
        $data['title'] = 'Expedientes - Pases - Revision';
        $data['titulo_pagina'] = "Revision";
        $data['js'][] = 'plugins/ckeditor/ckeditor.js';
        $data['js'][] = 'plugins/ckeditor/adapters/jquery.js';
        $data['js'][] = 'plugins/ckeditor/config.js';
        $data['js'][] = 'plugins/ckeditor/lang/es.js';
        $data['css'][] = 'plugins/ckeditor/skins/bootstrapck/editor.css';
        $this->load_template('expedientes/pases/print_plantilla', $data);   
    }
    
    public function nueva_revision(){
        $post = json_decode(file_get_contents('php://input'), true);
        $this->load->model('expedientes/revision_model');
        $revision = $this->revision_model->find($post['revid']);
        $revision_new = array(
            'contenido' => $post['revtext'],
            'id_expediente' => $revision->id_expediente,
            'id_plantilla' => $revision->id_plantilla,
            'observacion' => $post['revobse'],
            'usuario' => $this->session->userdata('CodiUsua'),
            
        );
        if($this->revision_model->nueva_revision($revision_new,$revision, $post['paseid'])){
           $data['status'] = "success";
           $data['message'] = "Nueva revision guardada exitosamente";
        }else{
           $data['status'] = "error";
           $data['message'] = "Ocurrio un error en la transaccion. Vuelva a intentarlo";
        }
        header("Content-Type: application/json");
        echo json_encode($data);
    }
    
    public function usuarios_data($idrevision)
    {
            if (!in_groups($this->grupos_permitidos, $this->grupos))
            {
                    show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
            }
            $this->datatables
                    ->select('ID, ID_USUARIO')
                    ->from("sigmu.usuario_oficina")
                    ->where(['ID_OFICINA'=>  $this->session->userdata('oficina_actual_id')])
                    ->add_column('select_user', '<a data-dismiss="modal" href="" onclick="asignar_revisor(\'$1\','.$idrevision.')" title="Seleccionar"><i class="fa fa-check"></i></a>', 'ID_USUARIO');

            echo $this->datatables->generate();
    }
    
    
    public function asignar_revisor(){
        $post = json_decode(file_get_contents('php://input'), true);
        $this->load->model('expedientes/revision_model');
        //var_dump($post);die();
        $status = $this->revision_model->update_revisor($post);
        if($status){
            $data['status'] = 'success';
            $data['message'] = 'Se ha asignado revisor';
        }else{
            $data['status'] = 'error';
            $data['message'] = 'Error al asiganar revisor';
        }
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public function finalizar_revision(){
    
        $post = json_decode(file_get_contents('php://input'), true);
        $archivos = $_FILES['files'];
        $this->load->model(['expedientes/revision_model','expedientes/plantillas_model']);
        $revision = $this->revision_model->find($post['revid']);
        $adjuntos = $post['adjuntos'];
        $this->load->library('pdf');
        require_once APPPATH . '/third_party/mpdf/vendor/setasign/fpdi/fpdi_pdf_parser.php';
        for($x = 0; $x<sizeof($adjuntos); $x++){
            $pdf = $this->pdf->load();
            $img_base64_encoded = $adjuntos[$x]['data'];
            $imageContent = file_get_contents($img_base64_encoded);
            $path = tempnam(sys_get_temp_dir(), 'prefix');
            file_put_contents($path, $imageContent);
            $pdf->SetImportUse();
            $pagecount = $pdf->SetSourceFile($path);
            $tplId = $pdf->ImportPage($pagecount);
            $pdf->UseTemplate($tplId);
            //$pdf->writeHTML($content);
            $adjuntos[$x]['data'] = $pdf->Output('', 'S');
        }
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->defaultheaderline = false;
        /* agrego los sellos de foleo */
        $this->load->model('expedientes/expedientes_model');
        $pagina = $this->expedientes_model->get(array('select' => 'max(fojas) as fojas',
            'id' => $revision->id_expediente))->fojas;
        $expdata = $this->expedientes_model->find_by_id($revision->id_expediente);
        $pdf->fojasExpediente = $pagina;

        $tramite = $this->expedientes_model->getNombreTramite($revision->id_expediente);
        
        $plant = $this->plantillas_model->getPlantilla($revision->id_plantilla);
        $html = $post['revtext'];
        
        //<div style="height: 57px;width: 80px;background-image: url(\'img/expedientes/folio.png\');position:absolute;float:right;text-align:center;padding-top: 22px;"><span style="font-size:24px">{PAGENO}</span></div>
        if($plant->cabecera == '1'){
            $pdf->setHeader('<table width="100%" style="border: 0.1mm solid #000000;font-family: `Times New Roman`, Times, serif;">
                                <tr>
                                    <td width="25%" style="text-align: center;">
                                        <img src="img/generales/municipalidad_marca_lavalle.png" style="margin: 10px;" height="50" width="100">
                                    </td>
                                    <td width="50%" style="border-left: 0.1mm solid; border-right: 0.1mm solid;text-align: center;">
                                        <h4>'.$tramite['nombre'].'</h4>
                                    </td>
                                    <td width="25%" style="font-size: 11px;">
                                        <p>Expediente: '.$expdata->numero.' / '.$expdata->ano.' - '.$expdata->anexo.'</p>
                                        <p>Foja: {FOJASNRO}</p>
                                        <p>Página: {PAGENO}</p>
                                        <p>Oficina: '.$this->session->userdata('oficina_actual').'</p>
                                    </td>
                                </tr>
                            </table>');
        }
        if($plant->pie == '1'){
            $pdf->setFooter('<table width="100%">
                                <tr>
                                    <td style="text-align: left;font-size: 8px;">
                                        Fecha: ' . date('d-m-Y H:i:s') . '
                                    </td>
                                    <td style="text-align: right;font-size: 8px;">
                                        Usuario: ' . $this->session->userdata('CodiUsua') . '
                                    </td>
                                </tr>
                            </table>');
        }

        $pdf->AddPage();
        $pdf->WriteHTML('<br><br><br><br>'.$html); // write the HTML into the PDF
        $pdf_content = $pdf->Output('', 'S');


        //header("Content-type:application/pdf");
        //echo $pdf_content;die();

        $num_pag = numeroPaginasPdf($pdf_content);

        $this->db->trans_start();
        $this->load->model('expedientes/archivos_adjuntos_model');
        $trans_ok&= $this->archivos_adjuntos_model->insert_pdf(array(
            'nombre' => "Formulario_" . str_replace(" ", "_", $plant->nombre) . "_exp_" . $revision->id_expediente . ".pdf",
            'tamanio' => strlen($pdf_content),
            'tipodecontenido' => "application/pdf",
            'contenido' => $pdf_content,
            'id_expediente' => $revision->id_expediente,
            'descripcion' => '',
            'user' => $this->session->userdata('user_id'),
            'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s')
                ), FALSE);

        foreach($adjuntos as $file){
            $trans_ok&= $this->archivos_adjuntos_model->insert_pdf(array(
                'nombre' => $file['name'],
                'tamanio' => $file['size'],
                'tipodecontenido' => "application/pdf",
                'contenido' => $file['data'],
                'id_expediente' => $revision->id_expediente,
                'descripcion' => '',
                'user' => $this->session->userdata('user_id'),
                'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s')
                    ), FALSE);
        }

        $row_id = $this->archivos_adjuntos_model->max_id();
        /* ACTUALIZO LAS FOJAS DEL EXPEDIENTE */
        $query_fojas = $this->archivos_adjuntos_model->get(array('select' => 'COALESCE(MAX(foja_hasta),0)+1 as foja_desde',
            'join' => array(array('table' => 'fojas_archivos_adjuntos', 'where' => 'fojas_archivos_adjuntos.archivo_adjunto_id=archivoadjunto.id')),
            'id_expediente' => "" . $revision->id_expediente));
        $foja_desde = $query_fojas[0]->foja_desde;
        $this->load->model('expedientes/fojas_archivos_adjuntos_model');
        $trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
            'archivo_adjunto_id' => $row_id,
            'foja_desde' => $foja_desde,
            'foja_hasta' => $foja_desde + $num_pag - 1
                ), FALSE);


        //Guardao en el temporal el estado de este circuito

        $array_tmp['plantilla_id'] = $revision->id_plantilla;
        $array_tmp['tramite_id'] = $tramite['id'];
        $array_tmp['expediente_id'] = $revision->id_expediente;
        $array_tmp['estado'] = 'pendiente';
        //var_dump($this->session->userdata());die();
        $array_tmp['audi_user'] = $this->session->userdata('username');
        $this->load->model('circuito_model');
        $con_firma = false;
        $circuito = $this->circuito_model->getCircuito($array_tmp['plantilla_id'], $array_tmp['tramite_id']);
        if (!empty($circuito['firmantes'])){
            //existen firmas a solicitar
            $con_firma = true;
            $array_firmas = array(
                'firmantes' => explode(',',$circuito['firmantes']),
                'archivo_adjunto_id' => $row_id,
                'solicitante_id' => $this->session->userdata('user_id'),
                'solicitante_name' => $this->session->userdata('username'),
                'fecha_solicitud' => date_format(new DateTime(), 'Y-m-d H:i:s'),
                'estado_lectura' => '0',
                'estado' => 'Solicitada',
                'pase_id' => $this->circuito_model->ultimoPase($revision->id_expediente)['id']
            );
            if (!$this->circuito_model->solicitar_firmas($array_firmas)) {
                show_error('No se pudo realizsar la solicitud de firmas', 500, 'Error al solicitar firmas');
            }
            $this->circuito_model->guardar_temporal($array_tmp);
        }
        //traigo el pase pendiente de emision
        $pase = $this->pases_model->getLastPendiente_e($revision->id_expediente);
        $etapa_circuito = $this->pases_model->getLastEtapaCircuito($revision->id_expediente);
        $this->circuito_model->continuar_pase($pase, $con_firma, $circuito['oficina_destino_id'], $this->session->userdata('username'), $revision->id_expediente, $num_pag, $etapa_circuito);
        //Guardo el historico de la plantilla
        $this->revision_model->finalizar($revision,$pase['id']);
        

        $this->db->trans_complete(); 
        
        $data = array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data = ['status'=>'error','message'=>'La finalizacion del documento ha fallado'];
        } 
        else {
            $this->db->trans_commit();
            $data = ['status'=>'success','message'=>'Documento finalizado exitosamente!'];
        }
        header("Content-Type: application/json");
        echo json_encode($data);
    }
    
    public function view_pdf($row_id) {
        $this->load->model('expedientes/archivos_adjuntos_model');
        $pdf = $this->archivos_adjuntos_model->getPDF($row_id);
        //var_dump($pdf[0]['contenido']);
        header("Content-type:application/pdf");
        echo $pdf[0]['contenido'];
    }

    public function get_solicitante_data($id_expediente = false) {
        header("Content-Type: application/json");
        if ($id_expediente) {
            $this->load->model('expedientes/expedientes_model');
            $solic = $this->expedientes_model->get_solicitante($id_expediente);
            echo json_encode($solic);
            return;
        }

        echo json_encode(["error" => "no se a recibido $id_expediente"]);
    }

    public function is_pendiente_r() {
        $data = $this->input->post();
        if (!empty($data)) {
            $data = $this->pases_model->get_estado_pase($data['id_expediente'], $data['oficina']);
            header('Content-Type: application/json');
            if (count($data) > 0) {
                $in_carrito = false;
                $carrito = $this->session->userdata('carrito');
                foreach ($carrito as $item) {
                    $pase = (object) $item;
                    if ($data['id_expediente'] == $pase->id_expediente) {
                        $in_carrito = true;
                        break;
                    }
                }
                if ($in_carrito) {
                    echo "El expediente ya se encuentra en el carrito.";
                } else {
                    echo json_encode($data);
                }
            } else {
                echo "error";
            }
        }
    }

    public function add_carrito() {
        $data = $this->input->post();
        if (!empty($data)) {
            $carrito = $this->session->userdata('carrito');
            $pase = $data['pase'];
            $row = json_decode($pase, true);
            array_push($carrito, $row);
            $this->session->set_userdata('carrito', $carrito);
        }
    }

    public function delete_carrito() {
        $c_array = $this->session->userdata('carrito');
        //var_dump($this->input->post());die();
        if (!empty($this->input->post())) {
            $index = $this->input->post('idx_row');
            array_splice($c_array, $index, 1);
            $this->session->set_userdata('carrito', $c_array);
            echo 'success';
        } else {
            echo 'Empty data post.';
        }
    }

    function get_carrito_array() {
        $carrito_array = $this->session->userdata('carrito');
        echo json_encode($carrito_array);
    }

    function recepcionar_carrito() {
        if (in_groups($this->grupos_solo_consulta, $this->grupos)) {
            $this->session->set_flashdata('error', 'Usuario sin permisos de edición');
            redirect("expedientes/pases/listar_pendientes_r", 'refresh');
        }

        $carrito = $this->session->userdata('carrito');


        $this->db->trans_begin(); ///no deja funcionar el trigger
        //registramos un nuevo ticket

        $this->load->model('ticket_model');
        $ticket_id = $this->ticket_model->registerTicket(array(
            'cantexpe' => sizeof($carrito),
            'usuario' => $this->session->userdata('CodiUsua'),
            'ip' => $this->input->ip_address(),
            'oficina_receptora' => $this->session->userdata('oficina_actual_id'),
            'oficina_emisora' => null
        ));

        $trans_ok = TRUE;
        foreach ($carrito as $item) {
            $pase = (object) $item;
            if ($trans_ok) {
                if(!$this->pases_model->pendienteRecepcion($pase)) continue;
                if (empty($pase) || $pase->destino !== $this->session->userdata('oficina_actual_id')) {
                    if($pase->destino !== $this->session->userdata('oficina_actual_id')){
                        $this->session->set_flashdata('error', 'Los pases del carrito no pertenecen a la oficina actual');
                        redirect("expedientes/pases/listar_pendientes_r", 'refresh');
                    }
                    show_404();
                }
                $data['pase'] = $pase;
                $this->load->library('pdf');
                $pase->fecha = date_format(new DateTime(), 'Y-m-d H:i:s');
                $pase->usuario_receptor = $this->session->userdata('CodiUsua');
                //creacion del pdf del pase
                $this->load->model('expedientes/expedientes_model');
                $generate_pdf = $this->expedientes_model->is_digital($pase->id_expediente);
                if ($generate_pdf) {
                    $pdf = $this->pdf->load();
                    $html = $this->load->view('expedientes/pases/pases_pdf', $data, TRUE);
                    $pdf->WriteHTML($html);
                    $pdf_content = $pdf->Output('', 'S');
                }
                //guardamos el pdf en base de datos
                if ($generate_pdf) {
                    $this->load->model('expedientes/archivos_adjuntos_model');
                    $trans_ok&= $this->archivos_adjuntos_model->create(array(
                        'nombre' => "Pase_{$pase->origen}-{$pase->destino}_{$pase->id}.pdf",
                        'tamanio' => strlen($pdf_content),
                        'tipodecontenido' => "application/pdf",
                        'contenido' => $pdf_content,
                        'id_expediente' => $pase->id_expediente,
                        'descripcion' => 'NULL',
                        'fecha' => date_format(new DateTime(), 'Y-m-d H:i:s')
                            ), FALSE);
                }

                //                var_dump($trans_ok);
                $trans_ok&= $this->pases_model->update(array(
                    'id' => $pase->id,
                    'fecha' => $pase->fecha,
                    'respuesta' => 'aceptado',
                    'usuario_receptor' => $this->session->userdata('CodiUsua'),
                    'ticket_id' => $ticket_id
                        ), FALSE);
                $num_fojas = $pase->fojas + ($generate_pdf ? numeroPaginasPdf($pdf_content) : 0);

                $trans_ok&= $this->pases_model->create(array(
                    'id_expediente' => $pase->id_expediente,
                    'ano' => $pase->ano,
                    'numero' => $pase->numero,
                    'anexo' => $pase->anexo,
                    'origen' => $this->session->userdata('oficina_actual_id'),
                    'destino' => -1,
                    'respuesta' => 'pendiente',
                    'fojas' => $num_fojas,
                    'usuario_emisor' => $this->session->userdata('CodiUsua'),
                    'terminal' => 'EXPT. DIGITAL',
                    'fecha_usuario' => date_format(new DateTime(), 'Y-m-d  H:i:s')
                        ), FALSE);


                //aumentamos la foja automaticamente por cada pase debido al comprobante que se genera en la recepcion
                if ($generate_pdf) {
                    $archivo_adjunto_id = $this->archivos_adjuntos_model->get_row_id();
                    $foja_desde = $this->pases_model->getFojas($pase->id_expediente);
                    $this->load->model('expedientes/fojas_archivos_adjuntos_model');
                    $trans_ok&= $this->fojas_archivos_adjuntos_model->create(array(
                        'archivo_adjunto_id' => $archivo_adjunto_id,
                        'foja_desde' => $foja_desde,
                        'foja_hasta' => $foja_desde + count($pdf->pages) - 1
                            ), FALSE);
                    $this->load->model('expedientes/expedientes_model');
                    $trans_ok&= $this->expedientes_model->update(array(
                        'id' => $pase->id_expediente,
                        'fojas' => $foja_desde + count($pdf->pages) - 1
                            ), FALSE);
                }
            } else {
                break;
            }
        }
        if ($this->db->trans_status() && $trans_ok) {
            $this->db->trans_commit();
            $this->session->set_flashdata(array(
                'message' => 'Se aceptaron los pases correctamente',
                'ticket_id' => $ticket_id
            ));
            $this->session->set_userdata('carrito', array());
            redirect('expedientes/pases/listar_pendientes_r', 'refresh');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Error al aceptar los pases');
            redirect("expedientes/pases/listar_pendientes_r", 'refresh');
        }
    }
    
    public function limpiar_carrito(){
        $this->session->unset_userdata('carrito');
        $this->session->set_flashdata('message','El carrito ha sido vaciado');
        redirect("expedientes/pases/listar_pendientes_r", 'refresh');
    }

    public function listar_tickets_e($id_ofic = 0) {

        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->session->set_userdata('emitido', true);
        $tableData = array(
            'columns' => array(
                array('label' => 'Código', 'data' => 'id', 'sort' => 'ticket.id', 'width' => 10),
                array('label' => 'Oficina', 'data' => 'oficina_receptora', 'sort' => 'oficina_receptora', 'width' => 35),
                array('label' => 'Fecha', 'data' => 'fecha', 'sort' => 'ticket.fecha', 'width' => 20),
                array('label' => 'Cantidad Exp', 'data' => 'cantexpe', 'sort' => 'cantexpe', 'width' => 10),
                array('label' => 'Usuario', 'data' => 'usuario_receptor', 'sort' => 'usuario_receptor', 'width' => 35),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'ticket_table',
            'source_url' => 'expedientes/pases/listar_tickets_e_data',
            'order' => array(array(0, 'desc')),
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Pases - Tickets';
        $this->load_template('expedientes/pases/ticket_listar', $data);
    }

    public function listar_tickets_e_data() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('ticket.id,COUNT(pase.id) AS cantexpe,ticket.fecha,ticket.usuario AS usuario_receptor,oficina.nombre AS oficina_receptora',FALSE)
                ->unset_column('ticket.id')
                ->join('sigmu.pase', 'ticket.id = pase.ticket_id')
                ->join('sigmu.oficina', 'pase.destino = oficina.id')
                ->where(['pase.origen' => $this->session->userdata('oficina_actual_id'), 'pase.respuesta' => 'aceptado'])
                ->group_by('sigmu.pase.ticket_id')
                ->from("$this->sigmu_schema.ticket")
                ->add_column('edit', '<button class="btn btn-info" onclick="show_detail_ticket($1, true)" style="width: 100px;" title="Detalles"><i class="fa fa-info-circle"></i> Expedientes</button>'
                        . '<a class="btn btn-success" href="expedientes/pases/pdf_ticket_e/$1" target="_blank" style="width: 100px;" title="Imprimir"><i class="fa fa-print"></i> Imprimir</a>', 'id')
                ->where('ticket.id>0');
                #$this->datatables->set_limit(10);

        echo $this->datatables->generate();
    }

    public function listar_tickets_r($id_ofic = 0) {

        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->session->set_userdata('emitido', false);
        $tableData = array(
            'columns' => array(
                array('label' => 'Código', 'data' => 'id', 'sort' => 'oficina.id', 'width' => 10),
                array('label' => 'Oficina', 'data' => 'oficina_receptora', 'sort' => 'oficina.nombre', 'width' => 35),
                array('label' => 'Fecha', 'data' => 'fecha', 'sort' => 'oficina.nombre', 'width' => 20),
                array('label' => 'Cantidad Exp', 'data' => 'cantexpe', 'sort' => 'oficina.nombre', 'width' => 10),
                array('label' => 'Usuario', 'data' => 'usuario_receptor', 'sort' => 'pase.usuario', 'width' => 35),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'ticket_table',
            'source_url' => 'expedientes/pases/listar_tickets_r_data',
            'order' => array(array(0, 'desc')),
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Pases - Tickets';
        $this->load_template('expedientes/pases/ticket_listar', $data);
    }

    public function listar_tickets_r_data() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('ticket.id, ticket.cantexpe, ticket.fecha, ticket.usuario AS usuario_receptor, oficina.nombre AS oficina_receptora',FALSE)
                ->unset_column('ticket.id')
                ->join('sigmu.oficina', 'ticket.oficina_receptora = oficina.id')
                ->where(['ticket.oficina_receptora' => $this->session->userdata('oficina_actual_id')])
                ->from("$this->sigmu_schema.ticket")
                ->add_column('edit', '<button class="btn btn-info" onclick="show_detail_ticket($1, \'\')" style="width: 100px;" title="Detalles"><i class="fa fa-info-circle"></i> Expedientes</button>'
                        . '<a class="btn btn-success" href="expedientes/pases/pdf_ticket_r/$1" target="_blank" style="width: 100px;" title="Imprimir"><i class="fa fa-print"></i> Imprimir</a>', 'id');
                        $this->datatables->set_limit(10);
        echo $this->datatables->generate();
    }

    public function detalle_ticket($ticket_id = null, $emitido = false) {
        header("Content-Type: application/json");
        if ($ticket_id) {
            $this->load->model('expedientes/ticket_model');
            $expedientes = $this->ticket_model->get_detalle($ticket_id, $emitido);
            echo json_encode($expedientes);
            return;
        }
        echo json_encode(["error" => "no se a recibido $id_expediente"]);
    }
    /**
     * $emitido boolean
     * Determina si el ticket que se va a generar contiene expedientes
     * emitidos por otra oficina y recepcionados en la actual (false)
     * o si fueron emitidos por la oficina actual y recepcionados en otra 
     * oficina (true)
     */
    public function generar_pdf($ticket_id, $emitido){
        $ticket = $this->pases_model->get(array(
            'select' => 'ticket.id, '.(($emitido) ? 'COUNT(*) AS cantexpe' : 'ticket.cantexpe').',ticket.fecha, ticket.usuario, ticket.oficina_receptora,oficina.nombre as oficina_nombre',
            'from' => 'sigmu.ticket',
            'where' => array('ticket.id = ' . $ticket_id . (($emitido) ? ' AND p.origen = '.$this->session->userdata('oficina_actual_id') : '')),
            'join' => array(
                array(
                    'table' => "$this->sigmu_schema.oficina",
                    'where' => 'oficina.id=ticket.oficina_receptora',
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.pase p",
                    'where' => 'ticket.id = p.ticket_id',
                )
            )
        ));

        $expedientes = $this->pases_model->get(array(
            'select' => 'e.numero,e.ano,e.anexo',
            'from' => 'sigmu.ticket',
            'where' => array('ticket.id = ' . $ticket_id . (($emitido) ? ' AND p.origen = '.$this->session->userdata('oficina_actual_id') : '')),
            'join' => array(
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.pase p",
                    'where' => 'p.ticket_id=ticket.id',
                ),
                array(
                    'type' => 'left',
                    'table' => "$this->sigmu_schema.expediente e",
                    'where' => 'e.id=p.id_expediente',
                )
            )
        ));

        return array('expedientes' => $expedientes, 'ticket' => $ticket);
    }

    public function pdf_ticket_e($ticket_id) {

        if (!in_groups($this->grupos_permitidos, $this->grupos) || $ticket_id == NULL || !ctype_digit($ticket_id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }

        $resp = $this->generar_pdf($ticket_id, true);
        if (empty($resp['ticket'])) {
            show_404();
        }
        $data['ticket'] = $resp['ticket'][0];
        $data['expedientes'] = $resp['expedientes'];
        //ini_set('memory_limit', '32M'); // boost the memory limit if it's low
        //var_dump($data);die();
        $html = $this->load->view('expedientes/pases/pdf_ticket', $data, true);

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
//			$pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure
        $pdf->WriteHTML($html); // write the HTML into the PDF
        $pdf->Output("Comprobante_{$ticket_id}.pdf", 'I');
    }

    public function pdf_ticket_r($ticket_id) {

        if (!in_groups($this->grupos_permitidos, $this->grupos) || $ticket_id == NULL || !ctype_digit($ticket_id)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }

        $resp = $this->generar_pdf($ticket_id, false);
        if (empty($resp['ticket'])) {
            show_404();
        }
        $data['ticket'] = $resp['ticket'][0];
        $data['expedientes'] = $resp['expedientes'];
        //ini_set('memory_limit', '32M'); // boost the memory limit if it's low
        //var_dump($data);die();
        $html = $this->load->view('expedientes/pases/pdf_ticket', $data, true);

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
//			$pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure
        $pdf->WriteHTML($html); // write the HTML into the PDF
        $pdf->Output("Comprobante_{$ticket_id}.pdf", 'I');
    }
    
    public function reviciones() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $tableData = array(
            'columns' => array(
                array('label' => 'Código', 'data' => 'id', 'sort' => 'revision.id', 'width' => 10),
                array('label' => 'Número', 'data' => 'numero', 'sort' => 'expediente.numero', 'width' => 10),
                array('label' => 'Año', 'data' => 'ano', 'sort' => 'expediente.ano', 'width' => 10),
                array('label' => 'Anexo', 'data' => 'anexo', 'sort' => 'expediente.anexo', 'width' => 10),
                array('label' => 'Observacion', 'data' => 'observacion', 'sort' => 'revision.observacion', 'width' => 10),
                array('label' => 'Usuario Designado', 'data' => 'usuario_designado', 'sort' => 'revision.usuario_revisor', 'width' => 20),
                array('label' => 'Usuario Emisor', 'data' => 'usuario_emisor', 'sort' => 'revision.usuario', 'width' => 20),
                array('label' => 'Fecha', 'data' => 'fecha', 'sort' => 'revision.fecha', 'width' => 20),
                array('label' => '', 'data' => 'edit', 'width' => 5, 'class' => 'dt-body-center', 'responsive_class' => 'all', 'sortable' => 'false', 'searchable' => 'false')
            ),
            'table_id' => 'ticket_table',
            'source_url' => 'expedientes/pases/revisiones_data',
            'order' => array(array(1, 'desc')),
        );
        $data['html_table'] = buildHTML($tableData);
        $data['js_table'] = buildJS($tableData);
        $data['error'] = $this->session->flashdata('error');
        $data['message'] = $this->session->flashdata('message');
        $data['title'] = 'Expedientes - Pases - Tickets';
        $this->load_template('expedientes/pases/ticket_listar', $data);
    }

    public function reviciones_data() {
        if (!in_groups($this->grupos_permitidos, $this->grupos)) {
            show_error('No tiene permisos para la acción solicitada', 500, 'Acción no autorizada');
        }
        $this->datatables
                ->select('revision.id,expediente.numero,expediente.ano, expediente.anexo,revision.observacion, revision.usuario_revisor as usuario_designado, revisor.usaurio as usuario_emisor, fecha',FALSE)
                ->unset_column('revision.id')
                ->join('sigmu.expediente', 'expediente.id = revision.id_expediente')
                ->join('sigmu.pase', 'pase.id_expediente = expediente.id AND pase.origen = '.$this->session->userdata('oficina_actual_id').' AND pase.respuesta = \'pendiente\' AND pase.destino = -1 ')
                ->where(['revision.estado' => 0])
                ->group_by('revision.id_plantilla,revision.id_expediente')
                ->from("$this->sigmu_schema.revision")
                ->add_column('edit', '<button class="btn btn-info" onclick="show_detail_ticket($1)" style="width: 100px;" title="Detalles"><i class="fa fa-info-circle"></i> Expedientes</button>'
                        . '<a class="btn btn-success" href="expedientes/pases/pdf_ticket_r/$1" target="_blank" style="width: 100px;" title="Imprimir"><i class="fa fa-print"></i> Imprimir</a>', 'id')
                ->where('ticket.id>0');

        echo $this->datatables->generate();
    }
        
    public function is_digital_exp(){//si es digital el expediente
        if($this->input->post()){
            $idexp = $this->input->post('idexp');
            $this->load->model('expedientes/expedientes_model');
            echo json_encode(array('required' => $this->expedientes_model->is_digital($idexp)));
        }else{
            echo json_encode(array('required'=>false));
        }
    }

    protected function parsearFecha($fecha_str) {
        $mes = explode(" ", $fecha_str)[1];
        switch ($mes) {
            case "January":
                $fecha_str = str_replace("January", "de Enero de ", $fecha_str);
                break;
            case "February":
                $fecha_str = str_replace("February", "de Febrero de ", $fecha_str);
                break;
            case "March":
                $fecha_str = str_replace("March", "de Marzo de ", $fecha_str);
                break;
            case "April":
                $fecha_str = str_replace("April", "de Abril de ", $fecha_str);
                break;
            case "May":
                $fecha_str = str_replace("May", "de Mayo de ", $fecha_str);
                break;
            case "June":
                $fecha_str = str_replace("June", "de Junio de ", $fecha_str);
                break;
            case "July":
                $fecha_str = str_replace("July", "de Julio de ", $fecha_str);
                break;
            case "August":
                $fecha_str = str_replace("August", "de Agosto de ", $fecha_str);
                break;
            case "September":
                $fecha_str = str_replace("September", "de Septiembre de ", $fecha_str);
                break;
            case "October":
                $fecha_str = str_replace("October", "de Octubre de ", $fecha_str);
                break;
            case "November":
                $fecha_str = str_replace("November", "de Noviembre de ", $fecha_str);
                break;
            case "December":
                $fecha_str = str_replace("December", "de Diciembre de ", $fecha_str);
                break;
        }
        return $fecha_str;
    }

    public function queryTest(){
        $this->load->model('pases_model');
        var_dump($this->pases_model->queryTest('SELECT
        pase.id,
        expediente.id       AS codigo,
        pase.id_expediente  AS idexpediente,
        pase.ano,
        pase.numero,
        pase.anexo,
        pase.fojas,
        oficina.nombre      AS oficina_origen,
        expediente.caratula AS caratula,
        expediente.objeto   AS objeto,
        pase.nota_pase_id,
        pase.usuario_emisor,
        pase.fecha_usuario,
        revision_id
        FROM `sigmu`.`pase`
        INNER JOIN `sigmu`.`oficina`
            ON `oficina`.`id` = `pase`.`origen`
        INNER JOIN `sigmu`.`expediente`
            ON `expediente`.`id` = `pase`.`id_expediente`
        INNER JOIN `sigmu`.`tramite`
            ON `tramite`.`id` = `expediente`.`tramite_id`
        WHERE (`expediente`.`digital` = 1)
            AND `pase`.`origen` = "862"
            AND (`pase`.`respuesta` = "pendiente"
                OR `pase`.`respuesta` = "rechazado"
                OR `pase`.`respuesta` = "firma pendiente"
                OR (`pase`.`origen` = 1
                    AND pase.respuesta = "finalizado"))
            AND (`pase`.`destino` =  - 1
                OR `pase`.`destino` =  - 2)
        ORDER BY `ano` DESC, `numero` DESC
        LIMIT 10'));
    }


}

/* End of file Pases.php */
/* Location: ./application/modules/expedientes/controllers/Pases.php */