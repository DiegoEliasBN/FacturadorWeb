<?php
require_once "../controladores/mefectivo.controlador.php";
require_once "../modelos/mefectivo.modelo.php";
class AjaxMefectivo{
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idMovimiento;
	public function ajaxEditarMefectivo(){
		$item=null;
		$valor=null;
		$item2 = "CodMovimiento";
		$valor2 = $this->idMovimiento;
		$respuesta = ControladorMefectivo::ctrMostrarMefectivo($item,$item2, $valor,$valor2);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR CATEGORÍA
=============================================*/	
if(isset($_POST["idMovimiento"])){
	$categoria = new AjaxMefectivo();
	$categoria -> idMovimiento = $_POST["idMovimiento"];
	$categoria -> ajaxEditarMefectivo();
}
