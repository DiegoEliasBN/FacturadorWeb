<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/productos.controlador.php";
require_once "../modelos/clientes.modelo.php";
require_once "../controladores/clientes.controlador.php";
class AjaxVentas{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $datos  = array();
	public $CodAlmacen;
	public $nombreProducto;
	public function ajaxAgregarVenta(){
		$datosAjax = $this->datos;
		$respuesta = ControladorVentas::ctrCrearVenta($datosAjax);
		echo json_encode($respuesta);
	}
	public function ajaxEditarVenta(){
		$datosAjax = $this->datos;
		$respuesta = ControladorVentas::ctrEditarVenta($datosAjax);
		echo json_encode($respuesta);
	}
	public function ajaxAutocompletar(){
		$item ="descripcion";
		$item1="CodAlmacen";
		$valor = $this->nombreProducto;
		$valor1 = $this->CodAlmacen;
		$respuesta = ControladorProductos::ctrMostrarStockAutocompletar($item,$item1, $valor,$valor1);
		echo json_encode($respuesta);
	}
}
/*=============================================
AGREGAMOS LA VENTA 
=============================================*/	
if(isset($_POST["nuevaVenta"])){
	$venta = new AjaxVentas();
	$venta -> datos = array("idVendedor"=>$_POST["idVendedor"],
						   	  "seleccionarCliente"=>$_POST["seleccionarCliente"],
						      "nuevaVenta"=>$_POST["nuevaVenta"],
						      "listaProductos"=>$_POST["listaProductos"],
						      "nuevoIva"=>$_POST["nuevoIva"],
						      "nuevoIva12"=>$_POST["nuevoIva12"],
						      "nuevoIva0"=>$_POST["nuevoIva0"],
						      "totalVenta"=>$_POST["totalVenta"],
						      "nuevoTotalsito"=>$_POST["nuevoTotalsito"],
						      "nuevoCompra"=>$_POST["totalCompra"],
						      "nuevoMetodoPago"=>$_POST["nuevoMetodoPago"],
						      "nuevoAlmacen"=>$_POST["nuevoAlmacen"],
						      "CodUTurno"=>$_POST["CodUTurno"],
						      "codigo_df"=>$_POST["codigo_df"],
						      "Factura"=>$_POST["Factura"]);
	$venta -> ajaxAgregarVenta();
}
if(isset($_POST["editarVenta"])){
	$venta = new AjaxVentas();
	$venta -> datos = array("idVendedor"=>$_POST["idVendedor"],
							"editarVenta"=>$_POST["editarVenta"],
							"seleccionarCliente"=>$_POST["seleccionarCliente"],
							"listaProductos"=>$_POST["listaProductos"],
							"nuevoIva"=>$_POST["nuevoIva"],
							"nuevoIva12"=>$_POST["nuevoIva12"],
							"nuevoIva0"=>$_POST["nuevoIva0"],
							"totalVenta"=>$_POST["totalVenta"],
							"nuevoTotalsito"=>$_POST["nuevoTotalsito"],
							"nuevoCompra"=>$_POST["totalCompra"],
							"nuevoMetodoPago"=>$_POST["nuevoMetodoPago"],
							"codigo_df"=>$_POST["codigo_df"],
							"CodUTurno"=>$_POST["CodUTurno"],
							"CodAlmacen"=>$_POST["CodAlmacen"],
							"Factura"=>$_POST["editarFactura"]);
	$venta -> ajaxEditarVenta();
}
if (isset($_GET["descripcion"])) {
	$traerProductos = new AjaxVentas();
	$traerProductos -> CodAlmacen = $_GET["CodAlmacen"];
	$traerProductos -> nombreProducto = $_GET["descripcion"];
	$traerProductos -> ajaxAutocompletar();
}
