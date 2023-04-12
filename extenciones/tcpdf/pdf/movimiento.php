<?php
require_once "../../../controladores/mefectivo.controlador.php";
require_once "../../../modelos/mefectivo.modelo.php";
require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";
require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";
require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";
require_once "../../../controladores/almacen.controlador.php";
require_once "../../../modelos/almacen.modelo.php";
class imprimirFactura{
public $codigo;
public $idAlmacen;
public function traerImpresionFactura(){
//TRAEMOS LA INFORMACIÓN DE LA VENTA
$itemVenta="CodMovimiento";
$valorVenta=$this->codigo;
$item2="CodAlmacen";
$valor2=$this->idAlmacen;
$item=null;
$valor=null;
$respuestaVenta=ControladorMefectivo::ctrMostrarMefectivo($item,$itemVenta, $valor,$valorVenta);
$almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item2, $valor2);
foreach($almacen as $key => $value){
$ruc=$value["ruc"];
$direccion= $value["DireccionAlmacen"];
$telefono= $value["telefono"];
$email= $value["email"];
$nombrealmacen=$value["NombreAlmacen"];
}
foreach ($respuestaVenta as $key => $value1) {
	$fecha=substr($value1["fechaMovimiento"],0,-8);
	$neto=number_format($value1["valorMovimiento"],2);
	$descripcion=$value1["descripcionMovimiento"];
}
//$fecha=substr($respuestaVenta["fechaMovimiento"],0,-8);
//$neto=number_format($respuestaVenta["valorMovimiento"],2);
//TRAEMOS LA INFORMACIÓN DEL CLIENTE
/*$itemCliente="id";
$valorCliente=$respuestaVenta["id_cliente"];
$respuestaCliente=ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);*/
//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
/*$itemVendedor="CodUsuario";
$valorVendedor=$respuestaVenta["id_vendedor"];
$respuestaVendedor=ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);*/
//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');
$medidas = array(79, 100); // Ajustar aqui segun los milimetros necesarios;
$pdf=new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//DETERMINAMOS MARGEN DEL DOCUMENTO
$pdf->SetMargins(0, 0, 0);
$pdf->SetLeftMargin(5.7);
//TERMINA MARGEN DEL DOCUMENTO
$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 8, '', 'false');
// ---------------------------------------------------------
$bloque1=<<<EOF
<table style="font-size:12px; text-align:left">
	<tr>
		<td style="width:180px; text-align:left">
			<div style="text-align:center">
				$nombrealmacen
				<br>
				MOVIMIENTO N. $valorVenta
				<br>
		        FECHA: $fecha
				<br>
			</div>
		</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
$bloque2 = <<<EOF
<table style="font-size:10px;">
	<tr>
		<td style="width:90px; text-align:center">
		DESCRIPCIÓN 
		</td>
		<td style="width:90px; text-align:center">
		VALOR
		</td>
	</tr>
	<tr>
		<td style="width:200px;">
			 ==========================
		</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
$bloque2 = <<<EOF
<table style="font-size:10px;">
	<tr>
		<td style="width:90px; text-align:center; font-size:10px;">
		$descripcion
		</td>
		<td style="width:90px; text-align:center">
		$ $neto
		</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
$bloque3 = <<<EOF
<table style="font-size:10px; text-align:right">
	<tr>
		<td style="width:200px;  text-align:left">
			 ==========================
		</td>
	</tr>
		<br>
		<br>
		<br>
	<tr>
		<td style="width:180px; text-align:left">
			<div style="text-align:center">
				-------------------------
				<br>
		        FIRMA
				<br>
			</div>
		</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
$pdf->Output('factura.pdf');
}
}
$factura=new imprimirFactura();
$factura->codigo=$_GET["codigo"];
$factura->idAlmacen=$_GET["idAlmacen"];
$factura->traerImpresionFactura();
?>