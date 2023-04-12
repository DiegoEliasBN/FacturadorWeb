<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
class AjaxFactura{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $id_cliente;
	public function ajaxMostrarFacturasElectronicas(){
		//$_SESSION["idCliente"]=$this->id_cliente;
		$item = "id_cliente";
		$valor = $this->id_cliente;
		$respuesta = ControladorVentas::ctrMostrarFacturaElectronica($item, $valor);
		echo json_encode($respuesta);
	}
}
/*=============================================
=============================================*/	
$Ventas = new AjaxFactura();
$Ventas -> id_cliente=$_POST["idcliente"];
$Ventas -> ajaxMostrarFacturasElectronicas();
