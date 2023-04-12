<?php
require_once "../../../controladores/retencion.controlador.php";
require_once "../../../modelos/retencion.modelo.php";
require_once "../../../controladores/almacen.controlador.php";
require_once "../../../modelos/almacen.modelo.php";
class imprimirRetencion{
public $codigo;
public $idAlmacen;
public function traerImpresionRetencion(){
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemRetencion="ID";
$valorRetencion=$this->codigo;
$item2="CodAlmacen";
$valor2=$this->idAlmacen;
$item="id_retencion";
$valor=$this->codigo;
/*
$respuestaVenta=ControladorRetenciones::ctrMostrarRetenciones($itemRetencion,$item2, $valorRetencion,$valor2, $item1);
*/
$respuestaVenta = ControladorRetenciones::ctrMostrarVistaRetenciones('id',"codigo_almacen", $this->codigo,$this->idAlmacen);
$nombre_proveedor = $respuestaVenta['nombre_proveedor'];
$identificacion_proveedor = $respuestaVenta['identificacion_proveedor'];
$telefono_proveedor = $respuestaVenta['telefono_proveedor'];
$doc_sustento = $respuestaVenta['doc_sustento'];
$numero_comprobante = $respuestaVenta['numero_comprobante'];
$email_proveedor = $respuestaVenta['email_proveedor'];
$respuestaDetalleR=ControladorRetenciones::ctrMostrarDetalleRetenciones($item, $valor);
$almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item2, $valor2);
foreach($almacen as $key => $value){
$ruc=$value["ruc"];
$direccion= $value["DireccionAlmacen"];
$telefono= $value["telefono"];
$email= $value["email"];
$nombrealmacen=$value["NombreAlmacen"];
}
$fecha=substr($respuestaVenta["fecha"],0,-8);
//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');
$medidas = array(72, 200); // Ajustar aqui segun los milimetros necesarios;
$pdf=new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
//DETERMINAMOS MARGEN DEL DOCUMENTO
$pdf->SetMargins(0, 0, 0);
$pdf->SetLeftMargin(4);
//TERMINA MARGEN DEL DOCUMENTO
$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 8, '', '');
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
	'stretchtext' => 2
);
// ---------------------------------------------------------
$bloque1=<<<EOF
<tr>
	<td style="width:200px; text-align:center"><img src="images/cabecera.png"></td>
</tr>
<table style="width:180px; text-align:center; font-size:09px">
	<tr>	
		<td> 
		    <strong>
		JORGE BARROS VALLEJO
		    <br>
		 $ruc
		    <br>
		 $direccion
		    <br>
		    </strong>
		</td>
	</tr>
</table>
<tr>
	    <td style="width:180px; text-align:center; font-size:10px"> 
	        <strong>
	        DATOS DEL PROVEEDOR
	        </strong>
	    </td>
	</tr>
	<tr>
		<td style="width:160px; text-align:left">
			<div style="text-align:left;">
				<br>
				PROVEEDOR: $nombre_proveedor
				<br>
				C.I./RUC.: $identificacion_proveedor
				<br>
				TELÉFONO: $telefono_proveedor
				<br>
				TIPO COMPROBANTE: $doc_sustento
				<br>
				NUMERO COMPROBANTE: $numero_comprobante
				<br>
			</div>
		</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
$bloque2 = <<<EOF
<table>
	<tr>
	********************************************
	<br>
<td style="width:42px; text-align:left">
		TIPO
		</td>
		<td style="width:36px; text-align:left">
		CANT
		</td>
		<td style="width:45px; text-align:left">
		%PORC
		</td>
		<td style="width:39px; text-align:left">
		BASE IMP
		</td>
	</tr>
	********************************************
<br>
</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
$bloqueDetalleRetencion = '<table style="font-size:9px;">';
foreach ($respuestaDetalleR as $key => $item) {
	if ($item["Tipo"]=="I") {
		$Tipo="IVA";
	}elseif ($item["Tipo"]=="R") {
		$Tipo="RENTA";
	}
$precioTotal = number_format($item["Total"], 2);
$bloqueDetalleRetencion .='
	<tr>
	<br>
		<td style="width:45px; text-align:left;">'.
		$Tipo .'
		</td>
		<td style="width:30px; text-align:left">
		'.$item[Codigo] .'
		</td>
		<td style="width:45px; text-align:center">
		% '. $item[TasaRetencion].'
		</td>
		<td style="width:60px; text-align:left">
		$ '.$item[BaseImponible].'
		</td>
	</tr>';
}
$bloqueDetalleRetencion .='</table>';
$pdf->writeHTML($bloqueDetalleRetencion, false, false, false, false, '');
$pieRetencion = <<<EOF
<table style="text-align:right">
		<br>
		<br>
	<tr>
		<td style="width:75px; font-size:12px;">
		<strong>
			 TOTAL: 
			 </strong>
		</td>
		<td style="width:90px; font-size:12px;">
		<strong>
			$ $precioTotal
			</strong>
		</td>
	</tr>
	<tr>
		********************************************
	</tr>	
	<br>
	<tr> 
		<td style="width:180px;font-size:09px; text-align:center">
			<br>
			Su retencion es electronica, este documente es una constancia de la misma. <br> La retencion sera enviada a $email_proveedor
		</td>
	</tr>
********************************************
</table>
<br> <br>
EOF;
$pdf->writeHTML($pieRetencion, false, false, false, false, '');
//SALIDA DEL ARCHIVO 
$pdf->Output('factura.pdf');
}
}
$factura=new imprimirRetencion();
$factura->codigo=$_GET["codigo"];
$factura->idAlmacen=$_GET["idAlmacen"];
$factura->traerImpresionRetencion();
?>