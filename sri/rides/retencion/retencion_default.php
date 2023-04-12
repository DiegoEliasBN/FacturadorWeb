<?php
if (!defined("ACCESS")) {
    die("Error: You don't have permission to access here...");
}
require_once(dirname(__FILE__) . DS . "retencion_ride_base.php");
class RetencionDefault extends RetencionRideBase{
    final protected function initialize(){
    }
    final protected function getFormatHTML(){
        $path_logo = 'https://facturador.systsolutions-ec.com/vistas/img/plantilla/LogoRide';
        switch ($this->xml->infoTributaria->estab){
            case '999':
                $path_logo .= '-002.png'; break;
            default:
                $path_logo .= ($this->xml->infoTributaria->ruc.'.png'); break;
        }
        $formatoFactura =  '
        <table width="100%" border="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="3">
                        <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                    <tr>
                                        <td><img src="'.$path_logo.'" width="400" /></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><strong>'.$this->xml->infoTributaria->razonSocial.'</strong></td>
                                    </tr>
                                    <tr>
                                        <td>'.$this->xml->infoTributaria->nombreComercial.'</td>
                                    </tr>
                                    <tr>
                                        <td>Dirección Matríz: '.$this->xml->infoTributaria->dirMatriz.'</td>
                                    </tr>
                                    <tr>
                                        <td>Dirección Sucursal: '.$this->xml->infoCompRetencion->dirEstablecimiento.'</td>
                                    </tr>
                                    <tr>
                                        <td>Contribuyente Especial Nro. '.$this->xml->infoCompRetencion->contribuyenteEspecial.'</td>
                                    </tr>
                                    <tr>
                                        <td>OBLIGADO A LLEVAR CONTABILIDAD: '.$this->xml->infoCompRetencion->obligadoContabilidad.'</td>
                                    </tr>
                                </table>
                            </td>
                            <td  bgcolor="#F4F4F4">
                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <td><strong>R.U.C.: '.$this->xml->infoTributaria->ruc.'</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>COMPROBANTE DE RETENCION Nro. '.$this->xml->infoTributaria->estab.'-'.$this->xml->infoTributaria->ptoEmi.'-'.$this->xml->infoTributaria->secuencial.'</strong></td>
                                    </tr>          
                                    <tr>
                                        <td>NÚMERO DE AUTORIZACIÓN</td>
                                    </tr>
                                    <tr>
                                        <td>'.$this->numeroAutorizacion.'</td>
                                    </tr>
                                    <tr>
                                        <td>Fecha y Hora de Autorización</td>
                                    </tr>
                                    <tr>
                                        <td>'.$this->fechaAutorizacion.'</td>
                                    </tr>
                                    <tr>
                                        <td>AMBIENTE: '.$this->getAmbiente().'</td>
                                    </tr>
                                    <tr>
                                        <td>EMISION: '.$this->getEmision().'</td>
                                    </tr>
                                    <tr>
                                        <td>CLAVE DE ACCESO:</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;<br>&nbsp;<br></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr bgcolor="#FF3C33">
                            <td colspan="4" bgcolor="#FF3C33"><font color="#fff"><strong>DATOS DEL SUJETO RETENIDO</strong></font></td>
                        </tr>
                        <tr>
                            <td width="15%" bgcolor="#F4F4F4">RUC/CI/PASS</td>
                            <td width="50%">'.$this->xml->infoCompRetencion->identificacionSujetoRetenido.'</td>
                            <td width="15%" bgcolor="#F4F4F4">Fecha Emisión</td>
                            <td width="20%">'.$this->xml->infoCompRetencion->fechaEmision.'</td>
                        </tr>
                        <tr>
                            <td width="15%" bgcolor="#F4F4F4">Razón Social</td>
                            <td width="50%">'.$this->xml->infoCompRetencion->razonSocialSujetoRetenido.'</td>
                            <td width="15%" bgcolor="#F4F4F4"></td>
                            <td width="20%"></td>
                        </tr>      
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr align="left" bgcolor="#FF3C33">
                            <td colspan="4"><font color="#fff"><strong>DETALLE RETENCIÓN</strong></font></td>
                        </tr>
                        <tr bgcolor="#E3E3E3">
                            <td width="15%" align="left"><strong>Comprobante</strong></td>
                            <td width="15%" align="left"><strong>Número</strong></td>
                            <td width="10%" align="center"><strong>Fecha Emisión</strong></td>
                            <td width="10%" align="center"><strong>Ejercicio Fiscal</strong></td>
                            <td width="20%" align="right"><strong>Base Imponible para la retención</strong></td>
                            <td width="10%" align="center"><strong>Impuesto</strong></td>
                            <td width="10%" align="right"><strong>Porcentaje Retención</strong></td>
                            <td width="10%" align="right"><strong>Valor Retenido</strong></td>
                        </tr>';
                        foreach ($this->xml->impuestos->impuesto as $detalle){
                            $formatoFactura = $formatoFactura . '        		
                        <tr>
                            <td align="left">' . $this->getDocumentoSustento((string)$detalle->codDocSustento) . '</td>
                            <td align="left">' . (string)$detalle->numDocSustento. '</td>
                            <td align="center">' . (string)$detalle->fechaEmisionDocSustento. '</td>
                            <td align="center">' . (string)$this->xml->infoCompRetencion->periodoFiscal. '</td>
                            <td align="right">$ ' . $this->money_format((float)$detalle->baseImponible, 2) . '</td>
                            <td align="center" bgcolor="#F4F4F4">'.$this->getTipoImpuesto((string)$detalle->codigo).'</td>
                            <td align="right">'.$this->money_format((float)$detalle->porcentajeRetener).'</td>
                            <td align="right" bgcolor="#F4F4F4">$ '.$this->money_format((float)$detalle->valorRetenido).'</td>
                        </tr>';
                        }
                        $formatoFactura = $formatoFactura . '
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table widtd="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="55%">
                                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                    <tr bgcolor="#FF3C33">
                                        <td colspan="2" bgcolor="#FF3C33"><font color="#fff"><strong>DATOS ADICIONALES</strong></font></td>                                        
                                    </tr>';
                                            foreach ($this->xml->infoAdicional->campoAdicional as $node) {
                                                $nombre = $node->attributes();
                                                $valor = (string)$node;
                                                $formatoFactura = $formatoFactura . '
                                                <tr>
                                                    <td bgcolor="#F4F4F4">'.$nombre.'</td>
                                                    <td align="right">'.$valor.'</td>
                                                </tr>';
                                            }
                                            $formatoFactura = $formatoFactura . '
                                </table>
                            </td>
                            <td width="45%">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>            
        </table>';
        return $formatoFactura;
    }
    public function showPDF(){
        $pdf = new Tcpdf('P', 'px', 'letter', true, 'UTF-8', false);
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set font
        $pdf->SetFont('helvetica', '', 8, '', 'false');
        $pdf->AddPage();
        // output the HTML content
        $pdf->writeHTML($this->getFormatHTML(), 1, 0, 1, 0, '');
        // define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $pdf->SetXY(301, 188);
        $pdf->write1DBarcode($this->xml->infoTributaria->claveAcceso, 'C128', '', '', '', 43, 0.8, $style, 'N');
        $pdf->lastPage();// reset pointer to the last page
        $pdf->Output(sprintf('%s.pdf', $this->xml->infoTributaria->claveAcceso), 'I');//Close and output PDF document
    }
}