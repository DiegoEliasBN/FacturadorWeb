<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('PATH_COMPROBANTES') or define('PATH_COMPROBANTES', PATH_ROOT . DS. 'comprobantes');
defined('PATH_AUTORIZADOS') or define('PATH_AUTORIZADOS', PATH_COMPROBANTES . DS . 'autorizados');
defined('PATH_FIRMADOS') or define('PATH_FIRMADOS', PATH_COMPROBANTES . DS . 'firmados');
defined('CODIGO_AMBIENTE')  or define('CODIGO_AMBIENTE', 2); // 1: PRUEBAS ; 2: PRODUCCION
defined('SIGNER_URL_BASE')  or define('SIGNER_URL_BASE', "http://ec2-3-17-23-249.us-east-2.compute.amazonaws.com/rest/");
// defined('SIGNER_URL_BASE')  or define('SIGNER_URL_BASE', "http://localhost:8080/rest/");
defined('SIGNER_AUTH_USER')  or define('SIGNER_AUTH_USER', 'fpinduisaca');
defined('SIGNER_AUTH_PSW')  or define('SIGNER_AUTH_PSW', '*yachasoft.com.1123581321*');
session_start();
include_once "xml/xmldocument.generator.php";
include_once "rest.client.php";
include_once "webservices/srisoapclient.php";
include_once "ride.php";
include_once dirname(dirname(__FILE__)) . DS . "modelos" . DS . "comprobantes.modelo.php";
include_once "identificaciones.php";
class ComprobantesElectronicos
{
    const TIPO_FACTURA = 'Factura';
    const TIPO_RETENCION = 'Retencion';
    const TIPO_GUIA = 'Guia';
    private function getDatosEstablecimiento($codigo_almacen){
        switch ($codigo_almacen){
            case 1: // La ternera colon
                return [
                    'nombreEstablecimiento' => 'LA TERNERA',
                    'establecimiento' => '003',
                    'puntoemision' => '002'
                ];
            case 2: // La ternera chirijos
                return [
                    'nombreEstablecimiento' => 'LA TERNERA',
                    'establecimiento' => '004',
                    'puntoemision' => '002'
                ];
            case 3: // Carnisariato
                return [
                    'nombreEstablecimiento' => 'CARNISARIATO CB',
                    'establecimiento' => '002',
                    'puntoemision' => '002'
                ];
            default: // Local no asignado
                return [
                    'nombreEstablecimiento' => 'NO DEFINIDO',
                    'establecimiento' => '',
                    'puntoemision' => ''
                ];
        }
    }
    /*=============================================
    PROCESAR COMPROBANTES ELECTRONICOS
    =============================================*/
    public function procesarComprobantesPendientes(){
        //echo 'Espere... procesando comprobantes pendientes.';
        //header("Content-Type: text/xml");
        //header('Content-Type: application/json');
        $configComprobantes = [
            [
                'tipo' => self::TIPO_FACTURA,
                'tabla' => 'ventas',
                'vista' => 'vista_facturas'
            ],
            [
                'tipo' => self::TIPO_RETENCION,
                'tabla' => 'retencion',
                'vista' => 'vista_retenciones'
            ]
        ];
        foreach ($configComprobantes as $config){
            $this->procesarPendientes($config);
        }
    }
    private function procesarPendientes($config)
    {
        $c = new ModeloComprobantes();
        $rows = $c->getComprobantesPendientes($config['vista'], 0);
        foreach ($rows as $row)
        {
            echo sprintf('Procesando %s %s', $config['tipo'], $row['id']);
            $end_point = '';
            switch ($config['tipo']){
                case self::TIPO_RETENCION:
                    $end_point = 'sign/retention';
                    $obj = $this->getRetencionObject($row);
                    break;
                case self::TIPO_FACTURA:
                default:
                    $end_point = 'sign/invoice';
                    $obj = $this->getFacturaObject($row);
                    break;
            }
            $api = new RestClient([
                'base_url' => SIGNER_URL_BASE,
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(sprintf("%s:%s", SIGNER_AUTH_USER, SIGNER_AUTH_PSW)),
                    'Content-Type' => 'application/json'
                ],
            ]);
            $result = $api->post($end_point, json_encode($obj));
            //echo $result->response;
            //die();
            if ($result->info->http_code == 200){
                $dom_signed = $result->response;
                $xml = new SimpleXMLElement($dom_signed);
                $claveAcceso = $xml->infoTributaria->claveAcceso;
                if(!isset($row['claveacceso'])){
                    $this->setClaveAcceso($config['tabla'], $row['id'], $claveAcceso);
                }
                $ws = new SriSoapClient();
                $message = $ws->validarComprobante($dom_signed); //ok
                echo ' * RECEPCION: '. $message['estado'];
                if($message['estado'] == 'RECIBIDA'){
                    sleep(3);
                    $auth = $this->autorizarComprobante($dom_signed);
                    echo ' * AUTORIZACION: ' . $auth['estado'];
                    if ($auth['estado'] == "AUTORIZADO") {
                        $this->setCambiarEstado($config['tabla'], $row['id'], 1);
                    }
                    else{
                        print_r($auth);
                    }
                }elseif ($message['estado'] == 'DEVUELTA'){
                    if ($message['mensajes']['identificador'] == 43 || $message['mensajes']['identificador'] == 45){
                        $auth = $this->autorizarComprobante($dom_signed);
                        echo ' * AUTORIZACION: ' . $auth['estado'];
                        if ($auth['estado'] == "AUTORIZADO") {
                            $this->setCambiarEstado($config['tabla'], $row['id'], 1);
                        }
                        else{
                            print_r($auth);
                        }
                    }
                    else
                    {
                        print_r($message);
                    }
                }
            }
            else{
                echo sprintf('<br>No se pudo firmar %s %s: Code:%s Detail: %s %s', $config['tipo'], $row['id'], $result->info->http_code, $result->error, $result->response);
            }
            //break;
        }
    }
    private function autorizarComprobante($dom_signed){
        $ws = new SriSoapClient();
        $resp = $ws->autorizacionComprobante($dom_signed);
        if ($resp['estado'] == "AUTORIZADO") {
            $g = new XMLDocumentGenerator();
            $dom_aut = $g->getXMLAutorizacionSRI($resp['estado'], $resp['numeroAutorizacion'], $resp['fechaAutorizacion'], $resp['ambiente'], $resp['comprobante']);
            $filePath = sprintf('%s%s%s.xml', PATH_AUTORIZADOS, DIRECTORY_SEPARATOR, $resp['numeroAutorizacion']);
            if (!is_null($filePath))
                file_put_contents($filePath, $dom_aut);
        }
        return $resp;
    }
    public function showPDF($xmlfile){
        (new Ride())->showPDF($xmlfile);
    }
    public function downloadXML($xmlfile){
        (new Ride())->downloadXML($xmlfile);
    }
    /* GENERAR CONTENIDOS DE UNA FACTURA */
    private function getFacturaObject($row){
        $secuencia = '';
        $de = $this->getDatosEstablecimiento($row['codigo_almacen']);
        $establecimiento = $de['establecimiento'];
        $puntoemision = $de['puntoemision'];
        $nombreEstablecimiento = $de['nombreEstablecimiento'];
        if(!isset($row['secuencia']) || strlen($row['secuencia']) != 17){
            $c = new ModeloComprobantes();
            $nextid = $c->getNextID(sprintf("FACTURA_%s-%s-%s", CODIGO_AMBIENTE, $establecimiento, $puntoemision));
            $secuencia = str_pad($nextid, 9, "0", STR_PAD_LEFT);
            $row['secuencia'] = sprintf("%s-%s-%s", $establecimiento, $puntoemision, $secuencia);
            $c->updateComprobante('ventas','secuencia',$row['secuencia'], 'id', $row['id']);
        }
        else
        {
            $tmp = explode('-', $row['secuencia']);
            $establecimiento = $tmp[0];
            $puntoemision = $tmp[1];
            $secuencia = $tmp[2];
        }
        $informacionAdicional = [];
        $informacionAdicional[] = ['nombre' => 'Direccion del cliente', 'valor' => $row['direccion_cliente']];
        $informacionAdicional[] = ['nombre' => 'Correo del cliente', 'valor' => $row['email_cliente']];
        // Detalle de comprobante
        $productos = json_decode($row['productos'], true);
        $detalle_productos = [];
        $totalConImpuesto = 0;
        $totalSinImpuesto = 0;
        foreach ($productos as $producto){
            $paga_iva = !($producto['precio'] == $producto['precioconiva']);
            $cantidad = round($producto['cantidad'], 6, PHP_ROUND_HALF_UP);
            $precioTotalSinImpuesto = $producto['total'];
            $tasa_iva = 0;
            $codigo_impuesto = 2;
            $codigo_porcentaje = 0;
            if ($paga_iva){
                // $precioTotalSinImpuesto = $this->round_number( $precioTotalSinImpuesto / 1.12 );
                $tasa_iva = 12;
                $codigo_porcentaje = 2;
            }
            $precioUnitario = round($precioTotalSinImpuesto / $cantidad, 4, PHP_ROUND_HALF_UP);
            $baseImponibleImpuesto = round($cantidad * $precioUnitario, 2, PHP_ROUND_HALF_UP);
            $iva = round($baseImponibleImpuesto * $tasa_iva / 100, 2, PHP_ROUND_HALF_UP);
            if($paga_iva)
                $totalConImpuesto += $baseImponibleImpuesto;
            else
                $totalSinImpuesto += $baseImponibleImpuesto;
            $detalle = [
                'codigoAuxiliar' => '',
                'precioSinSubsidio' => '0',
                'detallesAdicionales' =>
                    array (
                        'detalleAdicional' =>
                            array (
                            ),
                    ),
                'codigoPrincipal' => $producto['id'],
                'descripcion' => $producto['descripcion'],
                'cantidad' => number_format ($cantidad, 2, '.', ''),
                'precioUnitario' => number_format ($precioUnitario, 4, '.', ''),
                'descuento' => '0',
                'precioTotalSinImpuesto' => number_format ($baseImponibleImpuesto, 2, '.', ''),
                'detallesImpuestos' =>
                    array (
                        'detalleImpuesto' =>
                            array (
                                0 =>
                                    array (
                                        'codigo' => $codigo_impuesto,
                                        'codigoPorcentaje' => $codigo_porcentaje,
                                        'baseImponible' => number_format ($baseImponibleImpuesto, 2, '.', ''),
                                        'valor' => number_format ($iva, 2, '.', ''),
                                        'tarifa' => $tasa_iva,
                                    ),
                            ),
                    )
            ];
            $detalle_productos[] = $detalle;
        }
        $totalImpuesto = 0;
        $impuesto = [];
        $impuesto[] = ['codigo' => '2',
            'codigoPorcentaje' => '0',
            'baseImponible' => number_format ($totalSinImpuesto, 2, '.', ''),
            'valor' => 0,
            'tarifa' => 0];
        if($totalConImpuesto > 0){
            $totalImpuesto = number_format (round($totalConImpuesto * 12 / 100,2, PHP_ROUND_HALF_UP), 2, '.', '');
            $impuesto[] = ['codigo' => '2',
                'codigoPorcentaje' => '2',
                'baseImponible' => number_format ($totalConImpuesto, 2),
                'valor' => number_format ($totalImpuesto, 2),
                'tarifa' => 12];
        }
        $importeTotal = number_format ($totalSinImpuesto + $totalConImpuesto + $totalImpuesto, 2, '.', '');
        $pago = [];
        $pago[] = ['formaPago' => '01',
            'total' => number_format ($importeTotal, 2, '.', ''),
            'plazo' => '0',
            'unidadTiempo' => 'n/a'];
        $fechaEmision = new DateTime($row['fecha']);
        // echo $fechaEmision->format('d-m-Y');
        $razonSocialDelComprador = trim($row['nombre_cliente']);
        $identificacionDelComprador = trim($row['identificacion_cliente']);
        $lenIdentificacionDelComprador = strlen($identificacionDelComprador);
        $validador = new Identificaciones();
        if( $lenIdentificacionDelComprador == 10 && $validador->validarCedula($identificacionDelComprador)){
            $tipoIdentificacionDelComprador = '05';
        }
        elseif( $lenIdentificacionDelComprador == 13 && ($validador->validarRucPersonaNatural($identificacionDelComprador) || $validador->validarRucSociedadPublica($identificacionDelComprador))){
            $tipoIdentificacionDelComprador = '04';
        }
        elseif( $lenIdentificacionDelComprador == 13 && $validador->validarRucSociedadPrivada($identificacionDelComprador)){
            $tipoIdentificacionDelComprador = '04';
        }
        else{
            $tipoIdentificacionDelComprador = '07';
            $razonSocialDelComprador = 'CONSUMIDOR FINAL';
            $identificacionDelComprador = '9999999999999';
        }
        return array (
            'claveAcceso' => '',
            'contribuyenteEspecial' => '',
            'obligadoLlevarContabilidad' => 'SI',
            'guiaRemision' => '',
            'totalSubsidio' => 0,
            'pagos' =>
                array (
                    'pago' => $pago
                ),
            'codigoRandomico' => '00000001',
            'codigoAmbiente' => CODIGO_AMBIENTE,
            'codigoTipoEmision' => '1',
            'ruc' => $row['ruc_almacen'],
            'codigoDocumento' => '01',
            'establecimiento' => $establecimiento,
            'puntoEmision' => $puntoemision,
            'secuencial' => $secuencia,
            'fechaEmision' => $fechaEmision->format('d/m/Y'),
            'documentoVersion' => '1.1.0',
            'razonSocial' => 'BARROS VALLEJO JORGE ENRIQUE',
            'nombreComercial' => $nombreEstablecimiento,
            'direccionMatriz' => 'Milagro',
            'direccionEstablecimiento' => $row['direccion_almacen'],
            'infoAdicional' =>
                array (
                    'camposAdicionales' => $informacionAdicional
                ),
            'tipoIdentificacionDelComprador' => $tipoIdentificacionDelComprador,
            'razonSocialDelComprador' => $razonSocialDelComprador,
            'identificacionDelComprador' => $identificacionDelComprador,
            'totalSinImpuestos' => number_format ($totalSinImpuesto + $totalConImpuesto, 2, '.', ''),
            'totalDescuento' => '0',
            'totalConImpuestos' =>
                array (
                    'impuesto' => $impuesto
                ),
            'propina' => '0',
            'importeTotal' => number_format ($importeTotal, 2, '.', ''),
            'moneda' => 'DOLAR',
            'detallesFactura' =>
                array (
                    'detalleFactura' => $detalle_productos
                ),
        );
    }
    private function fixNumDocumentoSustentoRetencion($secuencia){
        $tmp = explode('-', $secuencia);
        if(is_array($tmp)){
            switch (count($tmp)){
                case 1:
                    return str_replace('-', '', $tmp[0]);
                case 2:
                    return $tmp[0].str_pad($tmp[1], 9, "0", STR_PAD_LEFT);
                case 3:
                    return $tmp[0].$tmp[1].str_pad($tmp[2], 9, "0", STR_PAD_LEFT);
                default:
                    return $secuencia;
            }
        }
        return $secuencia;
    }
    /* GENERAR CONTENIDOS DE UNA RETENCION */
    private function getRetencionObject($row){
        $secuencia = '';
        $de = $this->getDatosEstablecimiento($row['codigo_almacen']);
        $establecimiento = $de['establecimiento'];
        $puntoemision = $de['puntoemision'];
        $nombreEstablecimiento = $de['nombreEstablecimiento'];
        if(!isset($row['secuencia']) || strlen($row['secuencia']) != 17){
            $c = new ModeloComprobantes();
            $nextid = $c->getNextID(sprintf("RETENCION_%s-%s-%s", CODIGO_AMBIENTE, $establecimiento, $puntoemision));
            $secuencia = str_pad($nextid, 9, "0", STR_PAD_LEFT);
            $row['secuencia'] = sprintf("%s-%s-%s", $establecimiento, $puntoemision, $secuencia);
            $c->updateComprobante('retencion','secuencia',$row['secuencia'], 'id', $row['id']);
        }
        else
        {
            $tmp = explode('-', $row['secuencia']);
            $establecimiento = $tmp[0];
            $puntoemision = $tmp[1];
            $secuencia = $tmp[2];
        }
        $informacionAdicional = [];
        $informacionAdicional[] = ['nombre' => 'Direccion', 'valor' => $row['direccion_proveedor']];
        $informacionAdicional[] = ['nombre' => 'Email', 'valor' => $row['email_proveedor']];
        // Detalle de comprobante
        $detalleRetencion = [];
        $c = new ModeloComprobantes();
        $dt_ret = $c->getDetalleComprobante('vista_detalle_retencion', $row['id']);
        foreach ($dt_ret as $item) {
            $fechaEmisionComprobante = new DateTime($row['fecha_emision_comprobante']);
            $impuestoRetencion = [
                'codigo' => $item['codigo'],
                'codigoRetencion' => $item['codigo_retencion'],
                'baseImponible' => $item['base_imponible'],
                'porcentajeRetener' => $item['porcentaje_retener'],
                'valorRetenido' => $item['valor_retenido'],
                'codDocSustento' => $row['cod_doc_sustento'],
                'numDocSustento' => $this->fixNumDocumentoSustentoRetencion($row['numero_comprobante']),
                'fechaEmisionDocSustento' => $fechaEmisionComprobante->format('d/m/Y')
            ];
            $detalleRetencion[] = $impuestoRetencion;
        }
        $fechaEmision = new DateTime($row['fecha']);
        $razonSocialSujetoRetenido = trim($row['nombre_proveedor']);
        $identificacionSujetoRetenido = trim($row['identificacion_proveedor']);
        $lenIdentificacionDelSujetoRetenido = strlen($identificacionSujetoRetenido);
        $tipoIdentificacionSujetoRetenido = ($lenIdentificacionDelSujetoRetenido == 13 ? '04' : '05');
        $validador = new Identificaciones();
        if( $lenIdentificacionDelSujetoRetenido == 10 && $validador->validarCedula($identificacionSujetoRetenido)){
            $tipoIdentificacionSujetoRetenido = '05';
        }
        elseif( $lenIdentificacionDelSujetoRetenido == 13 && ($validador->validarRucPersonaNatural($identificacionSujetoRetenido) || $validador->validarRucSociedadPublica($identificacionSujetoRetenido))){
            $tipoIdentificacionSujetoRetenido = '04';
        }
        elseif( $lenIdentificacionDelSujetoRetenido == 13 && $validador->validarRucSociedadPrivada($identificacionSujetoRetenido)){
            $tipoIdentificacionSujetoRetenido = '04';
        }
        else{
            /*$tipoIdentificacionSujetoRetenido = '07';
            $razonSocialSujetoRetenido = 'CONSUMIDOR FINAL';
            $identificacionSujetoRetenido = '9999999999999';*/
        }
        return array (
            'claveAcceso' => '',
            'contribuyenteEspecial' => '',
            'obligadoLlevarContabilidad' => 'SI',
            'codigoRandomico' => '00000001',
            'codigoAmbiente' => CODIGO_AMBIENTE,
            'codigoTipoEmision' => '1',
            'ruc' => $row['ruc_almacen'],
            'codigoDocumento' => '07',
            'establecimiento' => $establecimiento,
            'puntoEmision' => $puntoemision,
            'secuencial' => $secuencia,
            'fechaEmision' => $fechaEmision->format('d/m/Y'),
            'periodoFiscal' => $fechaEmision->format('m/Y'),
            'documentoVersion' => '1.0.0',
            'razonSocial' => 'BARROS VALLEJO JORGE ENRIQUE',
            'nombreComercial' => $nombreEstablecimiento,
            'direccionMatriz' => 'Milagro',
            'direccionEstablecimiento' => $row['direccion_almacen'],
            'infoAdicional' =>
                array (
                    'camposAdicionales' => $informacionAdicional
                ),
            'tipoIdentificacionSujetoRetenido' => $tipoIdentificacionSujetoRetenido,
            'razonSocialSujetoRetenido' => $razonSocialSujetoRetenido,
            'identificacionSujetoRetenido' => $identificacionSujetoRetenido,
            'impuestosRetencion' => [
                'impuestoRetencion' => $detalleRetencion
            ]
        );
    }
    private function setClaveAcceso($tabla, $id, $clave){
        $c = new ModeloComprobantes();
        return $c->updateComprobante($tabla,'claveacceso',$clave, 'id', $id);
    }
    private function setCambiarEstado($tabla, $id, $estado){
        $c = new ModeloComprobantes();
        return $c->updateComprobante($tabla,'procesado_sri',$estado, 'id', $id);
    }
}