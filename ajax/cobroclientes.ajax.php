<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
class AjaxFacturaFiadas{
	/*=============================================
	EDITAR CATEGORÍA
	=============================================*/	
	public $idTurno;
	public function ajaxEditarFacturasFiadas(){
		  $item = "saldo";
          $item1="id_cliente";
          $valor1=$this->idTurno;
          $respuesta = ControladorVentas::ctrMostrarVentasFiadas($item,$item1,$valor1);
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
if(isset($_POST["idCliente"])){
	$categoria = new AjaxFacturaFiadas();
	$categoria -> idTurno = $_POST["idCliente"];
	$categoria -> ajaxEditarFacturasFiadas();
}
