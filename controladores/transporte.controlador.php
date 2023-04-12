<?php
class ControladorTransportes{
	/*=============================================
	CREAR TRAAPORTE
	=============================================*/
	static public function ctrCrearTransporte(){
		if(isset($_POST["nuevoTransporte"])){
			   	$tabla = "trasporte";
			   	$datos = array("nombre"=>$_POST["nuevoTransporte"],
							   "licencia"=>$_POST["nuevoLicencia"],
							   "CodAlmacen"=>$_POST["nuevoAlmacen"],
					           "placa"=>$_POST["nuevaPlaca"]);
				//var_dump($datos);
			   	$respuesta = ModeloTransportes::mdlIngresarTransporte($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Transporte ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "transporte";
									}
								})
					</script>';
				}
		}
	}
	/*=============================================
	MOSTRAR TRASPORTE
	=============================================*/
	static public function ctrMostrarTransporte($item, $valor){
		$tabla = "trasporte";
		$respuesta = ModeloTransportes::mdlMostrarTransportes($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarTransporteAlmacen($item, $item1, $valor, $valor1){
		$tabla = "trasporte";
		$respuesta = ModeloTransportes::mdlMostrarTransportesAlmacen($tabla,$item, $item1, $valor, $valor1);
		return $respuesta;
	}
	/*=============================================
	EDITAR TRASPORTE
	=============================================*/
	static public function ctrEditarTransporte(){
		if(isset($_POST["editarTransporte"])){
			var_dump($_POST["editarTransporte"]);
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarTransporte"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarLicencia"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPlaca"])){
			   	$tabla = "trasporte";
			   	$datos = array("id"=>$_POST["idTransporte"],
			   				   "nombre"=>$_POST["editarTransporte"],
					           "licencia"=>$_POST["editarLicencia"],
					           "placa"=>$_POST["editarPlaca"]);
			   	$respuesta = ModeloTransportes::mdlEditarTransporte($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El transporte ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "transporte";
									}
								})
					</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El transporte no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	ELIMINAR TRASPORTE
	=============================================*/
	static public function ctrEliminarTransporte(){
		if(isset($_GET["idTransporte"])){
			$tabla ="trasporte";
			$datos = $_GET["idTransporte"];
			$respuesta = ModeloTransportes::mdlEliminarTransporte($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El Transporte ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "transporte";
								}
							})
				</script>';
			}		
		}
	}
}
