<?php
/*if (!defined("ACCESS")) {
	die("Error: You don't have permission to access here...");
}
*/
require_once(dirname(__FILE__) . DS . "libs" . DS . "tcpdf" . DS . "tcpdf_import.php");
class Ride {
    public function showPDF($xmlfile){
        $claveAcceso = $xmlfile;
        $xmlfile = PATH_AUTORIZADOS . DS . $xmlfile . '.xml';
        if(file_exists( $xmlfile )){
            $tipo_documento = substr($claveAcceso, 8, 2);
            switch ($tipo_documento){
                case '01': // Facturas
                    require_once(dirname(__FILE__) . DS . 'rides' . DS . 'facturas' . DS . 'factura_default.php');
                    $pdf = new FacturaDefault($xmlfile);
                    $pdf->showPDF();
                    break;
                case '06': // Guias
                    require_once(dirname(__FILE__) . DS . 'rides' . DS . 'guia' . DS . 'guia_default.php');
                    $pdf = new GuiaDefault($xmlfile);
                    $pdf->showPDF();
                    break;
                case '07': // Retenciones
                    require_once(dirname(__FILE__) . DS . 'rides' . DS . 'retencion' . DS . 'retencion_default.php');
                    $pdf = new RetencionDefault($xmlfile);
                    $pdf->showPDF();
                    break;
            }
        }else{
            echo 'No se ha podido localizar comprobante';
        }
    }
    public function downloadXML($xmlfile){
        $filename = $xmlfile . ".xml";
        $xmlfile = PATH_AUTORIZADOS . DS . $xmlfile . '.xml';
        if(file_exists( $xmlfile )){
            header("Content-type: application/octet-stream");
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=\"$filename\"\n");
            readfile($xmlfile);
        }else{
            die("El archivo no existe.");
        }
    }    
}