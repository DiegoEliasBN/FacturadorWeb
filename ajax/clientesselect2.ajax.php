<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
class AjaxClientes{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public function ajaxEditarCliente(){
		$item = null;
		$valor = null;
		$respuesta = ControladorClientes::ctrMostrarClientes3($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
EDITAR CLIENTE
=============================================*/	
$cliente = new AjaxClientes();
$cliente -> ajaxEditarCliente();
