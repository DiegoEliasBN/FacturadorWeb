<?php
require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";
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
$itemVenta="id";
$valorVenta=$this->codigo;
$item2="CodAlmacen";
$valor2=$this->idAlmacen;
$respuestaVenta=ControladorVentas::ctrMostrarVentas($itemVenta,$item2, $valorVenta,$valor2);
$almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item2, $valor2);
foreach($almacen as $key => $value){
$ruc=$value["ruc"];
$direccion= $value["DireccionAlmacen"];
$telefono= $value["telefono"];
$email= $value["email"];
$nombrealmacen=$value["NombreAlmacen"];
}
$fecha=substr($respuestaVenta["fecha"],0,-8);
$productos=json_decode($respuestaVenta["productos"], true);
$neto=number_format($respuestaVenta["neto"],2);
$iva12=number_format($respuestaVenta["iva_12"],2);
$iva0=number_format($respuestaVenta["iva_0"],2);
$impuesto=number_format($respuestaVenta["impuesto"],2);
$total=number_format($respuestaVenta["total"],2);
//TRAEMOS LA INFORMACIÓN DEL CLIENTE
$itemCliente="id";
$valorCliente=$respuestaVenta["id_cliente"];
$respuestaCliente=ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
//TRAEMOS LA INFORMACIÓN DEL VENDEDOR
$itemVendedor="CodUsuario";
$valorVendedor=$respuestaVenta["id_vendedor"];
$respuestaVendedor=ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);
//REQUERIMOS LA CLASE TCPDF
require_once('tcpdf_include.php');
$medidas = array(72, 260); // Ajustar aqui segun los milimetros necesarios;
$pdf=new TCPDF('P', 'mm', $medidas, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//DETERMINAMOS MARGEN DEL DOCUMENTO
$pdf->SetMargins(0, 0, 0);
$pdf->SetLeftMargin(4);
//TERMINA MARGEN DEL DOCUMENTO
$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 8, '', '');
	$path_logo =  'images/logo_comprobantes-';
        switch ($valor2){
            case 1:
                $path_logo .= '001.png'; break;
            default:
                $path_logo .= '002.png'; break;
        }
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
//<tr>
	//<td style="width:50px; text-align:center"><img src="images/favicon.png"></td>
//</tr>
$bloque1=<<<EOF
<tr>
<tr align:center>	
		<div align="center"><img width="100" src="$path_logo"></div>
	</tr>
</tr>
<table style="width:180px; text-align:center; font-size:09px">
	<tr>	
		<td> 
		    <strong>
		 $ruc
		    <br>
		 $direccion
		    <br>
		    </strong>
		</td>
	</tr>
</table>
<table>
	<tr>
	    <td style="width:180px; text-align:left">
		<strong>CONTROL INTERNO:</strong> $valorVenta
		    <br>
		<strong>VENDEDOR:</strong> $respuestaVendedor[nombre]
		    <br>
		<strong>FECHA:</strong> $fecha
		</td>
	</tr>
	<tr>
	    <td style="width:180px; text-align:center; font-size:10px"> 
	        <strong>
	        DATOS DEL CLIENTE
	        </strong>
	    </td>
	</tr>
</table>
<table>
	<tr>
			<td style="width:180px; text-align:left">
				<br>
				<strong>CI. RUC.:</strong> $respuestaCliente[documento]
				<br>
				<strong>CLIENTE:</strong> $respuestaCliente[nombre]
				<br>
				<strong>DIRECCION:</strong> $respuestaCliente[direccion]
		    </td>
	</tr>
 </table>
EOF;
$pdf->writeHTML($bloque1, false, false, false, false, '');
// ---------------------------------------------------------
$bloque2 = <<<EOF
<tr>
	********************************************
	<br>
	<strong>
		<td style="width:80px; text-align:left">
		PRODUC 
		</td>
		<td style="width:34px; text-align:left">
		CANT
		</td>
		<td style="width:33px; text-align:left">
		PREC
		</td>
		<td style="width:39px; text-align:left">
		VALOR
		</td>
</strong>
	</tr>
	********************************************
	<br>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
foreach ($productos as $key => $item) {
$itemProducto = "descripcion";
// $valorProducto = $item["descripcion"];
$valorProducto = trim($item["descripcion"]) ;
$valorProducto = strlen($valorProducto) > 14 ? substr($valorProducto, 0, 14) : $valorProducto;
$orden = null;
$cadena =$valorProducto;
//saco el número de palabras con el parámtero '0'
$numero=strlen($cadena);
//guardo las palabras en un array	
$array_cadena = str_word_count($cadena, 1);
//saco cada elemento del array 
$count=0;
$palabrasalida="";
foreach ($array_cadena as $palabra) {
	if ($palabra!="i") {
		if ($count != 2) {
			$palabrasalida=$palabrasalida." ".$palabra;
			$count ++;
		}
	}else{
		$palabrasalida="(i)";
	}
}
$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);
//$valorUnitario = number_format($respuestaProducto["precio_siniva"], 2);
$valorUnitario = number_format($item["precio"], 2);
$precioTotal = number_format($item["total"], 2);
$bloque2 = <<<EOF
<table>
	<tr>
		<td style="width:80px; text-align:left;">
		$valorProducto
		</td>
		<td style="width:28px; text-align:left;">
		$item[cantidad]
		</td>
		<td style="width:24px; text-align:center;">
			$valorUnitario
		</td>
		<td style="width:40px; text-align:center;">
		$ $precioTotal
		</td>
	</tr>
</table>
EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');
}
$bloque3 = <<<EOF
<table style="text-align:right">
********************************************
<br>
	<tr>
		<td style="width:85px;">
			 SUBTOTAL 12%: 
		</td>
		<td style="width:85px;">
			$ $iva12
		</td>
	</tr>
	<tr>
		<td style="width:85px;">
			 SUBTOTAL 0%: 
		</td>
		<td style="width:85px;">
			$ $iva0
		</td>
	</tr>
	<tr>
		<td style="width:85px;">
			 SUBTOTAL: 
		</td>
		<td style="width:85px;">
			$ $neto
		</td>
	</tr>
	<tr>
		<td style="width:85px;">
			 IVA 12%: 
		</td>
		<td style="width:85px;">
			$ $impuesto
		</td>
	</tr>
	<tr>
		<td style="width:85px; font-size:15px;">
		<strong>
			 TOTAL: 
			 </strong>
		</td>
		<td style="width:95px; font-size:15px;">
		<strong>
			$ $total
			</strong>
		</td>
	</tr>
********************************************
	<br>
	<tr> 
		<td style="width:180px;text-align:center; font-size:08px">
			SISTEMA DESARROLLADO POR:
			<br>SystSolutionsEC Telf: 0982005664 <br>YACHASOFT Telf:(04) 2975811 - (09)91739751
		</td>
	</tr>
********************************************
</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
// ---------------------------------------------------------
//	<tr> 
//		<td style="width:160px;font-size:10px; text-align:left">
//				VENDEDOR: $respuestaVendedor[nombre]
//		</td>
//	</tr>
//SALIDA DEL ARCHIVO 
$pdf->Output('factura.pdf');
}
}
$factura=new imprimirFactura();
$factura->codigo=$_GET["codigo"];
$factura->idAlmacen=$_GET["idAlmacen"];
$factura->traerImpresionFactura();
?>