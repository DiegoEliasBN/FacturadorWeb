<?php
if (!defined("ACCESS")) {
	die("Error: You don't have permission to access here...");
}
require_once(dirname(__FILE__) . DS . "factura_ride_base.php");
class FacturaAguaGadmm extends FacturaRideBase{
    final protected function initialize(){
        $graphLabel = array();
        $graphSerie1 = array();
        foreach ($this->xml->infoAdicional->campoAdicional as $node)
        {
            $nombre = $node->attributes();
            $valor = (string)$node;
            switch ($nombre)
            {
                case "MEDIDOR":
                        $args = explode(";", $valor);
                        $this->data["Medidor"] = $this->GetOnlyValue($args[0]);
                        $this->data["LecturaAnterior"] = $this->GetOnlyValue($args[1]);
                        $this->data["LecturaActual"] = $this->GetOnlyValue($args[2]);
                        $this->data["Consumo"] = $this->GetOnlyValue($args[3])." (M3)";				
                        break;
                case "DATOS CUENTA":
                        $args = explode(";", $valor);
                        $this->data["Catastro"] = $this->GetOnlyValue($args[0]);
                        $this->data["Categoria"] = $this->GetOnlyValue($args[1]);
                        $this->data["Ubicacion"] = $this->GetOnlyValue($args[2]);				
                        break;
                case "NUMERO DE CUENTA":
                        $this->data["NumeroCuenta"] = $valor;
                        break;
                case "CLIENTE":
                        $this->data["Cliente"] = $valor;
                        break;
                case "DIRECCION":
                        $this->data["DireccionCliente"] = $valor;
                        break;
                case "FECHA DE VENCIMIENTO":
                        $this->data["FechaVencimiento"] = $valor;
                        break;
                case "MESES DEUDA":
                        $this->data["MesesDeuda"] = $valor;
                        break;
                case "DEUDA ANTERIOR":
                        $this->data["DeudaAnterior"] = $valor;
                        break;
                case "FACT. MES ACTUAL":
                        $this->data["TotalFacturaActual"] = $valor;
                        break;
                case "VALOR TOTAL":
                        $this->data["ValorTotalPagar"] = $valor;
// 				Tools.NumberToLetter c = new Tools.NumberToLetter();
// 				rpt.SetParameterValue("Son", c.ToLetter(m.Valor) + " " + this.m_Comprobante.InfoFactura.Moneda);
                        break;
                case "MES1(M3)":
                        $graphLabel[] = $this->GetMes(1) . "\n" . $valor . "m3";
                        $graphSerie1[] = (int)$valor;
                        break;
                case "MES2(M3)":
                        $graphLabel[] = $this->GetMes(2) . " " . $valor . "m3";
                        $graphSerie1[] = (int)$valor;
                        break;
                case "MES3(M3)":
                        $graphLabel[] = $this->GetMes(3) . " " . $valor . "m3";
                        $graphSerie1[] = (int)$valor;
                        break;
                case "MES4(M3)":
                        $graphLabel[] = $this->GetMes(4) . " " . $valor . "m3";
                        $graphSerie1[] = (int)$valor;
                        break;
                case "MES5(M3)":
                        $graphLabel[] = $this->GetMes(5) . " " . $valor . "m3";
                        $graphSerie1[] = (int)$valor;
                        break;
                default:
                        break;
            }
        }
        $this->data["HistorialConsumo"] = array("label"=>$graphLabel, "serie1"=>$graphSerie1);        
    }
    private function GetOnlyValue($message, $sep = ':')
    {
	return trim(substr($message, strripos($message, $sep) + 1));
    }
    private function  GetMes($mes)
    {
    // 	DateTime fecha = DateTime.Parse(this.m_Comprobante.InfoFactura.FechaEmision);
    // 	fecha = fecha.AddMonths(mes * -1);
            return $mes;// fecha.ToString("MMM yy");
    }
    final protected function getFormatHTML(){
        $formatoFactura =  '
<table width="100%" border="0" cellspacing="2">
  <tr>
    <td><table width="100%" border="0" cellspacing="5">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td><img src="'.PATH_PUBLIC .'assets/images/logoce.png" width="400" /></td>
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
        </table></td>
        <td  bgcolor="#F4F4F4"><table width="100%" border="0" cellspacing="0" cellpadding="5">
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
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr bgcolor="#9DC418">
        <td colspan="4" bgcolor="#9DC418"><font color="#fff"><strong>DATOS DEL CLIENTE</strong></font></td>
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
        <td width="15%" bgcolor="#F4F4F4">Fecha Vencimiento</td>
        <td width="20%">'.$this->data["FechaVencimiento"].'</td>
      </tr>
      <tr>
        <td width="15%" bgcolor="#F4F4F4">Cliente</td>
        <td width="50%">'.$this->data["Cliente"].'</td>
        <td width="15%" bgcolor="#F4F4F4">Nro. Cuenta</td>
        <td width="20%">'.$this->data["NumeroCuenta"].'</td>
      </tr>
      <tr>
        <td width="15%" bgcolor="#F4F4F4">Dirección</td>
        <td width="50%">'.$this->data["DireccionCliente"].'</td>
        <td width="15%" bgcolor="#F4F4F4">Categoría</td>
        <td width="20%">'.$this->data["Categoria"].'</td>
      </tr>
      <tr>
        <td width="15%" bgcolor="#F4F4F4">Catastro</td>
        <td width="50%">'.$this->data["Catastro"].'</td>
        <td width="15%" bgcolor="#F4F4F4">Ubicación</td>
        <td width="20%">'.$this->data["Ubicacion"].'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr bgcolor="#9DC418">
        <td colspan="8" bgcolor="#9DC418"><font color="#fff"><strong>DATOS DEL MEDIDOR</strong></font></td>
        </tr>
      <tr>
        <td width="15%" bgcolor="#F4F4F4">Número</td>
        <td width="10%" align="right">'.$this->data["Medidor"].'</td>
        <td width="15%" bgcolor="#F4F4F4">Lectura Anterior</td>
        <td width="10%" align="right">'.$this->data["LecturaAnterior"].'</td>
        <td width="15%" bgcolor="#F4F4F4">Lectura Actual</td>
        <td width="10%" align="right">'.$this->data["LecturaActual"].'</td>
        <td width="15%" bgcolor="#F4F4F4">Consumo</td>
        <td width="10%" align="right">'.$this->data["Consumo"].'</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr align="left" bgcolor="#9DC418">
        <td colspan="4"><font color="#fff"><strong>FACTURACIÓN</strong></font></td>
      </tr>
      <tr bgcolor="#E3E3E3">
        <td width="55%" align="left"><strong>Servicios</strong></td>
        <td width="15%" align="right"><strong>Precio</strong></td>
        <td width="15%" align="right"><strong>Descuento</strong></td>
        <td width="15%" align="right"><strong>Total</strong></td>
      </tr>    ';
foreach ($this->xml->detalles->detalle as $detalle){
$formatoFactura = $formatoFactura . '        		
      <tr>
        <td width="55%" align="left">'.(string)$detalle->descripcion.'</td>
        <td width="15%" align="right" bgcolor="#F4F4F4">$ '.Util::money_format((float)$detalle->precioUnitario).'</td>
        <td width="15%" align="right">$ '.Util::money_format((float)$detalle->descuento).'</td>
        <td width="15%" align="right" bgcolor="#F4F4F4">$ '.Util::money_format((float)$detalle->precioTotalSinImpuesto).'</td>
      </tr>'; 	
}
$formatoFactura = $formatoFactura . '
    </table></td>
  </tr>
  <tr>
    <td><table widtd="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td width="55%"><img src="'.$this->getGraphBarUrl().'" /></td>
        <td width="45%"><table width="100%" cellspacing="0" cellpadding="3" >
          <tr>
            <td width="66%" bgcolor="#F4F4F4">SUBTOTAL 12%</td>
            <td width="34%" align="right">'.  Util::money_format($this->subTotal12).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">SUBTOTAL 0%</td>
            <td width="34%" align="right">'.  Util::money_format($this->subTotal0).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">SUBTOTAL NO OBJETO DE IVA</td>
            <td width="34%" align="right">'.  Util::money_format($this->subTotalNoSujetoIva).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">SUBTOTAL EXENTO DE IVA</td>
            <td width="34%" align="right">'.  Util::money_format($this->subTotalExentoIVA).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">SUBTOTAL SIN IMPUESTOS</td>
            <td width="34%" align="right">'.  Util::money_format((float)$this->xml->infoFactura->totalSinImpuestos).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">TOTAL DESCUENTO</td>
            <td width="34%" align="right">'.Util::money_format((float)$this->xml->infoFactura->totalDescuento).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">ICE</td>
            <td width="34%" align="right">'.  Util::money_format($this->totalIce).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">IVA 12%</td>
            <td width="34%" align="right">'.  Util::money_format($this->totalIva12).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">IRBPNR</td>
            <td width="34%" align="right">'.  Util::money_format($this->totalIRBPNR).'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">PROPINA</td>
            <td width="34%" align="right">'.Util::money_format((float)$this->xml->infoFactura->propina).'</td>
          </tr>
          <tr bgcolor="#E3E3E3">
            <td width="66%"><strong>FACTURACIÓN MES ACTUAL</strong></td>
            <td width="34%" align="right">'.Util::money_format((float)$this->xml->infoFactura->importeTotal).'</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="55%"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr bgcolor="#9DC418">
            <td bgcolor="#9DC418"><font color="#fff"><strong>ESTIMADO CLIENTE</strong></font></td>
          </tr>
          <tr>
            <td bgcolor="#F4F4F4"></td>
          </tr>          
        </table></td>
        <td width="45%"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr bgcolor="#9DC418">
            <td colspan="2" bgcolor="#9DC418"><font color="#fff"><strong>ESTADO DE CUENTA</strong></font></td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">NÚMERO DE FACTURAS VENCIDAS</td>
            <td width="34%" align="right">'.$this->data["MesesDeuda"].'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">DEUDA ANTERIOR</td>
            <td width="34%" align="right">$ '.$this->data["DeudaAnterior"].'</td>
          </tr>
          <tr>
            <td width="66%" bgcolor="#F4F4F4">( + ) FACTURACIÓN MES ACTUAL</td>
            <td width="34%" align="right">$ '.$this->data["TotalFacturaActual"].'</td>
          </tr>
          <tr bgcolor="#E3E3E3">
            <td width="66%"><strong>( = ) TOTAL A PAGAR</strong></td>
            <td width="34%" align="right"><strong>$ '.$this->data["ValorTotalPagar"].'</strong></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>		
';
        return $formatoFactura;
    }
    private function getGraphBarUrl(){
        $graphic = new Graph(400, 200);
        $graphic->img->SetMargin(50,40,30,30);
        $graphic->SetScale("textlin");
        $graphic->SetShadow();
        $graphic->SetFrame(false);
        $graphic->title->Set("Historial de Consumos");
        $graphic->yaxis->SetTitle("Consumo (m3)","middle");
        $graphic->yaxis->scale->SetGrace(10);
        $graphic->xaxis->SetTickLabels($this->data["HistorialConsumo"]["label"]);
        $graphic->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
        $graphic->Add($this->getGraphBarSerie());
        $graphic->Stroke($this->getGraphBarPath());
        return PATH_PUBLIC . 'files/' . $this->xml->infoTributaria->claveAcceso.".jpg";
    }
    private function getGraphBarPath(){        
        return $this->deleteGraphBarPath();
    }
    private function deleteGraphBarPath(){        
        $graphpath = dirname(PATH_APP) . DS . "public".DS."files" . DS . $this->xml->infoTributaria->claveAcceso.".jpg";
        if(file_exists( $graphpath )){
            unlink($graphpath);
        }
        return $graphpath;
    }
    private function getGraphBarSerie(){
        $serie = $this->data["HistorialConsumo"]["serie1"];
        $bar = new BarPlot($serie);
        $bar->SetFillColor("#9dc418");
        $bar->SetShadow();        
        $bar->value->Show();
        return $bar;
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
        $pdf->SetXY(301, 191);
        $pdf->write1DBarcode($this->xml->infoTributaria->claveAcceso, 'C128', '', '', '', 43, 0.8, $style, 'N');
        $pdf->lastPage();// reset pointer to the last page
        $pdf->Output('reporte.pdf', 'I');//Close and output PDF document
        $this->deleteGraphBarPath();
    }
}