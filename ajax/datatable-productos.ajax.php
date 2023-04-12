<?php
set_time_limit(0);
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
require_once "../controladores/almacen.controlador.php";
require_once "../modelos/almacen.modelo.php";
class TablaProductos{
 	/*=============================================
 	 MOSTRAR LA TABLA DE PRODUCTOS
  	=============================================*/ 
	public function mostrarTablaProductos(){
		$item = null;
    	$valor = null;
  		$productos = ControladorProductos::ctrMostrarProductos($item, $valor);	
  		$datosJson = '{
		  "data": [';
		  for($i = 0; $i < count($productos); $i++){
		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 
		  	$imagen = "<img src='".$productos[$i]["imagen"]."' width='40px'>";
		  	/*=============================================
 	 		TRAEMOS LA CATEGORÍA
  			=============================================*/ 
		  	$item = "idCategoria";
		  	$valor = $productos[$i]["id_categoria"];
		  	$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
		  	$itema=null;
            $valora=null;
            $almacen=ControladorAlmacenes::ctrMostrarAlmacenes($itema,$valora);
		  	$item2= "CodAlmacen";
			  $item1= "CodProducto";
		  	$valor1=$productos[$i]["id"];
		  	$valor2=$almacen[1]["CodAlmacen"];
		  	$valor3=$almacen[0]["CodAlmacen"];
  			$stock1=ControladorProductos::ctrMostrarStock($item2,$item1, $valor2,$valor1);
  			$stockFinal=$stock1["CantidadIngreso"]-$stock1["CantidadEgreso"];
  			$stock2=ControladorProductos::ctrMostrarStock($item2,$item1, $valor3,$valor1);
  			$stockFinal1=$stock2["CantidadIngreso"]-$stock2["CantidadEgreso"];
  			if($stockFinal <= 10){
  				$stock = "<button class='btn btn-danger'>".$stockFinal."</button>";
  			}else if($stockFinal > 11 && $stockFinal <= 15){
  				$stock = "<button class='btn btn-warning'>".$stockFinal."</button>";
  			}else{
  				$stock = "<button class='btn btn-success'>".$stockFinal."</button>";
  			}
  			if($stockFinal1 <= 10){
  				$stock1 = "<button class='btn btn-danger'>".$stockFinal1."</button>";
  			}else if($stockFinal1 > 11 && $stockFinal1 <= 15){
  				$stock1 = "<button class='btn btn-warning'>".$stockFinal1."</button>";
  			}else{
  				$stock1 = "<button class='btn btn-success'>".$stockFinal1."</button>";
  			}
		  	/*=============================================
 	 		STOCK
  			=============================================*/ 
  			/*if($productos[$i]["stock"] <= 10){
  				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";
  			}else if($productos[$i]["stock"] > 10 && $productos[$i]["stock"] <= 15){
  				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";
  			}else{
  				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";
  			}*/
		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 
  			$item="CodUsuario";
            $valor=$_GET["idperfiloculto"];
            $usuario=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
            if ($usuario["perfil"]=="Administrador") {
            	$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>"; 
            }else{
            	$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></div>";
            }
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["codigo"].'",
			      "'.$productos[$i]["descripcion"].'",
            "'.$productos[$i]["iva_producto"].'",
			      "'.$categorias["categoria"].'",
			      "'.$productos[$i]["precio_compra"].'",
			      "'.$productos[$i]["precio_venta"].'",
			      "'.$stock1.'",
			      "'.$stock.'",
			      "'.$productos[$i]["fecha"].'",
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
$activarProductos = new TablaProductos();
$activarProductos -> mostrarTablaProductos();
