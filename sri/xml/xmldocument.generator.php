<?php
include_once "document.wizard.php";
class XMLDocumentGenerator extends DocumentWizard
{
    public function getFacturaXML($factura = null){
        $this->getFacturaBaseXML($factura);
        return $this->generateDocument();
    }
    protected function generarRandom(){
        return '00000123';
    }
    protected function generarDigitoModulo11($cadena) {
        $digits = strrev($cadena );
        if ( ! ctype_digit( $digits ) )
        {
            return null;
        }
        $total = 0;
        $multiplicador = 2;
        for( $i=0;$i<strlen( $digits ); $i++ )
        {
            $total += substr( $digits,$i,1 ) * $multiplicador;
            if ( $multiplicador == 7 )
            {
                $multiplicador = 2;
            }else{
                $multiplicador++;
            }
        }
        $verificador = 11 - ($total % 11);
        if ( $verificador < 10 )
        {
            return $verificador;
        }
        if ( $verificador == 10 )
        {
            return 1;
        }
        return 0;
    }
    protected function generarClaveDeAccesoNormal(&$comprobanteElectronico)
    {
        if (!isset($comprobanteElectronico['codigoRandomico']))
        {
            $comprobanteElectronico['codigoRandomico'] = $this->generarRandom();
        }
        else
        {
            $comprobanteElectronico['codigoRandomico'] = $this->generarRandom();
        }
        $clave = str_replace("/", "", $comprobanteElectronico['fechaEmision']);
        $clave = $clave . $comprobanteElectronico['codigoDocumento'];
        $clave = $clave . $comprobanteElectronico['ruc'];
        $clave = $clave . $comprobanteElectronico['codigoAmbiente'];
        $clave = $clave . $comprobanteElectronico['establecimiento'];
        $clave = $clave . $comprobanteElectronico['puntoEmision'];
        $clave = $clave . $comprobanteElectronico['secuencial'];
        $clave = $clave . $comprobanteElectronico['codigoRandomico'];
        $clave = $clave . $comprobanteElectronico['codigoTipoEmision'];
        $verificador = $this->generarDigitoModulo11($clave);
        $claveGenerada = $clave . $verificador;
        if (strlen($claveGenerada) != 49) {
            $claveGenerada = null;
        }
        return $claveGenerada;
    }
    private function procesadorDeClaveDeAcceso(&$comprobanteElectronico){
        $comprobanteElectronico['claveAcceso'] = $this->generarClaveDeAccesoNormal($comprobanteElectronico);
    }
    private function getInfoTributaria($comprobanteElectronico)
    {
        $infoTributaria = $this->doc->createElement('infoTributaria');
        //$infoTributaria->appendChild($this->doc->createElement('ambiente', 1));
//$infoTributaria = $this.doc.createElement("infoTributaria");
        $infoTributaria->appendChild($this->getNodo("ambiente", $comprobanteElectronico['codigoAmbiente']));
        $infoTributaria->appendChild($this->getNodo("tipoEmision", $comprobanteElectronico['codigoTipoEmision']));
        $infoTributaria->appendChild($this->getNodo("razonSocial", $comprobanteElectronico['razonSocial']));
        if (isset($comprobanteElectronico['nombreComercial'])) {
            $infoTributaria->appendChild($this->getNodo("nombreComercial", $comprobanteElectronico['nombreComercial']));
        }
        $infoTributaria->appendChild($this->getNodo("ruc", $comprobanteElectronico['ruc']));
        $infoTributaria->appendChild($this->getNodo("claveAcceso", $comprobanteElectronico['claveAcceso']));
        $infoTributaria->appendChild($this->getNodo("codDoc", $comprobanteElectronico['codigoDocumento']));
        $infoTributaria->appendChild($this->getNodo("estab", $comprobanteElectronico['establecimiento']));
        $infoTributaria->appendChild($this->getNodo("ptoEmi", $comprobanteElectronico['puntoEmision']));
        $infoTributaria->appendChild($this->getNodo("secuencial", $comprobanteElectronico['secuencial']));
        $infoTributaria->appendChild($this->getNodo("dirMatriz", $comprobanteElectronico['direccionMatriz']));
        return $infoTributaria;
    }
    public function getFacturaBaseXML($factura = null){
        $this->procesadorDeClaveDeAcceso($factura);
        $this->createDomDocument();
        $facturaElement = $this->doc->createElement('factura');
        $facturaElement->setAttribute('id', 'comprobante');
        $facturaElement->setAttribute('version', $factura['documentoVersion']);
        $infoTributaria = $this->getInfoTributaria($factura);
        $infoFactura = $this->doc->createElement("infoFactura");
        $elementDetalles = $this->doc->createElement("detalles");
        $elementInfoAdicional = $this->doc->createElement("infoAdicional");
        $infoFactura->appendChild($this->getNodo("fechaEmision", $factura['fechaEmision']));
        $this->appendNodeIfValueIsNotNull("dirEstablecimiento", $factura['direccionEstablecimiento'], $infoFactura);
        if (isset($factura['contribuyenteEspecial']) && strcmp($factura['contribuyenteEspecial'] , '999') != 0) {
            $this->appendNodeIfValueIsNotNull("contribuyenteEspecial", $factura['contribuyenteEspecial'], $infoFactura);
        } else {
            $this->appendNodeIfValueIsNotNull("contribuyenteEspecial", "", $infoFactura);
        }
        $this->appendNodeIfValueIsNotNull("obligadoContabilidad", $factura['obligadoALlebarContabilidad'], $infoFactura);
        $infoFactura->appendChild($this->getNodo("tipoIdentificacionComprador", $factura['tipoIdentificacionDelComprador']));
        $this->appendNodeIfValueIsNotNull("guiaRemision", $factura['guiaRemision'], $infoFactura);
        $infoFactura->appendChild($this->getNodo("razonSocialComprador", $factura['razonSocialDelComprador']));
        $infoFactura->appendChild($this->getNodo("identificacionComprador", $factura['identificacionDelComprador']));
        $infoFactura->appendChild($this->getNodo("totalSinImpuestos", $factura['totalSinImpuestos']));
        $infoFactura->appendChild($this->getNodo("totalSubsidio", $factura['totalSubsidio']));
        $infoFactura->appendChild($this->getNodo("totalDescuento", $factura['totalDescuento']));
        $elementTotalConImpuestos = $this->doc->createElement("totalConImpuestos");
        foreach ($factura['totalConImpuestos']['impuesto'] as $impuesto)
        {
            $elementTotalImpuesto = $this->doc->createElement("totalImpuesto");
            $elementTotalImpuesto->appendChild($this->getNodo("codigo", $impuesto['codigo']));
            $elementTotalImpuesto->appendChild($this->getNodo("codigoPorcentaje", $impuesto['codigoPorcentaje']));
            $elementTotalImpuesto->appendChild($this->getNodo("baseImponible", $impuesto['baseImponible']));
            $elementTotalImpuesto->appendChild($this->getNodo("valor", $impuesto['valor']));
            $elementTotalConImpuestos->appendChild($elementTotalImpuesto);
        }
        $infoFactura->appendChild($elementTotalConImpuestos);
        $infoFactura->appendChild($this->getNodo("propina", $factura['propina']));
        $infoFactura->appendChild($this->getNodo("importeTotal", $factura['importeTotal']));
        $this->appendNodeIfValueIsNotNull("moneda", $factura['moneda'], $infoFactura);
        foreach ($factura['detallesFactura']['detalleFactura'] as $detalleFactura)
        {
            $elementDetalle = $this->doc->createElement("detalle");
            $elementDetalle->appendChild($this->getNodo("codigoPrincipal", $detalleFactura['codigoPrincipal']));
            $this->appendNodeIfValueIsNotNull("codigoAuxiliar", $detalleFactura['codigoAuxiliar'], $elementDetalle);
            $elementDetalle->appendChild($this->getNodo("descripcion", $detalleFactura['descripcion']));
            $elementDetalle->appendChild($this->getNodo("cantidad", $detalleFactura['cantidad']));
            $elementDetalle->appendChild($this->getNodo("precioUnitario", $detalleFactura['precioUnitario']));
            $cantXvalor = $detalleFactura['precioUnitario'] * $detalleFactura['cantidad'];
            $aux = round( $cantXvalor, 2, PHP_ROUND_HALF_UP);
            if ($detalleFactura['precioSinSubsidio'] > $aux) {
                $elementDetalle->appendChild($this->getNodo("precioSinSubsidio", $detalleFactura['precioSinSubsidio']));
            }
            $elementDetalle->appendChild($this->getNodo("descuento", $detalleFactura['descuento']));
            $elementDetalle->appendChild($this->getNodo("precioTotalSinImpuesto", $detalleFactura['precioTotalSinImpuesto']));
            if (count($detalleFactura['detallesAdicionales']['detalleAdicional']) > 0)
            {
                $elementDetallesAdicionales = $this->doc->createElement("detallesAdicionales");
                foreach ($detalleFactura['detallesAdicionales']['detalleAdicional'] as $detalleAdicional)
                {
                    $detAdicional = $this->getNodo("detAdicional");
                    $detAdicional->setAttribute("nombre", $detalleAdicional['nombre']);
                    $detAdicional->setAttribute("valor", $detalleAdicional['valor']);
                    $elementDetallesAdicionales->appendChild($detAdicional);
                }
                $elementDetalle->appendChild($elementDetallesAdicionales);
            }
            $elementImpuestos = $this->doc->createElement("impuestos");
            foreach ($detalleFactura['detallesImpuestos']['detalleImpuesto'] as $detalleImpuesto)
            {
                $elementImpuesto = $this->doc->createElement("impuesto");
                $elementImpuesto->appendChild($this->getNodo("codigo", $detalleImpuesto['codigo']));
                $elementImpuesto->appendChild($this->getNodo("codigoPorcentaje", $detalleImpuesto['codigoPorcentaje']));
                $elementImpuesto->appendChild($this->getNodo("tarifa", $detalleImpuesto['tarifa']));
                $elementImpuesto->appendChild($this->getNodo("baseImponible", $detalleImpuesto['baseImponible']));
                $elementImpuesto->appendChild($this->getNodo("valor", $detalleImpuesto['valor']));
                $elementImpuestos->appendChild($elementImpuesto);
            }
            $elementDetalle->appendChild($elementImpuestos);
            $elementDetalles->appendChild($elementDetalle);
        }
        $elementPagos = $this->doc->createElement("pagos");
        foreach ($factura['pagos']['pago'] as $pago) {
            $elementPago = $this->doc->createElement("pago");
            $elementPago->appendChild($this->getNodo("formaPago", $pago['formaPago']));
            $elementPago->appendChild($this->getNodo("total", $pago['total']));
            $elementPago->appendChild($this->getNodo("plazo", $pago['plazo']));
            $elementPago->appendChild($this->getNodo("unidadTiempo", $pago['unidadTiempo']));
            $elementPagos->appendChild($elementPago);
        }
        $infoFactura->appendChild($elementPagos);
        foreach ($factura['infoAdicional']['camposAdicionales'] as $campoAdicional) {
            if (isset($campoAdicional['valor'])) {
                //if (!((CampoAdicional)comprobanteElectronico.getInfoAdicional().getCamposAdicionales().get(i)).getValor().equals(""))
                //{
                    $campoAdicionalTmp = $this->getNodo("campoAdicional", $campoAdicional['valor']);
                    $campoAdicionalTmp->setAttribute("nombre", $campoAdicional['nombre']);
                    $elementInfoAdicional->appendChild($campoAdicionalTmp);
                //}
            }
        }
        $facturaElement->appendChild($infoTributaria);
        $facturaElement->appendChild($infoFactura);
        $facturaElement->appendChild($elementDetalles);
        if ($elementInfoAdicional->childNodes->length > 0) {
            $facturaElement->appendChild($elementInfoAdicional);
        }
        $this->doc->appendChild($facturaElement);
        return $this->doc;
    }
    public function getXMLAutorizacionSRI($estado, $numeroAutorizacion, $fechaAutorizacion, $ambiente, $comprobante)
    {
        $this->createDomDocument();
        $elementAutorizacion = $this->doc->createElement('autorizacion');
        $elementAutorizacion->appendChild($this->getNodo("estado", $estado));
        $elementAutorizacion->appendChild($this->getNodo("numeroAutorizacion", $numeroAutorizacion));
        $elementAutorizacion->appendChild($this->getNodo("fechaAutorizacion", $fechaAutorizacion));
        $elementAutorizacion->appendChild($this->getNodo("ambiente", $ambiente));
        $elementAutorizacion->appendChild($this->getNodo("comprobante", $comprobante));
        $mensajes = $this->doc->createElement("mensajes");
        $elementAutorizacion->appendChild($mensajes);
        $this->doc->appendChild($elementAutorizacion);
        //this.doc.setXmlStandalone(true);
        return $this->generateDocumentAsString();
    }
}