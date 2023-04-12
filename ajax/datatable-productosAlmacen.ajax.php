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
    public $idUAlmacen;
	public function mostrarTablaProductos(){
		$item = "CodAlmacen";
		$item1= "CodProducto";
    	$valor = $this->idUAlmacen;
		$productos = ControladorProductos::ctrMostrarProductoss($item, $valor);
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
		  	$itemc = "idCategoria";
		  	$valorc = $productos[$i]["id_categoria"];
		  	$categorias = ControladorCategorias::ctrMostrarCategorias($itemc, $valorc);
            /*=============================================
 	 		STOCK
  			=============================================*/ 
            $valor1=$productos[$i]["id"];
            //   var_dump($productos[$i]["id"]);
  			$stock1=ControladorProductos::ctrMostrarStock($item,$item1, $valor,$valor1);
            $stockFinal=$stock1["CantidadIngreso"]-$stock1["CantidadEgreso"];
  			// $stockFinalF= number_format($stockFinal, 2, '.', '');
  			if($stockFinal <= 10){
  				$stock = "<button class='btn btn-danger'>".number_format($stockFinal, 2, '.', '')."</button>";
  			}else if($stockFinal > 11 && $stockFinal <= 15){
  				$stock = "<button class='btn btn-warning'>".number_format($stockFinal, 2, '.', '')."</button>";
  			}else{
  				$stock = "<button class='btn btn-success'>".number_format($stockFinal, 2, '.', '')."</button>";
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
  			$itemId="CodUsuario";
            $valorId=$_GET["idperfiloculto"];
            $usuario=ControladorUsuarios::ctrMostrarUsuarios($itemId,$valorId);
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
			      "'.number_format($productos[$i]["precio_compra"], 2, '.', '').'",
			      "'.number_format($productos[$i]["precio_venta"], 2, '.', '').'",
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
$activarProductos -> idUAlmacen=$_GET["nuevo"];
$activarProductos -> mostrarTablaProductos();
