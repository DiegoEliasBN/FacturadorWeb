<?php
if (!defined("ACCESS")) {
    die("Error: You don't have permission to access here...");
}
require_once(dirname(__FILE__) . DS . "guia_ride_base.php");
class GuiaDefault extends GuiaRideBase{
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
        $formatoFactura = '
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
                                        <td><strong>GUÍA DE REMISIÓN Nro. '.$this->xml->infoTributaria->estab.'-'.$this->xml->infoTributaria->ptoEmi.'-'.$this->xml->infoTributaria->secuencial.'</strong></td>
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
						<tr align="left" bgcolor="#FF3C33">
							<td colspan="4"><font color="#fff"><strong>INFORMACIÓN DEL TRANSPORTISTA</strong></font></td>
						</tr>
                        <tr>
                            <td width="35%" bgcolor="#F4F4F4">Identificación (Transportista):</td>
                            <td colspan="3">'.$this->xml->infoGuiaRemision->rucTransportista.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Razón Social / Nombres y Apellidos:</td>
                            <td colspan="3">'.$this->xml->infoGuiaRemision->razonSocialTransportista.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Placa:</td>
                            <td colspan="3">'.$this->xml->infoGuiaRemision->placa.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Punto de Partida:</td>
                            <td colspan="3">'.$this->xml->infoGuiaRemision->dirPartida.'</td>                            
                        </tr>
                        <tr>
                            <td width="35%" bgcolor="#F4F4F4">Fecha Inicio Transporte:</td>
                            <td width="15%">'.$this->xml->infoGuiaRemision->fechaIniTransporte.'</td>
                            <td width="35%" bgcolor="#F4F4F4">Fecha Fin Transporte:</td>
                            <td width="15%">'.$this->xml->infoGuiaRemision->fechaFinTransporte.'</td>
                        </tr>      
                    </table>
                </td>
            </tr>';
			foreach ($this->xml->destinatarios->destinatario as $destinatario){
			$formatoFactura = $formatoFactura . '
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">                        
						<tr align="left" bgcolor="#FF3C33">
							<td colspan="4"><font color="#fff"><strong>INFORMACIÓN DEL DESTINATARIO</strong></font></td>
						</tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Comprobante de Venta:</td>
                            <td width="15%">'.$destinatario->numDocSustento.'</td>
                            <td width="35%" bgcolor="#F4F4F4">Fecha de Emisión:</td>
                            <td width="15%">'.$destinatario->fechaEmisionDocSustento.'</td>
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Número de Autorización:</td>
                            <td colspan="3">'.$destinatario->numAutDocSustento.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Motivo Traslado:</td>
                            <td colspan="3">'.$destinatario->motivoTraslado.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Destino (Punto de llegada):</td>
                            <td colspan="3">'.$destinatario->dirDestinatario.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Identificación:</td>
                            <td colspan="3">'.$destinatario->identificacionDestinatario.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Razón Social / Nombres y Apellidos:</td>
                            <td colspan="3">'.$destinatario->razonSocialDestinatario.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Documento Aduanero:</td>
                            <td colspan="3">'.$destinatario->docAduaneroUnico.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Código Establecimiento Destino:</td>
                            <td colspan="3">'.$destinatario->codEstabDestino.'</td>                            
                        </tr>
						<tr>
                            <td width="35%" bgcolor="#F4F4F4">Ruta:</td>
                            <td colspan="3">'.$destinatario->ruta.'</td>                            
                        </tr>
                        <tr>
							<td colspan="4">
								<table width="100%" border="0" cellspacing="2" cellpadding="2">
									<tr align="left" bgcolor="#FF3C33">
										<td colspan="4"><font color="#fff"><strong>DETALLE DE PRODUCTOS</strong></font></td>
									</tr>
									<tr bgcolor="#E3E3E3">
										<td width="10%" align="center"><strong>Cantidad</strong></td>
										<td width="70%" align="left"><strong>Descripción</strong></td>
										<td width="10%" align="center"><strong>Codigo Principal</strong></td>
										<td width="10%" align="center"><strong>Codigo Auxiliar</strong></td>										
									</tr>';
									foreach ($destinatario->detalles->detalle as $detalle){
										$formatoFactura = $formatoFactura . '        		
									<tr>										
										<td align="center">' . (string)$detalle->cantidad. '</td>
										<td align="left">' . (string)$detalle->descripcion. '</td>
										<td align="center">' . (string)$detalle->codigoInterno. '</td>
										<td align="center">' . (string)$detalle->codigoAdicional. '</td>
									</tr>';
									}
									$formatoFactura = $formatoFactura . '
								</table>
							</td>
						</tr>
                    </table>
                </td>
            </tr>
        ';
            }
            $formatoFactura = $formatoFactura . '
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