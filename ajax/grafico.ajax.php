<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
class AjaxGrafico{
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idMovimiento;
	public function ajaxEditarGrafico(){
		$item = "CodAlmacen";
		$valor = $this->idMovimiento;
		$respuesta = ControladorProductos::ctrMostrarStockdinamico($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idMovimiento"])){
	$categoria = new AjaxGrafico();
	$categoria -> idMovimiento = $_POST["idMovimiento"];
	$categoria -> ajaxEditarGrafico();
}
