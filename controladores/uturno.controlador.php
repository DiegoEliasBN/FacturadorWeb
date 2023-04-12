<?php
class ControladorUsuariosTurno{
	/*=============================================
	CREAR CLIENTES
	=============================================*/
	static public function ctrCrearUTurno(){
		if(isset($_POST["nuevoUsuario"])){
			   	$tabla = "usuarioturno";
			   	$datos = array("CodUsuario"=>$_POST["nuevoUsuario"],
			   				   "CodAlmacen"=>$_POST["CodAlmacen"],
					           "CodTurno"=>$_POST["nuevoTurno"]);
			   	$respuesta = ModeloUTurno::mdlIngresarUTurno($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Usuario Del turno ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "usuarioturno";
									}
								})
					</script>';
				}
		}
	}
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function ctrMostrarUsuariosTurno($item,$item2, $valor,$valor2){
		$tabla = "usuarioturno";
		$respuesta = ModeloUTurno::mdlMostrarUTurno($tabla,$item,$item2, $valor,$valor2);
		return $respuesta;
	}
	static public function ctrMostrarUsuariosTurno1($item, $valor){
		$tabla = "usuarioturno";
		$respuesta = ModeloUTurno::mdlMostrarUTurnos($tabla, $item, $valor);
		return $respuesta;
	}
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function ctrEditarUTurno(){
		if(isset($_POST["editarUsuarioT"])){
				$tabla = "usuarioturno";
			   $datos = array("CodUsuario"=>$_POST["editarUsuarioT"],
					          "CodTurno"=>$_POST["editarTurno"],
					      	  "id"=>$_POST["idUTurno"]);
			   var_dump($datos);
			   	$respuesta = ModeloUTurno::mdlEditarUTurno($tabla, $datos);
			   	if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Usuario Del turno ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
										window.location = "usuarioturno";
									}
								})
					</script>';
				}
		}
	}
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function ctrEliminarUTurno(){
		if(isset($_GET["idUTurno"])){
			$tabla ="usuarioturno";
			$datos = $_GET["idUTurno"];
			$respuesta = ModeloUTurno::mdlEliminarUTurno($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
				swal({
					  type: "success",
					  title: "El Usuario Del turno ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {
								window.location = "usuarioturno";
								}
							})
				</script>';
			}		
		}
	}
}
