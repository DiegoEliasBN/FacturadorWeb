<?php
require_once "../controladores/almacen.controlador.php";
require_once "../modelos/almacen.modelo.php";
class AjaxAlmacenes{
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idAlmacen;
	public function ajaxEditarAlmacen(){
		$item = "CodAlmacen";
		$valor = $this->idAlmacen;
		$respuesta = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
		echo json_encode($respuesta);
	}
	//public $idAlmacenn;
	//public function ajaxEditarAlmacen(){
		//$item = "CodAlmacen";
		//$valor = $this->idAlmacen;
		//$respuesta = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
		//echo json_encode($respuesta);
	//}
}
/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idAlmacen"])){
	$categoria = new AjaxAlmacenes();
	$categoria -> idAlmacen = $_POST["idAlmacen"];
	$categoria -> ajaxEditarAlmacen();
}
