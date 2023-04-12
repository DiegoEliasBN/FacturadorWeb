<?php
require_once "../controladores/transporte.controlador.php";
require_once "../modelos/transporte.modelo.php";
class AjaxTransportes{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $idTransporte;
	public function ajaxEditarTransporte(){
		$item = "id";
		$valor = $this->idTransporte;
		$respuesta = ControladorTransportes::ctrMostrarTransporte($item, $valor);
		echo json_encode($respuesta);
	}
	public function ajaxEditarTransporteLicencia(){
		$item = "licencia";
		$valor = $this->idTransporte;
		$respuesta = ControladorTransportes::ctrMostrarTransporte($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR CLIENTE
=============================================*/	
if(isset($_POST["idTransporte"])){
	$transporte = new AjaxTransportes();
    $transporte -> idTransporte = $_POST["idTransporte"];
    $transporte -> ajaxEditarTransporte();
}
if(isset($_GET["q"])){
    $transporte = new AjaxTransportes();
    $transporte -> idTransporte = $_GET["q"];
    $transporte -> ajaxEditarTransporte();
}
if(isset($_POST["licencia"])){
    $transporte = new AjaxTransportes();
    $transporte -> idTransporte = $_POST["licencia"];
    $transporte -> ajaxEditarTransporteLicencia();
}