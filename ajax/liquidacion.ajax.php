<?php
require_once "../controladores/liquidacion.controlador.php";
require_once "../modelos/liquidacion.modelo.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/productos.controlador.php";
class AjaxLiquidacion{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $datos  = array();
	public $CodAlmacen;
	public $nombreProducto;
	public $codigo;
	public function ajaxAgregarLiquidacion(){
		$datosAjax = $this->datos;
		$respuesta = ControladorLiquidaciones::ctrCrearLiquidacion($datosAjax);
		echo json_encode($respuesta);
	}
	public function ajaxEditarLiquidacion(){
		$datosAjax = $this->datos;
		$respuesta = ControladorVentas::ctrEditarVenta($datosAjax);
		echo json_encode($respuesta);
	}
	public function ajaxAutocompletar(){
		$item ="descripcion";
		$valor = $this->nombreProducto;
		$respuesta = ControladorProductos::ctrMostrarProductoLiquidacion($item, $valor);
		echo json_encode($respuesta);
	}
	public function ajaxBuscarProducto(){
		$item ="descripcion";
		$valor = $this->nombreProducto;
		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
		echo json_encode($respuesta);
	}
	public function ajaxBuscarProductos(){
		$item ="codigo";
		$valor = $this->codigo;
		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
AGREGAMOS LA VENTA 
=============================================*/	
if(isset($_POST["CodUTurno"])){
	$venta = new AjaxLiquidacion();
	$venta -> datos = array("idVendedor"=>$_POST["idVendedor"],
						   	  "seleccionarCliente"=>$_POST["seleccionarCliente"],
						      "listaProductos"=>$_POST["listaProductos"],
						      "nuevoIva"=>$_POST["nuevoIva"],
						      "nuevoIva12"=>$_POST["nuevoIva12"],
						      "nuevoIva0"=>$_POST["nuevoIva0"],
						      "totalVenta"=>$_POST["totalVenta"],
						      "nuevoTotalsito"=>$_POST["nuevoTotalsito"],
						      "nuevoAlmacen"=>$_POST["nuevoAlmacen"],
						      "CodUTurno"=>$_POST["CodUTurno"]
						     );
	$venta -> ajaxAgregarLiquidacion();
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
	$traerProductos = new AjaxLiquidacion();
	$traerProductos -> nombreProducto = $_GET["descripcion"];
	$traerProductos -> ajaxAutocompletar();
}
if (isset($_POST["nombreProducto"])) {
	$traerProductos = new AjaxLiquidacion();
	$traerProductos -> nombreProducto = $_POST["nombreProducto"];
	$traerProductos -> ajaxBuscarProducto();
}
if (isset($_POST["codigo"])) {
	$traerProductos = new AjaxLiquidacion();
	$traerProductos -> codigo = $_POST["codigo"];
	$traerProductos -> ajaxBuscarProductos();
}
