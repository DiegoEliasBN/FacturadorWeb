<?php
class ControladorProveedores{
	/*=============================================
	CREAR CLIENTES
	=============================================*/
	static public function ctrCrearProveedor(){
		if(isset($_POST["nuevoProveedor"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ(). -]+$/', $_POST["nuevoProveedor"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevoRUC"]) &&
                preg_match('/^[#\.\-a-zA-Z0-9(). -]+$/', $_POST["nuevaDireccionP"])) {
			   	$tabla = "proveedor";
			   	$datos = array("nombre"=>$_POST["nuevoProveedor"],
                                "ruc"=>$_POST["nuevoRUC"],
					           "telefono"=>$_POST["nuevoTelefono"],
							   "email"=>$_POST["nuevoEmail"],
							   "CodAlmacen"=>$_POST["nuevoAlmacen"],
                                "direccion"=>$_POST["nuevaDireccionP"]);
			   	$respuesta = ModeloProveedores::mdlIngresarProveedor($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El proveedor ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "proveedor";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "proveedor";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrMostrarProveedores($item, $valor){
		$tabla = "proveedor";
		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarProveedoresAlmacen($item, $item1, $valor, $valor1){
		$tabla = "proveedor";
		$respuesta = ModeloProveedores::mdlMostrarProveedoresAlmacen($tabla, $item, $item1, $valor, $valor1);
		return $respuesta;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function ctrEditarProveedor(){
		if(isset($_POST["editarProveedor"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ(). - ]+$/', $_POST["editarProveedor"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarRUC"])){
                $tabla = "proveedor";
                $datos = array("id"=>$_POST["idProveedor"],
                    "nombre"=>$_POST["editarProveedor"],
                    "ruc"=>$_POST["editarRUC"],
                    "email"=>$_POST["editarEmail"],
                    "telefono"=>$_POST["editarTelefono"],
                    "direccion"=>$_POST["editarDireccionP"]);
			   	$respuesta = ModeloProveedores::mdlEditarProveedor($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Proveedor ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "proveedor";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El Proveedor no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "proveedor";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function ctrEliminarProveedor(){
		if(isset($_GET["idProveedor"])){
			$tabla ="proveedor";
			$datos = $_GET["idProveedor"];
			$respuesta = ModeloProveedores::mdlEliminarProveedor($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El Proveedor ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "proveedor";
								}
							})
				</script>';
			}		
		}
	}
}
