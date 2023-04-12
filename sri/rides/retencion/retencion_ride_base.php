<?php
if (!defined("ACCESS")) {
    die("Error: You don't have permission to access here...");
}
// require_once(dirname(__FILE__) . DS . "tipo_impuesto_enum.php");
// require_once(dirname(__FILE__) . DS . "tipo_impuesto_iva_enum.php");
class RetencionRideBase{
    protected $data = array();
    protected $xml;
    protected $numeroAutorizacion;
    protected $fechaAutorizacion;
    public function __construct($xmlfile){
        $this->xml = $this->getComprobanteAutorizadoXML($xmlfile);
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
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
    public function round_number($number, $decimals = 2)
    {
        return round( $number, $decimals, PHP_ROUND_HALF_UP);
    }
    public function money_format($number , $decimals = 2 , $dec_point = "." , $thousands_sep = "" )
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
    protected function getTipoImpuesto($tipo){
        switch ($tipo){
            case 1:
                return 'RENTA';
            case 2:
                return 'IVA';
            default:
                return '';
        }
    }
    protected function getDocumentoSustento($doc){
        switch ($doc){
            case '01':
                return 'FACTURA';
            case '02':
                return 'NOTA DE VENTA';
            case '03':
                return 'LIQ. COMPRA';
            default:
                return '';
        }
    }
}