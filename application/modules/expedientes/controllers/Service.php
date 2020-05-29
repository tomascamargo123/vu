<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service
 *
 * @author m-1
 */
class Service extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library("nusoap_lib"); //cargando mi biblioteca
        $this->load->model('expedientes/archivos_adjuntos_model');
        $ns = "http://tempuri.org/";
        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("ServiceSoap", $ns);
        $this->nusoap_server->wsdl->schemaTargetNamespace = $ns;
 
        //registrando funciones
        $input_array = array ('xmlData' => "xsd:string");
        $return_array = array ("InvokerResult" => "xsd:string");
        $this->nusoap_server->register(
                'Invoker',
                $input_array,
                $return_array,
                $ns,
                $ns."Invoker",
                "rpc", 
                "encoded", 
                "Procesa las solicitudes del firmador");
    }
    
    function index(){
        function Invoker($xmlData)
        {
            $response = "";
            //pasamos el xml a un array
            $xml = simplexml_load_string($xmlData);
            $json = json_encode($xml);
            $xmlArray = json_decode($json,true);
            
            //procesamos solicitud
            file_put_contents("input.log", $xmlArray['operationData']['file']['type']);
            switch ($xmlArray['operationData']['file']['type']){
                case "obtenerPDF":
                    $data_pdf = get_pdf($xmlArray['operationData']['file']['id']);
                    //file_put_contents("pdf_original.pdf.", $data_pdf);
                    $response = create_xml_response($data_pdf);
                    break;
                case "guardarPDF":
                    $status = save_pdf_signed($xmlArray);
                    $pase_id = finalizar_solicitud($xmlArray['operationData']['file']['id']);
                    
                    if(!empty($pase_id) && $pase_id != 'NULL' && $pase_id > 0)
                        continuar_pase($xmlArray['operationData']['file']['id']);
                    else
                        habilitar_envio($xmlArray['operationData']['file']['id']);
                    //file_put_contents("pdf_firmado.pdf.", base64_decode($xmlArray['operationData']['file']['fileData']));
                    $response =  create_xml_status($status);
                    //file_put_contents("output.log", $response);
                    break;
                default :
                    break;
            }
            return $response;
        }
        
        function get_pdf($id = 0) {
            if ($id != 0) {
                $ci =& get_instance();
                $ci->db->select('contenido');
                $ci->db->select('nombre');
                $ci->db->where('id', $id);
                $ci->db->where('tipodecontenido', 'application/pdf');
                $ci->db->from('sigmu.archivoadjunto');
                $query = $ci->db->get();
                $result = $query->row_array();
                return $result;
            }
            return null;
        } 
        
        function create_xml_response($data_pdf) {
            
            $array_base = array(
                'name' => 'AddSignedFile',
                'return_code' => 0,
                'operation_data' => base64_encode($data_pdf['contenido']),
                'error_message' => 'Datos obtenidos correctamente. Cantidad de caracteres recibidos: '
            );

            //create the xml document
            $xmlDoc = new DOMDocument('1.0', 'utf-8');
            //$xmlDoc->encoding = 
            $root = $xmlDoc->appendChild($xmlDoc->createElement("operation"));

            $root->appendChild($xmlDoc->createElement("name", $array_base['name']));
            $root->appendChild($xmlDoc->createElement("returnCode", $array_base['return_code']));
            $root->appendChild($xmlDoc->createElement("operationData", $array_base['operation_data']));
            $root->appendChild($xmlDoc->createElement("errorMessage", $array_base['error_message']));

            header("Content-Type: text/plain");

            //make the output pretty
            $xmlDoc->formatOutput = true;
            //$xmlDoc->save("output_resonse.xml");


            return $xmlDoc->saveXML();
        }
        
        function save_pdf_signed($xmlArray = null) {
            if (!empty($xmlArray)) {
                $ci =& get_instance();
                $ci->db->set(
                        'contenido',
                        base64_decode($xmlArray['operationData']['file']['fileData']),
                        true);
                $ci->db->where('id', $xmlArray['operationData']['file']['id']);
                $ci->db->update('sigmu.archivoadjunto');
                return true;
            }
            return false;
        }
        
        function continuar_pase($id_archivo){
            $ci =& get_instance();
            //verificamos que todos los firmantes hayan firmado
            $sql = "SELECT estado, pase_id FROM expedientes.firmas_archivos_adjuntos WHERE archivo_adjunto_id = ".$id_archivo;
            $query = $ci->db->query($sql);
            $result = $query->result_array();
            $query->free_result();//libero el resultado para ahcer uso del $query de nuevo
            $pendientes = false;
            foreach ($result as $r){
                if($r['estado'] == 'Solicitada'){
                    $pendientes =true;
                }
            }
            if($pendientes || empty($result[0]['pase_id'])){
            //retornamos si hay pendiente hasta que ya no queden firmas en este documento O si
            // la no hay id de pase por que es una solicitud de firma no relacionada a un formulario automatisado
                return;
            }
            $pase_id = $result[0]['pase_id'];
            //obtenemos la oficina destino
            $query = $ci->db->query("SELECT e.id as id_expediente, c.oficina_destino_id as destino, ch.id as id_cir_histo, t.digital,e.ano,e.anexo,e.numero,e.fojas FROM sigmu.pase p"
                        ." INNER JOIN sigmu.expediente e ON e.id = p.id_expediente"
                        ." INNER JOIN sigmu.tramite t ON t.id = e.tramite_id"
                        ." INNER JOIN sigmu.circuito_firmas_historico ch ON ch.tramite_id = t.id AND ch.expediente_id = p.id_expediente"
                        ." INNER JOIN sigmu.circuito c ON c.tramite_id = ch.tramite_id AND c.plantilla_id = ch.plantilla_id"
                        ." WHERE p.id = ".$pase_id." AND p.origen = c.oficina_id ORDER BY ch.id DESC LIMIT 1;");
            $result = $query->row_array();
            $query->free_result();
            
            if(sizeof($result) == 0) return;// si hay firmas pendientes del mismo archivo no continuamos el pase
            
            $destino = $result['destino'];
            $id_expe = $result['id_expediente'];
            $id_histo = $result['id_cir_histo'];
            $ci->db->trans_begin();
            //modificamos el pase para que siga con su circuito
            $ci->db->set('destino', $destino);
            $ci->db->set('respuesta','aceptado');
            $ci->db->set('fecha', date('Y-m-d H:i:s'));
            $ci->db->where('id',$pase_id);
            $ci->db->update('sigmu.pase');
            
            //hacer el insert del sig pase
            
            $ci->db->select('etapa_circuito');
            $ci->db->where('id_expediente', $id_expe);
            $ci->db->order_by('etapa_circuito', 'desc');
            $ci->db->limit('1');
            $etapa_circuito = $ci->db->get('sigmu.pase')->row_array()['etapa_circuito'];
           
            $ci->db->insert('sigmu.pase',array(
                             'id_expediente' => $id_expe,
                             'ano' => $result['ano'],
                             'numero' => $result['numero'],
                             'anexo' => $result['anexo'],
                             'origen' => $destino,
                             'destino' => -1,
                             'respuesta' => 'pendiente',
                             'fojas' => $result['fojas'],
                             'fecha'=>date_format(new DateTime(), 'Y-m-d  H:i:s'),
                             'usuario_emisor' => 'firma_digital',
                             'fecha_usuario' => date_format(new DateTime(), 'Y-m-d  H:i:s'),
                             'etapa_circuito' => ($etapa_circuito+1)
                             )
                    );
            //se cambia el estado de la firma pendiente y ahora se completa
            $ci->db->set('firma_pendiente', false);
            $ci->db->where('id',$id_expe);
            $ci->db->update('sigmu.expediente');
            //insertamos nuevo pase el pendiente de emicion de la siguiente oficina, de esa manera
            //modificamos el estado del historico en la base sigmu
            $ci->db->set('estado','terminado');
            $ci->db->where('id',$id_histo);
            $ci->db->update('sigmu.circuito_firmas_historico');
            
            if($ci->db->trans_status() == FALSE){
                $ci->db->trans_rollback();
            }else{
                $ci->db->trans_commit();
            }
        }
        
        function finalizar_solicitud($id_pdf = 0){
            if($id_pdf > 0){
                $ci =& get_instance();
                $query = $ci->db->query("SELECT id,pdf_id, firm_id, user_id FROM expedientes.registro_firma WHERE estado = 0 AND pdf_id = $id_pdf ;");
                $result = $query->row_array();
                
                $pase_id = $ci->db->query("SELECT pase_id  FROM expedientes.firmas_archivos_adjuntos WHERE id = ".$result['firm_id']." AND archivo_adjunto_id = ".$id_pdf.";")->row_array()['pase_id'];
                
                $ci->db->set('estado','Realizada');
                $ci->db->set('estado_lectura',2);
                $ci->db->set('usuario_id',$result['user_id']);
                $ci->db->set('fecha_firma',(new DateTime())->format('Y-m-d H:i:s'));
                $ci->db->where('id', $result['firm_id']);
                $ci->db->where('archivo_adjunto_id', $result['pdf_id']);
                $ci->db->update('expedientes.firmas_archivos_adjuntos');
                
                $ci->db->set('estado', true);
                $ci->db->set('fecha',(new DateTime())->format('Y-m-d H:i:s'));
                $ci->db->set('audi_accion','U');
                $ci->db->set('audi_fecha',(new DateTime())->format('Y-m-d H:i:s'));
                $ci->db->where('id',$result['id']);
                $ci->db->where('estado',false);
                $ci->db->update('expedientes.registro_firma');
                
                return $pase_id;
            }
           
        }
        
        function create_xml_status($status) {
            $array_base = array();
            $array_base['name'] = 'AddSignedFile';
            $array_base['operation_data'] = "";
            $array_base['error_message'] = 'Mensaje de error 1';
            if ($status) {
                //si hubo exito al guardar el documento
                $array_base['return_code'] = 0;
            } else {
                $array_base['return_code'] = 1;
            }

            //create the xml document
            $xmlDoc = new DOMDocument('1.0', 'utf-8');
            //$xmlDoc->encoding = 
            $root = $xmlDoc->appendChild($xmlDoc->createElement("operation"));

            $root->appendChild($xmlDoc->createElement("name", $array_base['name']));
            $root->appendChild($xmlDoc->createElement("returnCode", $array_base['return_code']));
            $root->appendChild($xmlDoc->createElement("operationData", $array_base['operation_data']));
            $root->appendChild($xmlDoc->createElement("errorMessage", $array_base['error_message']));

            header("Content-Type: text/plain");

            //make the output pretty
            $xmlDoc->formatOutput = true;
            //$xmlDoc->save("output_status.xml");


            return $xmlDoc->saveXML();
        }
        
        function habilitar_envio($id_pdf){
            $ci =& get_instance();
            //verificamos que todos los firmantes hayan firmado
            $sql = "SELECT estado, pase_id FROM expedientes.firmas_archivos_adjuntos WHERE archivo_adjunto_id = ".$id_pdf." AND estado = 'Solicitada'";
            $query = $ci->db->query($sql);
            $result = $query->result_array();
            $query->free_result();//libero el resultado para ahcer uso del $query de nuevo

            if(sizeof($result) > 0) return;
            //retornamos si hay pendiente hasta que ya no queden firmas en este documento O si
            // la no hay id de pase por que es una solicitud de firma no relacionada a un formulario automatisado
            $cant = $ci->db->query("SELECT COUNT(*) as cant
            FROM expedientes.firmas_archivos_adjuntos
            WHERE archivo_adjunto_id IN(SELECT
            id
            FROM sigmu.archivoadjunto
            WHERE id_expediente = (SELECT
            id_expediente
            FROM sigmu.archivoadjunto
            WHERE id = $id_pdf))
            AND estado = 'Solicitada'")->result_array();

            if($cant[0]['cant'] < 1){
                $ci->db->simple_query('UPDATE sigmu.expediente SET firma_pendiente = 0 WHERE id = (SELECT archivoadjunto.id_expediente FROM sigmu.archivoadjunto WHERE archivoadjunto.id = '.$id_pdf.')');
            }
        }
 
        $this->nusoap_server->service(file_get_contents("php://input"));
    }

}
