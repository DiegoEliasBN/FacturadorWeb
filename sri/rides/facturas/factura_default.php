<?php
if (!defined("ACCESS")) {
    die("Error: You don't have permission to access here...");
}
require_once(dirname(__FILE__) . DS . "factura_ride_base.php");
class FacturaDefault extends FacturaRideBase{
    final protected function initialize(){
    }
    final protected function getFormatHTML(){
        $path_logo = '/vistas/img/plantilla/LogoRide';
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
                                        <td>Dirección Sucursal: '.$this->xml->infoFactura->dirEstablecimiento.'</td>
                                    </tr>
                                    <tr>
                                        <td>Contribuyente Especial Nro. '.$this->xml->infoFactura->contribuyenteEspecial.'</td>
                                    </tr>
                                    <tr>
                                        <td>OBLIGADO A LLEVAR CONTABILIDAD: '.$this->xml->infoFactura->obligadoContabilidad.'</td>
                                    </tr>




                                </table>
                            </td>
                            <td  bgcolor="#F4F4F4">
                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <td><strong>R.U.C.: '.$this->xml->infoTributaria->ruc.'</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>FACTURA Nro. '.$this->xml->infoTributaria->estab.'-'.$this->xml->infoTributaria->ptoEmi.'-'.$this->xml->infoTributaria->secuencial.'</strong></td>
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
                                        <td>&nbsp;<br>&nbsp;</td>
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
                            <td colspan="4" bgcolor="#3b3b3b"><font color="#fff"><strong>DATOS DEL CLIENTE</strong></font></td>
                        </tr>
                        <tr>
                            <td width="15%" bgcolor="#F4F4F4">RUC/CI/PASS</td>
                            <td width="50%">'.$this->xml->infoFactura->identificacionComprador.'</td>
                            <td width="15%" bgcolor="#F4F4F4">Fecha Emisión</td>
                            <td width="20%">'.$this->xml->infoFactura->fechaEmision.'</td>
                        </tr>
                        <tr>
                            <td width="15%" bgcolor="#F4F4F4">Razón Social</td>
                            <td width="50%">'.$this->xml->infoFactura->razonSocialComprador.'</td>
                            <td width="15%" bgcolor="#F4F4F4">Guía remisión</td>
                            <td width="20%"></td>
                        </tr>      
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                        <tr align="left" bgcolor="#3b3b3b">
                            <td colspan="4"><font color="#fff"><strong>FACTURACIÓN</strong></font></td>
                        </tr>
                        <tr bgcolor="#E3E3E3">
                            <td width="10%" align="left"><strong>Código</strong></td>
                            <td width="55%" align="left"><strong>Detalle</strong></td>
                            <td width="6%" align="right"><strong>Cant.</strong></td>
                            <td width="10%" align="right"><strong>Precio</strong></td>
                            <td width="9%" align="right"><strong>Descto</strong></td>
                            <td width="10%" align="right"><strong>Total</strong></td>
                        </tr>';
                        foreach ($this->xml->detalles->detalle as $detalle){
                            $formatoFactura = $formatoFactura . '        		
                        <tr>
                            <td align="left">' . (string)$detalle->codigoPrincipal . '</td>
                            <td align="left">' . (string)$detalle->descripcion. '</td>
                            <td align="right">' . (string)$detalle->cantidad . '</td>
                            <td align="right" bgcolor="#F4F4F4">$ '.$this->money_format((float)$detalle->precioUnitario, 4).'</td>
                            <td align="right">$ '.$this->money_format((float)$detalle->descuento).'</td>
                            <td align="right" bgcolor="#F4F4F4">$ '.$this->money_format((float)$detalle->precioTotalSinImpuesto).'</td>
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
                                        <td colspan="2" bgcolor="#3b3b3b"><font color="#fff"><strong>DATOS ADICIONALES</strong></font></td>
                                    </tr>';
                                            foreach ($this->xml->infoAdicional->campoAdicional as $node) {
                                                $nombre = $node->attributes();
                                                $valor = (string)$node;
                                                $formatoFactura = $formatoFactura . '
                                                <tr>
                                                    <td width="66%" bgcolor="#F4F4F4">'.$nombre.'</td>
                                                    <td width="34%" align="right">'.$valor.'</td>
                                                </tr>';
                                            }
                                            $formatoFactura = $formatoFactura . '
                                </table>
                                <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                    <tr bgcolor="#FF3C33">
                                        <td colspan="2" bgcolor="#3b3b3b"><font color="#fff"><strong>FORMAS DE PAGO</strong></font></td>
                                    </tr>';
                                            foreach ($this->xml->infoFactura->pagos->pago as $node) {
                                                $nombre = $this->getFormaPago((string)$node->formaPago);
                                                $valor = $this->money_format((float)$node->total);
                                                $formatoFactura = $formatoFactura . '
                                                <tr>
                                                    <td width="66%" bgcolor="#F4F4F4">'.$nombre.'</td>
                                                    <td width="34%" align="right">'.$valor.'</td>
                                                </tr>';
                                            }
                                            $formatoFactura = $formatoFactura . '
                                </table>
                            </td>
                            <td width="45%">
                                <table width="100%" border="0" cellspacing="2" cellpadding="2" >
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">SUBTOTAL 12%</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->subTotal12).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">SUBTOTAL 0%</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->subTotal0).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">SUBTOTAL NO OBJETO DE IVA</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->subTotalNoSujetoIva).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">SUBTOTAL EXENTO DE IVA</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->subTotalExentoIVA).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">SUBTOTAL SIN IMPUESTOS</td>
                                        <td width="34%" align="right">'.  $this->money_format((float)$this->xml->infoFactura->totalSinImpuestos).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">TOTAL DESCUENTO</td>
                                        <td width="34%" align="right">'.$this->money_format((float)$this->xml->infoFactura->totalDescuento).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">ICE</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->totalIce).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">IVA 12%</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->totalIva12).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">IRBPNR</td>
                                        <td width="34%" align="right">'.  $this->money_format($this->totalIRBPNR).'</td>
                                    </tr>
                                    <tr>
                                        <td width="66%" bgcolor="#F4F4F4">PROPINA</td>
                                        <td width="34%" align="right">'.$this->money_format((float)$this->xml->infoFactura->propina).'</td>
                                    </tr>
                                    <tr bgcolor="#E3E3E3">
                                        <td width="66%"><strong>TOTAL</strong></td>
                                        <td width="34%" align="right"><strong>'.$this->money_format((float)$this->xml->infoFactura->importeTotal).'</strong></td>
                                    </tr>
                                </table>
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

/* ETIQUETA CUANDO ES REGIMEN RIMPE

									<tr>
                                        <td>'.$this->xml->infoTributaria->contribuyenteRimpe.'</td>
                                    </tr>

*/

}