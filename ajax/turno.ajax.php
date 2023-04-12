<?php
require_once "../controladores/turno.controlador.php";
require_once "../modelos/turno.modelo.php";
class AjaxTurnos{
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idTurno;
	public function ajaxEditarTurno(){
		$item = "CodTurno";
		$valor = $this->idTurno;
		$respuesta = ControladorTurnos::ctrMostrarTurnos($item, $valor);
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
if(isset($_POST["idTurno"])){
	$categoria = new AjaxTurnos();
	$categoria -> idTurno = $_POST["idTurno"];
	$categoria -> ajaxEditarTurno();
}
