<?php
class ControladorUsuariosAlmacen{
	/*=============================================
	CREAR CLIENTES
	=============================================*/
	static public function ctrCrearUAlmacen(){
		if(isset($_POST["nuevoUsuario"])){
			   	$tabla = "usuarioalmacen";
			   	$datos = array("CodUsuario"=>$_POST["nuevoUsuario"],
					           "CodAlmacen"=>$_POST["nuevoAlmacen"]);
			   	$respuesta = ModeloUAlmacen::mdlIngresarUAlmacen($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Usuario de la Sucursal ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "Usuarioalmacen";
									}
								})
					</script>';
				}
		}
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrMostrarUsuariosAlmacen($item, $valor){
		$tabla = "usuarioalmacen";
		$respuesta = ModeloUAlmacen::mdlMostrarUAlmacen($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarUsuariosAlmacen1($item, $valor){
		$tabla = "usuarioalmacen";
		$respuesta = ModeloUAlmacen::mdlMostrarUAlmacenes($tabla, $item, $valor);
		return $respuesta;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function ctrEditarUAlmacen(){
		if(isset($_POST["editarUsuario"])){
				$tabla = "usuarioalmacen";
			   $datos = array("CodUsuario"=>$_POST["editarUsuario"],
					          "CodAlmacen"=>$_POST["editarAlmacen"],
					      	  "id"=>$_POST["idUAlmacen"]);
			   var_dump($datos);
			   	$respuesta = ModeloUAlmacen::mdlEditarUAlmacen($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El cliente ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "Usuarioalmacen";
									}
								})
					</script>';
				}
		}
	}
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function ctrEliminarUAlmacen(){
		if(isset($_GET["idUAlmacen"])){
			$tabla ="usuarioalmacen";
			$datos = $_GET["idUAlmacen"];
			$respuesta = ModeloUAlmacen::mdlEliminarUAlmacen($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El Usuario De La Sucursal ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "Usuarioalmacen";
								}
							})
				</script>';
			}		
		}
	}
}
