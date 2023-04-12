<?php
require_once "../controladores/retencion.controlador.php";
require_once "../modelos/retencion.modelo.php";
class AjaxImpuesto{
	/*=============================================
	mostrar los tipos de impuestos
	=============================================*/	
	public $tipoimpuesto;
	public $campo;
	public function ajaxVerImpuesto(){
		$item = $this->campo;
		$valor = $this->tipoimpuesto;
		$respuesta = ControladorRetenciones::ctrMostrarTipoImpuesto($item, $valor);
		echo json_encode($respuesta);
	}
}
$cliente = new AjaxImpuesto();
$cliente -> tipoimpuesto = $_POST["tipoimpuesto"];
$cliente -> campo = $_POST["campo"];
$cliente -> ajaxVerImpuesto();
