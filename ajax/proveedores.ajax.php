<?php
require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
class AjaxProveedores{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $idProveedor;
	public function ajaxEditarProveedor(){
		$item = "id";
		$valor = $this->idProveedor;
		$respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR CLIENTE
=============================================*/	
if(isset($_POST["idProveedor"])){
	$cliente = new AjaxProveedores();
	$cliente -> idProveedor = $_POST["idProveedor"];
	$cliente -> ajaxEditarProveedor();
}