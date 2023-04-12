<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
class TablaProductosCompras{
 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 
  	public $idUAlmacen;
	public function mostrarTablaProductosCompras(){
		$valor1 = $this->idUAlmacen;
		$item = null;
    	$valor = null;
  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor);	
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
  			/*if($productos[$i]["stock"] <= 10){
  				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";
  			}else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){
  				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";
  			}else{
  				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";
  			}*/ 
		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarProductoc recuperarBoton' idProducto='".$productos[$i]["id"]."' idAlmacen='".$valor1."'>Agregar</button></div>"; 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["descripcion"].'",
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
	$activarProductosVentas = new TablaProductosCompras();
	$activarProductosVentas -> idUAlmacen=$_GET["nuevo"];
	$activarProductosVentas -> mostrarTablaProductosCompras();
}