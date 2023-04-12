<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
class TablaFacturacionElectronica{
 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 
  	public $idCliente;
	public function mostrarTablaFacturacionElectronica(){
		$item = "id";
		$item2 = "id_cliente";
		$valor = $this->idCliente;
		$respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
		//echo json_encode($respuesta);
  		//$productos = ControladorProductos::ctrMostrarProductoss($item, $valor);
  		$facturas = ControladorVentas::ctrMostrarFacturaElectronica($item2, $valor);	
  		if(count($facturas) == 0){
  			echo '{"data": []}';
		  	return;
  		}
  		$datosJson = '{
		  "data": [';
		   for($i = 0; $i < count($facturas); $i++){
		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
		  	$botones =  "<div class='btn-group'><button class='btn btn-warning descargarXml' codAcceso='".$facturas[$i]["claveacceso"]."'>XML</button><button class='btn btn-danger descargarPdf'codAcceso='".$facturas[$i]["claveacceso"]."'>PDF</button></div>";
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$facturas[$i]["NombreAlmacen"].'",
			      "'.$respuesta["nombre"].'",
			      "'.$facturas[$i]["fecha"].'",
			      "'.$botones.'"
			    ],';
		  }
		  $datosJson = substr($datosJson, 0, -1);
		 $datosJson .=   '] 
		 }';
		echo $datosJson;
	}
}
/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/ 
if (isset($_GET["idCliente"])) {
	$activarTbFacturacion = new TablaFacturacionElectronica();
	$activarTbFacturacion -> idCliente=$_GET["idCliente"];
	$activarTbFacturacion -> mostrarTablaFacturacionElectronica();
}
