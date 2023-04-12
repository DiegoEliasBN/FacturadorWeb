<?php
class ControladorTraspasos{
	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function ctrMostrarTraspasos($item,$item1, $valor,$valor1){
		$tabla = "traspaso";
		$respuesta = ModeloTraspasos::mdlMostrarTraspasos($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	/*=============================================
	CREAR VENTA
	=============================================*/
	static public function ctrCrearTraspaso(){
		if(isset($_POST["nuevaVenta"])){
			if ($_POST["listaProductosT"]!="") {
					/*=============================================
					ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
					=============================================*/
					//var_dump($_POST["listaProductosT"]);
					$listaProductos = json_decode($_POST["listaProductosT"], true);
					$almacen=$_POST["nuevoAlmacen"];
					$almacenEntrada=$_POST["nuevoAlmacenEntradda"];
					$contador=0;
					$totalProductosComprados = array();
					foreach ($listaProductos as $key => $value) {
							   $contador=0;
							   array_push($totalProductosComprados, $value["cantidad"]);
							   $tablaProductos = "stockalmacen";
							    $item = "CodProducto";
							    $coda="CodAlmacen";
							    $valor = $value["id"];
							    $traerProducto = ModeloProductos::mdlMostrarStock($tablaProductos, $item,$coda, $valor,$almacenEntrada);
							    $traerProducto2 = ModeloProductos::mdlMostrarProductoss($tablaProductos,$coda,$almacenEntrada);
							    foreach ($traerProducto2 as $key1 => $value12) {
							    	if ($value12["CodProducto"]==$value["id"]) {
							    		$item1a = "CantidadIngreso";
										$valor1a = $value["cantidad"] + $traerProducto["CantidadIngreso"];
							    		$nuevasVentas = ModeloProductos::mdlActualizarStock($almacenEntrada,$tablaProductos, $item1a, $valor1a, $valor);
							    		$contador=1;
							    	}
							    }
							    if ($contador==0) {
							    		$datos2 = array("CodProducto"=>$value["id"],
										   "CantidadIngreso"=>$value["cantidad"],
										   "CodAlmacen"=>$almacenEntrada);
							    		$nuevasVentas = ModeloProductos::mdlIngresarStockProducto($tablaProductos,$datos2);
							    	}
							    $traerProductoSalida = ModeloProductos::mdlMostrarStock($tablaProductos, $item,$coda, $valor,$almacen);
							    $valorSalida = $value["cantidad"] + $traerProductoSalida["CantidadEgreso"];
							    $itemSalida="CantidadEgreso";
							    $nuevasVentas = ModeloProductos::mdlActualizarStock($almacen,$tablaProductos, $itemSalida, $valorSalida, $valor);
					}
					/*=============================================
					GUARDAR LA COMPRA
					=============================================*/	
					$tabla = "traspaso";
					$datos = array("id_usuario"=>$_POST["idVendedor"],
								   "codigo"=>$_POST["nuevaVenta"],
								   "productos"=>$_POST["listaProductosT"],
								   "CodAlmacenEntrada"=>$_POST["nuevoAlmacenEntradda"],
								   "CodAlmacen"=>$_POST["nuevoAlmacen"]);
					//var_dump($datos);
					$respuesta = ModeloTraspasos::mdlIngresarTraspaso($tabla, $datos);
					if($respuesta == "ok"){
						echo'<script>
						localStorage.removeItem("rango");
						swal({
							  type: "success",
							  title: "El Traspaso ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then((result) => {
										if (result.value) {
											window.location = "traspasos";
										}
									})
						</script>';
					}
			}else{
				echo'<script>
						localStorage.removeItem("rango");
						swal({
							  type: "error",
							  title: "El Traspaso debe contener productos",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then((result) => {
										if (result.value) {
											window.location = "crear-traspaso";
										}
									})
						</script>';
			}
		}
	}
	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function ctrEditarCompra(){
		if(isset($_POST["editarVenta"])){
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$tabla = "ventas";
			$item = "id";
			$valor = $_POST["editarVenta"];
			$item1="CodAlmacen";
          	$valor1=$_SESSION["CodAlmacen"];
			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item,$item1, $valor,$valor1);
			/*=============================================
			REVISAR SI VIENE PRODUCTOS EDITADOS
			=============================================*/
			if($_POST["listaProductos"] == ""){
				$listaProductos = $traerVenta["productos"];
				$cambioProducto = false;
			}else{
				$listaProductos = $_POST["listaProductos"];
				//var_dump($listaProductos["cantidad"]);
				$cambioProducto = true;
			}
			if($cambioProducto){
				$productos =  json_decode($traerVenta["productos"], true);
				$totalProductosComprados = array();
				foreach ($productos as $key => $value) {
					array_push($totalProductosComprados, $value["cantidad"]);
					$tablaProductos = "stockalmacen";
					$item = "CodProducto";
					$valor = $value["id"];
					$traerProducto = ModeloProductos::mdlMostrarStock($tablaProductos, $item,$item1, $valor,$valor1);
					$item1a = "ventasa";
					$valor1a = $traerProducto["ventasa"] - $value["cantidad"];
					//var_dump($value["cantidad"]);
					//var_dump($traerProducto["ventasa"]);
					$nuevasVentas = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos, $item1a, $valor1a, $valor);
					$item1b = "CantidadEgreso";
					$valor1b =$traerProducto["CantidadEgreso"]- $value["cantidad"];
					//var_dump($valor1b);
					$nuevoStock = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos, $item1b, $valor1b, $valor);
				}
				$tablaClientes = "clientes";
				$itemCliente = "id";
				$valorCliente = $_POST["seleccionarCliente"];
				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);
				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);
				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);
				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
				=============================================*/
				$listaProductos_2 = json_decode($listaProductos, true);
				$totalProductosComprados_2 = array();
				foreach ($listaProductos_2 as $key => $value) {
					array_push($totalProductosComprados_2, $value["cantidad"]);
					$tablaProductos_2 = "stockalmacen";
					$item_2 = "CodProducto";
					$valor_2 = $value["id"];
					$traerProducto_2 = ModeloProductos::mdlMostrarStock($tablaProductos_2, $item_2,$item1, $valor_2,$valor1);
					$item1a_2 = "ventasa";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventasa"];
					$nuevasVentas_2 = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);
					$item1b_2 = "CantidadEgreso";
					$valor1b_2 = $value["stock"];
					$nuevoStock_2 = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);
				}
				$tablaClientes_2 = "clientes";
				$item_2 = "id";
				$valor_2 = $_POST["seleccionarCliente"];
				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);
				$item1a_2 = "compras";
				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerCliente_2["compras"];
				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);
				$item1b_2 = "ultima_compra";
				date_default_timezone_set('America/Bogota');
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;
				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);
			}
			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	
			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarVenta"],
						   "productos"=>$listaProductos,
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "CodAlmacen"=>$valor1,
						   "metodo_pago"=>$_POST["listaMetodoPago"]);
				//var_dump($listaProductos);
			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				localStorage.removeItem("rango");
				swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {
									window.location = "compras";
								}
							})
				</script>';
			}
		}
	}
	/*=============================================
	ELIMINAR VENTA
	=============================================*/
	static public function ctrEliminarTraspaso(){
		if(isset($_GET["idTraspaso"])){
			$tabla = "traspaso";
			$item = "CodTraspaso";
			$item1="CodAlmacen";
			$valor = $_GET["idTraspaso"];
			$valor1= $_GET["idAlmacen"];
			//var_dump($item);
			//var_dump($item1);
			//var_dump($valor);
			//var_dump($valor1);
			$traerVenta = ModeloTraspasos::mdlMostrartraspasos($tabla, $item,$item1, $valor,$valor1);
			//var_dump($traerVenta);
			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/
			$tablaClientes = "clientes";
			$itemVentas = null;
			$valorVentas = null;
			$itemVentas1 = "CodAlmacen";
			$valorVentas1= $_GET["idAlmacen"];
			$traerVentas = ModeloTraspasos::mdlMostrarTraspasos($tabla, $itemVentas,$itemVentas1, $valorVentas,$valorVentas1);
			/*=============================================
			FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
			=============================================*/
			$productos =  json_decode($traerVenta["productos"], true);
			$totalProductosComprados = array();
			foreach ($productos as $key => $value) {
				array_push($totalProductosComprados, $value["cantidad"]);
				$tablaProductos = "stockalmacen";
				$item = "CodProducto";
				$valor = $value["id"];
				$item1="CodAlmacen";
				$valor1=$_GET["idAlmacen"];
				$valor12=$traerVenta["CodAlmacenEntrada"];
				$traerProducto = ModeloProductos::mdlMostrarStock($tablaProductos, $item,$item1, $valor,$valor1);
				$item1b = "CantidadEgreso";
				$valor1b = $traerProducto["CantidadEgreso"]-$value["cantidad"];
				$nuevoStock = ModeloProductos::mdlActualizarStock($valor1,$tablaProductos, $item1b, $valor1b, $valor);
				$traerProducto12= ModeloProductos::mdlMostrarStock($tablaProductos, $item,$item1, $valor,$valor12);
				$itemSalida = "CantidadIngreso";
				$valorSalida = $traerProducto12["CantidadIngreso"]-$value["cantidad"];
				$nuevoStock12 = ModeloProductos::mdlActualizarStock($valor12,$tablaProductos, $itemSalida, $valorSalida, $valor);
			}
			/*=============================================
			ELIMINAR VENTA
			=============================================*/
			$respuesta = ModeloTraspasos::mdlEliminarTraspaso($tabla, $_GET["idTraspaso"]);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El traspaso ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {
								window.location = "traspasos";
								}
							})
				</script>';
			}		
		}
	}
}