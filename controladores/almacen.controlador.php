<?php
class ControladorAlmacenes{
	/*=============================================
	CREAR CATEGORIAS
	=============================================*/
	static public function ctrCrearAlmacen(){
		if(isset($_POST["nuevoAlmacen"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoAlmacen"])){
				$tabla = "almacen";
				$datos=array("NombreAlmacen"=> $_POST["nuevoAlmacen"],
							 "DireccionAlmacen"=> $_POST["nuevoDireccion"],
							 "telefono"=> $_POST["nuevoTelefono"],
							 "email"=> $_POST["nuevoEmail"],
							 "ruc"=> $_POST["nuevoRuc"]
							 );
				$respuesta = ModeloAlmacenes::mdlIngresarAlmacen($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La Sucursal ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "almacen";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La Sucursal no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "almacen";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function ctrMostrarAlmacenes($item, $valor){
		$tabla = "almacen";
		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarAlmacenes1($item,$item1, $valor,$valor1){
		$tabla = "almacen";
		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes1($tabla, $item,$item1, $valor,$valor1);
		return $respuesta;
	}
	/*=============================================
	EDITAR CATEGORIA
	=============================================*/
	static public function ctrEditarAlmacen(){
		if(isset($_POST["editarAlmacen"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarAlmacen"])){
				$tabla = "almacen";
				$datos = array("NombreAlmacen"=> $_POST["editarAlmacen"],
							   "DireccionAlmacen"=> $_POST["editarDireccion"],
							   "telefono"=> $_POST["editarTelefono"],
							   "email"=> $_POST["editarEmail"],
							   "ruc"=> $_POST["editarRuc"],
							   "id"=>$_POST["idAlmacen"]);
				$respuesta = ModeloAlmacenes::mdlEditarAlmacen($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "La Sucursal ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "almacen";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡La Sucursal no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "almacen";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR CATEGORIA
	=============================================*/
	static public function ctrBorrarAlmacen(){
		if(isset($_GET["idAlmacen"])){
			$tabla ="almacen";
			$datos = $_GET["idAlmacen"];
			$respuesta = ModeloAlmacenes::mdlBorrarAlmacen($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "La Sucursal ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "almacen";
									}
								})
					</script>';
			}
		}
	}
	static public function ctrCreaVa(){
		if(isset($_GET["idAlmacenn"])){
			$tabla ="almacen";
			$item = "CodAlmacen";
			$valor = $_GET["idAlmacenn"];
			$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor);
			$_SESSION["almacenes"]=$respuesta;
			$_SESSION["CodAlmacen"]=$valor;
				echo'<script>
							window.location = "inicio";
					</script>';
		}
	}
}
