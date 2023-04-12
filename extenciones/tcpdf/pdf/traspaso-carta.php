<?php
require_once "../../../controladores/traspasos.controlador.php";
require_once "../../../modelos/traspasos.modelo.php";
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
$itemVenta="CodTraspaso";
$valorVenta=$this->codigo;
$item2="CodAlmacen";
$valor2=$this->idAlmacen;
$respuestaVenta=Controladortraspasos::ctrMostrarTraspasos($itemVenta,$item2, $valorVenta,$valor2);
$valor21=$respuestaVenta["CodAlmacenEntrada"];
$almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item2, $valor2);
foreach($almacen as $key => $value){
$ruc=$value["ruc"];
$direccion= $value["DireccionAlmacen"];
$nombreAlmacen= $value["NombreAlmacen"];
$telefono= $value["telefono"];
$email= $value["email"];
}
$almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item2, $valor21);
foreach($almacen as $key => $value){
$ruc2=$value["ruc"];
$direccion2= $value["DireccionAlmacen"];
$nombreAlmacen2= $value["NombreAlmacen"];
$telefono2= $value["telefono"];
$email2= $value["email"];
}
$fecha=substr($respuestaVenta["fechaTraspaso"],0,-8);
$productos=json_decode($respuestaVenta["productos"], true);
//TRAEMOS LA INFORMACIÓN DEL CLIENTE
/*$itemCliente="id";
$valorCliente=$respuestaVenta["id_cliente"];
$respuestaCliente=ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);*/
//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
$itemVendedor="CodUsuario";
$valorVendedor=$respuestaVenta["id_usuario"];
$respuestaVendedor=ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);
//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');
$pdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->startPageGroup();
$pdf->AddPage();
// ---------------------------------------------------------
$bloque1=<<<EOF
	<table>
		<tr>
			<td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
			<td style="background-color:white; width:140px">
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					<br>
					RUC: $ruc
					<br>
					Dirección: $direccion
					<br>
					NOMBRE: $nombreAlmacen
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
			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>TRASPASO N.<br>$valorVenta</td>
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
			<td style="border: 1px solid #666; background-color:white; width:195px">
				Sucursal Entrada: $nombreAlmacen2
			</td>
			<td style="border: 1px solid #666; background-color:white; width:195px">
				C.I./RUC.: $ruc2
			</td>
			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
				Fecha: $fecha
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:540px">Vendedor: $respuestaVendedor[nombre]</td>
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
		<td style="border: 1px solid #666; background-color:white; width:405px; text-align:center">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:135px; text-align:center">Cantidad</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
foreach ($productos as $key => $item) {
$itemProducto = "descripcion";
$valorProducto = $item["descripcion"];
$orden = null;
$bloque4 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:405px; text-align:center">
				$item[descripcion]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:135px; text-align:center">
				$item[cantidad]
			</td>
		</tr>
	</table>
EOF;
$pdf->writeHTML($bloque4, false, false, false, false, '');
}
// ---------------------------------------------------------
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