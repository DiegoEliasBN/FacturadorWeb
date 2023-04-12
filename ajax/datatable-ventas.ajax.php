<?php
set_time_limit(0);
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
class TablaProductosVentas{
 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 
  	public $idUAlmacen;
	public function mostrarTablaProductosVentas(){
		$item = "CodAlmacen";
		$item1= "CodProducto";
    	$valor = $this->idUAlmacen;
  		$productos = ControladorProductos::ctrMostrarProductoss($item, $valor);	
  		if(count($productos) == 0){
  			echo '{"data": []}';
		  	return;
  		}
  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($productos); $i++){
		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 
		  	$imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";
		  	/*=============================================
 	 		STOCK
  			=============================================*/ 
  			$valor1=$productos[$i]["id"];
  			$stock1=ControladorProductos::ctrMostrarStock($item,$item1, $valor,$valor1);
  			//$stockFinal=$stock1["CantidadIngreso"]-$stock1["CantidadEgreso"];
  			$stockFinal= number_format($stock1["precio_venta"], 2, '.', '');
  			$stock = "<button class='btn btn-success'>".$stockFinal."</button>";
		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."'         idAlmacen='".$productos[$i]["CodAlmacen"]."'>Agregar</button></div>"; 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["descripcion"].'",
			      "'.$stock.'",
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
if (isset($_GET["nuevo"])) {
	$activarProductosVentas = new TablaProductosVentas();
	$activarProductosVentas -> idUAlmacen=$_GET["nuevo"];
	$activarProductosVentas -> mostrarTablaProductosVentas();
}
