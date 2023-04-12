<?php
class SriSoapClient{
    /* Enviar comprobante */
    function validarComprobante($doc) {
        $content = $doc;// $doc->C14N();
        $xml = new SimpleXMLElement($content);
        $ambiente = $xml->infoTributaria->ambiente;
        if ($ambiente == 1) {
            $wsdl = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl";
        } else {
            $wsdl = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl";
        }
        $options = array('soap_version' => SOAP_1_1, 'trace' => true, 'encoding'=>'UTF-8');
        $client = new SoapClient($wsdl, $options);
        try {
            $respuesta = $client->validarComprobante(array('xml' => $content));
            // $datosXML = $client->__getLastResponse();
        } catch (SoapFault $exp) {
        }
        //print_r($respuesta);
        //die();
        //$mensaje = $doc->getElementsByTagName('estado')->item(0)->nodeValue;
        $claveAcceso = null;
        if(isset($respuesta->RespuestaRecepcionComprobante->comprobantes->comprobante->claveAcceso))
            $claveAcceso = (string)$respuesta->RespuestaRecepcionComprobante->comprobantes->comprobante->claveAcceso;
        $estado = (string)$respuesta->RespuestaRecepcionComprobante->estado;
        //$doc = new DOMDocument();
        //$doc->loadXML($datosXML);
        $mensaje = null;
        if(isset($respuesta->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes))
            $mensaje = $this->sri_mensajes_recepcion($respuesta->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes);
        $respuestaRecepcion = [
            'estado' => $estado,
            'claveAcceso' => $claveAcceso,
            'mensajes' => $mensaje
        ];
        return $respuestaRecepcion;
    }
    function sri_mensajes_recepcion($node) {
        $fin_mensaje = null;
        try {
            $msg = $node->mensaje;
            if(isset($msg))
                $fin_mensaje = [
                    'identificador' => $msg->identificador,
                    'mensaje' => $msg->mensaje,
                    'informacionAdicional' => isset($msg->informacionAdicional) ? $msg->informacionAdicional : '',
                    'tipo' => $msg->tipo
                ];
        } catch (Exception $exc) {
            $fin_mensaje = [
                'identificador' => 9999,
                'mensaje' => $exc->getTraceAsString(),
                'informacionAdicional' => '',
                'tipo' => 'ERROR'
                ];
        }
        return $fin_mensaje;
    }
    /* Fin envio comprobante*/
    /* Verificar estado del comprobante */
    public function queryAutorizacionComprobante($ambiente, $claveAcceso) {
        $respuestaSRI = array('estado' => 'ERROR');
        if ($ambiente == 1) {
            $wsdl = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl";
        } else {
            $wsdl = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl";
        }
        $options = array('soap_version' => SOAP_1_1, 'trace' => true, 'encoding'=>'UTF-8');
        $client = new SoapClient($wsdl, $options);
        try {
            $respuesta = $client->autorizacionComprobante(array('claveAccesoComprobante' => $claveAcceso));
            $datosXML = $client->__getLastResponse();
        } catch (SoapFault $exp) {
        }
        $doc1 = new DOMDocument();
        $doc1->loadXML($datosXML);
        $claveConsultada = $respuesta->RespuestaAutorizacionComprobante->claveAccesoConsultada;
        if ($claveAcceso == $claveConsultada) {
            if($respuesta->RespuestaAutorizacionComprobante->numeroComprobantes > 0) {
                $proceso = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado;
                if ($proceso == "AUTORIZADO") {
                    $nroAut = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
                    $fecAut = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
                    $ambiente = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;
                    $comprobante = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                    $respuestaSRI['estado'] = $proceso;
                    $respuestaSRI['numeroAutorizacion'] = $nroAut;
                    $respuestaSRI['fechaAutorizacion'] = $fecAut;
                    $respuestaSRI['ambiente'] = $ambiente;
                    $respuestaSRI['comprobante'] = $comprobante;
                } else {
                    $nroAut = $claveAcceso; //$respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
                    $fecAut = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
                    $ambiente = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente;
                    $comprobante = $respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                    $mensaje = null;
                    if (isset($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes))
                        $mensaje = $this->sri_mensajes_rechazada($respuesta->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes);
                    $respuestaSRI['estado'] = $proceso;
                    $respuestaSRI['numeroAutorizacion'] = $nroAut;
                    $respuestaSRI['fechaAutorizacion'] = $fecAut;
                    $respuestaSRI['ambiente'] = $ambiente;
                    $respuestaSRI['comprobante'] = $comprobante;
                    $respuestaSRI['mensajes'] = $mensaje;
                }
            }
        }
        return $respuestaSRI;
    }
    public function autorizacionComprobante($doc) {
        $content = $doc;// $doc->C14N();
        $xml = new SimpleXMLElement($content);
        $ambiente = $xml->infoTributaria->ambiente;
        $claveAcceso = $xml->infoTributaria->claveAcceso;
        return $this->queryAutorizacionComprobante($ambiente, $claveAcceso);
    }
    function sri_mensajes_rechazada($node) {
        $fin_mensaje = null;
        try {
            $msg = $node->mensaje;
            if(isset($msg))
                $fin_mensaje = [
                    'identificador' => $msg->identificador,
                    'mensaje' => $msg->mensaje,
                    'informacionAdicional' => isset($msg->informacionAdicional) ? $msg->informacionAdicional : '',
                    'tipo' => $msg->tipo
                ];
        } catch (Exception $exc) {
            $fin_mensaje = [
                'identificador' => 9999,
                'mensaje' => $exc->getTraceAsString(),
                'informacionAdicional' => '',
                'tipo' => 'ERROR'
            ];
        }
        return $fin_mensaje;
    }
}