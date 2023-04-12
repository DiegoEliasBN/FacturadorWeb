<?php 
require_once "../controladores/ccaja.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../modelos/ccaja.modelo.php";
require_once "../modelos/acaja.modelo.php";
require_once "../modelos/mefectivo.modelo.php";
require_once "../controladores/mefectivo.controlador.php";
class ajaxCcaja{
	public $idCcaja;
		public function ajaxMostrarCCaja(){
			$item1="CodApertura";
			$valor1=$this -> idCcaja;
			$respuesta=ControladorCCaja::ctrGenerarCCaja($item1,$valor1);
			echo json_encode($respuesta);
		}
}
if (isset($_POST["idApertura"])) {
	$editar =new ajaxCcaja();
	$editar -> idCcaja=$_POST["idApertura"];
	$editar->ajaxMostrarCCaja();
}