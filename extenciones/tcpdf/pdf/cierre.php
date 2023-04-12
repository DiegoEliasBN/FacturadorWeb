<?php
require_once "../../../controladores/ccaja.controlador.php";
require_once "../../../modelos/ccaja.modelo.php";
require_once "../../../controladores/acaja.controlador.php";
require_once "../../../modelos/acaja.modelo.php";
require_once "../../../controladores/uturno.controlador.php";
require_once "../../../modelos/uturno.modelo.php";
require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";
require_once "../../../controladores/almacen.controlador.php";
require_once "../../../modelos/almacen.modelo.php";
class imprimirCierre{
public $codigo;
public $idAlmacen;
public function traerImpresionCierre(){
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemVenta="CodCierre";
$valorVenta=$this->codigo;
$item2=null;
$valor2=null;
$item3="CodAlmacen";
$valor3=$this->idAlmacen;
$respuestaVenta=ControladorCCaja::ctrMostrarCCaja($item2,$itemVenta,$valor2,$valorVenta);
$respuestadetalle=ControladorCCaja::ctrMostrarCCajaDetalle($item2,$itemVenta,$valor2,$valorVenta);
//var_dump($respuestadetalle);
$almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item3, $valor3);
foreach($almacen as $key => $value){
$ruc=$value["ruc"];
$direccion= $value["DireccionAlmacen"];
$telefono= $value["telefono"];
$email= $value["email"];
}
$fecha=substr($respuestaVenta[0]["fecha"],0,-8);
$neto=number_format($respuestaVenta[0]["valorcierre"],2);
$totalfp=number_format($respuestaVenta[0]["totalFacturaPagadas"],2);
$totalfc=number_format($respuestaVenta[0]["totalFacturaFiada"],2);
$totaltc=number_format($respuestaVenta[0]["totalFacturaTc"],2);
$totaltd=number_format($respuestaVenta[0]["totalFacturaTd"],2);
$totalm=number_format($respuestaVenta[0]["totalMovimientos"],2);
$totalConsolidado=number_format($respuestaVenta[0]["totalConsolidado"],2);
$item4="CodApertura";
$valor4=$respuestaVenta[0]["CodApertura"];
$respuestaapertura=ControladorACaja::ctrMostrarACaja($item2,$item4, $valor2,$valor4);
$nombreapertura=$respuestaapertura[0]["nombre"].'-'.$respuestaapertura[0]["descripcion"];
//TRAEMOS LA INFORMACIÓN DEL CLIENTE
//$itemCliente="id";
//$valorCliente=$respuestaVenta["id_cliente"];
//$respuestaCliente=ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
//$itemVendedor="CodUsuario";
//$valorVendedor=$respuestaVenta["id_vendedor"];
//$respuestaVendedor=ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);
//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');
$pdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->startPageGroup();
$pdf->AddPage();
// ---------------------------------------------------------
$bloque1=<<<EOF
	<table>
		<tr>
			<td style="width:150px"><img src="images/favicon.png"></td>
			<td style="background-color:white; width:140px">
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					RUC: $ruc
					<br>
					Dirección: $direccion
				</div>
			</td>
			<td style="background-color:white; width:140px">
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					Teléfono: $telefono
					<br>
					$email
				</div>
			</td>
			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>CIERRE N.<br>$valorVenta</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
$bloque2=<<<EOF
	<table>
		<tr>
			<td style="width:540px"><img src="images/back.jpg"></td>
		</tr>
	</table>
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:390px">
				Nombre Apertura: $nombreapertura
			</td>
			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
				Fecha: $fecha
			</td>
		</tr>
		<tr>
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
// ---------------------------------------------------------
$bloque3=<<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:180px; text-align:center">Tipo Documento</td>
		<td style="border: 1px solid #666; background-color:white; width:180px; text-align:center">Descripcion/Cliente</td>
		<td style="border: 1px solid #666; background-color:white; width:180px; text-align:center">Cantidad</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
foreach ($respuestadetalle as $key => $item) {
$bloque4 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:center">
				$item[tipodocumento]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:center">
				$item[descripcion_cliente]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:center">
				$item[valorcadauno]
			</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
// ---------------------------------------------------------
$bloque5 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total Facturas Pagadas:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $totalfp
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total Facturas Fiadas:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $totalfc
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total Facturas Pagadas con tarjeta de credito:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $totaltc
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total Facturas Pagadas con tarjeta de debito:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $totaltd
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total movimientos:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $totalm
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total Cierre:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $neto
			</td>
		</tr>
		<tr>
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Total consolidado de las facturas:
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $totalConsolidado
			</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque5, false, false, false, false,'');
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
$pdf->Output('cierre.pdf');
}
}
$factura=new imprimirCierre();
$factura->codigo=$_GET["codigo"];
$factura->idAlmacen=$_GET["idAlmacen"];
$factura->traerImpresionCierre();
?>