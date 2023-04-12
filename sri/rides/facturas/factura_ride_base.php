<?php
if (!defined("ACCESS")) {
	die("Error: You don't have permission to access here...");
}
require_once(dirname(__FILE__) . DS . "tipo_impuesto_enum.php");
require_once(dirname(__FILE__) . DS . "tipo_impuesto_iva_enum.php");
class FacturaRideBase{
    protected $data = array();
    protected $xml;
    protected $numeroAutorizacion;
    protected $fechaAutorizacion;
    protected $totalDescuento = 0;
    protected $totalIva12 = 0;
    protected $subTotal0 = 0;
    protected $subTotal12 = 0;
    protected $totalIce = 0;
    protected $subTotal = 0;
    protected $subTotalExentoIVA = 0;
    protected $totalIRBPNR = 0;
    protected $subTotalNoSujetoIva = 0;
    public function __construct($xmlfile){
        $this->xml = $this->getComprobanteAutorizadoXML($xmlfile);
        if (method_exists($this, 'initialize')) {
            $this->initialize();
	    }
        $this->generateSummary();
    }
    private function getComprobanteAutorizadoXML($xmlfile){
	    $domSrc = file_get_contents($xmlfile);
	    $xmldoc = new SimpleXMLElement($domSrc);
        $this->numeroAutorizacion = $xmldoc->numeroAutorizacion;
        $this->fechaAutorizacion = $xmldoc->fechaAutorizacion;	
	    return  new SimpleXMLElement($xmldoc->comprobante);
    }
    protected function getFormatHTML(){
        return "";
    }
    protected function getAmbiente()
    {            
        switch ($this->xml->infoTributaria->ambiente)
        {
            case "1":
                $m_Ambiente = "PRUEBAS";
                break;
            case "2":
                $m_Ambiente = "PRODUCCION";
                break;
            default :
                $m_Ambiente = "NO DEFINIDO";
                break;
        }
        return $m_Ambiente;
    }
    protected function getEmision()
    {
        switch ($this->xml->infoTributaria->tipoEmision)
        {
            case "1":
                $m_Emision = "NORMAL";
                break;
            case "2":
                $m_Emision = "CONTINGENCIA";
                break;
            default :
                $m_Emision = "NO DEFINIDO";
                break;
        }
        return $m_Emision;
    }
    protected function calcularDescuento()
    {
        $descuento = 0;
        foreach ($this->xml->detalles->detalle as $detalle){
            $descuento = $descuento + $detalle->descuento;
        }
        return $descuento;
    }
    private function generateSummary()
    {
        $this->totalDescuento = $this->calcularDescuento();
        $totalIva12 = 0;
        $totalIva0 = 0;
        $totalExentoIVA = 0;
        $iva12 = 0;
        $totalICE = 0;
        $totalIRBPNR = 0;
        $totalSinImpuesto = 0;
        foreach ($this->xml->infoFactura->totalConImpuestos->totalImpuesto as $ti)
        {
            if ((TipoImpuestoEnum::IVA == (string)$ti->codigo) && (TipoImpuestoIvaEnum::IVAVENTA12 == (string)$ti->codigoPorcentaje))
            {
                $totalIva12 = $totalIva12 + (float)$ti->baseImponible;
                $iva12 = $iva12 + (float)$ti->valor;
            }
            if ((TipoImpuestoEnum::IVA == (string)$ti->codigo) && (TipoImpuestoIvaEnum::IVAVENTA0 == (string)$ti->codigoPorcentaje))
            {
                $totalIva0 = $totalIva0 + (float)$ti->baseImponible;
            }
            if ((TipoImpuestoEnum::IVA == (string)$ti->codigo) && (TipoImpuestoIvaEnum::IVANOOBJETO == (string)$ti->codigoPorcentaje))
            {
                $totalSinImpuesto = $totalSinImpuesto + (float)$ti->baseImponible;
            }
            if ((TipoImpuestoEnum::IVA == (string)$ti->codigo) && (TipoImpuestoIvaEnum::IVAEXCENTO == (string)$ti->codigoPorcentaje))
            {
                $totalExentoIVA = $totalExentoIVA + (float)$ti->baseImponible;
            }
            if (TipoImpuestoEnum::ICE == (string)$ti->codigo)
            {
                $totalICE = $totalICE + (float)$ti->valor;
            }
            if (TipoImpuestoEnum::IRBPNR == (string)$ti->codigo)
            {
                $totalIRBPNR = $totalIRBPNR + (float)$ti->valor;
            }
        }
        $this->totalIva12 = $this->round_number($iva12, 2);
        $this->subTotal0 = $this->round_number($totalIva0, 2);
        $this->subTotal12 = $this->round_number($totalIva12, 2);
        $this->totalIce = $this->round_number($totalICE, 2);
        $this->subTotal = $this->round_number($totalIva0, 2) + $this->round_number($totalIva12, 2);
        $this->subTotalExentoIVA = $this->round_number($totalExentoIVA, 2);
        $this->totalIRBPNR = $this->round_number($totalIRBPNR, 2);
        $this->subTotalNoSujetoIva = $this->round_number($totalSinImpuesto, 2);
    }
    public function round_number($number, $decimals = 2)
    {
        return round( $number, $decimals, PHP_ROUND_HALF_UP);
    }
    public function money_format($number , $decimals = 2 , $dec_point = "." , $thousands_sep = "" )
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
    protected function getFormaPago($code){
        switch ($code){
            case '15':
                return 'COMPENSACIÓN DE DEUDAS';
            case '16':
                return 'TARJETA DE DÉBITO';
            case '17':
                return 'DINERO ELECTRÓNICO';
            case '18':
                return 'TARJETA PREPAGO';
            case '19':
                return 'TARJETA DE CRÉDITO';
            case '20':
                return 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO';
            case '21':
                return 'ENDOSO DE TÍTULOS';
            case '01':
            default:
                return 'SIN UTILIZACION DEL SISTEMA FINANCIERO';
        }
    }
}