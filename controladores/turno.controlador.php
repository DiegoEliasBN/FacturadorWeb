<?php
class ControladorTurnos{
	/*=============================================
	CREAR TURNOS
	=============================================*/
	static public function ctrCrearTurno(){
		if(isset($_POST["nuevoTurno"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoTurno"])){
				$tabla = "turno";
				$datos=array("descripcion"=> $_POST["nuevoTurno"],
							 "HoraInicio"=> $_POST["HoraInicio"],
							 "CodAlmacen"=> $_POST["CodAlmacen"],
							 "HoraFin"=> $_POST["HoraFin"]);
				$respuesta = ModeloTurnos::mdlIngresarTurno($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Turno ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "turnos";
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
							window.location = "turnos";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/
	static public function ctrMostrarTurnos($item, $valor){
		$tabla = "turno";
		$respuesta = ModeloTurnos::mdlMostrarTurnos($tabla, $item, $valor);
		return $respuesta;
	}
	static public function ctrMostrarTurnos2($item,$item2, $valor,$valor2){
		$tabla = "turno";
		$respuesta = ModeloTurnos::mdlMostrarTurnos2($tabla,$item,$item2, $valor,$valor2);
		return $respuesta;
	}
	/*=============================================
	EDITAR CATEGORIA
	=============================================*/
	static public function ctrEditarTurno(){
		if(isset($_POST["editarTurno"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarTurno"])){
				$tabla = "turno";
				$datos=array("descripcion"=> $_POST["editarTurno"],
							 "HoraInicio"=> $_POST["eHoraInicio"],
							 "HoraFin"=> $_POST["eHoraFin"],
							 "CodTurno"=>$_POST["idTurno"]);
				$respuesta = ModeloTurnos::mdlEditarTurno($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>
					swal({
						  type: "success",
						  title: "El Turno ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "turnos";
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
							window.location = "turnos";
							}
						})
			  	</script>';
			}
		}
	}
	/*=============================================
	BORRAR CATEGORIA
	=============================================*/
	static public function ctrBorrarTurno(){
		if(isset($_GET["idTurno"])){
			$tabla ="turno";
			$datos = $_GET["idTurno"];
			$respuesta = ModeloTurnos::mdlBorrarTurno($tabla, $datos);
			if($respuesta == "ok"){
				echo'<script>
					swal({
						  type: "success",
						  title: "El Turno ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "turnos";
									}
								})
					</script>';
			}
		}
	}
}
