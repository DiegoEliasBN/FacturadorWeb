<?php
class ControladorProductos{
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	static public function ctrMostrarProductos($item, $valor){
		$tabla = "productos";
		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarProductoss($item, $valor){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarProductoss($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarStock($item,$item1, $valor,$valor1){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarStock($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	static public function ctrMostrarStock1($item,$item1, $valor,$valor1){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarStock1($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	static public function ctrMostrarStock12($item,$item1, $valor,$valor1){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarStock12($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	static public function ctrMostrarStockAutocompletar($item,$item1, $valor,$valor1){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarStockAutocompletar($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	static public function ctrMostrarProductoLiquidacion($item, $valor){
		$tabla = "productos";
		$respuesta = ModeloProductos::mdlMostrarProductoLiquidacion($tabla,$item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarStock2($item,$item1, $valor,$valor1){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarStock2($tabla,$item,$item1, $valor,$valor1);
		return $respuesta;
	}
	static public function ctrMostrarStockdinamico($item, $valor){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlMostrarProductosdinamico($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarDescuento(){
		$tabla = "descuento";
		$respuesta = ModeloProductos::mdlMostrarDescuento($tabla);
		return $respuesta;
	}
	/*=============================================
	CREAR PRODUCTO
	=============================================*/
	static public function ctrCrearProducto(){
		if(isset($_POST["nuevaDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ().,"" -]+$/', $_POST["nuevaDescripcion"]) &&	
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			   	$ruta = "vistas/img/productos/default/anonymous.png";
			   	if(isset($_FILES["nuevaImagen"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];
					mkdir($directorio, 0755);
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}
					if($_FILES["nuevaImagen"]["type"] == "image/png"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";
						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}
				$tabla = "productos";
				if (isset($_POST["iva_producto"])) {
					$iva=$_POST["iva_producto"];
				}else{
					$iva="N";
				}
				$datos = array("id_categoria" => $_POST["nuevaCategoria"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "descripcion" => $_POST["nuevaDescripcion"],
							   "precio_compra" => $_POST["nuevoPrecioCompra"],
							   "precio_venta" => $_POST["nuevoPrecioVenta"],
							   "iva_producto" => $iva,
							   "preciosiniva" => $_POST["preciosiniva"],
							   "imagen" => $ruta);
				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
				if($respuesta['respuesta'] == "ok"){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  allowOutsideClick:false,
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
									if (result.value) {
										window.location = "productos";
									}
							  })
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  allowOutsideClick:false,
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
								window.location = "productos";
							}
						})
			  	</script>';
			}
		}
	}
	static public function ctrCrearProductoAlmacen(){
		if(isset($_POST["nuevaDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ().,"" -]+$/', $_POST["nuevaDescripcion"]) &&	
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				   $ruta = "vistas/img/productos/default/anonymous.png";
			   	if($_FILES["nuevaImagen"]["tmp_name"] !=""){
					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];
					mkdir($directorio, 0755);
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}
					if($_FILES["nuevaImagen"]["type"] == "image/png"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";
						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}
				$tabla = "productos";
				if (isset($_POST["iva_producto"])) {
					$iva=$_POST["iva_producto"];
				}else{
					$iva="N";
				}
				$datos = array("id_categoria" => $_POST["nuevaCategoria"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "descripcion" => $_POST["nuevaDescripcion"],
							   "precio_compra" => $_POST["nuevoPrecioCompra"],
							   "precio_venta" => $_POST["nuevoPrecioVenta"],
							   "iva_producto" => $iva,
							   "preciosiniva" => $_POST["preciosiniva"],
							   "imagen" => $ruta);
				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);
				if($respuesta['respuesta'] == "ok"){
					$tablaProductos = "stockalmacen";
					$datos2 = array("CodProducto"=>$respuesta["id_factura"],
						   "CantidadIngreso"=>$_POST["nuevoStock"],
						   "CodAlmacen"=>$_POST["nuevoAlmacen"]);
							$nuevoProduct = ModeloProductos::mdlIngresarStockProducto($tablaProductos,$datos2);
							if ($nuevoProduct == "ok") {
								echo'<script>
										swal({
											type: "success",
											title: "El producto ha sido guardado correctamente",
											allowOutsideClick:false,
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
											}).then(function(result){
												if (result.value) {
													window.location = "productosAlmacen";
												}
											})
										</script>';
							}else {
								echo'<script>
										swal({
											type: "error",
											title: "El producto no se ha guardado correctamente",
											allowOutsideClick:false,
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
											}).then(function(result){
												if (result.value) {
													window.location = "productosAlmacen";
												}
											})
										</script>';
							}
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  allowOutsideClick:false,
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
								window.location = "productosAlmacen";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function ctrEditarProducto(){
		if(isset($_POST["editarDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ(). -]+$/', $_POST["editarDescripcion"]) &&	
			   preg_match('/^[0-9.,]+$/', $_POST["editarPrecioCompra"]) &&
			   preg_match('/^[0-9.,]+$/', $_POST["editarPrecioVenta"])){
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			   	$ruta = $_POST["imagenActual"];
			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$tabla = "productos";
					$item="id";
					$valor=$_POST["idproducto"];
					$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);
					$directorio = "vistas/img/productos/".$respuesta["codigo"];
					$directorio2= "vistas/img/productos/".$_POST["editarCodigo"];
					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/
					if (!file_exists($directorio)) {
    					mkdir($directorio2, 0755);
					}else{
						unlink($directorio);
						mkdir($directorio2, 0755);
					}
					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){
						unlink($_POST["imagenActual"]);
					}else{
						mkdir($directorio2, 0755);	
					}
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["editarImagen"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}
					if($_FILES["editarImagen"]["type"] == "image/png"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";
						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}
				$tabla = "productos";
				if (isset($_POST["editar_iva"])) {
					$iva=$_POST["editar_iva"];
				}else{
					$iva="N";
				}
				$datos = array("id_categoria" => $_POST["editarCategoria"],
							   "codigo" => $_POST["editarCodigo"],
							   "descripcion" => $_POST["editarDescripcion"],
							   "precio_compra" => $_POST["editarPrecioCompra"],
							   "precio_venta" => $_POST["editarPrecioVenta"],
							   "precio_siniva" => $_POST["epreciosiniva"],
							   "iva_producto" => $iva,
							   "id" => $_POST["idproducto"],
							   "imagen" => $ruta);
				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
											window.location = "productos";
										}
									})
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "productos";
							}
						})
			  	</script>';
			}
		}
	}
	static public function ctrEditarProductoAlmacen(){
		if(isset($_POST["editarDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ(). -]+$/', $_POST["editarDescripcion"]) &&	
			   preg_match('/^[0-9.,]+$/', $_POST["editarPrecioCompra"]) &&
			   preg_match('/^[0-9.,]+$/', $_POST["editarPrecioVenta"])){
		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/
			   	$ruta = $_POST["imagenActual"];
			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){
					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
					$tabla = "productos";
					$item="id";
					$valor=$_POST["idproducto"];
					$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);
					$directorio = "vistas/img/productos/".$respuesta["codigo"];
					$directorio2= "vistas/img/productos/".$_POST["editarCodigo"];
					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/
					if (!file_exists($directorio)) {
    					mkdir($directorio2, 0755);
					}else{
						unlink($directorio);
						mkdir($directorio2, 0755);
					}
					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){
						unlink($_POST["imagenActual"]);
					}else{
						mkdir($directorio2, 0755);	
					}
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
					if($_FILES["editarImagen"]["type"] == "image/jpeg"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";
						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
					}
					if($_FILES["editarImagen"]["type"] == "image/png"){
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
						$aleatorio = mt_rand(100,999);
						$ruta = "vistas/img/productos/".$_POST["editarCodigo"]."/".$aleatorio.".png";
						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);
					}
				}
				$tabla = "productos";
				if (isset($_POST["editar_iva"])) {
					$iva=$_POST["editar_iva"];
				}else{
					$iva="N";
				}
				$datos = array("id_categoria" => $_POST["editarCategoria"],
							   "codigo" => $_POST["editarCodigo"],
							   "descripcion" => $_POST["editarDescripcion"],
							   "precio_compra" => $_POST["editarPrecioCompra"],
							   "precio_venta" => $_POST["editarPrecioVenta"],
							   "precio_siniva" => $_POST["epreciosiniva"],
							   "iva_producto" => $iva,
							   "id" => $_POST["idproducto"],
							   "imagen" => $ruta);
				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  allowOutsideClick:false,
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
											window.location = "productosAlmacen";
										}
									})
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  allowOutsideClick:false,
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "productosAlmacen";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR PRODUCTO
	=============================================*/
	static public function ctrEliminarProducto(){
		if(isset($_GET["idProducto"])){
			$tabla ="productos";
			$datos = $_GET["idProducto"];
			if($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){
				unlink($_GET["imagen"]);
				rmdir('vistas/img/productos/'.$_GET["codigo"]);
			}
			$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El producto ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "productos";
								}
							})
				</script>';
			}		
		}
	}
	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/
	static public function ctrSumaTotalVentasa($item1,$valor1){
		$tabla = "stockalmacen";
		$respuesta = ModeloProductos::mdlSumaTotalVentasa($tabla,$item1,$valor1);
		return $respuesta;
	}
}